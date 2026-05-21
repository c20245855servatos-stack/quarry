<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<div class="adm-wrap">

  <!-- HEADER -->
  <div class="adm-header">
    <div>
      <h1 class="adm-title"><i class="bi bi-layers-fill"></i> Materials Management</h1>
      <p class="adm-sub">Add, edit, and manage your sand, stone, and gravel product catalog.</p>
    </div>
    <div class="adm-header-actions">
      <button class="adm-btn adm-btn-green" onclick="openModal('addModal')">
        <i class="bi bi-plus-lg"></i> Add Material
      </button>
    </div>
  </div>

  <!-- STATS ROW -->
  <div class="adm-stats" style="margin-bottom:24px; grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
      <div class="stat-icon green"><i class="bi bi-layers-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count($materials ?? []) ?></div>
        <div class="stat-lbl">Total Materials</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon blue"><i class="bi bi-check-circle-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count(array_filter($materials ?? [], fn($m) => $m['is_active'] ?? false)) ?></div>
        <div class="stat-lbl">Active</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon gray"><i class="bi bi-x-circle-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count(array_filter($materials ?? [], fn($m) => !($m['is_active'] ?? true))) ?></div>
        <div class="stat-lbl">Inactive</div>
      </div>
    </div>
  </div>

  <!-- SEARCH -->
  <div class="adm-search">
    <input class="adm-input" type="text" id="matSearch" placeholder="Search materials..." oninput="filterTable()" style="max-width:320px;">
  </div>

  <!-- TABLE -->
  <div class="adm-card">
    <div class="adm-card-head">
      <span><i class="bi bi-table me-2"></i>All Materials</span>
    </div>
    <?php if (empty($materials ?? [])): ?>
      <div class="adm-empty">No materials yet. Click "Add Material" to get started.</div>
    <?php else: ?>
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
    <table class="adm-table" id="matTable" style="min-width:600px;">
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Unit</th>
          <th>Stock</th>
          <th>Status</th>
          <th>Added</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($materials ?? [] as $m): ?>
        <tr>
          <td>
            <?php 
            $imageUrl = '';
            if (!empty($m['image'] ?? '')) {
              if (strpos($m['image'] ?? '', 'http') === 0) {
                $imageUrl = $m['image'] ?? '';
              } else {
                $imageUrl = '/app/public/assets/imgs/materials/' . ($m['image'] ?? '');
              }
            }
            ?>
            <?php if ($imageUrl): ?>
              <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($m['material_name']) ?>" 
                   style="width:55px; height:55px; object-fit:cover; border-radius:8px; border:2px solid #ddd; box-shadow:0 2px 6px rgba(0,0,0,0.12);">
            <?php else: ?>
              <div style="width:55px; height:55px; background:#f0f0f0; border-radius:8px; border:2px dashed #ccc; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:2px;">
                <i class="bi bi-image" style="color:#aaa; font-size:1.2rem;"></i>
                <span style="color:#aaa; font-size:0.6rem; font-weight:700;">No img</span>
              </div>
            <?php endif; ?>
          </td>
          <td><strong><?= htmlspecialchars($m['material_name'] ?? '') ?></strong></td>
          <td style="max-width:200px; color:var(--text-secondary); font-size:0.82rem; font-weight:700;">
            <?= htmlspecialchars(mb_strimwidth($m['description'] ?? '', 0, 60, '…')) ?>
          </td>
          <td><strong style="color:#22c55e;">₱<?= number_format($m['unit_price'] ?? 0, 2) ?></strong></td>
          <td style="color:var(--text-primary); font-size:0.82rem; font-weight:700;"><?= htmlspecialchars($m['unit_type'] ?? '') ?></td>
          <td style="color:var(--text-primary); font-weight:900; font-size:0.9rem;"><?= number_format($m['stock_quantity'] ?? 0) ?></td>
          <td>
            <span class="status-badge <?= ($m['is_active'] ?? false) ? 'status-active' : 'status-inactive' ?>">
              <?php if ($m['is_active'] ?? false): ?>
                <i class="bi bi-check-circle-fill me-1"></i> Active
              <?php else: ?>
                <i class="bi bi-archive-fill me-1"></i> Archived
              <?php endif; ?>
            </span>
          </td>
          <td style="color:var(--text-primary); font-size:0.8rem; font-weight:700;"><?= date('M d, Y', strtotime($m['updated_at'] ?? 'now')) ?></td>
          <td>
            <div style="display:flex; gap:6px;">
              <button class="adm-btn adm-btn-yellow" style="padding:6px 12px; font-size:0.8rem;"
                onclick="openEditMaterial(<?= $m['material_id'] ?? 0 ?>)" 
                title="Edit Material">
                <i class="bi bi-pencil-fill"></i>
              </button>
              <?php if ($m['is_active'] ?? false): ?>
              <a href="?controller=admin&action=archiveMaterial&id=<?= $m['material_id'] ?? 0 ?>"
                 class="adm-btn adm-btn-gray" style="padding:6px 12px; font-size:0.8rem;"
                 onclick="return confirm('Archive this material? It will be hidden from the shop but not deleted.')"
                 title="Archive Material">
                <i class="bi bi-archive-fill"></i>
              </a>
              <?php else: ?>
              <a href="?controller=admin&action=restoreMaterial&id=<?= $m['material_id'] ?? 0 ?>"
                 class="adm-btn adm-btn-green" style="padding:6px 12px; font-size:0.8rem;"
                 onclick="return confirm('Restore this material to the shop?')"
                 title="Restore Material">
                <i class="bi bi-arrow-counterclockwise"></i>
              </a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?php endif; ?>
  </div>

