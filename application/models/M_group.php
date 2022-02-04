<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_group extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function read($limit, $start, $key) {
        $this->db->select('group_id, group_name');
        $this->db->from('tbl_group');
        
        if($key!=''){
            $this->db->like("group_name", $key);
        }

        if($limit !="" OR $start !=""){
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

    public function create($data) {
        $this->db->insert('tbl_group', $data);
    }
    
    public function update($data) {
        $this->db->update('tbl_group', $data, array('group_id' => $data['group_id']));
    }
    
    public function delete($id) {
        $this->db->delete('tbl_group', array('group_id' => $id));
    }
    
    public function get($id) {
        $this->db->where('group_id', $id);
        $query = $this->db->get('tbl_group', 1);
        return $query->result();
    }

    function __destruct() {
        $this->db->close();
    }
    
}
?>