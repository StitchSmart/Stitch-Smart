
            <!-- Website Settings Form -->
            <form action="<?php echo BASE_URL ?>index.php?page=admin_save_settings" method="POST" enctype="multipart/form-data">
                <div class="row">
  <!-- Social Media Links -->
                    <div class="col-sm-3 mt-3">
                        <div class="box db rounded-top p-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="text" id="facebook" name="facebook" class="form-control text-light border-0 border-bottom bg-transparent" value="<?php echo $facebook ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <div class="box db rounded-top p-3">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="text" id="instagram" name="instagram" class="form-control text-light border-0 border-bottom bg-transparent" value="<?php echo $instagram ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <div class="box db rounded-top p-3">
                            <label for="pinterest" class="form-label">Pinterest</label>
                            <input type="text" id="pinterest" name="pinterest" class="form-control text-light border-0 border-bottom bg-transparent" value="<?php echo $pinterest ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <div class="box db rounded-top p-3">
                            <label for="linkdin" class="form-label">LinkedIn</label>
                            <input type="text" id="linkdin" name="linkdin" class="form-control text-light border-0 border-bottom bg-transparent" value="<?php echo $linkdin ?? '' ?>">
                        </div>
                    </div>

                 <div class="d-flex justify-content-center mt-3">
                    <button type="submit" id="dbutton" class="btn px-5" style="margin-right: 50px;" name="save_social_info">Save Social Links</button>
                </div>
            </form>

                </div>
           
<!-- Banners Management -->
<div class="row mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white mb-0">Manage Banners</h2>
        <a href="<?php echo BASE_URL ?>index.php?page=banner_add" class="btn btn-warning px-4 rounded-pill fw-bold" style="background: #CD9A48; border: none; color: #1a0f0a;">
            + Add New Banner
        </a>
    </div>
    
    <div class="table-responsive rounded-4 shadow-lg" style="background: rgba(0,0,0,0.2); border: 1px solid rgba(205, 154, 72, 0.2);">
        <table class="table table-hover align-middle mb-0" style="color: #fff;">
            <thead style="background: rgba(205, 154, 72, 0.1); color: #CD9A48;">
                <tr class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">
                    <th class="py-3 px-4">Banner #</th>
                    <th class="py-3">Banner Image</th>
                    <th class="py-3">Banner Name</th>
                    <th class="py-3 text-end px-4">Update</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach($banners as $row): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td class="px-4 fw-bold" style="color: rgba(255,255,255,0.6);"><?php echo $id; ?></td>
                        <td>
                            <div class="p-2 bg-dark rounded shadow-sm d-inline-block">
                                <img src="<?php echo BASE_URL . $row['image_url']; ?>" width="100px" class="rounded">
                            </div>
                        </td>
                        <td class="fw-semibold"><?php echo $row['text']; ?></td>
                        <td class="text-end px-4">
                            <div class="btn-group">
                                <a href="<?php echo BASE_URL ?>index.php?page=edit_banner&id=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm px-3 rounded-pill me-2" 
                                   style="background: #CD9A48; color: #1a0f0a; font-weight: 700;">Edit</a>
                                <a href="<?php echo BASE_URL ?>index.php?page=delete_banner&id=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-danger px-3 rounded-pill" 
                                   style="font-weight: 700;"
                                   onclick="return confirm('Remove this banner?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php $id++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SEO Settings Section -->
<div class="d-flex justify-content-center align-items-center mt-5">
    <form class="w-75 p-4 mx-auto rounded border border-2" action="<?php echo BASE_URL ?>index.php?page=admin_save_settings" method="POST" id="metaForm">
        <div class="top w-100 rounded-top d-flex justify-content-between align-items-center p-2 mb-4" style="background: #3d241c;">
            <h3 class="text-white mb-0">SEO Settings</h3>
            <button type="button" onclick="generateMetaAI(this)" class="btn btn-sm" style="background: var(--accent-bronze); color: #000; font-weight: 700; border-radius: 50px;">✨ Generate SEO with AI</button>
        </div>
        <div id="ai-error-container"></div>
        
        <!-- Meta Title -->
        <div class="mb-3">
            <label for="meta-title" class="form-label">Meta Title</label>
            <input type="text" name="meta_title" id="meta-title" class="form-control" value="<?=$meta_title?>" />
        </div>
    
        <!-- Meta Description -->
        <div class="mb-3">
            <label for="meta-description" class="form-label">Meta Description</label>
            <textarea class="form-control" name="meta_description" id="meta-description" rows="3" ><?=$meta_description?></textarea>
        </div>
    
        <!-- Meta Keywords -->
        <div class="mb-3">
            <label for="meta-keywords" class="form-label">Meta Keywords</label>
            <input type="text" name="meta_keywords" id="meta-keywords" class="form-control" value="<?=$meta_keywords?>" />
        </div>
    
        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn" id="mbut" name="save_meta_info">Update SEO</button>
        </div>
    </form>
</div>

<script>
async function generateMetaAI(btn) {
    const originalText = btn.innerText;
    
    try {
        btn.disabled = true;
        btn.innerText = "Generating...";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        const url = `https://generativelanguage.googleapis.com/v1beta/models/<?= GEMINI_MODEL ?>:generateContent?key=${apiKey}`;

        const body = {
            contents: [{
                parts: [{
                    text: `Return ONLY valid JSON for SEO meta settings for a fashion brand named "Stitch Smart".
                    Format: {"title": "", "description": "", "keywords": ""}
                    Make it professional and optimized.`
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

        document.getElementById("meta-title").value = json.title || "";
        document.getElementById("meta-description").value = json.description || "";
        document.getElementById("meta-keywords").value = json.keywords || "";

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
            alert("AI Generation failed: " + err.message);
        }
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}
</script>

         


