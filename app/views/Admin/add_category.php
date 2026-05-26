<div class="d-flex justify-content-center align-items-center mt-5">
<form class="w-75 p-4 border rounded shadow-lg bg-transparent"
method="POST"
enctype="multipart/form-data"
action="<?= BASE_URL ?>/index.php?page=store_category" novalidate>

    <style>
        .form-control.is-invalid,
        textarea.form-control.is-invalid,
        select.form-control.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.2);
            background: rgba(220, 53, 69, 0.06);
        }
        .form-control.is-invalid::placeholder,
        textarea.form-control.is-invalid::placeholder {
            color: #b02a37 !important;
            opacity: 1 !important;
            font-weight: 600;
        }
        select.form-control {
            background-color: rgba(243, 226, 205, 0.8) !important;
            color: #000 !important;
        }
        select.form-control option {
            background-color: #f5e4d0 !important;
            color: #000 !important;
        }
        select.form-control option:hover,
        select.form-control option:checked {
            background-color: #e8d3b3 !important;
            color: #000 !important;
        }
    </style>

    <?php if(!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
        <div class="alert alert-danger mb-4" role="alert">
            <strong>Fix the highlighted fields below.</strong>
        </div>
    <?php endif; ?>

    <div class="card-header rounded-top-4 py-3">
        <h3 class="text-center mb-0">Add Category</h3>
    </div>

<div class="mb-3">
    <label class="form-label fw-bold">Category Name</label>
    <input type="text" name="cat_name" id="cat_name" class="form-control <?= isset($_SESSION['errors']['cat_name']) ? 'is-invalid' : '' ?>" placeholder="<?= isset($_SESSION['errors']['cat_name']) ? htmlspecialchars($_SESSION['errors']['cat_name']) : 'Enter category name' ?>" style="background: rgba(255,255,255,0.05); color: inherit;" value="<?= htmlspecialchars($_SESSION['old_input']['cat_name'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Parent Category (Optional)</label>
    <select name="parent_id" class="form-control" style="background: rgba(255,255,255,0.05); color: inherit;">
        <option value="0" <?= (isset($_SESSION['old_input']['parent_id']) && $_SESSION['old_input']['parent_id'] == 0) ? 'selected' : '' ?>>-- None (Top Level) --</option>
        <?php foreach($parents as $parent): ?>
            <option value="<?= $parent['c_id'] ?>" <?= (isset($_SESSION['old_input']['parent_id']) && $_SESSION['old_input']['parent_id'] == $parent['c_id']) ? 'selected' : '' ?> >
                <?= str_repeat('&nbsp;&nbsp;', $parent['level']) ?>
                <?= ($parent['level'] > 0 ? '↳ ' : '') ?>
                <?= htmlspecialchars($parent['c_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Category Image</label>
        <input type="file" name="cimage" class="form-control <?= isset($_SESSION['errors']['cimage']) ? 'is-invalid' : '' ?>" style="background: rgba(255,255,255,0.05); color: inherit;">
        <?php if(isset($_SESSION['errors']['cimage'])): ?>
            <div class="invalid-feedback d-block"><?= htmlspecialchars($_SESSION['errors']['cimage']) ?></div>
        <?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Category Banner</label>
        <input type="file" name="bimage" class="form-control <?= isset($_SESSION['errors']['bimage']) ? 'is-invalid' : '' ?>" style="background: rgba(255,255,255,0.05); color: inherit;">
        <?php if(isset($_SESSION['errors']['bimage'])): ?>
            <div class="invalid-feedback d-block"><?= htmlspecialchars($_SESSION['errors']['bimage']) ?></div>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 mt-4">
    <label class="form-label mb-0 fw-bold">Category Description</label>
    <button type="button" onclick="generateCategoryAI(this)" class="btn btn-dark btn-sm">✨ Generate with AI</button>
</div>
<div id="ai-error-container"></div>
<div class="mb-3">
    <textarea name="cat_desc" id="cat_desc" class="form-control <?= isset($_SESSION['errors']['cat_desc']) ? 'is-invalid' : '' ?>" rows="4" placeholder="<?= isset($_SESSION['errors']['cat_desc']) ? htmlspecialchars($_SESSION['errors']['cat_desc']) : 'AI will generate this...' ?>" style="background: rgba(255,255,255,0.05); color: inherit;" required><?= htmlspecialchars($_SESSION['old_input']['cat_desc'] ?? '') ?></textarea>
</div>

<div class="seo-section p-3 border rounded mb-4" style="background: rgba(0,0,0,0.1);">
    <h5 class="mb-3 fw-bold">SEO Settings</h5>
    <div class="mb-3">
        <label class="fw-bold">Meta Title</label>
        <input type="text" name="meta_title" id="meta_title" class="form-control" style="background: rgba(255,255,255,0.05); color: inherit;">
    </div>
    <div class="mb-3">
        <label class="fw-bold">Meta Description</label>
        <textarea name="meta_desc" id="meta_desc" class="form-control" style="background: rgba(255,255,255,0.05); color: inherit;"><?= htmlspecialchars($_SESSION['old_input']['meta_desc'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label class="fw-bold">Meta Keywords</label>
        <textarea name="meta_keywords" id="meta_keywords" class="form-control" style="background: rgba(255,255,255,0.05); color: inherit;"><?= htmlspecialchars($_SESSION['old_input']['meta_keywords'] ?? '') ?></textarea>
    </div>
</div>

<div class="text-center">
    <button type="submit" class="btn btn-success px-5">Save Category</button>
</div>

</form>

</div>
<?php unset($_SESSION['errors'], $_SESSION['old_input']); ?>

<script>
async function generateCategoryAI(btn) {
    const nameInput = document.getElementById("cat_name");
    const name = nameInput.value.trim();
    if(!name) {
        nameInput.classList.add('is-invalid');
        nameInput.placeholder = 'Fill the Category Name field.';
        nameInput.focus();
        return;
    }

    nameInput.classList.remove('is-invalid');
    try {
        btn.disabled = true;
        btn.innerText = "Generating...";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        const url = `https://generativelanguage.googleapis.com/v1beta/models/<?= GEMINI_MODEL ?>:generateContent?key=${apiKey}`;

        const body = {
            contents: [{
                parts: [{
                    text: `Return ONLY valid JSON for a product category named "${name}" in a high-end fashion store.
                    Format: {"description": "", "seo_title": "", "seo_desc": "", "seo_keywords": ""}
                    Make it professional, luxury, and optimized for SEO.`
                }]
            }]
        };

        const res = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body)
        });

        const data = await res.json();
        if (data.error) throw new Error(data.error.message);

        let text = data.candidates[0].content.parts[0].text;
        
        // Robust JSON extraction
        const jsonMatch = text.match(/\{[\s\S]*\}/);
        if (!jsonMatch) throw new Error("Could not parse AI response.");
        const json = JSON.parse(jsonMatch[0]);

        document.getElementById("cat_desc").value = json.description || "";
        document.getElementById("meta_title").value = json.seo_title || "";
        document.getElementById("meta_desc").value = json.seo_desc || "";
        document.getElementById("meta_keywords").value = json.seo_keywords || "";

    } catch (err) {
        console.error("AI Error:", err);
        const errorContainer = document.getElementById("ai-error-container");
        if (errorContainer) {
            errorContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show mt-3 border-0 rounded-3 p-3 shadow" role="alert" style="background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3) !important; color: #ea868f;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>AI Generation failed:</strong> ${err.message}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger px-3 py-1 rounded-pill" data-bs-dismiss="alert" aria-label="Close" style="font-weight: 600; border-color: rgba(220,53,69,0.5);">OK</button>
                    </div>
                </div>
            `;
        } else {
            alert("AI failed: " + err.message);
        }
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="<?= BASE_URL ?>/index.php?page=store_category"]');
    if (!form) return;

    form.addEventListener('submit', function(event) {
        let valid = true;
        const fields = [
            { el: document.getElementById('cat_name'), error: 'Fill the Category Name field.' },
            { el: document.getElementById('cat_desc'), error: 'Fill the Category Description field.' }
        ];

        fields.forEach(field => {
            if (!field.el) return;
            field.el.classList.remove('is-invalid');
            if (!field.el.value.trim()) {
                field.el.classList.add('is-invalid');
                field.el.placeholder = field.error;
                field.el.value = '';
                valid = false;
            }
        });

        if (!valid) {
            event.preventDefault();
            form.querySelector('.is-invalid')?.focus();
        }
    });
});
</script>
