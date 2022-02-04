<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_corebase_crud extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function read($limit, $start, $key) {
        $this->db->select('corebase_crud_id, corebase_crud_name');
        $this->db->from('tbl_corebase_crud');
        
        if($key!=''){
            $this->db->like("corebase_crud_name", $key);
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
        $this->db->insert('tbl_corebase_crud', $data);
    }
    
    public function update($data) {
        $this->db->update('tbl_corebase_crud', $data, array('corebase_crud_id' => $data['corebase_crud_id']));
    }
    
    public function delete($id) {
        $this->db->delete('tbl_corebase_crud', array('corebase_crud_id' => $id));
    }
    
    public function get($id) {
        $this->db->where('corebase_crud_id', $id);
        $query = $this->db->get('tbl_corebase_crud', 1);
        return $query->result();
    }

    function __destruct() {
        $this->db->close();
    }
    
}
?>