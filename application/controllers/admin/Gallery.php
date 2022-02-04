<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_gallery');
        $this->load->library('upload');
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    /**
     * ---------------------------------------------------------------------
     * SECTION GALLERY ALBUM / VIDEO
     * ---------------------------------------------------------------------
     */
    public function data() {
        $this->session->unset_userdata('sess_search_gallery');

        // PAGINATION
        $baseUrl    = base_url() . "admin/gallery/data/photo/";
        $totalRows  = count((array) $this->m_gallery->read('','','',$this->uri->segment(4)));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting'] = getSetting();
        $data['gallery'] = $this->m_gallery->read($perPage, $page,'', $this->uri->segment(4));


        if($this->uri->segment(4) == 'photo'){
            $data['title']   = 'Galeri Foto';
            $view            = "_backend/gallery/gallery";
        }else{
            $data['title']   = 'Galeri Video';
            $view            = "_backend/gallery/video";
        }
        
        
        // TEMPLATE
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_gallery', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_gallery');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/gallery/search/".$this->uri->segment(4)."/".$data['search']."/";
        $totalRows  = count((array)$this->m_gallery->read('','',$data['search'], $this->uri->segment(4) ));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 6;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting'] = getSetting();
        $data['gallery'] = $this->m_gallery->read($perPage, $page, $data['search'], $this->uri->segment(4));

        if($this->uri->segment(4) == 'photo'){
            $data['title']   = 'Galeri Foto';
            $view            = "_backend/gallery/gallery";
        }else{
            $data['title']   = 'Galeri Video';
            $view            = "_backend/gallery/video";
        }
        
        // TEMPLATE
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();

        if($_FILES['gallery_cover']['name'] !=""){
            if($this->input->post('gallery_type') == 'photo'){
                $filename_1      = "gallery-".date('YmdHis');
                $path            = './upload/gallery/cover/';
                $config['allowed_types'] = "jpeg|jpg|png";
            }else{
                $filename_1      = "video-".date('YmdHis');
                $path            = './upload/gallery/video/';
                $config['allowed_types'] = "mp4|mpeg|mkv|avi";
            }

            $config['upload_path']   = $path;
            $config['overwrite']     = "true";
            $config['max_size']      = "0";
            $config['max_width']     = "10000";
            $config['max_height']    = "10000";
            $config['file_name']     = '' . $filename_1;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('gallery_cover')) { 
                // ALERT
                $alertStatus  = "failed";
                $alertMessage = $this->upload->display_errors();
                getAlert($alertStatus, $alertMessage);
            } else {
                $dat  = $this->upload->data();

                // POST
                $data['gallery_id']          = '';
                $data['gallery_name']        = $this->input->post('gallery_name');
                $data['gallery_cover']       = $dat['file_name'];
                $data['gallery_description'] = $this->input->post('gallery_description');
                $data['gallery_date']        = $this->input->post('gallery_date');
                if($this->input->post('gallery_type') == 'video'){
                    $data['gallery_url']        = $this->input->post('gallery_url');
                }
                $data['gallery_type']        = $this->input->post('gallery_type');
                $data['createtime']          = date('Y-m-d H:i:s');
                $this->m_gallery->create($data);

                // LOG
                $message    = $this->session->userdata('user_name')." menambah data galeri dengan nama = ".$data['gallery_name'];
                createLog($message);

                // ALERT
                $alertStatus  = "success";
                $alertMessage = "Berhasil menambah data galeri dengan nama = ".$data['gallery_name'];
                getAlert($alertStatus, $alertMessage);
            }
        }else{
            // POST
            $data['gallery_id']          = '';
            $data['gallery_name']        = $this->input->post('gallery_name');
            $data['gallery_description'] = $this->input->post('gallery_description');
            $data['gallery_date']        = $this->input->post('gallery_date');
            if($this->input->post('gallery_type') == 'video'){
                $data['gallery_url']        = $this->input->post('gallery_url');
            }
            $data['gallery_type']        = $this->input->post('gallery_type');
            $data['createtime']          = date('Y-m-d H:i:s');
            $this->m_gallery->create($data);

            // LOG
            $message    = $this->session->userdata('user_name')." menambah data galeri dengan nama = ".$data['gallery_name'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil menambah data galeri dengan nama = ".$data['gallery_name'];
            getAlert($alertStatus, $alertMessage);
        }

        redirect('admin/gallery/data/'.$data['gallery_type']);
    }
    

    public function update() {
        csrfValidate();

        if($_FILES['gallery_cover']['name'] !=""){
            if($this->input->post('gallery_type') == 'photo'){
                $filename_1      = "gallery-".date('YmdHis');
                $path            = './upload/gallery/cover/';
                $config['allowed_types'] = "jpeg|jpg|png";
            }else{
                $filename_1      = "video-".date('YmdHis');
                $path            = './upload/gallery/video/';
                $config['allowed_types'] = "mp4|mpeg|mkv|avi";
            }

            $config['upload_path']   = $path;
            $config['overwrite']     = "true";
            $config['max_size']      = "0";
            $config['max_width']     = "10000";
            $config['max_height']    = "10000";
            $config['file_name']     = '' . $filename_1;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('gallery_cover')) { 
                // ALERT
                $alertStatus  = "failed";
                $alertMessage = $this->upload->display_errors();
                getAlert($alertStatus, $alertMessage);
            } else {
                $dat  = $this->upload->data();
                unlink($path.$this->input->post('gallery_cover_old'));
                
                // POST
                $data['gallery_id']          = $this->input->post('gallery_id');
                $data['gallery_name']        = $this->input->post('gallery_name');
                $data['gallery_description'] = $this->input->post('gallery_description');
                $data['gallery_type']        = $this->input->post('gallery_type');
                if($this->input->post('gallery_type') == 'video'){
                    $data['gallery_url']        = $this->input->post('gallery_url');
                }
                $data['gallery_cover']       = $dat['file_name'];
                $this->m_gallery->update($data);

                // LOG
                $message    = $this->session->userdata('user_name')." menambah data galeri dengan ID = ".$data['gallery_id'];
                createLog($message);

                // ALERT
                $alertStatus  = "success";
                $alertMessage = "Berhasil menambah data galeri ".$data['gallery_id'];
                getAlert($alertStatus, $alertMessage);
            }
        }else{
            // POST
            $data['gallery_id']          = $this->input->post('gallery_id');
            $data['gallery_name']        = $this->input->post('gallery_name');
            $data['gallery_description'] = $this->input->post('gallery_description');
            $data['gallery_type']        = $this->input->post('gallery_type');
            if($this->input->post('gallery_type') == 'video'){
                $data['gallery_url']        = $this->input->post('gallery_url');
            }
            $this->m_gallery->update($data);

            // LOG
            $message    = $this->session->userdata('user_name')." mengubah data galeri dengan ID = ".$data['gallery_id'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil mengubah data galeri dengan ID = ".$data['gallery_id'];
            getAlert($alertStatus, $alertMessage);
        }


        redirect('admin/gallery/data/'.$data['gallery_type']);
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_gallery->delete($this->input->post('gallery_id'));
        if($this->input->post('gallery_type') == 'photo'){
            unlink('./upload/gallery/cover/'.$this->input->post('gallery_cover'));
            // DELETE RECURSIVE ALL PHOTO BY ID
            $getAllPhoto = $this->m_gallery->read_gallery('','','',$this->input->post('gallery_id'));
            foreach($getAllPhoto as $gAP){
                $this->m_gallery->delete_gallery($gAP->gallery_photo_token);
                unlink('./upload/gallery/photo/'.$gAP->gallery_photo_name);
            }
        }else{
            if($this->input->post('gallery_cover') !=""){
                unlink('./upload/gallery/video/'.$this->input->post('gallery_cover'));
            }
        }

        

        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data galeri dengan ID = ".$this->input->post('gallery_id')." - ".$this->input->post('gallery_id');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data galeri : ".$this->input->post('gallery_id');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/gallery/data/'.$this->input->post('gallery_type'));
    }

    /**
     * ---------------------------------------------------------------------
     * SECTION GALLERY FOTO UPLOAD
     * ---------------------------------------------------------------------
     */

    public function all_photo() {
        $this->session->unset_userdata('sess_search_allphoto');

        // PAGINATION
        $baseUrl    = base_url() . "admin/gallery/allphoto/".$this->uri->segment(4)."/";
        $totalRows  = count((array) $this->m_gallery->read_gallery('','','', $this->uri->segment(4)));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting']      = getSetting();
        $data['title']        = 'Galeri Foto : ';
        $data['allphoto']     = $this->m_gallery->read_gallery($perPage, $page,'', $this->uri->segment(4));
        $data['gallery_name'] = $this->m_gallery->get($this->uri->segment(4));
		
        
        // TEMPLATE
		$view         = "_backend/gallery/allphoto";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }

    public function dropzone_photo() { 
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Upload Foto Batch';
        $data['gallery_name'] = $this->m_gallery->get($this->uri->segment(4));
		
        // TEMPLATE
		$view         = "_backend/gallery/_create";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }

    public function delete_gallery() {
        csrfValidate();
        // POST
        $this->m_gallery->delete_gallery($this->input->post('gallery_photo_token'));
        unlink('./upload/gallery/photo/'.$this->input->post('gallery_photo_name'));
        
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data form dengan ID = ".$this->input->post('gallery_photo_id');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data form ID : ".$this->input->post('gallery_photo_id');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/gallery/all_photo/'.$this->input->post('gallery_id'));
    }



    // AJAX
   
	public function ajaxupload(){
        $config['upload_path']   = './upload/gallery/photo';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['file_name']     = 'photo-'.$this->uri->segment(4).'-'.date('YmdHis')."-".rand(1000,9999);
        $this->upload->initialize($config);
        if($this->upload->do_upload('userfile')){
        	
        	$data['gallery_photo_name']  = $this->upload->data('file_name');
        	$data['gallery_photo_token'] = $this->input->post('token');
        	$data['gallery_id']          = $this->uri->segment(4);
        	$data['createtime']          = date('Y-m-d H:i:s');
        	$this->m_gallery->create_gallery($data);
        }
	}


    public function ajaxremove(){
		$token = $this->input->post('token');
		$image = $this->db->get_where('tbl_web_gallery_photo', array('gallery_photo_token'=>$token));

		if($image->num_rows()>0){
			$getImage    = $image->row();
			$geImageName = $getImage->gallery_photo_name;
			if(file_exists($file='./upload/gallery/photo/'.$geImageName)){
				unlink($file);
			}
			$this->m_gallery->delete_gallery($token);
		}
		echo "{}";
	}


    
    
}
?>