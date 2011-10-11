<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quiz extends CI_Model {
	
	public function get_name($id)
	{
		$this->db->where('id', $id);
		$quiz = $this->db->get('class_assignments')->row(1);
		if($quiz->alt_title){ return $quiz->alt_title; }
		else {
			$this->db->where('assignment_id', $quiz->assignment_id);
			$this->db->where('version', $quiz->assignment_version);
			return $this->db->get('assignments')->row(1)->name;
		}
	}
	
	public function get_path($id)
	{
		$this->db->where('id', $id);
		$quiz = $this->db->get('class_assignments')->row(1);
		$this->db->where('assignment_id', $quiz->assignment_id);
		$this->db->where('version', $quiz->assignment_version);
		return $this->db->get('assignments')->row(1)->file_path;
	}
	
}