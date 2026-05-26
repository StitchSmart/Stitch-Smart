import os
from dotenv import load_dotenv

load_dotenv()

# ── Hugging Face (for embeddings only) ───────────────────────
HF_TOKEN: str = os.getenv("HF_TOKEN", "")

# ── Google Gemini ─────────────────────────────────────────────
GOOGLE_API_KEY: str = os.getenv("GOOGLE_API_KEY", "")

# ── Embedding model (Sentence Transformers) ───────────────────
EMBEDDING_MODEL_NAME: str = "sentence-transformers/all-MiniLM-L6-v2"

# ── LLM model (Google Gemini) ────────────────────────────────
LLM_MODEL_NAME: str = "gemini-2.5-flash"
LLM_TEMPERATURE: float = 0.3
LLM_MAX_NEW_TOKENS: int = 1024

# ── Data paths ────────────────────────────────────────────────
PRODUCTS_JSON_PATH: str = os.path.join(os.path.dirname(__file__), "..", "data", "products.json")
FAISS_INDEX_DIR: str = os.path.join(os.path.dirname(__file__), "..", "faiss_index")

# ── Retriever settings ────────────────────────────────────────
RETRIEVER_TOP_K: int = 10
