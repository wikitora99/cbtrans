<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Usr extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
      is_logged();
    }

    public function index()
    {
      $data['title'] = "Profil Saya";
      $data['user'] = $this->muser->getUser($this->session->userdata('uname'));

      $this->load->view('templates/panel_header', $data);
      $this->load->view('templates/panel_sidebar', $data);
      $this->load->view('templates/panel_topbar', $data);
      $this->load->view('member/index', $data);
      $this->load->view('templates/panel_footer');
    }


    public function invoice()
    {
      is_user($this->session->userdata('role'));
      
      $data['title'] = "Bukti Transfer";
      $data['user'] = $this->muser->getUser($this->session->userdata('uname'));
      $data['latest_invoice'] = $this->minvoice->getLatest($this->session->userdata('user_id'));
      $data['invoices'] = $this->minvoice->getByUser($this->session->userdata('user_id'));

      $this->load->view('templates/panel_header', $data);
      $this->load->view('templates/panel_sidebar', $data);
      $this->load->view('templates/panel_topbar', $data);
      $this->load->view('member/invoice', $data);
      $this->load->view('templates/panel_footer');
    }


    public function getUserEdit()
    {
      if (!$this->input->post()){
        redirect(base_url('usr'));
      }else{
        $data = $this->muser->getDataById($this->input->post('id'));

        echo json_encode($data);
      } 
    }


    public function editUser()
    {
      if ($this->input->post()){
        $this->form_validation->set_rules('uname', 'Nama', 'trim|required');
        $this->form_validation->set_rules('ubank', 'Bank', 'required|trim');

        $defacc = $this->input->post('defacc');
        $newacc = $this->input->post('uaccount');
        $oldAva = $this->input->post('defava');

        if ($newacc){
          if ($defacc != $newacc){
            $this->form_validation->set_rules('uaccount', 'Rekening', 'required|trim|is_unique[member.account]|min_length[6]');
          }
        }

        if (empty($_FILES['avatar']['name'])){
          $ava = $oldAva;
        }else{
          $ava = $this->_upload();
        }

        if ($this->form_validation->run() == false){
          if (strpos(validation_errors(), '6 characters')){
            swal_msg('Tidak Valid!', 'Password baru minimal harus terdiri dari 6 karakter', 'warning');
          }else if (strpos(validation_errors(), 'unique value')){
            swal_msg('Tidak Valid!', 'Rekening yang anda masukkan sudah terdaftar!', 'warning');
          }else{
            swal_msg('Tidak Valid!', 'Masukkan semua form isian dengan benar!', 'warning');
          }
        }else{
          if (!$ava){
            swal_msg('Tidak Valid!', 'Format file tidak valid atau ukuran file terlalu besar (max = 500 kb)', 'warning');
          }else{
            $data = $this->input->post();

            if ($this->muser->editByUser($data, $ava)){
              if ($ava != $oldAva){
                if ($oldAva != 'default.png'){
                  unlink('upload/profile/'.$oldAva);
                }
              }
              if ($newacc){
                if ($defacc != $newacc){
                  redirect(base_url('auth/logout/1'));
                }
              }
              swal_msg('Sukses!', 'Berhasil mengubah data', 'success');
            }else{
              swal_msg('Kesalahan!', 'Tidak ada data yang diubah', 'error');
            }
          }
        } 
      }
      redirect(base_url('usr'));
    }


    private function _upload()
    {
      $f_name = random_string('alnum', 16);
      $ext = explode('.', $_FILES['avatar']['name']);
      $f_ext = strtolower(end($ext));

      $config['upload_path'] = './upload/profile';
      $config['allowed_types'] = 'jpg|png|jpeg';
      $config['max_size'] = '1024';
      $config['file_name'] = $f_name;
      $config['file_ext_tolower'] = true;

      $this->upload->initialize($config);

      if (!$this->upload->do_upload('avatar')){
        return false;
      }else{
        $file_name = $f_name.'.'.$f_ext;

        $config['source_image'] = './upload/profile/'.$file_name;

        $imageSize = $this->image_lib->get_image_properties($config['source_image'], true);

        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = false;

        if ($imageSize['width'] > $imageSize['height']){
          $config['width'] = $imageSize['height'];
          $config['height'] = $imageSize['height'];
          $config['x_axis'] = (($imageSize['width'] / 2) - ($config['width']) / 2);
        }else{
          $config['width'] = $imageSize['width'];
          $config['height'] = $imageSize['width'];
          $config['x_axis'] = (($imageSize['height'] / 2) - ($config['height']) / 2);
        }

        $this->image_lib->initialize($config);
        $this->image_lib->crop();

        return $file_name;
      }
    }


    public function resetPass()  
    {
      if ($this->input->post('user_btn')){
        $u_id = $this->input->post('userid');
        $u_ids = $this->session->userdata('user_id');
        $old_pass = $this->input->post('oldpass');

        if ($u_id == $u_ids){
          $this->form_validation->set_rules('oldpass', 'Password Lama', 'trim|required');
          $this->form_validation->set_rules('newpass', 'Password Baru 1', 'required|trim|min_length[6]');
          $this->form_validation->set_rules('repass', 'Password Baru 2', 'trim|required|matches[newpass]');

          if ($this->form_validation->run() == false ){
            if (strpos(validation_errors(), '6 characters')){
              swal_msg('Tidak Valid!', 'Password baru minimal harus terdiri dari 6 karakter', 'warning');
            }else if (strpos(validation_errors(), 'not match')){
              swal_msg('Tidak Valid!', 'Konfirmasi password baru tidak sesuai', 'warning');  
            }else{
              swal_msg('Tidak Valid!', 'Masukkan semua form isian dengan benar', 'warning');
            }
          }else{
            if ($this->_passVerify($u_id, $old_pass)){
              $new_pass = $this->input->post('newpass');

              if ($this->_passVerify($u_id, $new_pass)){
                swal_msg('Tidak valid!', 'Password baru harus berbeda dengan password lama!', 'warning');
              }else{
                if ($this->_change($this->input->post())){
                  redirect(base_url('auth/logout/2'));
                }else{
                  swal_msg('Kesalahan!', 'Gagal mengganti password!', 'error');
                }
              }
            }else{
              swal_msg('Tidak Valid!', 'Password lama tidak sesuai!', 'warning');
            }
          } 
        }else{
          swal_msg('Kesalahan!', 'Aksi tidak diizinkan!', 'error');
        }
      }
      redirect(base_url('usr'));
    }


    private function _passVerify($id, $new_pass)
    {
      $user = $this->muser->getDataById($id);

      if ($user['is_change'] == 1){
        return (password_verify($new_pass, $user['password']));
      }else{
        return ($new_pass == $user['def_pass']);
      } 
    }


    private function _change($data)
    {
       $datas = [
        'id' => $data['userid'],
        'new_pass' => password_hash($data['newpass'], PASSWORD_DEFAULT),
        'is_change' => 1
       ];

       return $this->muser->changePass($datas);
    }

  }

?>