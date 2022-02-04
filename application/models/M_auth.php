<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_auth extends CI_Model {
                
    function __construct() {
        parent::__construct();
    }
    
    public function validate($username) {
        $this->db->select("*");
        $this->db->from('tbl_user');
        $this->db->where('user_name', $username);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    function __destruct() {
        $this->db->close();
    }          
}
?>