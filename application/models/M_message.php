<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_message extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function read($limit, $start, $key, $status) {
        $this->db->select('*');
        $this->db->from('tbl_web_message');
        if($status != ""){
            $this->db->where('message_status', $status);
        }
        
        if($key!=''){
            $this->db->like("message_name", $key);
            $this->db->or_like("message_subject", $key);
            $this->db->or_like("message_text", $key);
            $this->db->or_like("message_date", $key);
            $this->db->or_like("message_email", $key);
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
        $this->db->insert('tbl_web_message', $data);
    }
    
    public function update($data) {
        $this->db->update('tbl_web_message', $data, array('message_id' => $data['message_id']));
    }
    
    public function delete($id) {
        $this->db->delete('tbl_web_message', array('message_id' => $id));
    }
    
    public function get($id) {
        $this->db->where('message_id', $id);
        $query = $this->db->get('tbl_web_message', 1);
        return $query->result();
    }

    public function getByCode($code) {
        $this->db->where('message_code', $code);
        $query = $this->db->get('tbl_web_message', 1);
        return $query->result();
    }

    function __destruct() {
        $this->db->close();
    }
    
}
?>