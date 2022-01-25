<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
              <?php if (isset($user['name'])): ?>
                <?= ucwords(strtolower($user['name'])); ?>
              <?php else: ?>
                Silakan Login
              <?php endif; ?>
              </span>
            <img class="img-profile rounded-circle" src="
            <?php if (isset($user['avatar'])): ?>
            <?= base_url('upload/profile/').$user['avatar']; ?>
            <?php else: ?>
              <?= base_url('upload/profile/default.png'); ?>
            <?php endif; ?>
            ">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <?php if (isset($user)): ?>
            <a href="<?= base_url('usr'); ?>" class="dropdown-item">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profil
            </a>
            <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item logoutBtn">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Keluar
            </a>
          <?php else: ?>
            <a class="dropdown-item" href="<?= base_url(); ?>">
              <i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Masuk
            </button>
          <?php endif; ?>
          </div>
        </li>

      </ul>

    </nav>
    <!-- End of Topbar -->