<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_news extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function read($limit, $start, $key, $category, $field)
    {
        $this->db->select('a.*, b.field_name, c.user_fullname, d.news_category_name');
        $this->db->from('tbl_web_news a');
        $this->db->join('tbl_web_field b', 'a.field_id=b.field_id', 'LEFT');
        $this->db->join('tbl_user c', 'a.user_id=c.user_id', 'LEFT');
        $this->db->join('tbl_web_news_category d', 'a.news_category_id=d.news_category_id', 'LEFT');

        if ($category != "") {
            $this->db->where('a.news_category_id', $category);
        }

        if ($field != "") {
            $this->db->where('a.field_id', $field);
        }

        if ($key != '') {
            $this->db->like("a.news_title", $key);
            $this->db->or_like("b.field_name", $key);
            $this->db->or_like("c.user_fullname", $key);
            $this->db->or_like("d.news_category_name", $key);
        }

        if ($limit != "" or $start != "") {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('a.news_id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return null;
    }

    public function create($data)
    {
        $this->db->insert('tbl_web_news', $data);
    }

    public function update($data)
    {
        $this->db->update('tbl_web_news', $data, array('news_id' => $data['news_id']));
    }

    public function delete($id)
    {
        $this->db->delete('tbl_web_news', array('news_id' => $id));
    }

    public function get($id)
    {
        $this->db->where('news_id', $id);
        $query = $this->db->get('tbl_web_news', 1);
        return $query->result();
    }


    public function getBySlug($slug)
    {
        $this->db->select('a.*, b.field_name, c.user_fullname, d.news_category_name');
        $this->db->from('tbl_web_news a');
        $this->db->join('tbl_web_field b', 'a.field_id=b.field_id', 'LEFT');
        $this->db->join('tbl_user c', 'a.user_id=c.user_id', 'LEFT');
        $this->db->join('tbl_web_news_category d', 'a.news_category_id=d.news_category_id', 'LEFT');
        $this->db->where('news_slug', $slug);
        $query = $this->db->get();
        return $query->result();
    }

    function __destruct()
    {
        $this->db->close();
    }

    public function widget()
    {
        $query  = $this->db->query(" SELECT
            (SELECT count(news_id) FROM tbl_web_news) as total_artikel");
        return $query->result();
    }
}
