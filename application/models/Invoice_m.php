<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Invoice_m extends CI_Model {

    public function getDataById($id)
    {
      return $this->db->get_where('invoice', ['id' => $id])->row_array();
    }


    public function getMatch($data_id, $sender_id)
    {
      $this->db->where('id', $data_id);
      $this->db->where('sender_id', $sender_id);
      return $this->db->get('invoice')->row_array();
    }


    public function getLatest($r_id)
    {
      $this->db->where('reciever_id', $r_id);
      $this->db->order_by('date', 'DESC');
      $this->db->limit(1);
      return $this->db->get('invoice')->row_array();
    }


    public function getInvoices()
    {
      $this->db->select('invoice.id');
      $this->db->select('r.account penerima');
      $this->db->select('s.account pengirim');
      $this->db->select('a.alias kegiatan');
      $this->db->select('invoice.image');
      $this->db->select('invoice.date');
      $this->db->from('invoice');
      $this->db->join('member r', 'invoice.reciever_id = r.id');
      $this->db->join('member s', 'invoice.sender_id = s.id');
      $this->db->join('activity a', 'invoice.activity_id = a.id');
      $this->db->order_by('invoice.date', 'DESC');

      return $this->db->get()->result_array();
    }


    public function getByUser($id)
    {
      $this->db->select('image');
      $this->db->select('date');
      $this->db->where('reciever_id', $id);
      $this->db->order_by('date', 'DESC');

      return $this->db->get('invoice')->result_array();
    }


    public function storeData($data, $file)
    {
      $datas = [
        'reciever_id' => $data['reciever'],
        'sender_id' => $data['sender'],
        'activity_id' => $data['act'],
        'image' => $file,
        'date' => $data['date']
      ];

      return $this->db->insert('invoice', $datas);
    }


    public function editData($data, $file)
    {
      $this->db->set('reciever_id',$data['reciever']);
      $this->db->set('activity_id', $data['act']);
      $this->db->set('image', $file);
      $this->db->set('date', $data['date']);

      $this->db->where('id', $data['invoice_id']);
      $this->db->update('invoice');

      return $this->db->affected_rows();
    }


    public function dropInvoice($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('invoice');

      return $this->db->affected_rows();
    }

  }