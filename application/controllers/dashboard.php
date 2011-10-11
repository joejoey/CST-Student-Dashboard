<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index($message='')
	{
		if($this->session->userdata('is_logged_in')){ $class = $this->session->userdata('classes'); redirect(base_url().'classes/'.$class[0]); }
		else {	redirect(base_url().'login');	}
	}
	
	private function check_if_logged_in()
	{
		if(!$this->session->userdata('is_logged_in'))
		{
			redirect(base_url().'login');
		}
	}
	
	private function template($content, $theme='', $title, $vars=array())
	{
		$data['main_content'] = $content;
		$data['title'] = $title;
		$data['theme'] = $theme;
		$data = array_merge($data, $vars);
		$this->load->view('template/main', $data);
	}
	
	public function signup()
	{
		if($this->session->userdata('is_logged_in')){ redirect(base_url()); }
		else { $data['signup'] = true; $this->template('login', '', 'CST Sign Up', $data); }
	}
	
	public function login()
	{
		if($this->session->userdata('is_logged_in')){ redirect(base_url()); }
		else { $this->template('login', '', 'CST Login'); }
	}
	
	public function logout(){
		if(!$this->session->userdata('is_logged_in')){ redirect(base_url().'login'); }
		else
		{
			$this->session->sess_destroy();  
			$data['message'] = 'logout';
			$this->template('login', '', 'CST Login', $data);
		}
	}
	
	public function available()
	{
		$this->load->model('student');
		if($this->student->available($this->input->post('username')))
		{
			echo 'good';
		} else { echo 'bad'; }
	}
	
	public function check_sign_up()
	{
		$this->load->model('student');
		if($this->student->signup())
		{
			echo 'redirect: '.base_url().'signlog';
		} else { echo 'bad'; }
	}
	
	public function signlog()
	{
		$data['message'] = 'signup';
		$this->template('login', '', 'CST Login', $data);
	}
	
	public function check_login()
	{
		$this->load->model('student');
		if($id=$this->student->login())
		{
			$data = array(
				'username' => $this->input->post('username'),
				'student_id' => $id,
				'is_logged_in' => true,
				'classes' => array()
			);
			$classes = $this->student->get_classes($id);
			if($classes->num_rows>1)
			{
				$this->load->model('classes');
				foreach($classes->result() as $class)
				{
					$class = $this->classes->get_period_info($class->class_period_id);
					$name = $class->name;
					$slug = $class->slug;
					echo '<div class="class '.$slug.'"><a href="'.base_url().'classes/'.$slug.'" title="'.$name.' Class Page"></a></div>';
					array_push($data['classes'], $slug);
				}
			} else if($classes->num_rows==1)
			{
				$this->load->model('classes');
				$slug = $this->classes->get_period_info($classes->row(1)->class_period_id)->slug;
				echo 'redirect: '.base_url().'classes/'.$slug;
				array_push($data['classes'], $slug);
			}
			$this->session->set_userdata($data);
		}
		else { echo 'bad'; }
	}

	public function classes()
	{
		$this->check_if_logged_in();
		if($this->uri->segment(3)=='')
		{
			$this->load->model('classes');
			$data['itins'] = $this->classes->get_itins($this->uri->segment(2));
		}
		if($this->uri->segment(3)==''||$this->uri->segment(3)=='assigments')
		{
			$this->load->model('classes');
			$data['assigns'] = $this->classes->get_assignment_from_class($this->uri->segment(2), $this->session->userdata('student_id'));
		}
		$this->template('dashboard', 'dash', 'Student Dashboard', $data);
	}
	
	public function quizzes() {
		$this->check_if_logged_in();
		if(!$this->uri->segment(2)){
			$class = $this->session->userdata('classes'); redirect(base_url().'classes/'.$class[0]);
		} else if(!$this->uri->segment(3)) {
			$class = $this->uri->segment(2); redirect(base_url().'classes/'.$class.'/assignments');
		} else {
			$this->load->model('classes');
			$this->load->model('student');
			if(!$this->classes->if_quiz_belongs_to_class($this->uri->segment(3), $this->uri->segment(2))){
				$link = base_url().'classes/'.$this->uri->segment(2);
				$data['error'] = 'That quiz doesn\'t belong to this class. Make sure you are logged in to the right class! Go back to the <a title="assignments" href="'.$link.'">homepage</a>.';
				$this->template('error', '', 'Error!', $data);
			} else if(!$this->student->if_student_can_take_quiz($this->session->userdata('student_id'), $this->uri->segment(3))) {
				$assign = base_url().'classes/'.$this->uri->segment(2).'/assignments';
				$data['error'] = 'You already took this quiz the allowed number of times! Go back to <a title="assignments" href="'.$assign.'">assignments</a>.';
				$this->template('error', '', 'Error!', $data);
			} else {
				$this->load->model('quiz');
				$data['quiz'] = $this->uri->segment(3);
				$data['path'] = base_url().'quiz_files/'.$this->quiz->get_path($data['quiz']).'.xml';
				$data['name'] = $this->quiz->get_name($this->uri->segment(3));
				$this->template('quiz', '', 'Quiz | '.$data['name'], $data);
			}
		}
	}
	
}