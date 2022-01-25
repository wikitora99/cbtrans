
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="flash-alert" data-flash="<?= $this->session->flashdata('msg'); ?>"></div>

  <div id="base-url" data-url="<?= base_url(); ?>"></div>

  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h5 class="m-0 font-weight-bold text-primary"><?= $title; ?></h5>
      <button type="button" id="addActBtn" class="d-sm-inline-block btn btn-sm btn-primary" data-toggle="modal" data-target="#modalActee"><i class="fas fa-plus-circle text-white-50 mr-2"></i>Tambah <?= $title; ?></button>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover" width="100%" id="dataTables">
          <thead>
            <tr>
              <th>Nama Kegiatan</th>
              <th>Alias</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($acts as $ac): ?>
            <tr>
              <td><?= $ac['title']; ?></td>
              <td><?= $ac['alias']; ?></td>
              <td><?= id_fdate($ac['start_date']); ?></td>
              <td><?= id_fdate($ac['end_date']); ?></td>
              <td>
                <button type="button" class="btn btn-success btn-circle btn-sm editAct" data-toggle="modal" data-target="#modalActee" data-id="<?= $ac['id']; ?>"><i class="fas fa-edit"></i></button>

                <a href="<?= base_url('adm/dropAct'); ?>/<?= $ac['id']; ?>" class="btn btn-danger btn-circle btn-sm dropBtn"><i class="fas fa-trash"></i></a>
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
