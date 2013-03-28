<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Apple
 * Date: 3/11/13 AD
 * Time: 5:17 PM
 * To change this template use File | Settings | File Templates.
 */
/**
 * @property Assignment $Assignment
 */

App::uses('CakeTime', 'Utility');

class StudentController extends AppController{

    public $uses = array('User','Assignment','ProblemsetsProblem','ProblemDataSet','StudentsAssignment','AssignmentScore','Classroom');

    public function index2(){

    }
    public function index(){
        //$assignments = $this->Assignment->findAllByClassroomId($this->Auth->user('classroom_id'));
        date_default_timezone_set("Asia/Bangkok");
        $assignments = $this->Assignment->find('all',array(
            'conditions' => array(
                'classroom_id' => $this->Auth->user('classroom_id'),
                'status' => (array('assigned','released'))
            )));
        foreach($assignments as $assignment)
        {
            switch($assignment['Assignment']['status'])
            {
                case('released') :
                    $isEnd = substr(CakeTime::timeAgoInWords($assignment['Assignment']['end_date']),-3);
                    if ($isEnd == 'ago' || $isEnd == 'now')
                    {
                        $this->Assignment->id = $assignment['Assignment']['id'];
                        $this->Assignment->set('status','ended');
                        $this->Assignment->save();
                    }
                    break;
                case ('assigned') :
                    $isRelease = substr(CakeTime::timeAgoInWords($assignment['Assignment']['release_date']),-3);
                    if ($isRelease== 'ago' || $isRelease == 'now')
                    {
                        $this->Assignment->id = $assignment['Assignment']['id'];
                        $this->Assignment->set('status','released');
                        $this->Assignment->save();
                    }
                    break;
                default : break;
            }
        }
        $released = $this->Assignment->findAllByClassroomIdAndStatus($this->Auth->user('classroom_id'),'released');
        for ($i = 0 ; $i < count($released) ;$i++)
        {
            if ($this->AssignmentScore->findByAssignmentIdAndStudentId($released[$i]['Assignment']['id'],$this->Auth->user('id')) != null)
            {
                $released[$i]['Done'] = 1;
            }
            else
            {
                $released[$i]['Done'] = 0;
            }
        }
        $this->set("assignments",$released);
    }

