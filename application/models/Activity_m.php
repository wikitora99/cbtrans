<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Activity_m extends CI_Model {

    public function getDataById($id)
    {
      return $this->db->get_where('activity', ['id' => $id])->row_array();
    }


    public function getActivity()
    {
      $this->db->order_by('end_date', 'DESC');
      return $this->db->get('activity')->result_array();
    }


    public function storeData($data)
    {
      $datas = [
        'title' => htmlspecialchars($data['title']),
        'alias' => htmlspecialchars($data['alias']),
        'start_date' => $data['start_date'],
        'end_date' => $data['end_date']
      ];

      return $this->db->insert('activity', $datas);
    }


    public function editData($data)
    {
      $this->db->set('title', htmlspecialchars($data['title']));
      $this->db->set('alias', htmlspecialchars($data['alias']));
      $this->db->set('start_date', $data['start_date']);
      $this->db->set('end_date', $data['end_date']);

      $this->db->where('id', $data['act_id']);
      $this->db->update('activity');

      return $this->db->affected_rows();
    }


    public function dropData($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('activity');

      return $this->db->affected_rows();
    }

  }