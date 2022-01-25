  
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="flash-alert" data-flash="<?= $this->session->flashdata('msg'); ?>"></div>

  <div id="base-url" data-url="<?= base_url(); ?>"></div>

  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h5 class="m-0 font-weight-bold text-primary"><?= $title; ?></h5>
      <button type="button" id="addUserBtn" class="d-sm-inline-block btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUser"><i class="fas fa-plus-circle text-white-50 mr-2"></i>Tambah <?= $title; ?></button>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover" width="100%" id="dataTables">
          <thead>
            <tr>
              <th>Nama Moderator</th>
              <th>Nama Bank</th>
              <th>Nomor Rekening</th>
              <th>Terakhir Login</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mods as $m): ?>
            <tr>
              <td><?= $m['name']; ?></td>
              <td><?= $m['bank']; ?></td>
              <td><?= $m['account']; ?></td>
              <td>
                <?php if ($m['last_active']): ?>
                  <?= id_fdate($m['last_active']); ?>
                <?php else: ?>
                  <span class="badge badge-pill badge-secondary">Belum Login</span>
                <?php endif; ?>
              </td>
              <td>
                <button type="button" class="btn btn-success btn-circle btn-sm editUser" data-toggle="modal" data-target="#modalUser" data-id="<?= $m['id']; ?>"><i class="fas fa-edit"></i></button>
                
                <a href="<?= base_url('adm/drop'); ?>/<?= $m['id']; ?>" class="btn btn-danger btn-circle btn-sm dropBtn"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->