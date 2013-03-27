<?php 

class CoursesClassroom extends AppModel{

	public $useTable = 'courses_classrooms';
	public $primaryKey = 'course_classroom_id';

	var $belongTo = array(
			'Course' => array(
					'className' => 'Course',
					'foreignKey' => 'course_id'
			),
			'Classroom' => array(
					'className' => 'Classroom',
					'foreignKey' => 'classroom_id'
			));

}

?>