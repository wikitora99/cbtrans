
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="flash-alert" data-flash="<?= $this->session->flashdata('msg'); ?>"></div>

  <div id="base-url" data-url="<?= base_url(); ?>"></div>

  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h5 class="m-0 font-weight-bold text-primary">Data <?= $title; ?></h5>
      <button type="button" id="addInvoiceBtn" class="d-sm-inline-block btn btn-sm btn-primary" data-toggle="modal" data-target="#modalInvoice"><i class="fas fa-plus-circle text-white-50 mr-2"></i>Tambah <?= $title; ?></button>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover" width="100%" id="dataTables">
          <thead>
            <tr>
              <th>Rekening Penerima</th>
              <th>Rekening Pengirim</th>
              <th>Kegiatan</th>
              <th>Tanggal Transfer</th>
              <th>Bukti Transfer</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($invoices as $in): ?>
              <?php $imgpath = base_url('upload/invoice/').$in['image']; ?>
            <tr>
              <td><?= $in['penerima']; ?></td>
              <td><?= $in['pengirim']; ?></td>
              <td><?= $in['kegiatan']; ?></td>
              <td><?= id_fdate($in['date']); ?></td>
              <td>
              <a href="<?= $imgpath; ?>" target="_blank">Klik untuk melihat</a>
              </td>
              
              <td>
              <?php if ($user['role_id'] != 1): ?>
                <?php if ($in['pengirim'] == $user['account']): ?>
                  <button type="button" class="btn btn-success btn-circle btn-sm editInvoice" data-toggle="modal" data-target="#modalInvoice" data-id="<?= $in['id']; ?>" data-imgpath="<?= $in['image']; ?>"><i class="fas fa-edit"></i></button>

                  <a href="<?= base_url('mod/drop'); ?>/<?= $in['id']; ?>" class="btn btn-danger btn-circle btn-sm dropBtn "><i class="fas fa-trash"></i></a>
                <?php else: ?>
                  <span class="badge badge-pill badge-secondary">Aksi dibatasi</span>
                <?php endif; ?>
              <?php else: ?>
                <button type="button" class="btn btn-success btn-circle btn-sm editInvoice" data-toggle="modal" data-target="#modalInvoice" data-id="<?= $in['id']; ?>" data-imgpath="<?= $in['image']; ?>"><i class="fas fa-edit"></i></button>

                <a href="<?= base_url('mod/drop'); ?>/<?= $in['id']; ?>" class="btn btn-danger btn-circle btn-sm dropBtn"><i class="fas fa-trash"></i></a>
              <?php endif; ?>
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
