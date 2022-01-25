<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Adm extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
      is_logged();
    }

    public function index()
    {
      redirect(base_url('adm/mems'));
    }


    public function mems()
    {
      $data['title'] = "Data Peserta";
      $data['user'] = $this->muser->getUser($this->session->userdata('uname'));
      $data['role'] = 3;
      $data['members'] = $this->muser->getUsers(3);

      $this->load->view('templates/panel_header', $data);
      $this->load->view('templates/panel_sidebar', $data);
      $this->load->view('templates/panel_topbar', $data);
      $this->load->view('admin/index', $data);
      $this->load->view('templates/panel_footer');
    }


    public function mods()
    {
      $data['title'] = "Data Moderator";
      $data['user'] = $this->muser->getUser($this->session->userdata('uname'));
      $data['role'] = 2;

      $data['mods'] = $this->muser->getUsers(2);

      $this->load->view('templates/panel_header', $data);
      $this->load->view('templates/panel_sidebar', $data);
      $this->load->view('templates/panel_topbar', $data);
      $this->load->view('admin/moderator', $data);
      $this->load->view('templates/panel_footer');
    }


    public function acts()
    { 
      $data['title'] = "Data Kegiatan";
      $data['user'] = $this->muser->getUser($this->session->userdata('uname'));
      $data['acts'] = $this->mactive->getActivity();

      $this->load->view('templates/panel_header', $data);
      $this->load->view('templates/panel_sidebar', $data);
      $this->load->view('templates/panel_topbar', $data);
      $this->load->view('admin/activity', $data);
      $this->load->view('templates/panel_footer');
    }


    public function storeUser()
    {
      if ($this->input->post()){
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('bank', 'Bank', 'required|trim');
        $this->form_validation->set_rules('account', 'Rekening', 'required|trim|is_unique[member.account]');

        if ($this->input->post('role') == 3){
          $url = 'adm/mems';
        }else if ($this->input->post('role') == 2){
          $url = 'adm/mods';
        }

        if ($this->form_validation->run() == false){
          if (strpos(validation_errors(), 'unique value')){
            swal_msg('Tidak Valid!', 'Rekening yang Anda masukkan sudah terdaftar!', 'warning');
          }else{
            swal_msg('Tidak Valid!', 'Masukkan semua form isian dengan benar!', 'warning');
          }
        }else{
          if ($this->muser->storeData($this->input->post())){
            swal_msg('Sukses!', 'Berhasil menambahkan data baru', 'success');
          }else{
            swal_msg('Kesalahan!', 'Gagal menambahkan data baru', 'error');
          }
        }
        redirect(base_url($url));
      }else{
        redirect(base_url('adm/mems'));
      }
    }


    public function drop($id = null)
    {
      if ($id != null){
        $prev_url = $this->agent->referrer();
        $user = $this->muser->getDataById($id);
      
        if ($prev_url == null){
          redirect(base_url('adm'));
        }else{
          if ($this->muser->dropUser($id) > 0){
            swal_msg('Sukses!', 'Berhasil menghapus data', 'success');
              if ($user['avatar'] != 'default.png'){
                unlink('upload/profile/'.$user['avatar']);
              }
          }else{
            swal_msg('Kesalahan!', 'Gagal menghapus data', 'error');
          }
          redirect($prev_url);
        }
      }else{
        redirect(base_url('adm'));
      }
    }


    public function getUserEdit()
    {
      if (!$this->input->post()){
        redirect(base_url('adm/mems'));
      }else{
        $data = $this->muser->getDataById($this->input->post('id'));

        echo json_encode($data);
      }
    }


    public function editUser()
    {
      if ($this->input->post()){
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('bank', 'Bank', 'required|trim');
        if ($this->input->post('account') != $this->input->post('befacc')){
          $this->form_validation->set_rules('account', 'Rekening', 'required|trim|is_unique[member.account]');
        }

        if ($this->input->post('role') == 3){
          $url = 'adm/mems';
        }else if ($this->input->post('role') == 2){
          $url = 'adm/mods';
        }

        if ($this->form_validation->run() == false){
          if (strpos(validation_errors(), 'unique value')){
            swal_msg('Tidak Valid!', 'Rekening baru yang Anda masukkan sudah terdaftar!', 'warning');
          }else{
            swal_msg('Tidak Valid!', 'Masukkan semua form isian dengan benar!', 'warning');
          }
        }else{
          if ($this->muser->editByAdmin($this->input->post())){
            swal_msg('Sukses!', 'Berhasil mengubah data', 'success');
          }else{
            swal_msg('Kesalahan!', 'Tidak ada data yang diubah', 'error');
          }
        }
        redirect(base_url($url));
      }else{
        redirect(base_url('adm'));
      }
    }


    public function storeAct()
    {
      if ($this->input->post()){
        $this->form_validation->set_rules('title', 'Nama Kegiatan', 'required|trim');
        $this->form_validation->set_rules('alias', 'Alias', 'required|trim|is_unique[activity.alias]');
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'required|trim');
        $this->form_validation->set_rules('end_date', 'Tanggal Selesai', 'required|trim');

        if ($this->form_validation->run() == false){
          if (strpos(validation_errors(), 'unique value')){
            swal_msg('Tidak Valid!', 'Nama Alias kegiatan sudah digunakan!', 'warning');
          }else{
            swal_msg('Tidak Valid!', 'Masukkan semua form isian dengan benar!', 'warning');
          }
        }else{
          if ($this->mactive->storeData($this->input->post())){
            swal_msg('Sukses!', 'Berhasil menambahkan data baru', 'success');
          }else{
            swal_msg('Kesalahan!', 'Gagal menambahkan data baru', 'error');
          } 
        }
      }
      redirect(base_url('adm/acts'));
    }


    public function getActEdit()
    {
      if (!$this->input->post()){
        redirect(base_url('adm/acts'));
      }else{
        $data = $this->mactive->getDataById($this->input->post('id'));

        echo json_encode($data);
      } 
    }


    public function editAct()
    {
      if ($this->input->post()){
        $this->form_validation->set_rules('title', 'Nama Kegiatan', 'required|trim');
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'required|trim');
        $this->form_validation->set_rules('end_date', 'Tanggal Selesai', 'required|trim');
        if ($this->input->post('alias') != $this->input->post('defalias')){
          $this->form_validation->set_rules('alias', 'Alias', 'required|trim|is_unique[activity.alias]');
        }


        if ($this->form_validation->run() == false){
          if (strpos(validation_errors(), 'unique value')){
            swal_msg('Tidak Valid!', 'Nama Alias kegiatan sudah digunakan!', 'warning');
          }else{
            swal_msg('Tidak Valid!', 'Masukkan semua form isian dengan benar!', 'warning');
          }
        }else{
          if ($this->mactive->editData($this->input->post())){
            swal_msg('Sukses!', 'Berhasil mengubah data', 'success');
          }else{
            swal_msg('Kesalahan!', 'Tidak ada data yang diubah', 'error');
          } 
        }
      }
      redirect(base_url('adm/acts'));
    }


    public function dropAct($id = null)
    {  
      if ($id != null){
        $act = $this->mactive->getDataById($id);

        if ($act != null){
          if ($this->mactive->dropData($id) > 0){
            swal_msg('Sukses!', 'Berhasil menghapus data', 'success');
          }else{
            swal_msg('Kesalahan!', 'Gagal menghapus data', 'error');
          }
        }else{
          swal_msg('Kesalahan!', 'Tidak ada data yang dihapus!', 'error');
        }
      }
      redirect(base_url('adm/acts'));
    }


    // private function _resetAllMember()
    // {
    //   $this->muser->resetAll();
    // }
  }

?>