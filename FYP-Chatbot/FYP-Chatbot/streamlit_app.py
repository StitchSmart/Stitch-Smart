import streamlit as st
import requests
import uuid

# Configuration
API_URL = "http://127.0.0.1:8000/chat"

st.set_page_config(page_title="🛍️ E-Commerce Bot Tester", layout="wide")

st.title("🛍️ E-Commerce Chatbot Tester")
st.markdown("""
This Streamlit app is a testing tool for the RAG Chatbot. 
It connects to the FastAPI backend and supports:
- **Streaming Responses**: Visualized in real-time.
- **Session History**: Partitioned by User and Session ID.
- **Direct Prompt Context**: No rephrasing, just raw retrieval and history.
""")

# Sidebar for session management
with st.sidebar:
    st.header("👤 User & Session Settings")
    user_id = st.text_input("User ID", value="user_1", help="Identify unique users.")
    
    if "session_id" not in st.session_state:
        st.session_state.session_id = str(uuid.uuid4())[:8]
    
    session_id = st.text_input("Session ID", value=st.session_state.session_id, help="Unique ID for this conversation turn.")
    
    if st.button("🔄 Reset Session"):
        st.session_state.messages = []
        st.session_state.session_id = str(uuid.uuid4())[:8]
        st.rerun()

    st.divider()
    st.info(f"Connected to: {API_URL}")

# Initialize chat history
if "messages" not in st.session_state:
    st.session_state.messages = []

# Display chat messages from history on app rerun
for message in st.session_state.messages:
    with st.chat_message(message["role"]):
        st.markdown(message["content"])

# React to user input
if prompt := st.chat_input("Ask about headphones, laptops, or cameras..."):
    # Display user message in chat message container
    st.chat_message("user").markdown(prompt)
    st.session_state.messages.append({"role": "user", "content": prompt})

    # Prepare request payload
    payload = {
        "query": prompt,
        "session_id": session_id,
        "user_id": user_id
    }

    # Display assistant response in chat message container
    with st.chat_message("assistant"):
        response_placeholder = st.empty()
        full_response = ""
        
        try:
            # Send POST request with stream=True
            with requests.post(API_URL, json=payload, stream=True, timeout=120) as r:
                if r.status_code == 200:
                    for chunk in r.iter_content(chunk_size=None):
                        if chunk:
                            token = chunk.decode("utf-8")
                            full_response += token
                            # Update the response placeholder with the cumulative text
                            response_placeholder.markdown(full_response + "▌")
                    response_placeholder.markdown(full_response)
                else:
                    try:
                        error_detail = r.json().get("detail", "Error from server")
                    except:
                        error_detail = r.text
                    st.error(f"Server Error ({r.status_code}): {error_detail}")
        except Exception as e:
            st.error(f"Network Error: {e}")

    # Add assistant response to chat history
    if full_response:
        st.session_state.messages.append({"role": "assistant", "content": full_response})
