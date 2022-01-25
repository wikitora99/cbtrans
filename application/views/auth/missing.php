
  <!-- Begin Page Content -->
  <div class="container-fluid mt-5">

    <?php if ($this->session->userdata('uname')): ?>
      <?php $page = 'Utama'; ?>
      <?php if ($this->session->userdata('role') == 1) $url = base_url('adm'); ?>
      <?php if ($this->session->userdata('role') == 2) $url = base_url('mod'); ?>
      <?php if ($this->session->userdata('role') == 3) $url = base_url('usr/invoice'); ?>
    <?php else: ?>
      <?php $url = base_url(); $page = 'Login'; ?>
    <?php endif ?>

    <!-- 404 Error Text -->
    <div class="text-center">
      <div class="error mx-auto" data-text="404">404</div>
      <p class="lead text-gray-800 mb-5"><?= $title; ?>!</p>
      <p class="text-gray-500">Halaman yang Anda cari tidak dapat ditemukan..</p>
      <a href="<?= $url; ?>">&larr; Kembali ke Halaman <?= $page; ?></a>
      <div class="mb-5">
    </div>

  </div>
  <!-- /.container-fluid -->