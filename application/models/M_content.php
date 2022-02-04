<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_content extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    

    public function update($data) {
        $this->db->update('tbl_web_content', $data, array('content_id' => $data['content_id']));
    }
    
    public function get($id) {
        $this->db->where('content_menu', $id);
        $query = $this->db->get('tbl_web_content', 1);
        return $query->result();
    }


    public function widget() {
        $query  = $this->db->query(" SELECT
            (SELECT count(regulation_id) FROM tbl_web_regulation) as total_regulasi,
            (SELECT count(news_id) FROM tbl_web_news) as total_berita
        ");
        return $query->result();
    }

    function __destruct() {
        $this->db->close();
    }
    
}
?>