    public function beforeFilter(){
        parent::beforeFilter();
        if($this->Auth->user('role') === 'school_admin'){
            $this->Auth->allow('add');
            $this->layout = 'school_admin';
        }
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'student' ) {
            return true;
        }else{
            $this->Session->setFlash('You have no authoritative here','flash_notification');
        }
        return false;
    }

    public function add($classroomid){
        if ($this->request->is('post')){
            $uses = array('User');
            $this->loadModel('User');
            $sadmin = $this->Auth->user();
            $this->User->set('school_id',$sadmin['school_id']);
            $this->User->set('classroom_id',$classroomid);
            $this->User->set('role','student');
            if($this->User->save($this->request->data)){
                $this->redirect(array(
                    'controller' => 'classrooms',
                    'action' => 'index'
                ));
            }
        }
    }
    public function assignment($asid){
        //$asid = Assignment ID
        $assignment = $this->Assignment->findById($asid);
        $this->set('assignment',$assignment);
    }
    public function start($str)
    {
        $asid = substr($str,11);
        $assignment = $this->Assignment->findById($asid);
        $problems = $this->ProblemsetsProblem->findAllByProblemsetId($assignment['ProblemSet']['problemset_id']);
        //$lproblems = All Problems that already binded with Level and Dataset
        $lproblems = array();
        foreach ($problems as $problem)
        {
            $problem['DataSet'] = $this->ProblemDataSet->findAllByProblemLevelId($problem['ProblemLevel']['problem_level_id']);
            array_push($lproblems,$problem);
        }
        //pr($lproblems);
        $this->set('problems',$lproblems);

        if ($this->request->is('post'))
        {
            $answers = $this->request->data('StudentsAssignment');
            $i = 1;
            foreach ($lproblems as $problem)
            {
                $this->StudentsAssignment->create();
                $this->StudentsAssignment->set(array(
                    'problemset_problem_id' => $problem['ProblemsetsProblem']['problemset_problem_id'],
                    'student_id' => $this->Auth->user('id'),
                    'assignment_id' => $asid,
                    'problem_level_id' => $problem['ProblemsetsProblem']['problem_level_id'],
                    'problem_level_dataset_id' => $problem['DataSet'][$answers['Problem'. $i .' hidden']]['ProblemDataSet']['problem_level_dataset_id']
                ));
                $std_ans = "";
                for ($j = 1; $j <= $problem['ProblemLevel']['input_num'];$j++)
                {
                    if ($j > 1)
                    {
                        $std_ans .= ',';
                    }
                    $std_ans .= trim($answers['Problem'. $i . ' ' . $j]);
                }
                $this->StudentsAssignment->set('student_answer',$std_ans);
                $this->StudentsAssignment->save();
                $i++;
            }
            $this->redirect('setAnswerStatus/' . $this->Auth->user('id') . '/' . $asid);
        }
    }

    public function showCheckAnswer($student_id,$assignment_id){
        $studentAssignmentList = $this->StudentsAssignment->findAllByStudentIdAndAssignmentId($student_id,$assignment_id);
        $this->set('studentAssignmentList',$studentAssignmentList);
        $totalScore = 0;
        $totalQuestion = 0;
        foreach($studentAssignmentList as $studentAssignment){
            if($studentAssignment['StudentsAssignment']['answer_status'] == 1){
                $totalScore++;
            }
            $totalQuestion++;
        }
        $this->set('totalScore',$totalScore);
        $this->set('totalQuestion',$totalQuestion);

    }

    public function setAnswerStatus($student_id,$assignment_id){
        $studentAssignmentList = $this->StudentsAssignment->findAllByStudentIdAndAssignmentId($student_id,$assignment_id);
        $totalScore = 0;
        $totalQuestion = 0;
        foreach($studentAssignmentList as $studentAssignment){
            $studentAssignmentId = $studentAssignment['StudentsAssignment']['student_assignment_id'];
            $output_num = $studentAssignment['ProblemLevel']['output_num'];
            $input_num = $studentAssignment['ProblemLevel']['input_num'];
            $dataset = $studentAssignment['ProblemDataSet']['dataset'];
            $student_answer = $studentAssignment['StudentsAssignment']['student_answer'];
            $dataset = explode(",", $dataset);
            $answer = explode(",", $student_answer);
            $solveList = array_slice($dataset, $output_num);

            $correct = true;
            for($i=0;$i<$input_num;$i++){
                if($solveList[$i] != $answer[$i]){
                    $correct = false;
                }
            }
            if($correct){
                $this->StudentsAssignment->id = $studentAssignmentId;
                $this->StudentsAssignment->saveField('answer_status', '1',false);
                $totalScore++;
            }else{
                $this->StudentsAssignment->id = $studentAssignmentId;
                $this->StudentsAssignment->saveField('answer_status', '0',false);
            }
            $totalQuestion++;
        }

        // Save score
        $score=$this->AssignmentScore->findByStudentIdAndAssignmentId($student_id,$assignment_id);
        if(!empty($score)){
            $this->AssignmentScore->id = $score['AssignmentScore']['assignment_score_id'];
        }
        $this->AssignmentScore->save(array('student_id' => $student_id ,
            'assignment_id' => $assignment_id ,
            'score' => $totalScore ,
            'question' => $totalQuestion));

        $this->redirect('/student/showCheckAnswer/'.$student_id.'/'.$assignment_id);
    }
    
    public function view_class_rank(){
    	$student_id = $this->Auth->user('id');
    	$student = $this->User->find('first',array(
    			'conditions' => array('User.id' => $student_id),
    			'recursive' => -1));
    	$classroom_id = $student['User']['classroom_id'];
    	$classroom = $this->Classroom->find('first',array(
    			'conditions' => array('Classroom.id' => $classroom_id),
    			'recursive' => -1));
    	$classroom_name = $classroom['Classroom']['grade'].$classroom['Classroom']['room'];
    	
    	$db = $this->AssignmentScore->getDataSource();
    	$result = $db->fetchAll('SET @rank=0');
    	$result = $db->fetchAll(
    			'SELECT *
    				FROM (SELECT  A.* , @rank:=@rank+1 AS rank
    						FROM (SELECT AssignmentScore.student_id , SUM(AssignmentScore.score) AS total_score , SUM(AssignmentScore.question) AS total_question , Users.*
                        			FROM assignment_score AS AssignmentScore , user AS Users
                        			WHERE Users.id = AssignmentScore.student_id 
    								AND Users.classroom_id = ? 
    								GROUP BY AssignmentScore.student_id 
    								HAVING COUNT(AssignmentScore.assignment_score_id) = (SELECT COUNT(Assignment.id) 
    																		FROM assignment AS Assignment 
    																		WHERE Assignment.classroom_id = ? 
    																		AND Assignment.release_date < NOW())
                        			ORDER BY total_score DESC , Users.id ASC  
                        	) AS A ) AS Student 
    				WHERE Student.student_id = ?',
    			array($classroom_id,$classroom_id,$student_id)
    	);
    	
    	$result2 = $db->fetchAll(
    			'SELECT AssignmentScore.student_id , SUM(AssignmentScore.score) AS total_score , SUM(AssignmentScore.question) AS total_question , Users.* 
                        FROM assignment_score AS AssignmentScore , user AS Users 
                        WHERE Users.id = AssignmentScore.student_id 
    					AND Users.classroom_id = ? 
    					GROUP BY AssignmentScore.student_id 
    					HAVING COUNT(AssignmentScore.assignment_score_id) = (SELECT COUNT(Assignment.id) 
    																		FROM assignment AS Assignment 
    																		WHERE Assignment.classroom_id = ? 
    																		AND Assignment.release_date < NOW()) 
                        ORDER BY total_score DESC , Users.id ASC 
                        LIMIT 10',
    			array($classroom_id,$classroom_id)
    	);   	

    	if(!empty($result)){
    		$complete_assignment = true;
    	}else{
    		$complete_assignment = false;
    	}
    	
    	if(!empty($result) && $result[0]['Student']['rank'] <= 10)
    		$beTop10 = true;
    	else 
    		$beTop10 = false;
    	
    	$this->set('classroom_name',$classroom_name);
    	$this->set('complete_assignment',$complete_assignment);
    	$this->set('beTop10',$beTop10);
    	$this->set('top10List',$result2);
    	$this->set('student',$result);
    	$this->set('student_id',$student_id);
    	
    	
//     	echo '<br/><br/><br/><br/><br/><br/><br/>';
//     	pr($result2);
    	
    }
}

?>