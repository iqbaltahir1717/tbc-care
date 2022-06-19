<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_data_pasien extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function read($limit, $start, $key)
    {
        $this->db->select('a.*, b.*');
        $this->db->from('tbl_pasien a');
        $this->db->join('tbl_user b', 'a.user_id = b.user_id', 'LEFT');
        // $this->db->where('a.group_id=2');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return null;
    }

    public function update($data)
    {
        $this->db->update('tbl_pasien', $data, array('pasien_id' => $data['pasien_id']));
    }


    public function get($id)
    {
        $this->db->select('a.*, b.*');
        $this->db->from('tbl_pasien a');
        $this->db->join('tbl_user b', 'a.user_id = b.user_id', 'LEFT');
        // $this->db->where('a.user_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return null;
    }

    public function create($data)
    {
        $this->db->insert('tbl_pasien', $data);
    }

    function __destruct()
    {
        $this->db->close();
    }
}
