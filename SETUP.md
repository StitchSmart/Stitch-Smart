# Stitch Smart — Setup Guide

> Step-by-step installation and run instructions for the Stitch Smart platform.

---

## Prerequisites

Make sure the following are installed on your machine before you begin:

| Tool | Minimum Version | Check Command |
|------|----------------|---------------|
| PHP | 8.0+ | `php -v` |
| MySQL | 8.0+ | `mysql --version` |
| Python | 3.10+ | `python --version` |
| pip | Latest | `pip --version` |
| Composer | Optional | `composer --version` |

**Required PHP extensions** (enable in `php.ini`):
```ini
extension=mysqli
extension=curl
extension=mbstring
extension=fileinfo
```
Find your `php.ini` location: `php --ini`

---

## Step 1 — Clone / Download the Project

```bash
git clone https://github.com/StitchSmart/Stitch-Smart.git
cd Stitch-Smart
```

Or extract the ZIP archive into your XAMPP `htdocs` directory:
```
C:\xampp\htdocs\Stitch-Smart\
```

---

## Step 2 — Configure Environment Variables

### 2a. PHP Application

```bash
# Windows
copy .env.example .env

# macOS / Linux
cp .env.example .env
```

Open `.env` and fill in your values:

```env
# Database
DB_HOST=localhost
DB_NAME=StitchSmart
DB_USER=root
DB_PASS=

# Google Gemini (get free key at https://aistudio.google.com/apikey)
GOOGLE_API_KEY=your_key_here

# Base URL — adjust for your environment
# XAMPP:        http://localhost/Stitch-Smart/public/
# Built-in PHP: http://localhost:8000/
APP_URL=http://localhost:8000/
```

### 2b. Python Chatbot

```bash
# Windows
copy FYP-Chatbot\FYP-Chatbot\.env.example FYP-Chatbot\FYP-Chatbot\.env

# macOS / Linux
cp FYP-Chatbot/FYP-Chatbot/.env.example FYP-Chatbot/FYP-Chatbot/.env
```

Open `FYP-Chatbot/FYP-Chatbot/.env` and set:
```env
GOOGLE_API_KEY=your_key_here
```

> **Getting a free Gemini API key:**
> 1. Go to https://aistudio.google.com/apikey
> 2. Sign in with a Google account
> 3. Click **Create API Key** → **Create API key in new project**
> 4. Copy the key (starts with `AIza...`)

---

## Step 3 — Import the Database

### Option A — XAMPP phpMyAdmin

1. Start XAMPP → Start **Apache** and **MySQL**
2. Open http://localhost/phpmyadmin
3. Click **New** → Database name: `StitchSmart` → **Create**
4. Select `StitchSmart` → Click **Import**
5. Choose `db/vigorean.sql` → Click **Go**

### Option B — Command Line

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS StitchSmart;"
mysql -u root -p StitchSmart < db/vigorean.sql
```

---

## Step 4 — Set Up Python Virtual Environment

```bash
cd FYP-Chatbot/FYP-Chatbot

# Create virtual environment
python -m venv venv

# Activate — Windows
venv\Scripts\activate

# Activate — macOS / Linux
source venv/bin/activate

# Install dependencies
pip install -r requirements.txt
```

> **Note:** The first run downloads the embedding model (~90 MB). This is a one-time download.

---

## Step 5 — Run the Project

You need **two terminal windows** open simultaneously.

### Terminal 1 — PHP Web Server

**Option A: PHP Built-in Server (Recommended for development)**
```bash
cd public
php -S localhost:8000
```
Site: http://localhost:8000

**Option B: XAMPP Apache**

No extra command needed — just ensure Apache is running.
Site: http://localhost/Stitch-Smart/public/

---

### Terminal 2 — Python AI Chatbot

```bash
cd FYP-Chatbot/FYP-Chatbot

# Activate venv first (if not already active)
venv\Scripts\activate       # Windows
source venv/bin/activate    # macOS / Linux

