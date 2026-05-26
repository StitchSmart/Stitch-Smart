@echo off
echo Starting StitchSmart AI Assistant...
cd /d "%~dp0FYP-Chatbot\FYP-Chatbot"
".\venv\Scripts\python.exe" -m uvicorn app.main:app --host 127.0.0.1 --port 5000
pause
