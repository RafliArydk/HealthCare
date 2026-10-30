"""Retrain the CNN locally from consented user data.

The CSV is produced by the admin dataset export. Images are resolved from
Laravel's storage/app/public directory, so no cloud upload is required.
"""

from __future__ import annotations

import argparse
import csv
import json
import os
import shutil
import tempfile
from collections import Counter
from datetime import datetime, timezone
from pathlib import Path

import tensorflow as tf


CLASS_NAMES = ("luka", "obat", "tidak_relevan")
IMAGE_EXTENSIONS = {".jpg", ".jpeg", ".png", ".webp"}
IMAGE_SIZE = (224, 224)


def parse_args() -> argparse.Namespace:
    root = Path(__file__).resolve().parent
    return argparse.Namespace(
        manifest=Path(os.getenv("RETRAIN_MANIFEST", root / "storage" / "app" / "dataset" / "dataset.csv")),
        image_root=Path(os.getenv("RETRAIN_IMAGE_ROOT", root / "storage" / "app" / "public" / "scans")),
        base_dataset=Path(os.getenv("RETRAIN_BASE_DATASET", root / "ai-service" / "dataset" / "train")),
        output=Path(os.getenv("RETRAIN_OUTPUT", root / "ai-service" / "models" / "model_cnn.keras")),
        epochs=int(os.getenv("RETRAIN_EPOCHS", "8")),
        batch_size=int(os.getenv("RETRAIN_BATCH_SIZE", "16")),
        validation_split=float(os.getenv("RETRAIN_VALIDATION_SPLIT", "0.2")),
        dry_run=False,
        include_base_dataset=False,
    )


def build_parser() -> argparse.ArgumentParser:
    parser = argparse.ArgumentParser(
        description="Retrain MobileNetV2 from the admin CSV export and local Laravel images."
    )
    parser.add_argument("--manifest", type=Path, help="Admin CSV export containing image_filename and label.")
    parser.add_argument("--image-root", type=Path, help="Root containing the exported image files.")
    parser.add_argument("--base-dataset", type=Path, help="Optional class-folder dataset used for initial training.")
    parser.add_argument("--output", type=Path, help="Destination model_cnn.keras path.")
    parser.add_argument("--epochs", type=int, help="Number of training epochs.")
    parser.add_argument("--batch-size", type=int, help="Training batch size.")
    parser.add_argument("--validation-split", type=float, help="Validation fraction between 0 and 0.5.")
    parser.add_argument(
        "--include-base-dataset",
        action="store_true",
        help="Also include ai-service/dataset/train; disabled by default.",
    )
    parser.add_argument("--dry-run", action="store_true", help="Validate and count data without training.")
    return parser


def read_manifest(manifest: Path, image_root: Path, staging: Path) -> int:
    if not manifest.exists():
        print(f"Manifest tidak ditemukan: {manifest}")
        return 0

    copied = 0
    image_root = image_root.resolve()
    with manifest.open(newline="", encoding="utf-8-sig") as file:
        for row in csv.DictReader(file):
            label = (row.get("label") or "").strip().lower()
            filename = (row.get("image_filename") or "").strip()
            if label not in CLASS_NAMES or not filename:
                continue

            source = (image_root / filename).resolve()
            try:
                source.relative_to(image_root)
            except ValueError:
                continue
            if not source.is_file() or source.suffix.lower() not in IMAGE_EXTENSIONS:
                continue

            destination_dir = staging / label
            destination_dir.mkdir(parents=True, exist_ok=True)
            destination = destination_dir / f"user_{row.get('scan_id', copied)}{source.suffix.lower()}"
            shutil.copy2(source, destination)
            copied += 1
    return copied


def copy_base_dataset(base_dataset: Path, staging: Path) -> int:
    copied = 0
    if not base_dataset.is_dir():
        return copied

    for label in CLASS_NAMES:
        source_dir = base_dataset / label
        if not source_dir.is_dir():
            continue
        destination_dir = staging / label
        destination_dir.mkdir(parents=True, exist_ok=True)
        for source in source_dir.rglob("*"):
            if source.is_file() and source.suffix.lower() in IMAGE_EXTENSIONS:
                shutil.copy2(source, destination_dir / f"base_{copied}{source.suffix.lower()}")
                copied += 1
    return copied


