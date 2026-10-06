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
  <style>
  .stat-card-clickable {
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    border: 2px solid transparent;
    user-select: none;
  }
  .stat-card-clickable:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.4);
  }
  .stat-card-clickable.filter-active-card {
    border-color: #FFD700;
    box-shadow: 0 0 0 3px rgba(255,215,0,0.2);
  }
  .mat-filter-btn {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.75);
    padding: 9px 18px;
    border-radius: 20px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: 0.2s ease;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .mat-filter-btn:hover {
    background: rgba(255,215,0,0.15);
    border-color: #FFD700;
    color: #FFD700;
  }
  .mat-filter-btn.active {
    background: #FFD700;
    border-color: #FFD700;
    color: #1a1a1a;
  }
  </style>

  <?php
    $totalCount    = count($materials ?? []);
    $activeCount   = count(array_filter($materials ?? [], fn($m) => $m['is_active'] ?? false));
    $inactiveCount = count(array_filter($materials ?? [], fn($m) => !($m['is_active'] ?? true)));
  ?>
  <div class="adm-stats mat-stats-grid" style="margin-bottom:24px;">
    <style>
    .mat-stats-grid { grid-template-columns: repeat(3, 1fr); }
    @media (max-width: 575px) {
      .mat-stats-grid { grid-template-columns: 1fr; }
      .mat-stats-grid .stat-card { flex-direction: row; align-items: center; }
      .mat-stats-grid .stat-num { font-size: 1.4rem; }
      .mat-stats-grid .stat-lbl { font-size: 0.72rem; white-space: normal; }
    }
    </style>
    <div class="stat-card stat-card-clickable filter-active-card" id="statAll" onclick="setMatFilter('all', this)">
      <div class="stat-icon green"><i class="bi bi-layers-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= $totalCount ?></div>
        <div class="stat-lbl">Total Materials</div>
      </div>
    </div>
    <div class="stat-card stat-card-clickable" id="statActive" onclick="setMatFilter('active', this)">
      <div class="stat-icon blue"><i class="bi bi-check-circle-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= $activeCount ?></div>
        <div class="stat-lbl">Active</div>
      </div>
    </div>
    <div class="stat-card stat-card-clickable" id="statInactive" onclick="setMatFilter('inactive', this)">
      <div class="stat-icon gray"><i class="bi bi-x-circle-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= $inactiveCount ?></div>
        <div class="stat-lbl">Inactive / Archived</div>
      </div>
    </div>
  </div>

  <!-- SEARCH + FILTER BUTTONS -->
  <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center; margin-bottom:20px;">
    <input class="adm-input" type="text" id="matSearch" placeholder="Search materials..." oninput="filterTable()" style="max-width:320px; flex:1;">
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
      <button class="mat-filter-btn active" id="btnAll"      onclick="setMatFilter('all', null)"><i class="bi bi-grid-fill"></i> All</button>
      <button class="mat-filter-btn"        id="btnActive"   onclick="setMatFilter('active', null)"><i class="bi bi-check-circle-fill"></i> Active</button>
      <button class="mat-filter-btn"        id="btnArchived" onclick="setMatFilter('archived', null)"><i class="bi bi-archive-fill"></i> Archived</button>
    </div>
  </div>

  <!-- TABLE -->
  <div class="adm-card">
    <div class="adm-card-head">
      <span><i class="bi bi-table me-2"></i>All Materials <span id="filterLabel" style="font-size:0.8rem; color:var(--text-secondary); font-weight:600;"></span></span>
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
        <tr data-status="<?= ($m['is_active'] ?? false) ? 'active' : 'inactive' ?>">
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
            <?php
              $mdesc = $m['description'] ?? '';
              $mdid  = 'mdesc_' . ($m['material_id'] ?? 0);
              $mneedsMore = mb_strlen($mdesc) > 60;
              $mshort = mb_strimwidth($mdesc, 0, 60, '');
            ?>
            <?php if ($mneedsMore): ?>
              <span id="<?= $mdid ?>_s"><?= htmlspecialchars($mshort) ?>…
                <button onclick="document.getElementById('<?= $mdid ?>_s').style.display='none';document.getElementById('<?= $mdid ?>_f').style.display='inline';"
                  style="background:none;border:none;color:#FFD700;font-size:0.72rem;font-weight:800;cursor:pointer;padding:0;text-decoration:underline;">
                  see more
                </button>
              </span>
              <span id="<?= $mdid ?>_f" style="display:none;"><?= htmlspecialchars($mdesc) ?>
                <button onclick="document.getElementById('<?= $mdid ?>_f').style.display='none';document.getElementById('<?= $mdid ?>_s').style.display='inline';"
                  style="background:none;border:none;color:#FFD700;font-size:0.72rem;font-weight:800;cursor:pointer;padding:0;text-decoration:underline;">
                  see less
                </button>
              </span>
            <?php else: ?>
              <?= htmlspecialchars($mdesc ?: '—') ?>
            <?php endif; ?>
          </td>
          <td><strong style="color:#22c55e;">₱<?= number_format($m['unit_price'] ?? 0, 2) ?></strong></td>
          <td style="color:var(--text-primary); font-size:0.82rem; font-weight:700;"><?= htmlspecialchars($m['unit_type'] ?? '') ?></td>
          <td style="color:var(--text-primary); font-weight:900; font-size:0.9rem;"><?= number_format($m['stock_quantity'] ?? 0) ?></td>
          <td>
            <span class="status-badge <?= ($m['is_active'] ?? false) ? 'status-active' : 'status-archived' ?>">
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
              <button type="button"
                 class="adm-btn adm-btn-gray" style="padding:6px 12px; font-size:0.8rem;"
                 onclick="openMatConfirm('archive', <?= $m['material_id'] ?? 0 ?>, '<?= htmlspecialchars(addslashes($m['material_name'] ?? ''), ENT_QUOTES) ?>')"
                 title="Archive Material">
                <i class="bi bi-archive-fill"></i> Archive
              </button>
              <?php else: ?>
              <button type="button"
                 class="adm-btn adm-btn-green" style="padding:6px 12px; font-size:0.8rem;"
                 onclick="openMatConfirm('restore', <?= $m['material_id'] ?? 0 ?>, '<?= htmlspecialchars(addslashes($m['material_name'] ?? ''), ENT_QUOTES) ?>')"
                 title="Restore Material">
                <i class="bi bi-arrow-counterclockwise"></i> Restore
              </button>
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

