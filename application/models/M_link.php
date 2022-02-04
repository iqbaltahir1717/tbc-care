<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_link extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function read($limit, $start, $key) {
        $this->db->select('*');
        $this->db->from('tbl_web_link');
        
        if($key!=''){
            $this->db->like("link_name", $key);
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
        $this->db->insert('tbl_web_link', $data);
    }
    
    public function update($data) {
        $this->db->update('tbl_web_link', $data, array('link_id' => $data['link_id']));
    }
    
    public function delete($id) {
        $this->db->delete('tbl_web_link', array('link_id' => $id));
    }
    
    public function get($id) {
        $this->db->where('link_id', $id);
        $query = $this->db->get('tbl_web_link', 1);
        return $query->result();
    }

    function __destruct() {
        $this->db->close();
    }
    
}
?>