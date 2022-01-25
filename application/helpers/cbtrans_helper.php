<?php 

  function id_fdate($date)
  {
    $month = [ 1 =>
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    ];
    $exp = explode('-', $date);

    return $exp[2].' '.$month[(int)$exp[1]].' '.$exp[0];
  }


  function is_logged()
  {
    $ci = get_instance();

    if (!$ci->session->userdata('uname')){
      swal_msg('Sesi Habis!', 'Silakan login kembali', 'error');
      redirect(base_url());
    }else{
      $role_id = $ci->session->userdata('role');
      $menu = $ci->uri->segment(1);

      $queryMenu = $ci->db->get_where('menu', ['menu' => $menu])->row_array();
      $menu_id = $queryMenu['id'];

      $userAccess = $ci->db->get_where('user_access', [
        'role_id' => $role_id, 
        'menu_id' => $menu_id
      ]);

      if ($userAccess->num_rows() < 1){
        redirect(base_url('auth/blocked'));
      }
    }
  }


  function is_user($role_id)
  {
    if ($role_id != 3){
      redirect(base_url('auth/missing'));
    }
  }


  function swal_msg($title, $msg, $type)
  {
    $ci = get_instance();

    $ci->session->set_flashdata('msg', ''.$title.'-'.$msg.'-'.$type); 
  }