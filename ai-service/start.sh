#!/bin/sh
set -eu

if [ -n "${MODEL_URL:-}" ] && [ ! -f /app/models/model_cnn.keras ]; then
    python -c "import os, urllib.request; urllib.request.urlretrieve(os.environ['MODEL_URL'], '/app/models/model_cnn.keras')"
fi

exec uvicorn app.main:app --host 0.0.0.0 --port "${PORT:-8001}"
