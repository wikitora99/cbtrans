<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Auth extends CI_Controller{

    public function index()
    { 
      $this->form_validation->set_rules('user', 'Username', 'required|trim|min_length[6]', [
          'required' => 'Username harus diisi!',
          'min_length' => 'Username minimal 6 karakter!'
      ]);
      $this->form_validation->set_rules('pass', 'Password', 'required|trim', [
          'required' => 'Password harus diisi!'
      ]);

      if ($this->form_validation->run() == false){
        $data['title'] = 'Login Akun';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
      }else{
        $this->_login();
      }
    }


    private function _login()
    {
      $uname = $this->input->post('user');
      $pass = $this->input->post('pass');

      $user = $this->muser->getUser($uname);

      if ($user){
        if ($this->_passVerify($uname, $pass)){
          $data = [
            'uname' => $user['account'],
            'role' => $user['role_id'],
            'user_id' => $user['id'],
          ];
          $this->session->set_userdata($data);

          swal_msg('Berhasil Masuk!', 'Selamat datang, '.$user['name'].'!', 'success');

          if ($user['role_id'] == 1){
            redirect(base_url('adm/mems'));
          }else if ($user['role_id'] == 2){
            redirect(base_url('mod/invoice'));
          }else{
            redirect(base_url('usr/invoice'));
          }
        }else{
          swal_msg('Tidak Valid!', 'Username '.$uname.' terdaftar, namun Password tidak sesuai!', 'warning');
          redirect(base_url());
        }
      }else{
        swal_msg('Kesalahan!', 'Username '.$uname.' tidak terdaftar!', 'error');
        redirect(base_url());
      }
    }


    private function _passVerify($uname, $pass)
    {
      $user = $this->muser->getUser($uname);

      if ($user['is_change'] == 1){
        return (password_verify($pass, $user['password']));
      }else{
        return ($pass == $user['def_pass']);
      } 
    }
    

    public function blocked()
    {
      $data['title'] = "Akses Ditolak";
      $data['user'] = $this->db->get_where('member', ['account' => $this->session->userdata('uname')])->row_array();

      $this->load->view('templates/panel_header', $data);
      $this->load->view('templates/panel_topbar', $data);
      $this->load->view('auth/blocked');
      $this->load->view('templates/panel_footer');
    }


    public function missing()
    {
      $data['title'] = "Halaman Tidak Ditemukan";
      $data['user'] = $this->muser->getUser($this->session->userdata('uname'));

      $this->load->view('templates/panel_header', $data);
      $this->load->view('templates/panel_topbar', $data);
      $this->load->view('auth/missing');
      $this->load->view('templates/panel_footer');
    }


    public function logout($uc = null)
    { 
      $data = [
        'user_id' => $this->session->userdata('user_id'),
        'last_active' => date('Y-m-d')
      ];
      $this->muser->setLastActive($data);

      $this->session->unset_userdata('uname');
      $this->session->unset_userdata('role');
      $this->session->unset_userdata('qr_member');
      $this->session->unset_userdata('qr_invoice');
      $this->session->unset_userdata('user_id');

      if ($uc){
        if ($uc == 1){
          swal_msg('Sukses!', 'Anda mengubah Nomor Rekening (username), silakan Login kembali menggunakan username baru', 'success');
        }else if ($uc == 2){
          swal_msg('Sukses!', 'Berhasil mengganti password! Silakan Login kembali menggunakan password baru', 'success');
        }
      }else{
        swal_msg('Berhasil Keluar!', 'Sampai jumpa!', 'success');
      }
      redirect(base_url());
    }

  }

?>