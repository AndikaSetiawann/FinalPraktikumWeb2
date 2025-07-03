<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
/* OAuth Users Admin Styles */
.admin-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 2rem 0;
  margin-bottom: 2rem;
  border-radius: 15px;
}

.stats-card {
  background: white;
  border-radius: 15px;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  text-align: center;
  transition: all 0.3s ease;
}

.stats-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stats-number {
  font-size: 2rem;
  font-weight: 800;
  margin-bottom: 0.5rem;
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

.role-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

.role-admin {
  background: linear-gradient(135deg, #ff6b6b, #ee5a24);
  color: white;
}

.role-user {
  background: linear-gradient(135deg, #4ecdc4, #44a08d);
  color: white;
}

.status-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

.status-active {
  background: linear-gradient(135deg, #56ab2f, #a8e6cf);
  color: white;
}

.status-inactive {
  background: linear-gradient(135deg, #ffa726, #ffcc02);
  color: white;
}

.status-banned {
  background: linear-gradient(135deg, #e74c3c, #c0392b);
  color: white;
}

.table-section {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
}
</style>

<div class="container">
  <!-- Admin Header -->
  <div class="admin-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1 class="mb-1">
            <i class="fab fa-google me-2"></i>
            OAuth Users Management
          </h1>
          <p class="mb-0 opacity-75">Kelola pengguna yang login dengan Google</p>
        </div>
        <div class="col-md-4 text-end">
          <a href="<?= base_url('/admin/artikel') ?>" class="btn btn-light btn-lg">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali ke Dashboard
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-number text-primary" id="total-users">0</div>
        <div class="text-muted">Total Users</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-number text-success" id="active-users">0</div>
        <div class="text-muted">Active Users</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-number text-warning" id="admin-users">0</div>
        <div class="text-muted">Admin Users</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-number text-info" id="new-today">0</div>
        <div class="text-muted">New Today</div>
      </div>
    </div>
  </div>

  <!-- Users Table -->
  <div class="table-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">
        <i class="fas fa-users me-2"></i>
        Daftar OAuth Users
      </h5>
      <button class="btn btn-primary" onclick="refreshData()">
        <i class="fas fa-sync-alt me-2"></i>
        Refresh
      </button>
    </div>

    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="table-dark">
          <tr>
            <th width="60">ID</th>
            <th width="80">Avatar</th>
            <th>Name & Email</th>
            <th width="100">Role</th>
            <th width="100">Status</th>
            <th width="150">Last Login</th>
            <th width="120">Actions</th>
          </tr>
        </thead>
        <tbody id="users-table-body">
          <tr>
            <td colspan="7" class="text-center py-4">
              <i class="fas fa-spinner fa-spin fa-2x text-muted mb-2"></i><br>
              Loading users...
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
// Load users data
function loadUsers() {
  fetch('/api/oauth-users')
    .then(response => response.json())
    .then(data => {
      if (data.status === 200) {
        renderUsers(data.data);
        updateStats(data.data);
      } else {
        showError('Failed to load users');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showError('Error loading users');
    });
}

// Render users table
function renderUsers(users) {
  const tbody = document.getElementById('users-table-body');
  
  if (users.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-4">
          <i class="fas fa-users fa-2x text-muted mb-2"></i><br>
          No OAuth users found
        </td>
      </tr>
    `;
    return;
  }

  tbody.innerHTML = users.map(user => `
    <tr>
      <td><strong>#${user.id}</strong></td>
      <td>
        <img src="${user.avatar || '/assets/default-avatar.png'}" 
             alt="${user.name}" 
             class="user-avatar">
      </td>
      <td>
        <div class="fw-bold">${user.name}</div>
        <small class="text-muted">${user.email}</small>
      </td>
      <td>
        <span class="role-badge role-${user.role}">${user.role.toUpperCase()}</span>
      </td>
      <td>
        <span class="status-badge status-${user.status}">${user.status.toUpperCase()}</span>
      </td>
      <td>
        <small>${user.last_login ? formatDate(user.last_login) : 'Never'}</small>
      </td>
      <td>
        <div class="btn-group btn-group-sm">
          ${user.role === 'user' ? 
            `<button class="btn btn-outline-warning" onclick="promoteUser(${user.id})" title="Promote to Admin">
              <i class="fas fa-user-shield"></i>
            </button>` : 
            `<button class="btn btn-outline-info" onclick="demoteUser(${user.id})" title="Demote to User">
              <i class="fas fa-user"></i>
            </button>`
          }
          ${user.status === 'active' ? 
            `<button class="btn btn-outline-danger" onclick="banUser(${user.id})" title="Ban User">
              <i class="fas fa-ban"></i>
            </button>` : 
            `<button class="btn btn-outline-success" onclick="activateUser(${user.id})" title="Activate User">
              <i class="fas fa-check"></i>
            </button>`
          }
        </div>
      </td>
    </tr>
  `).join('');
}

// Update statistics
function updateStats(users) {
  const totalUsers = users.length;
  const activeUsers = users.filter(u => u.status === 'active').length;
  const adminUsers = users.filter(u => u.role === 'admin').length;
  const today = new Date().toISOString().split('T')[0];
  const newToday = users.filter(u => u.created_at && u.created_at.startsWith(today)).length;

  document.getElementById('total-users').textContent = totalUsers;
  document.getElementById('active-users').textContent = activeUsers;
  document.getElementById('admin-users').textContent = adminUsers;
  document.getElementById('new-today').textContent = newToday;
}

// Utility functions
function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
}

function showError(message) {
  alert('Error: ' + message);
}

function refreshData() {
  loadUsers();
}

// User management functions
function promoteUser(userId) {
  if (confirm('Promote this user to admin?')) {
    // Implementation for promote user
    console.log('Promote user:', userId);
  }
}

function demoteUser(userId) {
  if (confirm('Demote this admin to user?')) {
    // Implementation for demote user
    console.log('Demote user:', userId);
  }
}

function banUser(userId) {
  if (confirm('Ban this user?')) {
    // Implementation for ban user
    console.log('Ban user:', userId);
  }
}

function activateUser(userId) {
  if (confirm('Activate this user?')) {
    // Implementation for activate user
    console.log('Activate user:', userId);
  }
}

// Load data on page load
document.addEventListener('DOMContentLoaded', loadUsers);
</script>

<?= $this->endSection() ?>
