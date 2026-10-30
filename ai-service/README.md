# HealthCare AI Service

Internal FastAPI service for the Hybrid AI flow. The service loads the MobileNetV2 model from `models/model_cnn.keras`.

## Local retraining

Training awal dapat dilakukan di Google Colab. Untuk feedback loop dari data user yang sudah mendapat consent, jalankan `python train_retrain.py` dari root repository. Lihat `Docs/IMPLEMENTATION PLAN.md` untuk format CSV export admin, opsi `--dry-run`, dan alur backup model.

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

The prediction response includes the active value from `models/model_version.txt`, or `mobilenetv2-v1` when no version file exists.
