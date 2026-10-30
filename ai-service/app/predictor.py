from pathlib import Path
import tensorflow as tf
import numpy as np
from PIL import Image
import io
from fastapi import UploadFile
from .schemas import PredictionResponse

# Sesuaikan path ke folder models
MODEL_PATH = Path(__file__).resolve().parent.parent / "models" / "model_cnn.keras"
MODEL_VERSION_PATH = MODEL_PATH.with_name("model_version.txt")
CLASS_NAMES = ['luka', 'obat', 'tidak_relevan'] # Urutan sesuai abjad folder saat training

class Predictor:
    def __init__(self) -> None:
        self.model = None
        self.model_version = self._read_model_version()

        # Load model saat server dinyalakan
        if MODEL_PATH.exists():
            try:
                self.model = tf.keras.models.load_model(MODEL_PATH)
                print("✅ Model CNN berhasil dimuat!")
            except Exception as e:
                print(f"❌ Gagal memuat model: {e}")
        else:
            print(f"⚠️ File model tidak ditemukan di: {MODEL_PATH}")

    @staticmethod
    def _read_model_version() -> str:
        if MODEL_VERSION_PATH.exists():
            version = MODEL_VERSION_PATH.read_text(encoding="utf-8").strip()
            if version:
                return version
        return "mobilenetv2-v1"

    @property
    def is_loaded(self) -> bool:
        return self.model is not None

    async def predict(self, file: UploadFile) -> PredictionResponse:
        if not self.is_loaded:
            raise RuntimeError("CNN model is not installed yet")

        # 1. Baca gambar
        contents = await file.read()
        image = Image.open(io.BytesIO(contents)).convert('RGB')

        # 2. Preprocessing (Sesuai saat training: 224x224 dan normalisasi)
        image = image.resize((224, 224))
        img_array = np.array(image) / 255.0
        img_array = np.expand_dims(img_array, axis=0) # Tambah dimensi batch

        # 3. Prediksi
        predictions = self.model.predict(img_array)
        predicted_class_index = np.argmax(predictions[0])
        confidence_score = float(predictions[0][predicted_class_index])

        # 4. Return hasil
        return PredictionResponse(
            label=CLASS_NAMES[predicted_class_index],
            confidence_score=confidence_score,
            model_version=self.model_version
        )