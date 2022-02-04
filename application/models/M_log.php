<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_log extends CI_Model {
                
    function __construct() {
        parent::__construct();
    }
    
    public function read($limit, $start, $key) {
        $this->db->select('a.*, b.user_name');
        $this->db->from('tbl_log a');
        $this->db->join('tbl_user b','a.user_id=b.user_id','LEFT');
        
        if($key!=''){
            $this->db->like("a.log_message", $key);
            $this->db->or_like("a.log_time", $key);
            $this->db->or_like("a.log_ipaddress", $key);
            $this->db->or_like("b.user_name", $key);
        }

        if($limit !="" OR $start !=""){
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('a.log_id', 'DESC');
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
        $this->db->insert('tbl_log', $data);
    }

    

    function __destruct() {
        $this->db->close();
    }          
}
?>