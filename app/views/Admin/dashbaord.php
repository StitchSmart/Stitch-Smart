
<!-- Website & Social Settings Form -->
<form action="<?php echo BASE_URL ?>index.php?page=admin_save_settings" method="POST" enctype="multipart/form-data">
    <!-- Website Contact Info -->
    <div class="row">
        <div class="col-md-4">
            <div class="box db rounded mt-2 p-3">
                <label for="webname" class="form-label">Website Name</label>
                <input type="text" id="webname" name="webname" class="form-control d-block border-0 border-bottom text-light bg-transparent" value="<?php echo $webname ?? '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="box db rounded mt-2 p-3">
                <label for="webmail" class="form-label">Website Email</label>
                <input type="email" id="webmail" name="webmail" class="form-control border-0 border-bottom text-light bg-transparent" value="<?php echo $webmail ?? '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="box db rounded mt-2 p-3">
                <label for="webcontact" class="form-label">Website Contact</label>
                <input type="text" id="webcontact" name="webcontact" class="form-control border-0 border-bottom text-light bg-transparent" value="<?php echo $webcontact ?? '' ?>">
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <button type="submit" id="dbutton" class="btn me-2 px-5" name="save_contact_info">Save Contact Settings</button>
    </div>
</form>

<!-- SEO Settings Section -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <form class="card-body p-4" action="<?php echo BASE_URL ?>index.php?page=admin_save_settings" method="POST">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">SEO Settings</h5>
                    <button type="button" id="aiBtn" onclick="generateSEOAI(this)" class="btn btn-sm" style="background: var(--accent-bronze); color: #000; font-weight: 700; border-radius: 50px; padding: 5px 15px;">✨ Generate with AI</button>
                </div>
                <div id="ai-error-container"></div>
                
                <div class="mb-3">
                    <label for="meta-title" class="form-label">SEO Title</label>
                    <input type="text" name="meta_title" id="meta-title" class="form-control" value="<?=$meta_title?>" />
                </div>
            
                <div class="mb-3">
                    <label for="meta-description" class="form-label">SEO Description</label>
                    <textarea class="form-control" name="meta_description" id="meta-description" rows="3"><?=$meta_description?></textarea>
                </div>
            
                <div class="mb-3">
                    <label for="meta-keywords" class="form-label">SEO Keywords</label>
                    <input type="text" name="meta_keywords" id="meta-keywords" class="form-control" value="<?=$meta_keywords?>" />
                </div>
            
                <div class="text-end">
                    <button type="submit" class="btn" id="mbut" name="save_meta_info">Update SEO</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Dashboard Counts (Sales Boxes) -->