function openEditMaterial(materialId) {
  // Find the material data from the table
  const materials = <?= json_encode($materials ?? []) ?>;
  const material = materials.find(m => m.material_id == materialId);
  
  if (!material) {
    alert('Material not found!');
    return;
  }

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

function filterTable() {
  const q = document.getElementById('matSearch').value.toLowerCase();
  document.querySelectorAll('#matTable tbody tr').forEach(row => {
    const matchesSearch = row.textContent.toLowerCase().includes(q);
    const status = row.dataset.status;
    const matchesFilter = (currentFilter === 'all') ||
                          (currentFilter === 'active'   && status === 'active') ||
                          (currentFilter === 'inactive' && status === 'inactive') ||
                          (currentFilter === 'archived' && status === 'inactive');
    row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
  });
}

let currentFilter = 'all';

function setMatFilter(filter, clickedCard) {
  currentFilter = filter;

  // Update stat card highlights
  ['statAll','statActive','statInactive'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.classList.remove('filter-active-card');
  });
  if (filter === 'all'      && document.getElementById('statAll'))      document.getElementById('statAll').classList.add('filter-active-card');
  if (filter === 'active'   && document.getElementById('statActive'))   document.getElementById('statActive').classList.add('filter-active-card');
  if ((filter === 'inactive' || filter === 'archived') && document.getElementById('statInactive')) document.getElementById('statInactive').classList.add('filter-active-card');

  // Update filter buttons
  ['btnAll','btnActive','btnArchived'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.classList.remove('active');
  });
  const btnMap = { all: 'btnAll', active: 'btnActive', inactive: 'btnArchived', archived: 'btnArchived' };
  if (btnMap[filter] && document.getElementById(btnMap[filter])) {
    document.getElementById(btnMap[filter]).classList.add('active');
  }

  // Update card header label
  const labels = { all: '', active: '— Active', inactive: '— Inactive', archived: '— Archived' };
  const labelEl = document.getElementById('filterLabel');
  if (labelEl) labelEl.textContent = labels[filter] || '';

  filterTable();
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

<!-- Material Action Confirmation Modal -->
<div class="sys-modal-overlay" id="matConfirmOverlay">
  <div class="sys-modal">
    <div class="sys-modal-icon" id="matConfirmIcon"><i class="bi bi-archive-fill"></i></div>
    <div class="sys-modal-title" id="matConfirmTitle">Archive Material</div>
    <div class="sys-modal-msg" id="matConfirmMsg">Are you sure?</div>
    <div class="sys-modal-btns">
      <button class="sys-btn-cancel" onclick="closeMatConfirm()">Cancel</button>
      <a id="matConfirmBtn" href="#" class="sys-btn-gray">Confirm</a>
    </div>
  </div>
</div>

<!-- sys-modal styles loaded via admin_style.css.php -->

<script>
let matConfirmUrl = '';

function openMatConfirm(type, id, name) {
  const overlay = document.getElementById('matConfirmOverlay');
  const icon    = document.getElementById('matConfirmIcon');
  const title   = document.getElementById('matConfirmTitle');
  const msg     = document.getElementById('matConfirmMsg');
  const btn     = document.getElementById('matConfirmBtn');

  if (type === 'archive') {
    matConfirmUrl = `?controller=admin&action=archiveMaterial&id=${id}`;
    icon.className = 'sys-modal-icon gray';
    icon.innerHTML = '<i class="bi bi-archive-fill"></i>';
    title.textContent = 'Archive Material';
    msg.innerHTML = `Archive <strong>${name}</strong>? It will be hidden from the shop but not deleted.`;
    btn.className = 'sys-btn-gray';
    btn.innerHTML = '<i class="bi bi-archive-fill"></i> Archive';
  } else {
    matConfirmUrl = `?controller=admin&action=restoreMaterial&id=${id}`;
    icon.className = 'sys-modal-icon green';
    icon.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i>';
    title.textContent = 'Restore Material';
    msg.innerHTML = `Restore <strong>${name}</strong> back to the shop?`;
    btn.className = 'sys-btn-green';
    btn.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i> Restore';
  }

  btn.href = matConfirmUrl;
  overlay.classList.add('open');
}

function closeMatConfirm() {
  document.getElementById('matConfirmOverlay').classList.remove('open');
}

document.getElementById('matConfirmOverlay').addEventListener('click', function(e) {
  if (e.target === this) closeMatConfirm();
});

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeMatConfirm();
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
