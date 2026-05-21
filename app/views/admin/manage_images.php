<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<style>
.image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin-top: 24px;
}

.material-image-card {
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 20px;
    transition: all 0.3s ease;
}

.material-image-card:hover {
    border-color: rgba(255, 215, 0, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.material-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.material-info h4 {
    color: #FFD700;
    font-weight: 900;
    margin: 0 0 4px 0;
    font-size: 1.1rem;
}

.material-info .price {
    color: #22c55e;
    font-weight: 700;
    font-size: 0.9rem;
}

.material-status {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.material-status.active {
    background: rgba(34, 197, 94, 0.2);
    color: #22c55e;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.material-status.inactive {
    background: rgba(156, 163, 175, 0.2);
    color: #9ca3af;
    border: 1px solid rgba(156, 163, 175, 0.3);
}

.current-image {
    width: 100%;
    height: 200px;
    border-radius: 12px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.1);
    overflow: hidden;
}

.current-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    background: rgba(255, 255, 255, 0.05);
    color: rgba(255, 255, 255, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-weight: 700;
}

.no-image i {
    font-size: 2rem;
}

.upload-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.file-input-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
    width: 100%;
}

.file-input {
    position: absolute;
    left: -9999px;
}

.file-input-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    background: rgba(255, 215, 0, 0.1);
    border: 2px dashed rgba(255, 215, 0, 0.3);
    border-radius: 8px;
    color: #FFD700;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.file-input-label:hover {
    background: rgba(255, 215, 0, 0.2);
    border-color: rgba(255, 215, 0, 0.5);
}

