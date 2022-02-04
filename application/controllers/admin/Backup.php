<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class backup extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    public function index() {
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'BACKUP DATABASE';
		
        
        // TEMPLATE
		$view         = "_backend/backup_db";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }

    public function doBackupDatabases(){

        $this->load->dbutil();
        $format = $this->uri->segment(4);

        if($format=='sql'){
            $prefs = array(
                'tables'     => array(),
                // Array table yang akan dibackup
                'ignore'     => array(),
                // Daftar table yang tidak akan dibackup
                'format'     => 'txt',
                // gzip, zip, txt format filenya
                'filename'   => 'mybackup.sql',
                // Nama file
                'add_drop'   => TRUE, 
                // Untuk menambahkan drop table di backup
                'add_insert' => TRUE,
                // Untuk menambahkan data insert di file backup
                'newline'    => "\n"
                // Baris baru yang digunakan dalam file backup
             );
            
             $backup = $this->dbutil->backup($prefs);
        }else{
            $backup = $this->dbutil->backup();
        }

       
        // Uncomment jika ingin di backup dalam folder database project
        // $this->load->helper('file');
        // write_file('./database/backup/coreigniter_db-'.date('YmdHis').'.gz', $backup);

        $this->load->helper('download');
        force_download('coreigniter_db-'.date('YmdHis').'.'.$format, $backup);
    }


    public function doRestoreDatabases(){
        csrfValidate();

        $file         = file_get_contents($_FILES["userfile"]["tmp_name"]);
        $string_query = rtrim( $file, "\n;" );
        $array_query  = explode(";", $string_query);
        
        // SET ROLLBACK
        $this->db->trans_start();
        foreach($array_query as $query){
            // EXECUTION QUERY RESTORE
            $this->db->query($query);
        }
        $this->db->trans_complete();

         // ALERT
         $alertStatus  = "success";
         $alertMessage = "Berhasil Restore Database";
         getAlert($alertStatus, $alertMessage);


         redirect('admin/backup');
    }


    
    

    
    
}
?>