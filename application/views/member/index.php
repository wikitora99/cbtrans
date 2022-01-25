
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="flash-alert" data-flash="<?= $this->session->flashdata('msg'); ?>"></div>

  <div id="base-url" data-url="<?= base_url(); ?>"></div>

  <?php if ($user['is_change'] == 0): ?>
  <div class="alert alert-danger alert-dismissible fade show col-lg-6" role="alert">
    <p>Akun Anda masih menggunakan <strong>Password bawaan</strong> sistem. Harap <strong>mengganti Password</strong> untuk keamanan akun!</p>
    <button type="button" class="close" data-dismiss="alert">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <?php endif; ?>

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h2 class="h3 mb-0 text-gray-800"><?= $title; ?></h2>
  </div>

  <div class="card shadow mb-4 border-bottom-primary text-center col-lg-6" style="max-width: 350px;">
    <img src="<?= base_url('upload/profile') ?>/<?= $user['avatar']; ?>" class="card-img-top img-fluid rounded-circle d-block mx-auto mt-4" alt="Gambar Profil" style="max-width: 100px;">

    <div class="card-body">
      <h6 class="card-title"><strong>Nama: </strong><?= $user['name']; ?></h6>
      <h6 class="card-title"><strong>Rekening: </strong><?= $user['account']; ?></h6>
      <h6 class="card-title"><strong>Bank: </strong><?= $user['bank']; ?></h6>
    </div>

    <div class="card-footer d-flex justify-content-between">
      <button type="button" class="btn btn-success btn-sm userModf" data-toggle="modal" data-target="#modalModf" data-id="<?= $user['id']; ?>" data-imgpath="<?= $user['avatar']; ?>">Ubah Profil</button>

      <button type="button" class="btn btn-danger btn-sm userReset" data-toggle="modal" data-target="#modalModf" data-id="<?= $user['id']; ?>">Ganti Password</button>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
