<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_food extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function read($limit, $start, $key)
    {
        $this->db->select('a.*, b.category_food_name');
        $this->db->from('tbl_food a');
        $this->db->join('tbl_category_food b', 'a.food_id = b.category_food_id', 'LEFT');

        if ($key != '') {
            $this->db->like("a.food_name", $key);
            $this->db->or_like("b.category_food_name", $key);
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
        $this->db->insert('tbl_food', $data);
    }

    public function update($data)
    {
        $this->db->update('tbl_food', $data, array('food_id' => $data['food_id']));
    }

    public function delete($id)
    {
        $this->db->delete('tbl_food', array('food_id' => $id));
    }

    public function get($id)
    {
        $this->db->select('a.*, b.category_food_name');
        $this->db->from('tbl_food a');
        $this->db->join('tbl_category_food b', 'a.category_food_id = b.category_food_id', 'LEFT');
        $this->db->where('a.food_id', $id);
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
