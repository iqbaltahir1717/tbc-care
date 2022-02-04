<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_gallery extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function read($limit, $start, $key, $type) {
        $this->db->select('*');
        $this->db->from('tbl_web_gallery');
        $this->db->where('gallery_type', $type);
        
        if($key!=''){
            $this->db->like("gallery_name", $key);
        }

        if($limit !="" OR $start !=""){
            $this->db->limit($limit, $start);
        }

        $this->db->order_by("gallery_id", "DESC");
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
        $this->db->insert('tbl_web_gallery', $data);
    }
    
    public function update($data) {
        $this->db->update('tbl_web_gallery', $data, array('gallery_id' => $data['gallery_id']));
    }
    
    public function delete($id) {
        $this->db->delete('tbl_web_gallery', array('gallery_id' => $id));
    }
    
    public function get($id) {
        $this->db->where('gallery_id', $id);
        $query = $this->db->get('tbl_web_gallery', 1);
        return $query->result();
    }

    // ==================================================================================
    public function read_gallery($limit, $start, $key, $gallery) {
        $this->db->select('*');
        $this->db->from('tbl_web_gallery_photo');
        $this->db->where('gallery_id', $gallery);
        
        if($key!=''){
            $this->db->like("gallery_photo_name", $key);
        }

        if($limit !="" OR $start !=""){
            $this->db->limit($limit, $start);
        }

        $this->db->order_by("gallery_photo_id", "DESC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return null;
    }
    

    public function create_gallery($data) {
        $this->db->insert('tbl_web_gallery_photo', $data);
    }
    
    public function delete_gallery($token) {
        $this->db->delete('tbl_web_gallery_photo', array('gallery_photo_token' => $token));
    }



    function __destruct() {
        $this->db->close();
    }
    
}
?>