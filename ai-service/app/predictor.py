from pathlib import Path

from fastapi import UploadFile

from .schemas import PredictionResponse


MODEL_VERSION = "mobilenetv2-v0-placeholder"
MODEL_PATH = Path(__file__).resolve().parent.parent / "models" / "model_cnn.keras"


class Predictor:
    """CNN adapter.

    The real MobileNetV2 model is intentionally loaded only after the trained
    model is supplied. Until then this adapter provides a safe contract for
    Laravel integration tests and refuses to claim a real classification.
    """

    def __init__(self) -> None:
        self.model = None
        self.model_version = MODEL_VERSION

        if MODEL_PATH.exists():
            # Loading is enabled in the next implementation phase, after the
            # class order and preprocessing contract are finalized.
            self.model_version = "mobilenetv2-v1"

    @property
    def is_loaded(self) -> bool:
        return self.model is not None

    async def predict(self, file: UploadFile) -> PredictionResponse:
        await file.read()

        if not self.is_loaded:
            raise RuntimeError("CNN model is not installed yet")

        raise NotImplementedError("MobileNetV2 inference will be enabled in Phase 3")