</div>

<!-- ADD MODAL -->
<div class="adm-modal-overlay" id="addModal">
  <div class="adm-modal">
    <button class="adm-modal-close" onclick="closeModal('addModal')"><i class="bi bi-x-lg"></i></button>
    <h3><i class="bi bi-plus-circle-fill me-2" style="color:#4ade80;"></i>Add New Material</h3>
    <form method="POST" action="?controller=admin&action=addMaterial" enctype="multipart/form-data">
      <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
      <div class="adm-form-row">
        <div class="adm-form-group">
          <label>Material Name *</label>
          <input class="adm-input" type="text" name="name" placeholder="e.g. Crushed Stone" required>
        </div>
        <div class="adm-form-group">
          <label>Price (₱) *</label>
          <input class="adm-input" type="number" name="price" step="0.01" min="0.01" placeholder="750.00" required>
        </div>
      </div>
      <div class="adm-form-row">
        <div class="adm-form-group">
          <label>Unit</label>
          <select class="adm-input" name="unit">
            <option value="per cubic meter">per cubic meter</option>
            <option value="per ton">per ton</option>
            <option value="per bag">per bag</option>
            <option value="per piece">per piece</option>
            <option value="per load">per load</option>
          </select>
        </div>
        <div class="adm-form-group">
          <label>Stock Quantity</label>
          <input class="adm-input" type="number" name="stock" min="0" placeholder="0" value="0">
        </div>
      </div>
      <div class="adm-form-group">
        <label>Description</label>
        <textarea class="adm-input" name="description" rows="3" placeholder="Brief description of this material..."></textarea>
      </div>
      <div class="adm-form-group">
        <label>Material Image</label>
        <div style="display:flex; gap:8px; margin-bottom:12px;">
          <button type="button" class="adm-btn adm-btn-blue" style="flex:1; padding:10px;" onclick="toggleImageTab('upload')">
            <i class="bi bi-cloud-arrow-up me-1"></i> Upload
          </button>
          <button type="button" class="adm-btn adm-btn-blue" style="flex:1; padding:10px;" onclick="toggleImageTab('link')">
            <i class="bi bi-link-45deg me-1"></i> Image Link
          </button>
        </div>
        <div id="uploadTab" style="display:block;">
          <input class="adm-input" type="file" name="image" id="add_image" accept="image/*">
          <small style="color:var(--text-secondary); font-weight:700;">JPG, PNG, GIF, WebP (Max 5MB)</small>
        </div>
        <div id="linkTab" style="display:none;">
          <input class="adm-input" type="url" name="image_url" id="add_image_url" placeholder="https://example.com/image.jpg">
          <small style="color:var(--text-secondary); font-weight:700;">Enter the full URL to the image</small>
        </div>
      </div>
      <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:8px;">
        <button type="button" class="adm-btn adm-btn-gray" onclick="closeModal('addModal')">Cancel</button>
        <button type="submit" class="adm-btn adm-btn-green"><i class="bi bi-check-lg"></i> Add Material</button>
      </div>
    </form>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="adm-modal-overlay" id="editModal">
  <div class="adm-modal">
    <button class="adm-modal-close" onclick="closeModal('editModal')"><i class="bi bi-x-lg"></i></button>
    <h3><i class="bi bi-pencil-fill me-2" style="color:#ffc107;"></i>Edit Material</h3>
    <form method="POST" id="editForm" action="" enctype="multipart/form-data">
      <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
      <div class="adm-form-row">
        <div class="adm-form-group">
          <label>Material Name *</label>
          <input class="adm-input" type="text" name="name" id="edit_name" required>
        </div>
        <div class="adm-form-group">
          <label>Price (₱) *</label>
          <input class="adm-input" type="number" name="price" id="edit_price" step="0.01" min="0.01" required>
        </div>
      </div>
      <div class="adm-form-row">
        <div class="adm-form-group">
          <label>Unit</label>
          <select class="adm-input" name="unit" id="edit_unit">
            <option value="per cubic meter">per cubic meter</option>
            <option value="per ton">per ton</option>
            <option value="per bag">per bag</option>
            <option value="per piece">per piece</option>
            <option value="per load">per load</option>
          </select>
        </div>
        <div class="adm-form-group">
          <label>Stock Quantity</label>
          <input class="adm-input" type="number" name="stock" id="edit_stock" min="0">
        </div>
      </div>
      <div class="adm-form-group">
        <label>Description</label>
        <textarea class="adm-input" name="description" id="edit_description" rows="3"></textarea>
      </div>
      <div class="adm-form-group">
        <label>Status</label>
        <select class="adm-input" name="is_active" id="edit_status">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>
      <div class="adm-form-group">
        <label>Material Image</label>
        <div style="display:flex; gap:8px; margin-bottom:12px;">
          <button type="button" class="adm-btn adm-btn-blue" style="flex:1; padding:10px;" onclick="toggleImageTab('edit_upload')">
            <i class="bi bi-cloud-arrow-up me-1"></i> Upload
          </button>
          <button type="button" class="adm-btn adm-btn-blue" style="flex:1; padding:10px;" onclick="toggleImageTab('edit_link')">
            <i class="bi bi-link-45deg me-1"></i> Image Link
          </button>
        </div>
        <div id="edit_uploadTab" style="display:block;">
          <input class="adm-input" type="file" name="image" id="edit_image" accept="image/*">
          <small style="color:var(--text-secondary); font-weight:700;">JPG, PNG, GIF, WebP (Max 5MB)</small>
        </div>
        <div id="edit_linkTab" style="display:none;">
          <input class="adm-input" type="url" name="image_url" id="edit_image_url" placeholder="https://example.com/image.jpg">
          <small style="color:var(--text-secondary); font-weight:700;">Enter the full URL to the image</small>
        </div>
      </div>
      <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:8px;">
        <button type="button" class="adm-btn adm-btn-gray" onclick="closeModal('editModal')">Cancel</button>
        <button type="submit" class="adm-btn adm-btn-green"><i class="bi bi-check-lg"></i> Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id) {
  document.getElementById(id).classList.add('open');
}
function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function toggleImageTab(tab) {
  if (tab === 'upload') {
    document.getElementById('uploadTab').style.display = 'block';
    document.getElementById('linkTab').style.display = 'none';
  } else if (tab === 'link') {
    document.getElementById('uploadTab').style.display = 'none';
    document.getElementById('linkTab').style.display = 'block';
  } else if (tab === 'edit_upload') {
    document.getElementById('edit_uploadTab').style.display = 'block';
    document.getElementById('edit_linkTab').style.display = 'none';
  } else if (tab === 'edit_link') {
    document.getElementById('edit_uploadTab').style.display = 'none';
    document.getElementById('edit_linkTab').style.display = 'block';
  }
}

