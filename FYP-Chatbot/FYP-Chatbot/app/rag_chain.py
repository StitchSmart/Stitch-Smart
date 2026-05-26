from typing import AsyncGenerator
from app.llm import get_llm
from app.prompts import ECOMMERCE_PROMPT
from app.vector_store import get_retriever

import asyncio

# Shared memory for chat history
chat_histories = {}


async def get_rag_response(vector_store, query: str, session_id: str, user_id: str = "anonymous", base_url: str = "") -> str:
    """Get a complete RAG response (non-streaming, used by PHP integration)."""
    
    # 1. Management of Session History
    if user_id not in chat_histories:
        chat_histories[user_id] = {}
    
    if session_id not in chat_histories[user_id]:
        chat_histories[user_id][session_id] = []

    history = chat_histories[user_id][session_id]
    
    # Format chat history for the prompt
    history_str = "No history yet."
    if history:
        history_str = "\n".join([f"Human: {q}\nAI: {a}" for q, a in history])

    # 2. Retrieval
    retriever = get_retriever(vector_store)
    docs = retriever.invoke(query)
    
    context = "\n---\n".join([doc.page_content for doc in docs])
    if not context:
        context = "No relevant product information found."

    # 3. Final Answer Generation (non-streaming)
    llm = get_llm(streaming=False)
    
    # Format the prompt manually
    prompt_text = ECOMMERCE_PROMPT.format(
        context=context,
        question=query,
        chat_history=history_str,
        base_url=base_url
    )

    result = await llm.ainvoke(prompt_text)
    full_response = result.content if hasattr(result, 'content') else str(result)

    # Update session history
    chat_histories[user_id][session_id].append((query, full_response))
    if len(chat_histories[user_id][session_id]) > 10:
        chat_histories[user_id][session_id] = chat_histories[user_id][session_id][-10:]

    return full_response


async def stream_rag_response(vector_store, query: str, session_id: str, user_id: str = "anonymous", base_url: str = "") -> AsyncGenerator[str, None]:
    """Stream wrapper - gets full response then yields it (for streaming endpoint compatibility)."""
    response = await get_rag_response(vector_store, query, session_id, user_id, base_url)
    yield response
