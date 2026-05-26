from langchain_core.embeddings import FakeEmbeddings

# Cache the model instance to avoid re-initializing on every request
_embedding_model = None

def get_embedding_model() -> FakeEmbeddings:
    """Return a cached fake embedding model for testing."""
    global _embedding_model
    if _embedding_model is None:
        _embedding_model = FakeEmbeddings(size=384)  # Same size as sentence-transformers model
    return _embedding_model
