<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_field extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function read($limit, $start, $key) {
        $this->db->select('field_id, field_name');
        $this->db->from('tbl_web_field');
        
        if($key!=''){
            $this->db->like("field_name", $key);
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
        $this->db->insert('tbl_web_field', $data);
    }
    
    public function update($data) {
        $this->db->update('tbl_web_field', $data, array('field_id' => $data['field_id']));
    }
    
    public function delete($id) {
        $this->db->delete('tbl_web_field', array('field_id' => $id));
    }
    
    public function get($id) {
        $this->db->where('field_id', $id);
        $query = $this->db->get('tbl_web_field', 1);
        return $query->result();
    }

    function __destruct() {
        $this->db->close();
    }
    
}
?>