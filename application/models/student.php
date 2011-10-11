<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Model {

	public function login()
	{
		$this->db->where('user_name', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('students');
		if($query->num_rows==1)
		{
			return $query->row(1)->id;
		}
	}
	
	public function signup()
	{
		$data = $this->input->post();
		$data['password'] = md5($data['password']);
		unset($data['classes']);
		$classes = $this->input->post('classes');
		if($this->db->insert('students', $data)){
			$classes = str_replace('c', '', $this->input->post('classes'));
			$this->db->where('user_name', $data['user_name']);
			$this_user = $this->db->get('students')->row(1);
			for($i=0;$i<strlen($classes);$i++){
				$data = array('student_id' => $this_user->id, 'class_period_id' => $classes[$i]);
				$this->db->insert('student_classes', $data);
			}
			return true;
		}
	}
	
	public function get_classes($student_id)
	{
		$this->db->where('student_id', $student_id);
		return $this->db->get('student_classes');
	}
	
	public function available($username)
	{
		$this->db->where('user_name', $username);
		if($this->db->get('students')->num_rows!=0)
		{
			return false;
		} else { return true; }
	}
	
	public function if_student_can_take_quiz($student, $quiz_id)
	{
		$this->db->where('id', $quiz_id);
		$quiz = $this->db->get('class_assignments')->row(1);
		if($quiz->attempts==0){
			return true;
		} else {
			$this->db->where('assignment_id', $quiz_id);
			$this->db->where('student_id', $student);
			$times = count($this->db->get('grades')->result());
			return $times<$quiz->attempts;
		}
	}
	
	
	
}