function previewImage(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('imagePreview');
  
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  } else {
    preview.style.display = 'none';
  }
}

function openEditMaterial(materialId) {
  // Find the material data from the table
  const materials = <?= json_encode($materials ?? []) ?>;
  const material = materials.find(m => m.material_id == materialId);
  
  if (!material) {
    alert('Material not found!');
    return;
  }
  
  console.log('Editing material:', material);
  
  // Set form action
  document.getElementById('editForm').action = '?controller=admin&action=editMaterial&id=' + materialId;
  
  // Populate form fields
  document.getElementById('edit_name').value = material.material_name || '';
  document.getElementById('edit_price').value = material.unit_price || '';
  document.getElementById('edit_unit').value = material.unit_type || 'per cubic meter';
  document.getElementById('edit_stock').value = material.stock_quantity || 0;
  document.getElementById('edit_description').value = material.description || '';
  document.getElementById('edit_status').value = material.is_active ? '1' : '0';
  
  // Clear image fields
  document.getElementById('edit_image').value = '';
  document.getElementById('edit_image_url').value = '';
  
  // Show current image if exists
  const currentImageDiv = document.getElementById('currentImageDiv');
  if (currentImageDiv) {
    currentImageDiv.remove();
  }
  
  if (material.image) {
    const imageUrl = material.image.startsWith('http') ? material.image : '/app/public/assets/imgs/materials/' + material.image;
    const imageDiv = document.createElement('div');
    imageDiv.id = 'currentImageDiv';
    imageDiv.innerHTML = `
      <div style="margin-bottom: 12px; padding: 12px; background: rgba(255,255,255,0.05); border-radius: 8px;">
        <label style="color: var(--text-secondary); font-size: 0.8rem; font-weight: 700; margin-bottom: 8px; display: block;">Current Image:</label>
        <img src="${imageUrl}" alt="Current image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #FFD700;">
        <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 4px;">Upload a new image to replace this one</div>
      </div>
    `;
    document.getElementById('edit_uploadTab').insertBefore(imageDiv, document.getElementById('edit_uploadTab').firstChild);
  }
  
  // Reset to upload tab
  toggleImageTab('edit_upload');
  
  // Open modal
  openModal('editModal');
}