.upload-btn {
    background: linear-gradient(135deg, #FFD700, #FFB000);
    color: #1a1a1a;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 900;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.upload-btn:hover {
    background: linear-gradient(135deg, #FFB000, #FF8C00);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
}

.upload-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.file-info {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    text-align: center;
    margin-top: 8px;
}

.bulk-actions {
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid rgba(255, 215, 0, 0.2);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}

.bulk-actions h3 {
    color: #FFD700;
    font-weight: 900;
    margin: 0 0 16px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.bulk-info {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .image-grid {
        grid-template-columns: 1fr;
    }
    
    .material-header {
        flex-direction: column;
        gap: 8px;
    }
}
</style>

<div class="adm-wrap">

    <!-- HEADER -->
    <div class="adm-header">
        <div>
            <h1 class="adm-title"><i class="bi bi-images"></i> Image Management</h1>
            <p class="adm-sub">Upload and manage images for all materials in your inventory.</p>
        </div>
        <div class="adm-header-actions">
            <a href="?controller=admin&action=materials" class="adm-btn adm-btn-gray">
                <i class="bi bi-arrow-left"></i> Back to Materials
            </a>
        </div>
    </div>

    <!-- BULK ACTIONS INFO -->
    <div class="bulk-actions">
        <h3><i class="bi bi-info-circle-fill"></i> Image Upload Guidelines</h3>
        <div class="bulk-info">
            <strong>Supported formats:</strong> JPG, PNG, GIF, WebP<br>
            <strong>Maximum file size:</strong> 5MB per image<br>
            <strong>Recommended dimensions:</strong> 800x600 pixels or higher for best quality<br>
            <strong>Note:</strong> Images will be automatically optimized and stored in the materials directory.
        </div>
    </div>

    <!-- MATERIALS GRID -->
    <div class="adm-card">
        <div class="adm-card-head">
            <span><i class="bi bi-grid-3x3-gap-fill me-2"></i>Materials (<?= count($materials ?? []) ?>)</span>
        </div>
        
        <?php if (empty($materials ?? [])): ?>
            <div class="adm-empty">
                <i class="bi bi-inbox" style="font-size: 3rem; color: rgba(255,255,255,0.3); margin-bottom: 16px; display: block;"></i>
                <h3 style="color: rgba(255,255,255,0.8); margin-bottom: 8px;">No Materials Found</h3>
                <p style="color: rgba(255,255,255,0.6); margin: 0;">Add some materials first before managing images.</p>
            </div>
        <?php else: ?>
        <div class="image-grid">
            <?php foreach ($materials ?? [] as $material): ?>
            <div class="material-image-card">
                <div class="material-header">
                    <div class="material-info">
                        <h4><?= htmlspecialchars($material['material_name'] ?? '') ?></h4>
                        <div class="price">₱<?= number_format($material['unit_price'] ?? 0, 2) ?> <?= htmlspecialchars($material['unit_type'] ?? '') ?></div>
                    </div>
                    <div class="material-status <?= ($material['is_active'] ?? false) ? 'active' : 'inactive' ?>">
                        <?= ($material['is_active'] ?? false) ? 'Active' : 'Inactive' ?>
                    </div>
                </div>

                <div class="current-image">
                    <?php 
                    $imageUrl = '';
                    if (!empty($material['image'] ?? '')) {
                        if (strpos($material['image'] ?? '', 'http') === 0) {
                            $imageUrl = $material['image'] ?? '';
                        } else {
                            $imageUrl = '/app/public/assets/imgs/materials/' . ($material['image'] ?? '');
                        }
                    }
                    ?>
                    <?php if ($imageUrl): ?>
                        <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($material['material_name'] ?? '') ?>">
                    <?php else: ?>
                        <div class="no-image">
                            <i class="bi bi-image"></i>
                            <span>No Image</span>
                        </div>
                    <?php endif; ?>
                </div>

                <form method="POST" action="?controller=admin&action=uploadImage" enctype="multipart/form-data" class="upload-form">
                    <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
                    <input type="hidden" name="material_id" value="<?= $material['material_id'] ?? 0 ?>">
                    
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image_<?= $material['material_id'] ?? 0 ?>" 
                               class="file-input" accept="image/*" required
                               onchange="updateFileName(this, <?= $material['material_id'] ?? 0 ?>)">
                        <label for="image_<?= $material['material_id'] ?? 0 ?>" class="file-input-label">
                            <i class="bi bi-cloud-upload"></i>
                            <span id="file_name_<?= $material['material_id'] ?? 0 ?>">Choose Image File</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="upload-btn" id="upload_btn_<?= $material['material_id'] ?? 0 ?>" disabled>
                        <i class="bi bi-upload"></i> Upload Image
                    </button>
                    
                    <div class="file-info">
                        Stock: <?= number_format($material['stock_quantity'] ?? 0) ?> units
                    </div>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

</div>

<script>
function updateFileName(input, materialId) {
    const fileName = input.files[0]?.name || 'Choose Image File';
    const fileNameSpan = document.getElementById(`file_name_${materialId}`);
    const uploadBtn = document.getElementById(`upload_btn_${materialId}`);
    
    if (input.files[0]) {
        fileNameSpan.textContent = fileName;
        uploadBtn.disabled = false;
        
        // Validate file size (5MB limit)
        if (input.files[0].size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            input.value = '';
            fileNameSpan.textContent = 'Choose Image File';
            uploadBtn.disabled = true;
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(input.files[0].type)) {
            alert('Only image files are allowed (JPG, PNG, GIF, WebP)');
            input.value = '';
            fileNameSpan.textContent = 'Choose Image File';
            uploadBtn.disabled = true;
            return;
        }
    } else {
        fileNameSpan.textContent = 'Choose Image File';
        uploadBtn.disabled = true;
    }
}

// Add drag and drop functionality
document.querySelectorAll('.file-input-label').forEach(label => {
    label.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.background = 'rgba(255, 215, 0, 0.3)';
        this.style.borderColor = 'rgba(255, 215, 0, 0.7)';
    });
    
    label.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.background = 'rgba(255, 215, 0, 0.1)';
        this.style.borderColor = 'rgba(255, 215, 0, 0.3)';
    });
    
    label.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.background = 'rgba(255, 215, 0, 0.1)';
        this.style.borderColor = 'rgba(255, 215, 0, 0.3)';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const input = this.previousElementSibling;
            input.files = files;
            const materialId = input.id.split('_')[1];
            updateFileName(input, materialId);
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>