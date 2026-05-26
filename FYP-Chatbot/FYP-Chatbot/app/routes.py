from fastapi import APIRouter, HTTPException
from fastapi.responses import StreamingResponse
from pydantic import BaseModel
from typing import List, Any

from app.rag_chain import stream_rag_response, get_rag_response
from app.vector_store import create_vector_store, load_vector_store, create_vector_store_from_data

router = APIRouter()

# Will be set by main.py on startup
vector_store = None


class ChatRequest(BaseModel):
    query: str
    session_id: str
    user_id: str = "anonymous"
    base_url: str = "http://localhost/Stitch-Smart/public/"


def set_vector_store(vs):
    """Set the shared vector store reference (called from main.py)."""
    global vector_store
    vector_store = vs

@router.post("/chat-simple")
async def chat_simple(request: ChatRequest):
    """Non-streaming version for PHP"""
    if vector_store is None:
        raise HTTPException(status_code=503, detail="Vector store not initialized.")

    if not request.query.strip():
        raise HTTPException(status_code=400, detail="Query cannot be empty.")

    try:
        full_response = await get_rag_response(vector_store, request.query, request.session_id, request.user_id, request.base_url)
        return {"response": full_response}
    except Exception as e:
        import traceback
        traceback.print_exc()
        error_msg = str(e)
        if "429" in error_msg or "quota" in error_msg.lower():
            return {"response": "I'm currently experiencing high traffic. Please try again in a few seconds."}
        return {"response": "Sorry, I encountered an error. Please try again."}
@router.post("/chat")
async def chat_endpoint(request: ChatRequest):
    """Stream a RAG-powered response for the customer query."""
    if vector_store is None:
        raise HTTPException(status_code=503, detail="Vector store not initialized. Call /build-index first.")

    if not request.query.strip():
        raise HTTPException(status_code=400, detail="Query cannot be empty.")

    async def response_generator():
        async for token in stream_rag_response(vector_store, request.query, request.session_id, request.user_id):
            yield token

    return StreamingResponse(response_generator(), media_type="text/event-stream")


@router.post("/build-index")
async def build_index():
    """Rebuild the FAISS index from products.json."""
    try:
        vs = create_vector_store()
        set_vector_store(vs)
        return {"status": "success", "message": "FAISS index built successfully."}
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Failed to build index: {str(e)}")


class SyncProductsRequest(BaseModel):
    products: List[Any]


@router.post("/sync-products")
async def sync_products(request: SyncProductsRequest):
    """Receive full product list from PHP and rebuild the FAISS index automatically."""
    try:
        if not request.products:
            raise HTTPException(status_code=400, detail="Products list is empty.")
        vs = create_vector_store_from_data(request.products)
        set_vector_store(vs)
        return {"status": "success", "message": f"Synced {len(request.products)} products and rebuilt FAISS index."}
    except Exception as e:
        import traceback
        traceback.print_exc()
        raise HTTPException(status_code=500, detail=f"Sync failed: {str(e)}") 


@router.get("/health")
async def health_check():
    """Health check endpoint."""
    return {
        "status": "ok",
        "vector_store_loaded": vector_store is not None,
    }


class SimilarProductsRequest(BaseModel):
    product_id: str
    top_k: int = 3


@router.post("/similar-products")
async def similar_products(request: SimilarProductsRequest):
    """Find semantically similar products based on a given product_id."""
    if vector_store is None:
        raise HTTPException(status_code=503, detail="Vector store not initialized. Call /build-index first.")

    # 1. Find the target product in the FAISS store by its metadata id
    all_docs = vector_store.docstore._dict
    target_doc = None

    for doc_id, doc in all_docs.items():
        if doc.metadata.get("id") == request.product_id:
            target_doc = doc
            break

    if target_doc is None:
        raise HTTPException(status_code=404, detail=f"Product '{request.product_id}' not found in the index.")

    # 2. Use the product's description as query for semantic similarity search
    #    Fetch extra results since we'll exclude the queried product itself
    results = vector_store.similarity_search_with_score(
        target_doc.page_content,
        k=request.top_k + 1,
    )

    # 3. Build the response, excluding the queried product
    similar = []
    for doc, score in results:
        pid = doc.metadata.get("id")
        if pid == request.product_id:
            continue
        similar.append({
            "product_id": pid,
            "product_name": doc.metadata.get("product_name"),
            "category": doc.metadata.get("category"),
            "price": doc.metadata.get("price"),
            "similarity_score": round(float(score), 4),
        })

    # Limit to requested top_k
    similar = similar[:request.top_k]

    return {
        "query_product_id": request.product_id,
        "query_product_name": target_doc.metadata.get("product_name"),
        "similar_products": similar,
    }