function openEdit(mat) {
  console.log('Opening edit for material:', mat); // Debug log
  
  // Set form action
  document.getElementById('editForm').action = '?controller=admin&action=editMaterial&id=' + mat.material_id;
  
  // Populate form fields
  document.getElementById('edit_name').value = mat.material_name || '';
  document.getElementById('edit_price').value = mat.unit_price || '';
  document.getElementById('edit_unit').value = mat.unit_type || 'per cubic meter';
  document.getElementById('edit_stock').value = mat.stock_quantity || 0;
  document.getElementById('edit_description').value = mat.description || '';
  document.getElementById('edit_status').value = mat.is_active ? '1' : '0';
  
  // Clear image fields
  document.getElementById('edit_image').value = '';
  document.getElementById('edit_image_url').value = mat.image && mat.image.startsWith('http') ? mat.image : '';
  
  // Show current image if exists
  const currentImageDiv = document.getElementById('currentImageDiv');
  if (currentImageDiv) {
    currentImageDiv.remove();
  }
  
  if (mat.image) {
    const imageUrl = mat.image.startsWith('http') ? mat.image : '/app/public/assets/imgs/materials/' + mat.image;
    const imageDiv = document.createElement('div');
    imageDiv.id = 'currentImageDiv';
    imageDiv.innerHTML = `
      <div style="margin-bottom: 12px; padding: 12px; background: rgba(255,255,255,0.05); border-radius: 8px;">
        <label style="color: var(--text-secondary); font-size: 0.8rem; font-weight: 700; margin-bottom: 8px; display: block;">Current Image:</label>
        <img src="${imageUrl}" alt="Current image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #FFD700;">
      </div>
    `;
    document.getElementById('edit_uploadTab').insertBefore(imageDiv, document.getElementById('edit_uploadTab').firstChild);
  }
  
  // Reset to upload tab
  toggleImageTab('edit_upload');
  
  // Open modal
  openModal('editModal');
}

function filterTable() {
  const q = document.getElementById('matSearch').value.toLowerCase();
  document.querySelectorAll('#matTable tbody tr').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
}

// Close modal on overlay click
document.querySelectorAll('.adm-modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
  });
});

<?php if (isset($editMaterial)): ?>
openEdit(<?= json_encode($editMaterial) ?>);
<?php endif; ?>
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
