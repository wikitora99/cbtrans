
<?php if (!$this->session->userdata('uname')) redirect(base_url()); ?>

  <!-- Begin Page Content -->
  <div class="container-fluid mt-5">

    <!-- 404 Error Text -->
    <div class="text-center">
      <div class="error mx-auto" data-text="403">403</div>
      <p class="lead text-gray-800 mb-5"><?= $title; ?>!</p>
      <p class="text-gray-500">Anda mencoba mengakses halaman yang tidak dikenali..</p>
      <a href="<?= base_url('usr'); ?>">&larr; Kembali ke Halaman Pengguna</a>
      <div class="mb-5">
    </div>

  </div>
  <!-- /.container-fluid -->