def count_images(staging: Path) -> Counter[str]:
    return Counter(
        label
        for label in CLASS_NAMES
        for image in (staging / label).glob("*")
        if image.is_file()
    )


def train(staging: Path, output: Path, epochs: int, batch_size: int, validation_split: float) -> None:
    train_data = tf.keras.utils.image_dataset_from_directory(
        staging,
        class_names=list(CLASS_NAMES),
        image_size=IMAGE_SIZE,
        batch_size=batch_size,
        validation_split=validation_split,
        subset="training",
        seed=42,
        label_mode="categorical",
    )
    validation_data = tf.keras.utils.image_dataset_from_directory(
        staging,
        class_names=list(CLASS_NAMES),
        image_size=IMAGE_SIZE,
        batch_size=batch_size,
        validation_split=validation_split,
        subset="validation",
        seed=42,
        label_mode="categorical",
    )

    augmentation = tf.keras.Sequential(
        [
            tf.keras.layers.RandomFlip("horizontal"),
            tf.keras.layers.RandomRotation(0.08),
            tf.keras.layers.RandomZoom(0.1),
        ],
        name="augmentation",
    )
    base = tf.keras.applications.MobileNetV2(
        input_shape=(*IMAGE_SIZE, 3),
        include_top=False,
        weights="imagenet",
    )
    base.trainable = False

    inputs = tf.keras.Input(shape=(*IMAGE_SIZE, 3))
    x = augmentation(inputs)
    x = tf.keras.layers.Rescaling(1.0 / 255.0)(x)
    x = base(x, training=False)
    x = tf.keras.layers.GlobalAveragePooling2D()(x)
    x = tf.keras.layers.Dropout(0.25)(x)
    outputs = tf.keras.layers.Dense(len(CLASS_NAMES), activation="softmax")(x)
    model = tf.keras.Model(inputs, outputs)
    model.compile(
        optimizer=tf.keras.optimizers.Adam(learning_rate=1e-3),
        loss="categorical_crossentropy",
        metrics=["accuracy"],
    )

    model.fit(train_data, validation_data=validation_data, epochs=epochs)
    output.parent.mkdir(parents=True, exist_ok=True)
    temporary_output = output.with_suffix(".tmp.keras")
    model.save(temporary_output)
    os.replace(temporary_output, output)


def main() -> int:
    args = parse_args()
    cli = build_parser().parse_args()
    for name in (
        "manifest",
        "image_root",
        "base_dataset",
        "output",
        "epochs",
        "batch_size",
        "validation_split",
        "dry_run",
        "include_base_dataset",
    ):
        value = getattr(cli, name)
        if value is not None:
            setattr(args, name, value)

    if not 0 < args.validation_split < 0.5:
        raise SystemExit("--validation-split must be greater than 0 and less than 0.5")
    if args.epochs < 1 or args.batch_size < 1:
        raise SystemExit("--epochs and --batch-size must be at least 1")

    with tempfile.TemporaryDirectory(prefix="healthcare-retrain-") as directory:
        staging = Path(directory)
        base_count = copy_base_dataset(args.base_dataset, staging) if args.include_base_dataset else 0
        user_count = read_manifest(args.manifest, args.image_root, staging)
        counts = count_images(staging)
        print(json.dumps({"base_images": base_count, "user_images": user_count, "classes": counts}, indent=2))

        missing = [label for label in CLASS_NAMES if counts[label] < 2]
        if missing:
            source = "data user" if not args.include_base_dataset else "gabungan dataset"
            raise SystemExit(
                f"Minimal 2 gambar {source} dibutuhkan untuk setiap kelas: {', '.join(missing)}. "
                f"Pastikan CSV berada di {args.manifest} dan gambar berada di {args.image_root}."
            )
        if args.dry_run:
            return 0

        backup = args.output.with_name(f"{args.output.stem}.backup-{datetime.now(timezone.utc):%Y%m%d%H%M%S}{args.output.suffix}")
        if args.output.exists():
            shutil.copy2(args.output, backup)
            print(f"Previous model backed up to {backup}")
        train(staging, args.output, args.epochs, args.batch_size, args.validation_split)

    version_path = args.output.with_name("model_version.txt")
    version_path.write_text(f"mobilenetv2-retrained-{datetime.now(timezone.utc):%Y%m%d%H%M%S}\n", encoding="utf-8")
    print(f"Retrained model saved to {args.output}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