# Start the API server
python -m uvicorn app.main:app --host 0.0.0.0 --port 5000
```

Chatbot API: http://localhost:5000

---

## Step 6 — Build the FAISS Product Search Index

After the chatbot server is running, open this URL in your browser to build the AI product index:

```
http://localhost:5000/build-index
```

You should see: `{"status": "index built successfully"}`

> **When to re-run this:** Any time you add, edit, or delete products in the admin panel, re-export products JSON and rebuild the index. See the [Sync Products](#syncing-products-with-chatbot) section below.

---

## Access URLs

| Resource | URL |
|----------|-----|
| Storefront | http://localhost:8000 |
| Admin Login | http://localhost:8000/index.php?page=admin_login |
| Chatbot Health | http://localhost:5000/health |
| XAMPP Storefront | http://localhost/Stitch-Smart/public/ |
| XAMPP Admin | http://localhost/Stitch-Smart/public/index.php?page=admin_login |

### Default Admin Credentials
```
Email:    stitchSmartofficial@gmail.com
Password: 1234
```
> **Security:** Change the admin password immediately after first login.

---

## Syncing Products with Chatbot

When you update the product catalog, sync it with the AI chatbot:

1. **Export products JSON** from the admin panel:
   ```
   http://localhost:8000/index.php?page=exportJSON
   ```
2. The exported file is automatically placed at `FYP-Chatbot/FYP-Chatbot/data/products.json`
3. **Rebuild the index:**
   ```
   http://localhost:5000/build-index
   ```

---

## Dynamic Page Builder (CMS Setup)

The platform includes a database-driven Dynamic Page Builder (CMS) for customer informational pages like **About Us**, **Payment & Financing**, **Product Advice**, and **Our Story**.

To customize these pages:
1. Access the Admin Panel at `/index.php?page=pages`.
2. Edit existing pages (e.g., dynamic page slugs: `about-us`, `payment-and-financing`, `product-advice`, `ourstory`).
3. Use custom HTML or standard Bootstrap grid cards to format layouts beautifully.
4. **Student Founding Story**: The UMT university student founders story is custom-tailored inside the `ourstory` page. It features profiles for:
   - **Moiz Ahmed**: CEO & Lead Developer
   - **Bissma Ijaz**: Inventory Manager
   - **Ali Haider**: Finance Manager

---

## Troubleshooting

### Chatbot shows "No response received" or "high traffic"
- **Cause:** Gemini free tier daily quota (~1500 req/day) exhausted
- **Fix:** Wait 24 hours, or create a new Google account and get a new API key, then update `.env`

### Chatbot widget not responding
- **Cause:** Python chatbot server not running
- **Fix:** Ensure Terminal 2 is running the `uvicorn` command

### "Connection refused" errors
- **Cause:** Python server crashed or wrong port
- **Fix:** Restart uvicorn in Terminal 2

### PHP site shows database errors
- **Cause:** MySQL not running or wrong credentials in `.env`
- **Fix:** Start MySQL, verify `DB_*` values in `.env`

### Products not showing in chatbot
- **Cause:** FAISS index not built or outdated
- **Fix:** Run `http://localhost:5000/build-index`

### Blank page or PHP errors
- **Cause:** Missing PHP extensions
- **Fix:** Enable `mysqli`, `curl`, `mbstring`, `fileinfo` in `php.ini` and restart server

---

## Directory Overview

```
Stitch-Smart/
├── .env                  ← Your local config (never commit this)
├── .env.example          ← Template for .env
├── public/               ← Document root — point your server here
│   └── index.php         ← Front controller / router
├── app/                  ← MVC application code
│   ├── controllers/      ← Route handlers
│   ├── models/           ← Database queries
│   ├── views/            ← HTML templates
│   └── services/         ← External API bridge
├── config/               ← PHP config files
├── db/                   ← SQL dump
└── FYP-Chatbot/
    └── FYP-Chatbot/      ← Python chatbot
        ├── .env          ← Chatbot-specific config
        ├── app/          ← FastAPI application
        ├── data/         ← products.json for AI
        └── faiss_index/  ← Vector search index
```

---

*Stitch Smart — Setup Guide © 2026*
