<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Mod extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
      is_logged();
    }

    public function index()
    {
      redirect(base_url('mod/invoice'));
    }


    public function invoice()
    {
      $data['title'] = "Bukti Transfer";
      $data['user'] = $this->muser->getUser($this->session->userdata('uname'));
      $data['invoices'] = $this->minvoice->getInvoices();
      $data['members'] = $this->muser->getByAccount();
      $data['opts'] = $this->muser->getOperators();
      $data['acts'] = $this->mactive->getActivity();

      $this->load->view('templates/panel_header', $data);
      $this->load->view('templates/panel_sidebar', $data);
      $this->load->view('templates/panel_topbar', $data);
      $this->load->view('moderator/index', $data);
      $this->load->view('templates/panel_footer');
    }


    public function storeInvoice()
    {
      $this->form_validation->set_rules('reciever', 'Penerima', 'trim|numeric');
      $this->form_validation->set_rules('date', 'Tanggal', 'required|trim');
      $this->form_validation->set_rules('act', 'Kegiatan', 'required|trim');
      if (empty($_FILES['image']['name'])){
        $this->form_validation->set_rules('image', 'Invoice', 'required|trim');
      }

      if ($this->form_validation->run() == false){
        swal_msg('Tidak Valid!', 'Masukkan semua form isian dengan benar', 'warning');
      }else{
        $img = $this->_upload();

        if (!$img){
          swal_msg('Tidak Valid!', 'Format file tidak valid atau ukuran file terlalu besar (max = 1 mb)', 'warning');
        }else{
          $data = $this->input->post();
          $file = $img;

          if ($this->minvoice->storeData($data, $file)){
            swal_msg('Sukses!', 'Berhasil menambahkan data baru', 'success');
          }else{
            swal_msg('Kesalahan!', 'Gagal menambahkan data baru', 'error');
          }
        }
      }
      redirect(base_url('mod/invoice'));
    }


    private function _upload()
    {
      $f_name = random_string('alnum', 16);
      $ext = explode('.', $_FILES['image']['name']);
      $f_ext = strtolower(end($ext));

      $config['upload_path'] = './upload/invoice';
      $config['allowed_types'] = 'jpg|png';
      $config['max_size'] = '1024';
      $config['file_name'] = $f_name;
      $config['file_ext_tolower'] = true;

      $this->upload->initialize($config);

      if (!$this->upload->do_upload('image')){
        return false;
      }else{
        $file_name = $f_name.'.'.$f_ext;
        return $file_name;
      }
    }


    public function drop($id = null)
    {
      if ($id != null){
        $s_id = $this->session->userdata('user_id');
        $role_id = $this->session->userdata('role');
        $is_match = $this->minvoice->getMatch($id, $s_id);
        $invoice = $this->minvoice->getDataById($id);
        
        if ($invoice != null){
          if ($role_id != 1){
            if ($is_match != null){
              $action = true;
            }else{
              swal_msg('Tidak Valid!', 'Aksi dibatasi!', 'warning');
            }
          }else{
            $action = true;
          }
        }else{
          swal_msg('Kesalahan!', 'Tidak ada data yang dihapus!', 'error');
        }

        if ($action == true){
          if ($this->minvoice->dropInvoice($id) > 0){
            unlink('upload/invoice/'.$invoice['image']);
            swal_msg('Sukses!', 'Berhasil menghapus data', 'success');
          }else{
            swal_msg('Kesalahan!', 'Gagal menghapus data', 'error');
          }
        }
      }
      redirect(base_url('mod/invoice'));
    }


    public function getInvoiceEdit()
    {
      if (!$this->input->post()){
        redirect(base_url('mod'));
      }else{
        $data = $this->minvoice->getDataById($this->input->post('id'));

        echo json_encode($data);
      }
    }


    public function editInvoice()
    {
      if ($this->input->post()){
        $this->form_validation->set_rules('reciever', 'Penerima', 'trim|numeric');
        $this->form_validation->set_rules('act', 'Kegiatan', 'trim|required');
        $this->form_validation->set_rules('date', 'Tanggal', 'required|trim');

        $oldImg = $this->input->post('defimage');

        if (empty($_FILES['image']['name'])){
          $img = $oldImg;
        }else{
          $img = $this->_upload();
        }

        if ($this->form_validation->run() == false){
          swal_msg('Tidak Valid!', 'Masukkan semua form isian dengan benar', 'warning');
        }else{
          if (!$img){
            swal_msg('Tidak Valid!', 'Format file tidak valid atau ukuran file terlalu besar (max = 1 mb)', 'warning');
          }else{
            $data = $this->input->post();
            if ($this->minvoice->editData($data, $img)){
              if ($img != $oldImg){
                unlink('upload/invoice/'.$oldImg);
              }
              swal_msg('Sukses!', 'Berhasil mengubah data', 'success');
            }else{
              swal_msg('Kesalahan!', 'Tidak ada ata yang diubah', 'error');
            }
          }
        } 
      }
      redirect(base_url('mod/invoice'));     
    }

  }

?>