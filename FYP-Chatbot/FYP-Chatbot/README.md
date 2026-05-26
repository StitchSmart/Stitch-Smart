# E-Commerce RAG Chatbot

A RAG-based e-commerce store assistant powered by **Mistral LLM**, **Sentence Transformers**, **FAISS**, **LangChain**, and **FastAPI** with streaming responses.

## Setup

### 1. Create Virtual Environment
```bash
python -m venv venv
venv\Scripts\activate        # Windows
# source venv/bin/activate   # Linux/Mac
```

### 2. Install Dependencies
```bash
pip install -r requirements.txt
```

### 3. Configure Environment
Edit the `.env` file and add your HuggingFace API token:
```
HF_TOKEN=hf_your_actual_token_here
```

> **Note:** You must have access to `mistralai/Mistral-7B-Instruct-v0.3` on HuggingFace. Visit the model page and accept the license agreement.

### 4. Run the Server
```bash
uvicorn app.main:app --reload --port 8000
```

The server will automatically build the FAISS index from `data/products.json` on first startup.

### 5. Open the Chat UI
Navigate to [http://localhost:8000](http://localhost:8000) in your browser.

## API Endpoints

| Endpoint | Method | Description |
|---|---|---|
| `/` | GET | Chat UI |
| `/chat` | POST | Streaming chat response (`{"query": "..."}`) |
| `/build-index` | POST | Rebuild FAISS index from products.json |
| `/health` | GET | Health check |

## Project Structure
```
FYP_Chatbot/
├── app/
│   ├── __init__.py
│   ├── main.py           # FastAPI entry point
│   ├── config.py          # Configuration
│   ├── routes.py          # API endpoints
│   ├── embeddings.py      # Sentence Transformer setup
│   ├── vector_store.py    # FAISS index management
│   ├── llm.py             # Mistral LLM setup
│   ├── rag_chain.py       # LangChain RAG chain
│   └── prompts.py         # System prompt
├── data/
│   └── products.json      # Product catalog
├── static/
│   └── index.html         # Chat UI
├── .env                   # API token
├── requirements.txt
└── README.md
```

## Tech Stack
- **Embeddings:** Sentence Transformers (`all-MiniLM-L6-v2`)
- **Vector DB:** FAISS
- **LLM:** Mistral 7B Instruct v0.3 (via HuggingFace Inference API)
- **Framework:** LangChain + FastAPI
- **Streaming:** Server-Sent Events (async yield)
