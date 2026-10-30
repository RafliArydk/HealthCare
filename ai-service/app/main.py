import os

from fastapi import Depends, FastAPI, File, Header, HTTPException, UploadFile

from .predictor import Predictor
from .schemas import HealthResponse, PredictionResponse


app = FastAPI(
    title="HealthCare AI Service",
    version="0.1.0",
    description="Internal vision service for the HealthCare Hybrid AI prototype.",
)
predictor = Predictor()


def verify_internal_token(x_ai_service_token: str | None = Header(default=None)) -> None:
    expected_token = os.getenv("AI_SERVICE_TOKEN")
    if expected_token and x_ai_service_token != expected_token:
        raise HTTPException(status_code=401, detail="Invalid AI service token")


@app.get("/health", response_model=HealthResponse)
def health() -> HealthResponse:
    return HealthResponse(
        status="ok",
        model_loaded=predictor.is_loaded,
        model_version=predictor.model_version,
    )


@app.post(
    "/api/v1/predict",
    response_model=PredictionResponse,
    dependencies=[Depends(verify_internal_token)],
)
async def predict(file: UploadFile = File(...)) -> PredictionResponse:
    allowed_types = {"image/jpeg", "image/png", "image/webp"}
    if file.content_type not in allowed_types:
        raise HTTPException(status_code=422, detail="File must be a JPG, PNG, or WEBP image")

    try:
        contents = await file.read()
        max_size = 10 * 1024 * 1024
        if len(contents) > max_size:
            raise HTTPException(status_code=422, detail="File must not exceed 10 MB")

        await file.seek(0)
        return await predictor.predict(file)
    except ValueError as error:
        raise HTTPException(status_code=422, detail=str(error)) from error
    except RuntimeError as error:
        raise HTTPException(status_code=503, detail=str(error)) from error
