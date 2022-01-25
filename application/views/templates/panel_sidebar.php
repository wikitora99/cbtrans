<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
    <div class="sidebar-brand-icon">
      <i class="fab fa-sellcast"></i>
    </div>
    <div class="sidebar-brand-text mx-3">CBTrans</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <?php 
    $role_id = $this->session->userdata('role');
    $queryMenu = "SELECT `menu`.`id`, 
            `menu`.`menu`, `menu`.`alias`
            FROM `menu` JOIN `user_access`
            ON `menu`.`id` = `user_access`.`menu_id`
            WHERE `user_access`.`role_id` = {$role_id}
            ORDER BY `user_access`.`menu_id` ASC";
    $menu = $this->db->query($queryMenu)->result_array();
  ?>

  <?php foreach ($menu as $m): ?>

  <!-- Heading -->
  <div class="sidebar-heading">
    <?= $m['alias']; ?>
  </div>

    <?php 
      $querySubMenu = "SELECT * FROM `sub_menu`
              WHERE `menu_id` = {$m['id']}";
      $subMenu = $this->db->query($querySubMenu)->result_array();
    ?>

    <?php if ($role_id == 3): ?>
    <?php if ($title == "Bukti Transfer"): ?>
    <li class="nav-item active">
    <?php else: ?>
    <li class="nav-item">
    <?php endif; ?>
      <a class="nav-link" href="<?= base_url('usr/invoice'); ?>">
        <i class="fas fa-fw fa-file-invoice-dollar"></i>
        <span>Bukti Transfer</span></a>
    </li>
    <?php endif; ?>

    <?php foreach ($subMenu as $sm): ?>
    <?php if ($title == $sm['title']): ?>
    <li class="nav-item active">
    <?php else: ?>
    <li class="nav-item">
    <?php endif; ?>
      <a class="nav-link <?php if ($sm['url'] == 'auth/logout') echo 'logoutBtn'; ?>" href="<?= base_url($sm['url']); ?>">
        <i class="<?= $sm['icon']; ?>"></i>
        <span><?= $sm['title']; ?></span></a>
    </li>
    <?php endforeach; ?>

  <!-- Divider -->
  <hr class="sidebar-divider">  

  <?php endforeach; ?>

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar --> 