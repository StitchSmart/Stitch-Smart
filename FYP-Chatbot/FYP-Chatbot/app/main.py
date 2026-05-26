import os
from contextlib import asynccontextmanager

from fastapi import FastAPI
from fastapi.staticfiles import StaticFiles
from fastapi.responses import FileResponse
from fastapi.middleware.cors import CORSMiddleware

from app.routes import router, set_vector_store
from app.vector_store import create_vector_store, load_vector_store
from app.config import FAISS_INDEX_DIR


@asynccontextmanager
async def lifespan(app: FastAPI):
    """On startup, load or create the FAISS vector store."""
    if os.path.exists(os.path.join(FAISS_INDEX_DIR, "index.faiss")):
        vs = load_vector_store()
    else:
        vs = create_vector_store()
    set_vector_store(vs)
    yield


app = FastAPI(
    title="E-Commerce RAG Chatbot",
    description="A RAG-based e-commerce store assistant powered by Mistral LLM, Sentence Transformers, and FAISS.",
    version="1.0.0",
    lifespan=lifespan,
)

# Mount static files for the chat UI
static_dir = os.path.abspath(os.path.join(os.path.dirname(__file__), "..", "static"))
app.mount("/static", StaticFiles(directory=static_dir), name="static")

# Include API routes
app.include_router(router)


@app.get("/")
async def serve_ui():
    """Serve the chat UI."""
    return FileResponse(os.path.join(static_dir, "index.html"))
