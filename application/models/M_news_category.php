<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_news_category extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function read($limit, $start, $key) {
        $this->db->select('*');
        $this->db->from('tbl_web_news_category');
        
        if($key!=''){
            $this->db->like("news_category_name", $key);
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
        $this->db->insert('tbl_web_news_category', $data);
    }
    
    public function update($data) {
        $this->db->update('tbl_web_news_category', $data, array('news_category_id' => $data['news_category_id']));
    }
    
    public function delete($id) {
        $this->db->delete('tbl_web_news_category', array('news_category_id' => $id));
    }
    
    public function get($id) {
        $this->db->where('news_category_id', $id);
        $query = $this->db->get('tbl_web_news_category', 1);
        return $query->result();
    }

    function __destruct() {
        $this->db->close();
    }
    
}
?>