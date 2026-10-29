from typing import Literal

from pydantic import BaseModel, Field


ScanLabel = Literal["luka", "obat", "tidak_relevan"]


class PredictionResponse(BaseModel):
    label: ScanLabel
    confidence_score: float = Field(ge=0.0, le=1.0)
    model_version: str


class HealthResponse(BaseModel):
    status: Literal["ok"]
    model_loaded: bool
    model_version: str
