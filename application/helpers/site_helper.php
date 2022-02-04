<?php

    /**
     * --------------------------------------------------------------------------
     * SITE Helper
     * 
     * Copyrigt(c) 2021
     * 
     * @author      Techno's Studio
     * @link        http://techno-studio.com
     * @link        technos.studi@gmail.com
     * @category    Helper
     * @copyright   2021 - Techno's Studio
     * 
     * Using as a core base helper for codeigniter framework
     * on our office
     * --------------------------------------------------------------------------
     */
    defined('BASEPATH') OR exit('No direct script access allowed');
   

    /**
     * Render Template
     * --------------------------------------------------------------------------
     * Every function which using template must be set by this variable :
     * 
     * @param   array   every data will show in view page
     * @param   string  view path page
     * @param   string  view category (single or all)
     * 
     */
    if(!function_exists('renderTemplate')){
        function renderTemplate($data, $view, $viewCategory){
            switch($viewCategory){
                case "single": 
                    get_instance()->load->view($view,$data);
                    break;
                default:
                    get_instance()->load->view("_template/core_header", $data);
                    get_instance()->load->view("_template/core_menu");
                    get_instance()->load->view($view);
                    get_instance()->load->view("_template/core_footer");
            }
        }
    }

    /**
     * Render Template Front
     * --------------------------------------------------------------------------
     * Every function which using template must be set by this variable :
     * 
     * @param   array   every data will show in view page
     * @param   string  view path page
     * @param   string  view category (single or all)
     * 
     */
    if(!function_exists('renderTemplateFront')){
        function renderTemplateFront($data, $view, $viewCategory){
            switch($viewCategory){
                case "single": 
                    get_instance()->load->view($view,$data);
                    break;
                default:
                    get_instance()->load->view("_frontend/core_header", $data);
                    get_instance()->load->view("_frontend/core_menu");
                    get_instance()->load->view($view);
                    get_instance()->load->view("_frontend/core_footer");
            }
        }
    }


    /**
     * Get Setting
     * --------------------------------------------------------------------------
     * Use in every controller and call as global variabel
     * @return  array
     */
    if(!function_exists('getSetting')){
        function getSetting(){
            get_instance()->load->model('m_setting');
            $setting = get_instance()->m_setting->fetch_setting();
            return $setting;
        }
    }


    /**
     * Get Alert
     * --------------------------------------------------------------------------
     * Use for give notification about every action on the web
     * 
     * @param   string  status of alert (success or failed)
     * @param   string  message will show on view
     * 
     */
    if(!function_exists('getAlert')){
        function getAlert($status, $message){
            switch($status){
              case "success": 
                $alert ='<div class="callout callout-success"><p>'.$message.'</p></div>';
                get_instance()->session->set_flashdata('alert', $alert);
                break;
              case "failed": 
                $alert ='<div class="callout callout-danger"><p>'.$message.'</p></div>';
                get_instance()->session->set_flashdata('alert', $alert);
                break;
            }
        }
    }

    
    /**
     * Create Log
     * --------------------------------------------------------------------------
     * Use for give notification about every action on the web
     * 
     * @param   string  message about user action
     * 
     */
    if(!function_exists('createLog')){
        function createLog($message){
            get_instance()->load->model('m_log');

            $log['log_id']        = "";
            $log['log_time']      = date('Y-m-d H:i:s');
            $log['log_message']   = $message;
            $log['log_ipaddress'] = get_instance()->input->ip_address();
            $log['user_id']       = get_instance()->session->userdata('user_id');
            $log['createtime']    = date('Y-m-d H:i:s');
            get_instance()->m_log->create($log);
        }
    }


    // INDONESIAN FORMAT SECTION

    /**
     * Indonesian Date
     * --------------------------------------------------------------------------
     * Convert universal database date to Indonesian Format : dd MM yyyy
     * 
     * @param   string  date format
     * 
     */
    if (!function_exists('indonesiaDate')) {
        function indonesiaDate($date){
            $day        = substr($date,8,2);
			$month      = monthName(substr($date,5,2));
			$year       = substr($date,0,4);
			return $day.' '.$month.' '.$year;		 
        }
    }


    /**
     * Month Name
     * --------------------------------------------------------------------------
     * Convert universal month format to Indonesian Month Strings
     * 
     * @param   string  month format
     * 
     */
    if (!function_exists('monthName')) {
        function monthName($month){
            switch ($month){
                case 1: return "Januari";   break;
                case 2: return "Februari";  break;
                case 3: return "Maret";     break;
                case 4: return "April";     break;
                case 5: return "Mei";       break;
                case 6: return "Juni";      break;
                case 7: return "Juli";      break;
                case 8: return "Agustus";   break;
                case 9: return "September"; break;
                case 10:return "Oktober";   break;
                case 11:return "November";  break;
                case 12:return "Desember";  break;	 
            }
        }
    }

    /**
     * Indonesian Currency Format
     * --------------------------------------------------------------------------
     * Convert integer to Rupiah format
     * 
     * @param   int 
     * 
     */
    if (!function_exists('indonesiaCurrency')) {
        function indonesiaCurrency($int){
			return "Rp. ".number_format($int, 0, ".", ",");		 
        }
    }


    // SECURITY SECTION

    /**
     * CSRF Name
     * --------------------------------------------------------------------------
     * Set globaly form token
     * 
     * @return  string 
     * 
     */
    if (!function_exists('csrfName')) {
        function csrfName(){
            return "coreigniter_ts_token";
        }
    }


    /**
     * CSRF Input
     * --------------------------------------------------------------------------
     * Input form which have csrf token
     * 
     * @return  string 
     * 
     */
    if (!function_exists('csrf')) {
        function csrf(){
            return "<input type='hidden' name='".csrfName()."' value='".csrfToken()."' />";
        }
    }


    /**
     * CSRF Token
     * --------------------------------------------------------------------------
     * Generate token in every 1 used with session
     * 
     * @return  string 
     * 
     */
    if (!function_exists('csrfToken')) {
        function csrfToken(){
            get_instance()->session->unset_userdata('csrf_token');
            if(!get_instance()->session->csrf_token){
                get_instance()->session->csrf_token    = hash('sha1', time());
            }

            return get_instance()->session->csrf_token;
        }
    }


    /**
     * CSRF Token
     * --------------------------------------------------------------------------
     * Generate token in every 1 used with session
     * 
     * @return  string 
     * 
     */
    if (!function_exists('csrfValidate')) {
        function csrfValidate(){
            if(get_instance()->input->post(csrfName()) != get_instance()->session->csrf_token or !get_instance()->input->post(csrfName()) or !get_instance()->session->csrf_token){
                get_instance()->session->unset_userdata('csrf_token');
                show_error('The action you have requested is not allowed.', 403);
                return false;

            }
        }
    }


    /**
     * XSS Filtering
     * --------------------------------------------------------------------------
     * Using for handle xss javascript inject after print data on view
     * 
     * @param   string string data will shown in view page
     * @return  string 
     * 
     */
    if (!function_exists('xssprint')) {
        function xssprint($string){
            return htmlentities($string, ENT_QUOTES, 'UTF-8');
        }
    }

    /**
     * Generate Pagination
     * --------------------------------------------------------------------------
     * Using for generate pagination on view
     * 
     * @param   string  string for base url after click pagination
     * @param   int     integer for total rows data on page
     * @param   int     integer for limit rows data on page
     * @param   int     integer for segement will appear
     * @return  int,string  
     * 
     */
    if (!function_exists('generatePagination')) {
        function generatePagination($baseUrl, $totalRows, $perPage, $uriSegment){
           
            $config                    = array();
            $config["base_url"]        = $baseUrl;
            $config["total_rows"]      = $totalRows;
            $config["per_page"]        = $perPage;
            $config["uri_segment"]     = $uriSegment;
            $choice                    = $config["total_rows"] / $config["per_page"];
            $config['full_tag_open']   = '<ul class="pagination pagination-sm no-margin pull-right">';
            $config['full_tag_close']  = '</ul>';
            $config['first_link']      = 'First';
            $config['last_link']       = 'Last';
            $config['prev_link']       = '&laquo';
            $config['next_link']       = '&raquo';
            $config['first_tag_open']  = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['prev_tag_open']   = '<li class="prev">';
            $config['prev_tag_close']  = '</li>';
            $config['next_tag_open']   = '<li>';
            $config['next_tag_close']  = '</li>';
            $config['last_tag_open']   = '<li>';
            $config['last_tag_close']  = '</li>';
            $config['cur_tag_open']    = '<li class="active"><a href="#">';
            $config['cur_tag_close']   = '</a></li>';
            $config['num_tag_open']    = '<li>';
            $config['num_tag_close']   = '</li>';
            
            if (get_instance()->uri->segment($uriSegment) == "") {
                $numbers = 0;
            } else {
                $numbers = get_instance()->uri->segment($uriSegment);
            }
            
            get_instance()->pagination->initialize($config);
            $links = get_instance()->pagination->create_links();

            return array('numbers' => $numbers, 'links' => $links);
        }
    }



    /**
     * Generate Pagination Blog
     * --------------------------------------------------------------------------
     * Using for generate pagination on view
     * 
     * @param   string  string for base url after click pagination
     * @param   int     integer for total rows data on page
     * @param   int     integer for limit rows data on page
     * @param   int     integer for segement will appear
     * @return  int,string  
     * 
     */
    if (!function_exists('generatePaginationBlog')) {
        function generatePaginationBlog($baseUrl, $totalRows, $perPage, $uriSegment){
           
            $config                    = array();
            $config["base_url"]        = $baseUrl;
            $config["total_rows"]      = $totalRows;
            $config["per_page"]        = $perPage;
            $config["uri_segment"]     = $uriSegment;
            $choice                    = $config["total_rows"] / $config["per_page"];
            $config['full_tag_open']   = '<ul class="justify-content-center">';
            $config['full_tag_close']  = '</ul>';
            $config['first_link']      = 'First';
            $config['last_link']       = 'Last';
            $config['prev_link']       = '&laquo';
            $config['next_link']       = '&raquo';
            $config['first_tag_open']  = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['prev_tag_open']   = '<li class="prev">';
            $config['prev_tag_close']  = '</li>';
            $config['next_tag_open']   = '<li>';
            $config['next_tag_close']  = '</li>';
            $config['last_tag_open']   = '<li>';
            $config['last_tag_close']  = '</li>';
            $config['cur_tag_open']    = '<li class="active"><a href="#">';
            $config['cur_tag_close']   = '</a></li>';
            $config['num_tag_open']    = '<li>';
            $config['num_tag_close']   = '</li>';
            
            if (get_instance()->uri->segment($uriSegment) == "") {
                $numbers = 0;
            } else {
                $numbers = get_instance()->uri->segment($uriSegment);
            }
            
            get_instance()->pagination->initialize($config);
            $links = get_instance()->pagination->create_links();

            return array('numbers' => $numbers, 'links' => $links);
        }
    }

    
    /**
     * Rows Page
     * --------------------------------------------------------------------------
     * Using for set total row page
     * 
     * @param   string  string for base url after click pagination
     * 
     */
    if (!function_exists('rowpage')) {
        function rowpage($rows){
            get_instance()->session->set_userdata('sess_rowpage', $rows);
        }
    }


    /**
     * Compress Images
     * --------------------------------------------------------------------------
     * Using for compress image to 20% size
     * 
     * @param   string  string for path images
     * @param   string  string for images name
     * 
     */
    if(!function_exists('compressImages')){
        function compressImages($path, $filename){
            $config['image_library']  = 'gd2';
            $config['source_image']   = $path . $filename;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['quality']        = '20%';
            $config['width']          = 128;
            $config['height']         = 128;
            $config['new_image']      = $path . $filename;
            get_instance()->load->library('image_lib', $config);
            get_instance()->image_lib->resize();
        }
    }


   


   


?>