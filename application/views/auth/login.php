
<div class="container">

  <div id="flash-alert" data-flash="<?= $this->session->flashdata('msg'); ?>"></div>

  <!-- Outer Row -->
  <div class="row justify-content-center mt-3">

    <div class="col-lg-6">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center mb-5">
                  <h1 class="h4 text-gray-900 mb-4">Login Untuk Melanjutkan</h1>
                </div>

                <form class="user" method="post" action="<?= base_url('auth'); ?>">

                  <span><?= form_error('user', '<small class="text-danger pl-3">', '</small>'); ?></span>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-user userPass" id="user" name="user" autofocus="on" value="<?= set_value('user'); ?>" placeholder="Masukkan Username...">                
                  </div>

                  <span><?= form_error('pass', '<small class="text-danger pl-3">', '</small>'); ?></span>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control form-control-user" id="pass" name="pass" placeholder="Masukkan Password...">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-user d-block input-group-text" id="show-pass"><li class="fas fa-fw fa-eye"></li></button>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Login
                  </button>
                </form>
                <hr>
                <div class="text-center">
                  <a class="small"><strong>Lupa Password?</strong> Silakan hubungi Administrator untuk meangatur ulang password Anda!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
