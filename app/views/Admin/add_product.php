<!-- Styles handled globally by theme-luxury.css -->
<div class="container mt-5 mb-5">
    <div class="card  border-0 rounded-4">
        
        <!-- Header -->
        <div class="card-header rounded-top-4 py-3">
            <h4 class="mb-0 text-center">New Item</h4>
        </div>

        <div class="card-body px-4 py-4">
            <style>
                .form-control.is-invalid,
                textarea.form-control.is-invalid {
                    border-color: #dc3545 !important;
                    box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.25);
                    background: rgba(220, 53, 69, 0.06);
                }
                .form-control.is-invalid::placeholder,
                textarea.form-control.is-invalid::placeholder {
                    color: #b02a37 !important;
                    opacity: 1 !important;
                    font-weight: 600;
                }
            </style>
            <form action="<?= BASE_URL ?>/index.php?page=store_product" method="post" enctype="multipart/form-data" novalidate>

                <?php if(!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach($_SESSION['errors'] as $message): ?>
                                <li><?= htmlspecialchars($message) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Product Basic Info -->
                <h4 class="mb-3 tex text-center">Product Information</h4>
                <hr>
                <div class="row g-3">
                    <!-- 1. Add Photo -->
                    <div class="col-12">
                        <label class="form-label">Product Images (minimum 3)</label>
                        <input type="file" name="bimage[]" id="imageInput" class="form-control <?= isset($_SESSION['errors']['bimage']) ? 'is-invalid' : '' ?>" accept="image/*" multiple required>
                        <div id="previewContainer" class="mt-3 d-flex flex-wrap gap-2"></div>
                        <?php if(isset($_SESSION['errors']['bimage'])): ?>
                            <div class="invalid-feedback d-block"><?= htmlspecialchars($_SESSION['errors']['bimage']) ?></div>
                        <?php endif; ?>
                        <small class="text-muted d-block mt-2">Select at least three product images for the gallery.</small>
                    </div>

                    <!-- 2. Article Number -->
                    <div class="col-12">
                        <label class="form-label">Article Number</label>
                        <input type="text" name="art" class="form-control <?= isset($_SESSION['errors']['art']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['art'] ?? '') ?>" placeholder="<?= isset($_SESSION['errors']['art']) ? htmlspecialchars($_SESSION['errors']['art']) : 'Enter Article Number' ?>" required>
                        <?php if(isset($_SESSION['errors']['art'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['art']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- 3. Description -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="pdesc" class="form-control <?= isset($_SESSION['errors']['pdesc']) ? 'is-invalid' : '' ?>" id="pdesc" rows="3" placeholder="<?= isset($_SESSION['errors']['pdesc']) ? htmlspecialchars($_SESSION['errors']['pdesc']) : 'Enter Description' ?>" required><?= htmlspecialchars($_SESSION['old_input']['pdesc'] ?? '') ?></textarea>
                        <?php if(isset($_SESSION['errors']['pdesc'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['pdesc']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- 4. Generate with AI section -->
                    <div class="col-12 text-center">
                        <button type="button" id="aiBtn" onclick="analyzeImage()" class="btn btn-sm btn-success">
                            ✨ Generate with AI
                        </button>
                        <span id="loader" style="display:none; margin-left:10px;">
                            ⏳ Generating...
                        </span>
                    </div>
                    <div id="ai-error-container" class="col-12"></div>

                    <hr class="my-4">

                    <!-- 5. Remaining fields -->
                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="pname" id="pname" class="form-control <?= isset($_SESSION['errors']['pname']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['pname'] ?? '') ?>" placeholder="<?= isset($_SESSION['errors']['pname']) ? htmlspecialchars($_SESSION['errors']['pname']) : 'Enter Product Name' ?>" required>
                        <?php if(isset($_SESSION['errors']['pname'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['pname']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control <?= isset($_SESSION['errors']['price']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['price'] ?? '') ?>" placeholder="<?= isset($_SESSION['errors']['price']) ? htmlspecialchars($_SESSION['errors']['price']) : 'Enter Price' ?>" required>
                        <?php if(isset($_SESSION['errors']['price'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['price']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Details</label>
                        <textarea name="details" class="form-control <?= isset($_SESSION['errors']['details']) ? 'is-invalid' : '' ?>" rows="3" placeholder="<?= isset($_SESSION['errors']['details']) ? htmlspecialchars($_SESSION['errors']['details']) : 'Enter Details' ?>" required><?= htmlspecialchars($_SESSION['old_input']['details'] ?? '') ?></textarea>
                        <?php if(isset($_SESSION['errors']['details'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['details']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Inventory & Pricing -->
                <h4 class="mb-3 tex text-center">Inventory & Category</h4>
                <hr>
                <div class="row g-3">
                    <!-- Size Boxes / Quantities -->
                    <div class="col-md-2">
                        <label class="form-label">Size XS</label>
                        <input name="qty_xs" class="form-control qty-input" type="number" min="0" value="<?= $_SESSION['old_input']['qty_xs'] ?? '0' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size S</label>
                        <input name="qty_s" class="form-control qty-input" type="number" min="0" value="<?= $_SESSION['old_input']['qty_s'] ?? '0' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size L</label>
                        <input name="qty_l" class="form-control qty-input" type="number" min="0" value="<?= $_SESSION['old_input']['qty_l'] ?? '0' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size XL</label>
                        <input name="qty_xl" class="form-control qty-input" type="number" min="0" value="<?= $_SESSION['old_input']['qty_xl'] ?? '0' ?>">
                    </div>

                    <!-- Total Quantity (Auto-calculated) -->
                    <div class="col-md-2">
                        <label class="form-label">Total Quantity</label>
                        <input id="totalQty" class="form-control bg-light" type="text" readonly value="0">
                    </div>

                    <!-- Design Yourself Dropdown -->
                    <div class="col-md-2">
                        <label class="form-label">Design Yourself</label>
                        <select name="Designing" class="form-select">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Category Selection</label>
                        <div class="category-hover-selector p-3 border rounded shadow-sm <?= isset($_SESSION['errors']['parent_id']) ? 'border-danger' : '' ?>">
                            <select name="parent_id" class="form-select border-0 bg-transparent fw-bold <?= isset($_SESSION['errors']['parent_id']) ? 'is-invalid' : '' ?>" required size="5">
                                <option value="" disabled class="category-placeholder">-- Select a Brand/Category --</option>
                                <?php foreach($top_categories as $top_cat): ?>
                                    <optgroup label="✨ <?= htmlspecialchars($top_cat['c_name']) ?>">
                                        <option value="<?= $top_cat['c_id'] ?>" class="py-2 px-3" <?= (isset($_SESSION['old_input']['parent_id']) && $_SESSION['old_input']['parent_id'] == $top_cat['c_id']) ? 'selected' : '' ?>>
                                            ↳ <?= htmlspecialchars($top_cat['c_name']) ?>
                                        </option>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($_SESSION['errors']['parent_id'])): ?>
                                <div class="invalid-feedback d-block"><?= htmlspecialchars($_SESSION['errors']['parent_id']) ?></div>
                            <?php else: ?>
                                <div class="invalid-feedback d-block">Select a category.</div>
                            <?php endif; ?>
                            <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle"></i> Tip: Categories are grouped by brand for faster selection.</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- SEO Section -->
                <h4 class="mb-3 tex text-center">SEO Settings</h4>
                <hr>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control" value="<?= $_SESSION['old_input']['meta_title'] ?? '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="<?= $_SESSION['old_input']['meta_keywords'] ?? '' ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_desc" class="form-control" id="meta_desc" rows="3"><?= $_SESSION['old_input']['meta_desc'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-dark px-4 py-2 rounded-3">
                        Save Product
                    </button>
                </div>

                <?php unset($_SESSION['old_input']); ?>
            </form>
        </div>
    </div>
</div>
<script>
// 1. Quantity Calculation Logic
document.addEventListener("DOMContentLoaded", function() {
    const qtyInputs = document.querySelectorAll('.qty-input');
    const totalQtyField = document.getElementById('totalQty');

    function calculateTotal() {
        let total = 0;
        qtyInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        totalQtyField.value = total;
    }

    qtyInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    // Initial calculation
    calculateTotal();
});

// 2. Existing Image AI Logic
let base64Image = "";

document.getElementById("imageInput").addEventListener("change", function (e) {
    const files = Array.from(e.target.files || []);
    const previewContainer = document.getElementById("previewContainer");
    previewContainer.innerHTML = "";
    base64Image = "";

    files.forEach((file, index) => {
        if (!file.type.startsWith('image/')) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function () {
            if (index === 0) {
                base64Image = reader.result.split(",")[1];
            }

            const img = document.createElement('img');
            img.src = reader.result;
            img.style.maxWidth = '120px';
            img.style.borderRadius = '12px';
            img.style.boxShadow = '0 10px 30px rgba(0,0,0,0.08)';
            img.style.objectFit = 'cover';
            img.style.height = '110px';
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

async function analyzeImage() {
    const btn = document.getElementById("aiBtn");
    const loader = document.getElementById("loader");

    try {
        if (!base64Image) {
            alert("Please upload an image first.");
            return;
        }

        btn.disabled = true;
        btn.innerText = "Generating...";
        loader.style.display = "inline";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        const url = `https://generativelanguage.googleapis.com/v1beta/models/<?= GEMINI_MODEL ?>:generateContent?key=${apiKey}`;

        const body = {
            contents: [{
                parts: [
                    { 
                        text: `Return ONLY valid JSON: 
                        {
                          "title": "product name",
                          "description": "brief description",
                          "details": "technical details/fabric info",
                          "price": "estimated price in Rs",
                          "seo_title": "SEO Title",
                          "seo_description": "SEO Description",
                          "seo_keywords": "keyword1, keyword2"
                        }
                        Analyze this product image. For the price, estimate the current online market value and provide a competitive (slightly lower) price.` 
                    },
                    { inline_data: { mime_type: "image/jpeg", data: base64Image } }
                ]
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

        // fill everything
        document.getElementById("pname").value = json.title || "";
        document.getElementById("pdesc").value = json.description || "";
        document.querySelector('[name="details"]').value = json.details || "";
        document.querySelector('[name="price"]').value = json.price.toString().replace(/[^0-9]/g, "") || "";
        
        // also fill SEO
        document.getElementById("meta_title").value = json.seo_title || json.title || "";
        document.getElementById("meta_desc").value = json.seo_description || json.description || "";
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
        btn.innerText = "✨ Generate with AI";
        loader.style.display = "none";
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="<?= BASE_URL ?>/index.php?page=store_product"]');
    if (!form) return;

    form.addEventListener('submit', function(event) {
        let valid = true;
        const requiredFields = form.querySelectorAll('input[required], textarea[required], select[required]');

        requiredFields.forEach(field => {
            field.classList.remove('is-invalid');
            const feedback = field.parentElement.querySelector('.invalid-feedback');
            if (field.type === 'file') {
                if (!field.files || field.files.length === 0) {
                    field.classList.add('is-invalid');
                    valid = false;
                    if (feedback) feedback.textContent = 'Please upload at least 3 images.';
                }
            } else if (!field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
                if (feedback) feedback.textContent = 'Fill the text field.';
            }
        });

        if (!valid) {
            event.preventDefault();
            document.querySelector('.alert-danger')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

</script>