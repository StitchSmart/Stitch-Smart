
/* ═══════════════════════════════════════════════
   PROFESSIONAL E-COMMERCE CHATBOT — JS
   ═══════════════════════════════════════════════ */

(function () {
    'use strict';

    const toggle = document.getElementById('chat-toggle');
    const chatWindow = document.getElementById('chat-window');
    const chatWidget = document.getElementById('chat-widget');
    const minimize = document.getElementById('chat-minimize');
    const chatClose = document.getElementById('chat-close');
    const messages = document.getElementById('chat-messages');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const sendBtn = document.getElementById('chat-send');
    const iconOpen = document.getElementById('chat-icon-open');
    const iconClose = document.getElementById('chat-icon-close');
    const unread = document.getElementById('chat-unread');

    // Ensure chat widget is attached to body so fixed positioning works across pages
    if (chatWidget && chatWidget.parentElement !== document.body) {
        document.body.appendChild(chatWidget);
    }

    let isOpen = false;

    // ── Toggle Chat ─────────────────────────────
    toggle.addEventListener('click', () => {
        isOpen = !isOpen;

        if (isOpen) {
            chatWindow.classList.add('open');
            toggle.classList.add('active');
            iconOpen.style.display = 'none';
            iconClose.style.display = 'block';
            unread.style.display = 'none';
            input.focus();
            // Load chat history for logged-in users
            loadChatHistory();
        } else {
            closeChat();
        }
    });

    minimize.addEventListener('click', closeChat);
    
    if (chatClose) {
        chatClose.addEventListener('click', () => {
            if (chatWidget) chatWidget.style.display = 'none';
        });
    }

    function closeChat() {
        isOpen = false;
        chatWindow.classList.remove('open');
        toggle.classList.remove('active');
        iconOpen.style.display = 'block';
        iconClose.style.display = 'none';
    }

    // ── Quick Action Buttons ────────────────────
    document.querySelectorAll('.quick-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const msg = btn.getAttribute('data-msg');
            if (msg) {
                input.value = msg;
                sendMessage(msg);
            }
        });
    });

    // ── Send Message ────────────────────────────
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;
        sendMessage(text);
    });

    function sendMessage(text) {
        // Hide welcome & quick actions on first message
        const welcome = messages.querySelector('.chat-welcome');
        const quickActs = messages.querySelector('.quick-actions');
        if (welcome) welcome.style.display = 'none';
        if (quickActs) quickActs.style.display = 'none';

        // Add user message
        appendMessage('user', text);
        // Save user message (if logged in) — fire-and-forget
        fetch('index.php?page=user_chat_save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'role=user&message=' + encodeURIComponent(text)
        }).catch(()=>{});
        input.value = '';
        input.focus();
        sendBtn.disabled = true;

        // Show typing indicator
        const typingEl = showTyping();

        // Send to backend
        fetch('index.php?page=user_chat_send', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'message=' + encodeURIComponent(text)
        })
            .then(res => res.json())
            .then(data => {
                removeTyping(typingEl);
                const response = data.response || 'Sorry, I could not process that.';
                appendMessage('bot', response);
                // Save bot response
                fetch('index.php?page=user_chat_save', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'role=bot&message=' + encodeURIComponent(response)
                }).catch(()=>{});
            })
            .catch(() => {
                removeTyping(typingEl);
                appendMessage('bot', 'Sorry, I\'m having trouble connecting right now. Please try again later.', true);
            })
            .finally(() => {
                sendBtn.disabled = false;
            });
    }

    // ── Load chat history ───────────────────────
    function loadChatHistory() {
        fetch('index.php?page=user_chat_history')
            .then(res => res.json())
            .then(data => {
                if (!data.messages || !data.messages.length) return;
                // remove welcome and quick-actions
                const welcome = messages.querySelector('.chat-welcome');
                const quickActs = messages.querySelector('.quick-actions');
                if (welcome) welcome.style.display = 'none';
                if (quickActs) quickActs.style.display = 'none';

                // append messages chronologically
                data.messages.forEach(m => {
                    appendMessage(m.role === 'bot' ? 'bot' : 'user', m.message);
                });
                // mark messages as loaded
                // (no-op) — future: could fetch unseen count
            }).catch(()=>{});
    }

    // open chat history from account page button
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'open-chat-history') {
            e.preventDefault();
            // open chat widget
            if (!isOpen) toggle.click();
            // chat will auto-load history on open
        }
    });

    // ── Auto open chat when URL requests it ─────
    function shouldOpenChatFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.has('open_chat') || window.location.hash === '#open-chat';
    }

    if (shouldOpenChatFromUrl()) {
        if (!isOpen) {
            toggle.click();
        }
        // Remove the query param/hash so refresh won't reopen again unexpectedly
        if (window.history && window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete('open_chat');
            if (url.hash === '#open-chat') url.hash = '';
            window.history.replaceState({}, document.title, url.toString());
        }
    }

    // ── Markdown Parser ─────────────────────────
    function parseMarkdown(text) {
        let html = text;
        // Escape HTML
        html = html.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        // Bold **text**
        html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
        // Italic *text*
        html = html.replace(/\*(.+?)\*/g, '<em>$1</em>');
        // Links [text](url)
        html = html.replace(/\[(.+?)\]\((.+?)\)/g, '<a href="$2" target="_blank" class="chat-link">$1</a>');
        // Bullet points: lines starting with • or - or *
        html = html.replace(/^\s*[•\-\*]\s+(.+)/gm, '<li>$1</li>');
        // Wrap consecutive <li> in <ul>
        html = html.replace(/(<li>.*<\/li>\n?)+/g, (match) => '<ul>' + match + '</ul>');
        // Line breaks
        html = html.replace(/\n/g, '<br>');
        // Clean up double <br> inside <ul>
        html = html.replace(/<ul><br>/g, '<ul>').replace(/<br><\/ul>/g, '</ul>');
        html = html.replace(/<\/li><br><li>/g, '</li><li>');
        return html;
    }

    // ── Append Message Bubble ───────────────────
    function appendMessage(type, text, isError) {
        const now = new Date();
        const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const msg = document.createElement('div');
        msg.className = 'msg ' + type + (isError ? ' msg-error' : '');

        const avatar = document.createElement('div');
        avatar.className = 'msg-avatar';
        avatar.textContent = type === 'bot' ? '🤖' : '👤';

        const content = document.createElement('div');

        const bubble = document.createElement('div');
        bubble.className = 'msg-bubble';
        if (type === 'bot') {
            bubble.innerHTML = parseMarkdown(text);
        } else {
            bubble.textContent = text;
        }

        const timeEl = document.createElement('div');
        timeEl.className = 'msg-time';
        timeEl.textContent = time;

        content.appendChild(bubble);
        content.appendChild(timeEl);

        msg.appendChild(avatar);
        msg.appendChild(content);

        messages.appendChild(msg);
        scrollToBottom();
    }

    // ── Typing Indicator ────────────────────────
    function showTyping() {
        const msg = document.createElement('div');
        msg.className = 'msg bot';
        msg.id = 'typing-msg';

        const avatar = document.createElement('div');
        avatar.className = 'msg-avatar';
        avatar.textContent = '🤖';

        const bubble = document.createElement('div');
        bubble.className = 'msg-bubble';

        const dots = document.createElement('div');
        dots.className = 'typing-indicator';
        dots.innerHTML = '<span></span><span></span><span></span>';

        bubble.appendChild(dots);
        msg.appendChild(avatar);
        msg.appendChild(bubble);

        messages.appendChild(msg);
        scrollToBottom();
        return msg;
    }

    function removeTyping(el) {
        if (el && el.parentNode) {
            el.parentNode.removeChild(el);
        }
    }

    // ── Scroll ──────────────────────────────────
    function scrollToBottom() {
        requestAnimationFrame(() => {
            messages.scrollTop = messages.scrollHeight;
        });
    }

    // ── Enter key (no shift) sends ──────────────
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });
})();
