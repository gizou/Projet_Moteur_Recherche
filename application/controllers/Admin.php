<?php

/**
 * Description of Admin_controller
 *
 * @author GIZOU
 */
class Admin extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

    }
       
    
    public function index()
    {    
	$this->load->model('Connection_model', '', TRUE);
        $sessionTest = $this->session->userdata('userLogin');
	
        if( !empty($sessionTest) )
            $this->load->view('admin_index');            
        else{
        
            $code = $this->Connection_model->test_user();

            switch ($code){
                case -1:
                    $this->load->view('admin');
                    break;

                case 0:
                    //session_start();
                    $data['userName'] = $this->Connection_model->get_userName();
                    $data['userLogin'] = $this->Connection_model->get_userLogin();
                    $this->session->set_userdata($data);
                    $this->load->view('admin_index');
                    break;

                case 1:
                    $data['error'] = "Veuillez remplir tous les champs";
                    $this->load->view('admin', $data);
                    break;

                case 2:
                    $data['error'] = "Login ou mot de passe incorrect";
                    $this->load->view('admin', $data);
                    break;
            }
        }
    }
    
    
    
    public function createAccount(){
        $this->load->view('create_account');
    }
    
    
    public function newUser(){
        $this->load->model('Connection_model', '', TRUE);
        $res = $this->Connection_model->addUser();
        
        if( $res == 0 )
            $this->load->view('admin');
        else
        {
            $data['error'] = " Veuillez remplir les champs obligatoires ";
            $this->load->view('create_account', $data);
        }
    }
    
    
    public function deconnect(){
        $this->session->unset_userdata('data');
        $this->session->unset_userdata('userName');
        $this->session->unset_userdata('userLogin');
        $this->session->sess_destroy();
        $this->index();

//        redirect($this->load->view('welcome_message'));
    }
    
    
//    public function upload(){
//	$fileguid=@$_POST["myuploader"];   
//	if($fileguid)   
//	{   
//	    //get the uploaded file based on GUID   
//	    $mvcfile=$uploader->GetUploadedFile($fileguid);   
//	    if($mvcfile)   
//	    {   
//		//Gets the name of the file.   
//		echo($mvcfile->FileName);   
//		//Gets the temp file path.   
//		echo($mvcfile->FilePath);   
//		//Gets the size of the file.   
//		echo($mvcfile->FileSize);    
//
//		//Copys the uploaded file to a new location.   
//		$mvcfile->CopyTo("/uploads");   
//		//Moves the uploaded file to a new location.   
//		$mvcfile->MoveTo("/uploads");   
//		//Deletes this instance.   
//		$mvcfile->Delete();   
//	    }   
//	}
//    }
}

?>
