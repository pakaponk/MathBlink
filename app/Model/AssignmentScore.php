<?php 

class AssignmentScore extends AppModel{
	
	public $useTable = 'assignment_score';
	public $primaryKey = 'assignment_score_id';
	
    public $belongsTo = array(
        'User' => array(
            'foreignKey' => 'student_id'
        )
    );
}

?>