# HealthCare AI Service

Internal FastAPI service for the Hybrid AI flow. The current endpoint uses a random dummy classifier so Laravel integration can be tested before the trained MobileNetV2 model is installed.

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

The prediction response includes `model_version: dummy-random-v1`. This value must be replaced with the real MobileNetV2 model version in Phase 3; dummy results must not be presented as medical classification results.
