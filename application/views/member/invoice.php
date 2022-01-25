
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="flash-alert" data-flash="<?= $this->session->flashdata('msg'); ?>"></div>

  <div class="col-lg-12">

    <div class="card shadow mb-4 text-center" style="max-width: 350px;">
      <div class="card-header py-3">
        <h5 class="mb-2 font-weight-bold text-primary"><?= $title; ?> Terbaru</h5>
        <?php if ($latest_invoice): ?>
          <h6 class="mb-0"><?= id_fdate($latest_invoice['date']); ?></h6>
        <?php endif; ?>
      </div>
      <!-- Card Body -->
      <div class="card-body">
      <?php if ($latest_invoice): ?>
        <a href="<?= base_url('upload/invoice'); ?>/<?= $latest_invoice['image']; ?>" target="_blank">
          <img class="card-img-top img-fluid d-block mx-auto" src="<?= base_url('upload/invoice'); ?>/<?= $latest_invoice['image']; ?>" style="max-width: 300px;" alt="Bukti Transfer">
        </a>
        <h6 class="mt-2 text-danger small">Klik gambar untuk melihat ukuran asli.</h6>
        <?php if (count($invoices) > 1): ?>
          <button type="button" class="btn btn-sm btn-primary mt-2 show-tabs">Riwayat Bukti Transfer &raquo;</button>
        <?php endif; ?>
      <?php else: ?>
        <h6 class="mt-2 font-weight-bold text-danger">Belum ada data <?= strtolower($title); ?>!</h6>
        <h6 class="text-secondary">Untuk informasi lebih lanjut silakan hubungi pihak pengelola.</h6>
      <?php endif; ?>
      </div>
    </div>

    <div class="card shadow mb-4 d-none u-tabs">
      <div class="card-header py-3 d-flex flex-row align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Riwayat Bukti Transfer</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover usr" width="100%" id="dataTables">
            <thead>
              <tr>
                <th>Tanggal Transfer</th>
                <th>Bukti Transfer</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($invoices as $uin): ?>
              <tr>
                <td><?= id_fdate($uin['date']); ?></td>
                <td><a href="<?= base_url('upload/invoice'); ?>/<?= $uin['image']; ?>" target="_blank">Klik untuk melihat</td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->