<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Users_m extends CI_Model {

    public function getAllData($role_id = null)
    {
      if ($role_id != null){
        return $this->db->get_where('member', ['role_id' => $role_id])->result_array();
      }else{
        return $this->db->get('member')->result_array();
      }
    }


    public function getDataById($id)
    {
      return $this->db->get_where('member', ['id' => $id])->row_array();
    }


    public function getUser($account)
    {
      return $this->db->get_where('member', ['account' => $account])->row_array();
    }


    public function getUsers($role_id)
    { 
      $this->db->order_by('name', 'ASC');

      return $this->db->get_where('member', ['role_id' => $role_id])->result_array();
    }


    public function storeData($data)
    {
      $datas = [
        'role_id' => htmlspecialchars($data['role']),
        'name' => htmlspecialchars($data['name']),
        'bank' => htmlspecialchars($data['bank']),
        'account' => htmlspecialchars($data['account']),
        'def_pass' => '#'.strval($data['account']),
        'password' => null, 
        'avatar' => 'default.png',
        'is_change' => 0
      ];

      return $this->db->insert('member', $datas);
    }


    public function getByAccount()
    {
      $this->db->where('role_id', 3);
      $this->db->order_by('account', 'ASC');
      return $this->db->get('member')->result_array();
    }


    public function getOperators()
    {
      $this->db->where('role_id', 1);
      $this->db->or_where('role_id', 2);
      return $this->db->get('member')->result_array();
    }


    public function getTotalRows($role_id = null)
    {
      if ($role_id != null){
        return $this->db->get_where('member', ['role_id' => $role_id])->num_rows();
      }else{
        return $this->db->get('member')->num_rows();
      }
    }


    public function editByAdmin($data)
    {
      if ($data['reset']){
        $this->db->set('password', null);
        $this->db->set('is_change', 0);
      }
      $this->db->set('name', htmlspecialchars($data['name']));
      $this->db->set('bank', htmlspecialchars($data['bank']));
      $this->db->set('account', htmlspecialchars($data['account']));
      $this->db->set('def_pass', $def_pass = '#'.htmlspecialchars($data['account']));
      $this->db->where('id', $data['userid']);
      $this->db->update('member');

      return $this->db->affected_rows();
    }


    public function editByUser($data, $ava)
    {
      if ($data['uaccount']){
        $account = htmlspecialchars($data['uaccount']);
        $this->db->set('account', $account);
        $this->db->set('def_pass', '#'.$account);
      }

      $this->db->set('name', htmlspecialchars($data['uname']));
      $this->db->set('bank', htmlspecialchars($data['ubank']));
      $this->db->set('avatar', $ava);

      $this->db->where('id', $data['userid']);
      $this->db->update('member');

      return $this->db->affected_rows(); 
    }


    public function changePass($data)
    {
      $this->db->set('password', $data['new_pass']);
      $this->db->set('is_change', $data['is_change']);
      $this->db->where('id', $data['id']);
      $this->db->update('member');

      return$this->db->affected_rows();
    }


    public function setLastActive($data)
    {
      $this->db->set('last_active', $data['last_active']);
      $this->db->where('id', $data['user_id']);
      $this->db->update('member');
    }


    public function dropUser($id)
    {
      $this->db->where('role_id !=', 1);
      $this->db->where('id', $id);
      $this->db->delete('member');

      return $this->db->affected_rows();
    }


    public function resetAll()
    {
      $members = $this->getAllData();

      foreach ($members as $m){
        $this->db->where('id', $m->id);
        $this->db->update('member', [
          'def_pass' => '#'.$m->account, 
          'password' => null, 
          'is_confirm' => 0]);
      }

      return $this->db->count_all_results();
    }

  }