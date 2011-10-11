<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classes extends CI_Model {
	
	public function get_period_info($period)
	{
		$this->db->where('class_period_id', $period);
		$class_type = $this->db->get('classes')->row(1)->class_type;
		$this->db->where('id', $class_type);
		return $this->db->get('class_types')->row(1);
	}
	
	public function if_quiz_belongs_to_class($quiz, $class)
	{
		$this->db->where('slug', $class);
		$class = $this->db->get('class_types')->row(1);
		$this->db->where('id', $quiz);
		$this->db->where('class_type_id', $class->id);
		$q = $this->db->get('class_assignments');
		return count($q->result())>0;
	}
	
	public function get_itins($class, $limit=10, $offset=0)
	{
		$this->db->where('slug', $class);
		$class_id = $this->db->get('class_types')->row(1);
		$this->db->limit($limit, $offset);
		$this->db->where('class_type_id', $class_id->id);
		return $this->db->get('itineraries')->result();
	}
	
	public function get_assignment_from_class($class, $student, $limit=10, $offset=0)
	{
		$this->db->where('slug', $class);
		$class = $this->db->get('class_types')->row(1);
		$this->db->limit($limit, $offset);
		$this->db->where('class_type_id', $class->id);
		$this->db->select('id, assignment_id, assignment_version, alt_title');
		$assignments = $this->db->get('class_assignments')->result();
		foreach($assignments as &$assign)
		{
			if(!$assign->alt_title)
			{
				$this->db->where('assignment_id', $assign->assignment_id);
				$this->db->where('version', $assign->assignment_version);
				$q = $this->db->get('assignments')->row(1);
				$assign->title = $q->name;
			} else { $assign->title = $assign->alt_title; }
			$this->db->where('assignment_id', $assign->id);
			$this->db->where('student_id', $student);
			$q = $this->db->get('grades');
			$assign->taken = ($q->num_rows()>0)? true : false ;
		}
		unset($assign);
		return $assignments;
	}
	
}