<div class="mt-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="box dbox text-center p-4 rounded shadow-sm">
                <h5 class="mb-2">Total Products</h5>
                <h3 class="fw-bold mb-0"><?php echo $counts['products'] ?? 0 ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box dbox b text-center p-4 rounded shadow-sm">
                <h5 class="mb-2">Total Categories</h5>
                <h3 class="fw-bold mb-0"><?php echo $counts['categories'] ?? 0 ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box dbox text-center p-4 rounded shadow-sm">
                <h5 class="mb-2">Total Orders</h5>
                <h3 class="fw-bold mb-0"><?php echo $counts['orders'] ?? 0 ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box dbox b text-center p-4 rounded shadow-sm">
                <h5 class="mb-2">Total Blogs</h5>
                <h3 class="fw-bold mb-0"><?php echo $counts['blogs'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Stock Status Pie Chart -->
<div class="row mt-5 mb-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4 fw-bold">Stock Status Overview</h5>
                <div style="height: 320px;">
                    <canvas id="stockPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4 fw-bold">Low Stock Summary</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-3">
                        Healthy Stock
                        <span class="badge bg-success rounded-pill"><?php echo $counts['healthy_stock'] ?? 0 ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-3">
                        Low Stock (≤ 10 units)
                        <span class="badge bg-warning rounded-pill"><?php echo $counts['low_stock'] ?? 0 ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        Out of Stock
                        <span class="badge bg-danger rounded-pill"><?php echo $counts['out_of_stock'] ?? 0 ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Low-Stock Product List -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title mb-4 fw-bold">Low Stock Products</h5>
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lowStockProducts) || !empty($outOfStockProducts)): ?>
                                <?php foreach ($lowStockProducts as $index => $product): ?>
                                    <tr>
                                        <td><?php echo $index + 1 ?></td>
                                        <td><?php echo htmlspecialchars($product['article_number'] ?: '—') ?></td>
                                        <td><?php echo htmlspecialchars($product['name']) ?></td>
                                        <td><?php echo htmlspecialchars($product['quantity']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/index.php?page=edit_product&id=<?php echo (int)$product['id'] ?>" class="text-decoration-none">
                                                <span class="badge bg-warning">Low Stock</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php foreach ($outOfStockProducts as $index => $product): ?>
                                    <tr>
                                        <td><?php echo count($lowStockProducts) + $index + 1 ?></td>
                                        <td><?php echo htmlspecialchars($product['article_number'] ?: '—') ?></td>
                                        <td><?php echo htmlspecialchars($product['name']) ?></td>
                                        <td><?php echo htmlspecialchars($product['quantity']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/index.php?page=edit_product&id=<?php echo (int)$product['id'] ?>" class="text-decoration-none">
                                                <span class="badge bg-danger">Out of Stock</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No products are low or out of stock.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graph Section -->
<div class="row mt-5 mb-5">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4 fw-bold">Incoming Orders (Last 7 Days)</h5>
                <div style="height: 350px;">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Orders Graph
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php foreach($graphData as $g) echo "'".date('M d', strtotime($g['date']))."',"; ?>],
            datasets: [{
                label: 'Orders',
                data: [<?php foreach($graphData as $g) echo $g['count'].","; ?>],
                borderColor: '#c19a4e',
                backgroundColor: 'rgba(193, 154, 78, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#c19a4e',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a1a',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 10
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        stepSize: 1,
                        color: '#fff'
                    },
                    grid: { color: 'rgba(255,255,255,0.1)' }
                },
                x: {
                    ticks: { color: '#fff' },
                    grid: { display: false }
                }
            }
        }
    });

    // Stock Pie Chart
    const stockCtx = document.getElementById('stockPieChart');
    if (stockCtx) {
        new Chart(stockCtx, {
            type: 'pie',
            data: {
                labels: ['Healthy Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    data: [
                        <?php echo $counts['healthy_stock'] ?? 0 ?>,
                        <?php echo $counts['low_stock'] ?? 0 ?>,
                        <?php echo $counts['out_of_stock'] ?? 0 ?>
                    ],
                    backgroundColor: ['#4caf50', '#ffc107', '#dc3545'],
                    borderColor: '#161616',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#333',
                            boxWidth: 12,
                            padding: 16
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1a1a1a',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 10
                    }
                }
            }
        });
    }
});

async function generateSEOAI(btn) {
    const originalText = btn.innerText;
    
    try {
        btn.disabled = true;
        btn.innerText = "Generating...";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        const url = `https://generativelanguage.googleapis.com/v1beta/models/<?= GEMINI_MODEL ?>:generateContent?key=${apiKey}`;

        const body = {
            contents: [{
                parts: [{
                    text: `Return ONLY a valid JSON object for SEO settings for a premium fashion brand named "Stitch Smart".
                    Strict Format: {"title": "...", "description": "...", "keywords": "..."}
                    No conversation, no markdown blocks, just the JSON.`
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
        
        // Robust JSON extraction using Regex
        const jsonMatch = text.match(/\{[\s\S]*\}/);
        if (!jsonMatch) throw new Error("Invalid AI response format.");
        
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
