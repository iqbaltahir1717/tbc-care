<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_category_food extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function read($limit, $start, $key)
    {
        $this->db->select('*');
        $this->db->from('tbl_category_food');

        if ($key != '') {
            $this->db->like("category_food_name", $key);
        }

        if ($limit != "" or $start != "") {
            $this->db->limit($limit, $start);
        }

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
        $this->db->insert('tbl_category_food', $data);
    }

    public function update($data)
    {
        $this->db->update('tbl_category_food', $data, array('category_food_id' => $data['category_food_id']));
    }

    public function delete($id)
    {
        $this->db->delete('tbl_category_food', array('category_food_id' => $id));
    }

    public function get($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_category_food');
        $this->db->where('category_food_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return null;
    }

    function __destruct()
    {
        $this->db->close();
    }
}
