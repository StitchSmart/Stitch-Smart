import json
import os
from typing import List

from langchain_core.documents import Document
from langchain_community.vectorstores import FAISS

from app.config import PRODUCTS_JSON_PATH, FAISS_INDEX_DIR, RETRIEVER_TOP_K
from app.embeddings import get_embedding_model


def _product_to_text(product: dict) -> str:
    """Flatten a single product dict into a rich textual representation.
    Normalises keys to lowercase so PHP (mixed-case) and JSON (lowercase) both work."""
    p = {k.lower(): v for k, v in product.items()}
    lines = [
        f"Product ID: {p.get('id', 'N/A')}",
        f"Product Name: {p.get('name', 'N/A')}",
        f"Article Number: {p.get('article_number', 'N/A')}",
        f"Category: {p.get('category', 'N/A')}",
        f"Price: ${p.get('price', 'N/A')}",
        f"Size: {p.get('size', 'N/A')}",
        f"Fabric Type: {p.get('fabric_type', 'N/A')}",
        f"Design: {p.get('designing', 'N/A')}",
        f"Description: {p.get('description', 'N/A')}",
        f"Details: {p.get('details', 'N/A')}",
    ]
    return "\n".join(lines)


def _load_products() -> List[Document]:
    """Load products JSON and convert each product into a LangChain Document."""
    with open(PRODUCTS_JSON_PATH, "r", encoding="utf-8") as f:
        products = json.load(f)

    documents: List[Document] = []
    for product in products:
        text = _product_to_text(product)
        metadata = {
            "id": str(product.get("id")),
            "product_name": product.get("name"),
            "category": product.get("category"),
            "price": product.get("price"),
            "size": product.get("size"),
        }
        documents.append(Document(page_content=text, metadata=metadata))

    return documents


def create_vector_store_from_data(products: list) -> FAISS:
    """Build a FAISS index from a given list of products (in-memory, no file needed)."""
    documents: List[Document] = []
    for product in products:
        text = _product_to_text(product)
        metadata = {
            "id": str(product.get("id")),
            "product_name": product.get("name"),
            "category": product.get("category"),
            "price": product.get("price"),
            "size": product.get("size"),
        }
        documents.append(Document(page_content=text, metadata=metadata))

    embedding_model = get_embedding_model()
    vector_store = FAISS.from_documents(documents, embedding_model)

    os.makedirs(FAISS_INDEX_DIR, exist_ok=True)
    vector_store.save_local(FAISS_INDEX_DIR)
    return vector_store


def create_vector_store() -> FAISS:
    """Build a FAISS index from the products JSON and persist it to disk."""
    documents = _load_products()
    embedding_model = get_embedding_model()

    vector_store = FAISS.from_documents(documents, embedding_model)

    os.makedirs(FAISS_INDEX_DIR, exist_ok=True)
    vector_store.save_local(FAISS_INDEX_DIR)
    return vector_store


def load_vector_store() -> FAISS:
    """Load a previously saved FAISS index from disk."""
    embedding_model = get_embedding_model()
    vector_store = FAISS.load_local(
        FAISS_INDEX_DIR,
        embedding_model,
        allow_dangerous_deserialization=True,
    )
    return vector_store


def get_retriever(vector_store: FAISS):
    """Return a LangChain retriever from the FAISS vector store."""
    return vector_store.as_retriever(search_kwargs={"k": RETRIEVER_TOP_K})
