# HealthCare AI Service

Internal FastAPI service for the Hybrid AI flow. The endpoint contract is ready for Laravel integration; the trained MobileNetV2 model will be enabled in Phase 3 after the dataset and preprocessing are finalized.

## Setup on Windows

```powershell
cd ai-service
python -m venv .venv
.venv\Scripts\activate
python -m pip install --upgrade pip
pip install -r requirements.txt
```

## Run

```powershell
$env:AI_SERVICE_TOKEN="token_lokal"
uvicorn app.main:app --reload --port 8001
```

Health check:

```powershell
Invoke-RestMethod http://127.0.0.1:8001/health
```

The prediction endpoint returns `503` until `models/model_cnn.keras` and the real preprocessing/inference implementation are installed. This prevents the prototype from pretending that a dummy result is a valid medical classification.
