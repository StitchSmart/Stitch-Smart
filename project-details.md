# Stitch Smart — Project Details

> Comprehensive technical documentation for the Stitch Smart platform.

---

## 1. Project Overview

**Stitch Smart** is a luxury apparel e-commerce web application developed as a Final Year Project (FYP). The platform serves two audiences:

- **Customers** — browse, design, and purchase custom and ready-made garments
- **Administrators** — manage inventory, orders, content, and analytics

The project integrates a **Python-based AI chatbot** using Google Gemini LLM and FAISS vector search.

---

## 2. System Requirements

| Component | Version |
|-----------|---------|
| PHP | 8.0+ |
| MySQL | 8.0+ |
| Python | 3.10+ |
| Web Server | Apache (XAMPP) or PHP built-in server |

**PHP Extensions required:** `mysqli`, `curl`, `mbstring`, `fileinfo`

**Key Python Packages:** `fastapi`, `uvicorn`, `langchain`, `langchain-google-genai`, `faiss-cpu`, `sentence-transformers`, `python-dotenv`

---

## 3. Architecture

### PHP MVC Pattern

```
public/index.php  ← Front Controller (Router)
        │
        ├── Routes ?page= to Controller::method()
        ├── Controller → Model (DB) → View (template)
        ├── $frontendPages[] — public routes
        └── $adminPages[]   — session-guarded admin routes
```

### AI Chatbot RAG Pipeline

```
User Question → ChatController.php → FastAPI (localhost:5000)
                                           │
                                    rag_chain.py
                                    │              │
                              FAISS search    Gemini LLM
                              (products.json) (response)
                                    └──────────────┘
                                        Answer
```

---

## 4. Database Schema Summary

| Table | Purpose |
|-------|---------|
| `products` | Product catalog |
| `categories` | Hierarchical categories (3 levels) |
| `orders` | Customer orders |
| `order_items` | Line items per order |
| `users` | Customer accounts |
| `admins` | Admin credentials |
| `banners` | Homepage banners |
| `custom_orders` | Design Yourself inquiries |
| `pages` | CMS pages |
| `settings` | Global site settings |
| `cart` | Session-based cart |
| `wishlist` | Customer saved products |
| `reviews` | Product reviews |

Full schema: `db/vigorean.sql`

---

## 5. Module Documentation

### Frontend Store

| Feature | Controller | View |
|---------|-----------|------|
| Homepage | `HomeController` | `views/home.php` |
| Products | `ProductController` | `views/products.php` |
| Single product | `ProductController` | `views/single-product.php` |
| Cart | `CartController` | `views/cart.php` |
| Checkout | `OrderController` | `views/checkout.php` |
| Customer auth | `CustomerController` | `views/` |
| Design Yourself | `DesignController` | `views/designyourself/` |
| AI Chatbot | `ChatController` | `public/js/chatbot.js` |

### Admin Panel

| Feature | Controller |
|---------|-----------|
| Login | `Admin/LoginController` |
| Dashboard + reports | `Admin/DashboardController` |
| Products (CRUD + AI) | `Admin/ProductController` |
| Categories (3-level) | `Admin/CategoryController` |
| Banners | `Admin/BannerController` |
| Orders | `OrderController` |
| CMS Pages | `Admin/PageController` |
| Theme + settings | `Admin/HomeController` |

### Design Yourself Forms

Six-step garment customization forms for: **Hoodie**, **Crewneck**, **Sweatpants**, **Shorts**.

Steps: Fit & Fabric → Labels → Prints → Finishing → Quantity → Contact & Submit

Each form generates a pre-filled `mailto:` inquiry to the business email.

### Python Chatbot Service

| File | Responsibility |
|------|---------------|
| `app/main.py` | FastAPI entry point |
| `app/routes.py` | Endpoints: `/chat`, `/health`, `/build-index` |
| `app/rag_chain.py` | LangChain RAG pipeline |
| `app/vector_store.py` | FAISS index management |
| `app/embeddings.py` | Sentence-Transformer wrapper |
| `app/llm.py` | Gemini LLM configuration |
| `app/prompts.py` | AI system prompt |

---

## 6. Environment Variables

### Root `.env` (PHP)

| Key | Description |
|-----|-------------|
| `APP_NAME` | Application display name |
| `APP_ENV` | `development` / `production` |
| `APP_URL` | Base URL |
| `DB_HOST` / `DB_NAME` / `DB_USER` / `DB_PASS` | MySQL credentials |
| `GOOGLE_API_KEY` | Google Gemini API key |
| `CHATBOT_API_URL` | Python chatbot server URL |
| `MAIL_HOST` / `MAIL_USERNAME` / `MAIL_PASSWORD` | SMTP credentials |

### `FYP-Chatbot/FYP-Chatbot/.env` (Python)

| Key | Description |
|-----|-------------|
| `GOOGLE_API_KEY` | Google Gemini API key |
| `FAISS_INDEX_PATH` | Path to FAISS index directory |
| `FAISS_EMBEDDING_MODEL` | Sentence-Transformer model name |
| `HOST` / `PORT` | Uvicorn server binding |

---

## 7. Security

| Area | Implementation |
|------|---------------|
| SQL Injection | Prepared statements via `mysqli` |
| XSS | `htmlspecialchars()` on all output |
| Passwords | `password_hash()` / `password_verify()` (bcrypt) |
| Sessions | `session_start()` with regeneration on login |
| Admin Routes | Server-side session guard |
| File Uploads | MIME type validation + restricted directory |
| Secrets | `.env` files excluded from Git |

---

## 8. API Endpoints (Python Chatbot)

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/health` | Service health check |
| `POST` | `/chat` | Send message, receive AI response |
| `GET` | `/build-index` | Rebuild FAISS from `products.json` |
| `GET` | `/similar` | Similar products by product ID |

---

## 9. Known Limitations

| Item | Notes |
|------|-------|
| Payment gateway | Not integrated — planned feature |
| Real-time order tracking | Not implemented |
| Chatbot quota | Gemini free tier: ~1500 req/day; rotate key if exhausted |
| Product sync | Manual JSON export from admin required |
| Automated tests | No unit/integration tests — manual QA |

---

## 10. Deployment Checklist

- [ ] Set `APP_ENV=production`, `APP_DEBUG=false` in `.env`
- [ ] Point Apache `DocumentRoot` to `public/`
- [ ] Enable HTTPS (Let's Encrypt)
- [ ] Set `chmod 600 .env`
- [ ] Run Python chatbot as a systemd service
- [ ] Configure real SMTP provider
- [ ] Set up cron for automated product JSON sync

---

## 11. Version History

| Version | Date | Notes |
|---------|------|-------|
| 1.1.0 | May 2026 | Added dynamic CMS custom pages support (About Us, Payment & Financing, Product Advice, and Our Story featuring university student founders Moiz Ahmed, Bissma Ijaz, Ali Haider). Patched MVC front-controller router slug bindings (`index.php`) to prevent dynamic routing argument crashes. Cleaned up, sanitized, and stylized footer column links with CSS text-transform rules and dynamic phone-to-WhatsApp link naming ("Helo desk"). |
| 1.0.0 | May 2026 | Initial FYP release |

---

*Stitch Smart — FYP Documentation © 2026*