from langchain_google_genai import ChatGoogleGenerativeAI
from app.config import GOOGLE_API_KEY, LLM_MODEL_NAME, LLM_TEMPERATURE, LLM_MAX_NEW_TOKENS

# Cache LLM instances
_llm_cache = {}

def get_llm(streaming: bool = True):
    """Return a cached Google Gemini Chat LLM."""
    global _llm_cache
    if streaming not in _llm_cache:
        _llm_cache[streaming] = ChatGoogleGenerativeAI(
            model=LLM_MODEL_NAME,
            google_api_key=GOOGLE_API_KEY,
            temperature=LLM_TEMPERATURE,
            max_output_tokens=LLM_MAX_NEW_TOKENS,
            streaming=streaming,
        )
    
    return _llm_cache[streaming]
