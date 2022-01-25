    </div>
    <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>&copy; <?= date('Y'); ?> CBTrans by Wikitora</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  
  <!-- Form Modal User Update -->
  <div class="modal fade" id="modalModf" tabindex="-1" role="dialog" aria-labelledby="modalModfLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalModfLabel"></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="moduserForm" action="<?= base_url('usr/editUser'); ?>" method="post" enctype="multipart/form-data">
          <div class="modal-body">

            <input type="hidden" name="userid" value="<?= $user['id']; ?>">
            <input type="hidden" name="defava" value="<?= $user['avatar']; ?>">
            <input type="hidden" name="defacc" value="<?= $user['account']; ?>">

            <div class="user-reset">
              <div class="form-group">
                <label for="oldpass">Password Lama</label>
                <input type="password" class="form-control userPass" id="oldpass" name="oldpass" placeholder="Masukkan password lama..." autocomplete="off">
              </div>

              <div class="form-group">
                <label for="newpass">Password Baru</label>
                <input type="password" class="form-control userPass" id="newpass" name="newpass" placeholder="Minimal terdiri 6 karakter..." autocomplete="off">
              </div>

              <div class="form-group">
                <label for="repass">Konfirmasi Password</label>
                <input type="password" class="form-control userPass" id="repass" name="repass" placeholder="Ulangi password baru..." autocomplete="off">
              </div>

              <div class="form-group mt-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" id="change-pass">
                  </div>
                </div>
                <label class="form-control sp-label" for="change-pass">Lihat Password</label>
              </div>
            </div>
            </div>

            <div class="user-edit">
              <div class="form-group">
                <label for="uname">Nama Lengkap</label>
                <input type="text" class="form-control" id="uname" name="uname" placeholder="Nama Lengkap..." autocomplete="off">
              </div>

              <div class="form-group">
                <label for="uaccount">Nomor Rekening</label>
                <input type="number" class="form-control" id="uaccount" name="uaccount" placeholder="Minimal 6 digit angka..." autocomplete="off" <?php if ($this->session->userdata('role') == 3){ echo 'disabled'; } ?>>
              </div>

              <?php if ($this->session->userdata('role') != 3): ?>
                <div class="alert alert-danger d-none optAlert" role="alert">
                  <p><strong>Note:</strong> Mengubah <strong>Nomor Rekening</strong> berarti mengubah <strong>Username</strong> untuk Login. Gunakan Nomor Rekening yang baru sebagai Username Anda.</p>
                </div>
              <?php endif; ?>

              <?php if ($this->session->userdata('role') == 3): ?>
              <div class="alert alert-warning" role="alert">
                <p>Untuk melakukan perubahan pada <strong>Nomor Rekening</strong>, silakan hubungi <strong>Pihak Pengelola</strong> agar perubahan dapat diproses.</p>
              </div>
              <?php endif; ?>  

              <div class="form-group">
                <label for="ubank">Nama Bank</label>
                <input type="text" class="form-control" id="ubank" name="ubank" placeholder="Nama Bank..." autocomplete="off">
              </div>

              <div class="form-group">
                <label for="avatar">Gambar Profil</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="avatar" name="avatar">
                  <label class="custom-file-label ava">Pilih File (.jpg/.png)</label>
                </div>
                <img src="" class="mt-2 img-thumbnail" id="avaPreview" style="max-width: 100px;" alt="Gambar Profil"><span class="ml-2">Gambar Profil saat ini</span>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
            <button type="submit" class="btn btn-primary" name="user_btn" value="x">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <?php if ($this->session->userdata('role') == 3): ?>
  <!-- NO MODAL 1 -->
  <?php else: ?>
  <!-- Form Modal Bukti Transfer -->
  <div class="modal fade" id="modalInvoice" tabindex="-1" role="dialog" aria-labelledby="modalInvoiceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalInvoiceLabel" data-title="<?= $title; ?>">Tambah <?= $title; ?></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url('mod/storeInvoice'); ?>" method="post" enctype="multipart/form-data" id="invoiceForm">
          <input type="hidden" id="invoice-id" name="invoice_id">
          <input type="hidden" id="def-img" name="defimage">

          <div class="modal-body">
            <input type="hidden" id="base-url" value="<?= base_url(); ?>">

            <div class="form-group">
              <label for="reciever">Rekening Penerima (Peserta)</label>
              <select name="reciever" id="reciever" class="form-control">
                <option value="xxx" selected>Pilih Rekening</option>
              <?php foreach ($members as $m): ?>
                <option value="<?= $m['id']; ?>"><?= $m['account']; ?></option>
              <?php endforeach; ?>
              </select>
            </div>

            <input type="hidden" id="thisactive" data-userid="<?= $user['id']; ?>" data-useracc="<?= $user['account']; ?>">

            <div class="form-group">
              <label for="sender" id="senderLabel">Rekening Pengirim (Anda)</label>
              <select name="sender" id="sender" class="form-control" disabled>
              <?php foreach ($opts as $op): ?>
              <?php if ($op['id'] == $user['id']): ?>
                <option value="<?= $op['id']; ?>" selected><?= $op['account']; ?></option>
              <?php else: ?>
                <option value="<?= $op['id']; ?>"><?= $op['account']; ?></option>
              <?php endif; ?>
              <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="act">Jenis Kegiatan</label>
              <select name="act" id="act" class="form-control">              
                <option value="" selected>Pilih Kegiatan</option>
              <?php foreach ($acts as $ac): ?>
                <option value="<?= $ac['id']; ?>"><?= $ac['title']; ?></option>
              <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="date">Tanggal Transfer</label>
              <input type="date" class="form-control" id="date" name="date">
            </div>

            <div class="form-group">
              <label for="image">Gambar Bukti Transfer</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="image" name="image">
                <label class="custom-file-label img">Pilih Gambar (.jpg/.png)</label>
              </div>
              <img src="<?= base_url('upload/invoice/invoice.png'); ?>" class="mt-2 img-thumbnail" id="preview" width="250" alt="Contoh Bukti Transfer">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
            <button type="submit" class="btn btn-primary" id="saveInvoice">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>



  <?php if ($this->session->userdata('role') != 1): ?>
  <!-- NO MODAL 2 -->
  <!-- NO MODAL 3 -->
  <?php else: ?>
  <!-- Form Modal Data User -->
  <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modalUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUserLabel" data-title="<?= $title; ?>">Tambah <?= $title; ?></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="userForm" action="<?= base_url('adm/storeUser'); ?>" method="post">
          <div class="modal-body">
            <input type="hidden" id="user-id" name="userid">
            <input type="hidden" id="bef-acc" name="befacc">

            <?php if (isset($role)): ?>
              <input type="hidden" name="role" value="<?= $role; ?>">

              <label for="name"><?php if ($role == 3): ?>Nama Lengkap Peserta<?php else: ?>Nama Lengkap Moderator<?php endif; ?></label>
              <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="<?php if ($role == 3): ?>Nama Peserta...<?php else: ?>Nama Moderator...<?php endif; ?>" autocomplete="off">
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label for="bank">Nama Bank</label>
              <input type="text" class="form-control" id="bank" name="bank" placeholder="Nama Bank..." autocomplete="off">
            </div>

            <div class="form-group">
              <label for="account">Nomor Rekening</label>
              <input type="number" class="form-control" id="account" name="account" placeholder="Nomor Rekening..." autocomplete="off">
            </div>

            <div class="alert alert-danger" role="alert" id="modalAlert1">
              <p>Mengubah <strong>Rekening</strong> berarti mengubah <strong>Username</strong>! Harap informasikan perubahan tersebut kepada <strong>User</strong> terkait.</p>
            </div>
            <div class="form-group d-none" id="resetPass">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" id="reset" name="reset">
                  </div>
                </div>
                <label class="form-control" for="reset">Reset Password?</label>
              </div>
            </div>
            <div class="alert alert-primary d-none" role="alert" id="modalAlert2">
              <p>Password akan direset menjadi <strong>Rekening User</strong> saat ini dengan tambahan karakter <strong>#</strong> di depannya (<strong>#norekening</strong>).</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Form Modal Data Activity -->
  <div class="modal fade" id="modalActee" tabindex="-1" role="dialog" aria-labelledby="modalActeeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalActeeLabel" data-title="<?= $title; ?>">Tambah <?= $title; ?></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="acteeForm" action="<?= base_url('adm/storeAct'); ?>" method="post">
          <div class="modal-body">

            <input type="hidden" id="act-id" name="act_id">
            <input type="hidden" id="def-als" name="defalias">

            <div class="form-group">
              <label for="image">Nama Kegiatan</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Nama Lengkap Kegiatan..." autocomplete="off">
            </div>
            
            <div class="form-group">
              <label for="image">Alias (Nama Singkat)</label>
              <input type="text" class="form-control" id="alias" name="alias" placeholder="Nama Lain Kegiatan..." autocomplete="off">
            </div>

            <div class="form-group">
              <label for="s-date">Tanggal Mulai</label>
              <input type="date" class="form-control" id="s-date" name="start_date">
            </div>

            <div class="form-group">
              <label for="e-date">Tanggal Selesai</label>
              <input type="date" class="form-control" id="e-date" name="end_date">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>


  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
  
  <!-- DataTables -->
  <script src="<?= base_url('assets/'); ?>js/datatables.min.js"></script>
  <script src="<?= base_url('assets/'); ?>js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url('assets/'); ?>js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/'); ?>js/dataTables.fixedHeader.min.js"></script>
  <script src="<?= base_url('assets/'); ?>js/fixedHeader.bootstrap4.min.js"></script>

  <!-- Sweetalert 2 -->
  <script src="<?= base_url('assets/'); ?>js/sweetalert2.all.min.js"></script>

  <!-- Custom scripting -->
  <script src="<?= base_url('assets/'); ?>js/script.js"></script>

  <!-- NYARI APA SEEHH?? -->

</body>

</html>
