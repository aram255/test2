<?php

class Admin extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Admin_model');
	}

	

public function index()
	{  
		
		
		if($this->session->userdata('session_name') != true)
		{
					if (!isset($_SERVER['PHP_AUTH_USER']) ||
    ($this->input->post('login') =='admin'  && $this->input->post('password') == $_SERVER['PHP_AUTH_USER'])) {
      header('WWW-Authenticate: Basic realm="Test Authentication System"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Вы должны ввести корректный логин и пароль для получения доступа к ресурсу \n";
    exit;

} else {
    echo "<p>Добро пожаловать: " . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "<br />";
    echo "Предыдущий логин: " . htmlspecialchars($this->input->post('password'));
    echo "<form  method='post'>\n";
    echo "<input type='hidden' name='password' value='1' />\n";
    echo "<input type='hidden' name='login' value=\"" . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "\" />\n";
    echo "<input type='submit' value='Авторизоваться повторно' />\n";
    echo "</form></p>\n";
}
		$this->load->view('admin');

	    }
	    else
	    {
	    	return    redirect(base_url('index.php/admin/show'));
	    }                                                     
		                                             
	                                          
	}





	public function check()
	{


		$login    = $this->input->post('login');
		$password = $this->input->post('password');

		if($this->Admin_model->check_model($login,$password)){
			$session_data =  array('session_name'=>$login);
	 	    $this->session->set_userdata($session_data);
			redirect(base_url('index.php/admin/show'));
		}
		else{
			redirect(base_url('index.php/admin/index'));
		}

	
}

	public function show()
	{
        
        $data['get_data'] = $this->Admin_model->show_model();
		$this->load->view('admin',$data);	   
	}


	public function add_comment()
	{
		
		$add  = $this->input->post('type');
		$id   = $this->input->post('id');
		$this->Admin_model->add_comment_model($add,$id);
		$this->show();

	}

	public function delete()
	{
        $id = $this->input->post('get_id');
		$this->Admin_model->delete_model($id);
		$this->show();
	}

	public function edit()
	{
       $id      = $this->input->post('get_id');
       $email   = $this->input->post('email');
       $name    = $this->input->post('name');
       $comment = $this->input->post('comment');
       $date    = $this->input->post('date');

       $this->Admin_model->edit_model($id,$email,$name,$comment,$date);
	}

	public function logout(){
		$this->session->unset_userdata('session_name');
		redirect(base_url('index.php/admin/index'));
	}
}