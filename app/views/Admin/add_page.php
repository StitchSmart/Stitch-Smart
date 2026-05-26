<div class="d-flex justify-content-center align-items-center mt-5" > 
                            <form class="w-75 p-4 mx-auto rounded border border-2" enctype="multipart/form-data" action="index.php?page=store_page" method="post" novalidate>
    <style>
        .form-control.is-invalid,
        textarea.form-control.is-invalid,
        .note-editor .note-editable.is-invalid {
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
        .invalid-feedback-custom {
            color: #c92a2a;
            font-size: 0.95rem;
            margin-top: 0.25rem;
            display: block;
        }
    </style>
    <div class="top w-100 rounded-top">
        <h3 class="text-center text-white mb-4">Add Page</h3>
    </div>

    <?php if (!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <strong>Fix the highlighted fields below.</strong>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <div class="row">
     <div class="col-6">   

    <div class="mb-3">
        <label for="pname" class="form-label">Title</label>
        <input type="text" name="title" id="pname" class="form-control <?= isset($_SESSION['errors']['title']) ? 'is-invalid' : '' ?>" placeholder="<?= isset($_SESSION['errors']['title']) ? htmlspecialchars($_SESSION['errors']['title']) : 'Enter page title' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['title'] ?? '') ?>" required />
        <?php if(isset($_SESSION['errors']['title'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['title']) ?></span>
        <?php endif; ?>
    </div>


    <div class="mb-3">
        <label for="cat-description" class="form-label">Content</label>
       <textarea id="content" name="content" class="form-control <?= isset($_SESSION['errors']['content']) ? 'is-invalid' : '' ?>" required><?= htmlspecialchars($_SESSION['old_input']['content'] ?? '') ?></textarea>
        <?php if(isset($_SESSION['errors']['content'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['content']) ?></span>
        <?php endif; ?>
    </div>
  

</div>

  <div class="col-6"> 
    <div class="d-flex justify-content-between align-items-center mb-4 px-2 py-1 bg-success rounded">
        <h3 class="text-white mb-0" style="font-size: 1.2rem;">SEO Setting</h3>
        <button type="button" onclick="generateSEOWithAI()" class="btn btn-sm btn-light" id="aiBtn">✨ Generate SEO with AI</button>
    </div>
    <div id="ai-error-container"></div>

    <div class="mb-3">
        <label for="meta-title" class="form-label">Meta Title</label>
        <textarea class="form-control <?= isset($_SESSION['errors']['meta_title']) ? 'is-invalid' : '' ?>" name="meta_title" id="meta-title" rows="3" placeholder="<?= isset($_SESSION['errors']['meta_title']) ? htmlspecialchars($_SESSION['errors']['meta_title']) : 'Enter meta title' ?>" required><?= htmlspecialchars($_SESSION['old_input']['meta_title'] ?? '') ?></textarea>
        <?php if(isset($_SESSION['errors']['meta_title'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['meta_title']) ?></span>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="meta-description" class="form-label">Meta Description</label>
        <textarea class="form-control <?= isset($_SESSION['errors']['meta_desc']) ? 'is-invalid' : '' ?>" name="meta_desc" id="meta-description" rows="3" placeholder="<?= isset($_SESSION['errors']['meta_desc']) ? htmlspecialchars($_SESSION['errors']['meta_desc']) : 'Enter meta description' ?>" required><?= htmlspecialchars($_SESSION['old_input']['meta_desc'] ?? '') ?></textarea>
        <?php if(isset($_SESSION['errors']['meta_desc'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['meta_desc']) ?></span>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="meta-keyword" class="form-label">Meta Keywords</label>
        <textarea class="form-control <?= isset($_SESSION['errors']['meta_keywords']) ? 'is-invalid' : '' ?>" name="meta_keywords" id="meta-keyword" rows="3" placeholder="<?= isset($_SESSION['errors']['meta_keywords']) ? htmlspecialchars($_SESSION['errors']['meta_keywords']) : 'Enter meta keywords' ?>" required><?= htmlspecialchars($_SESSION['old_input']['meta_keywords'] ?? '') ?></textarea>
        <?php if(isset($_SESSION['errors']['meta_keywords'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['meta_keywords']) ?></span>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <button type="submit" name="update" class="btn" id="mbut">Save Changes</button>
    </div>
    <?php unset($_SESSION['old_input']); ?>
</form>

                        </div>

</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
<script>
$(document).ready(function () {
    $('#content').summernote({
        height: 300,
        placeholder: 'Write page content here...',
    toolbar: [
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['insert', ['link', 'picture']],
    ['view', ['codeview', 'fullscreen']]
]
    });

    if ($('#content').hasClass('is-invalid')) {
        $('.note-editable').addClass('is-invalid');
    }

    const form = document.querySelector('form[action="index.php?page=store_page"]');
    if (form) {
        form.addEventListener('submit', function(event) {
            let valid = true;
            const titleInput = document.getElementById('pname');
            const contentInput = document.getElementById('content');
            const metaTitle = document.getElementById('meta-title');
            const metaDescription = document.getElementById('meta-description');
            const metaKeywords = document.getElementById('meta-keyword');

            [titleInput, metaTitle, metaDescription, metaKeywords].forEach(field => {
                field.classList.remove('is-invalid');
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    field.placeholder = 'Fill this field.';
                    valid = false;
                }
            });

            const contentText = $('#content').summernote('code').replace(/<[^>]*>?/gm, '').trim();
            $('.note-editable').removeClass('is-invalid');
            if (!contentText) {
                $('#content').addClass('is-invalid');
                $('.note-editable').addClass('is-invalid');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
                document.querySelector('.is-invalid')?.focus();
            }
        });
    }
});

async function generateSEOWithAI() {
    const btn = document.getElementById("aiBtn");
    const titleInput = document.getElementById("pname");
    const title = titleInput.value.trim();
    const content = $('#content').summernote('code').replace(/<[^>]*>?/gm, ''); // get plain text

    if (!title) {
        titleInput.classList.add('is-invalid');
        titleInput.placeholder = 'Fill the Page Title field.';
        titleInput.focus();
        return;
    }

    try {
        btn.disabled = true;
        btn.innerText = "Generating...";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        const url = "https://generativelanguage.googleapis.com/v1beta/models/<?= GEMINI_MODEL ?>:generateContent?key=" + apiKey;

        const body = {
            contents: [{
                parts: [{
                    text: `Return ONLY valid JSON: {"title": "", "description": "", "keywords": ""}. Generate professional SEO meta data for a web page titled "${title}" with the following content summary: "${content.substring(0, 500)}"`
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
        text = text.replace(/```json|```/g, "").trim();
        const json = JSON.parse(text);

        document.getElementById("meta-title").value = json.title || "";
        document.getElementById("meta-description").value = json.description || "";
        document.getElementById("meta-keyword").value = json.keywords || "";

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
            alert("AI failed to generate SEO: " + err.message);
        }
    } finally {
        btn.disabled = false;
        btn.innerText = "✨ Generate SEO with AI";
    }
}
</script>