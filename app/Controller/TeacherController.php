<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/11/13 AD
 * Time: 5:24 PM
 * To change this template use File | Settings | File Templates.
 */

class TeacherController extends AppController{

    public $uses = array('Lesson','Course','Topic','ProblemSet','CoursesLesson','Teacher'
                        ,'Problem','ProblemLevel','ProblemDataSet','ProblemsetsProblem'
                        ,'Classroom','Assignment','AssignmentScore','User');
    public $components = array('RequestHandler');
    public $layout = 'teacher';

    public function beforeFilter(){
        parent::beforeFilter();
        if($this->Auth->user('role') === 'school_admin'){
            $this->Auth->allow('add');
            $this->layout = 'school_admin';
        }
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'teacher' ) {
            return true;
        }else{
            $this->Session->setFlash('You have no authoritative here','flash_notification');
        }
        return false;
    }

    public function index(){
        //only view here
    }

    public function create_problemset(){
        //pr($this->Course->find('list'));
        $this->set('course_list',$this->Course->find('list'));

        if($this->request->is('post')){
            //pr($this->request->data);
            $this->request->data['ProblemSet']['user_id'] = $this->Auth->user('id');
            if($this->ProblemSet->save($this->request->data)){
                $this->redirect(array(
                    'controller' => 'Teacher',
                    'action' => 'problemset',
                    $this->ProblemSet->getLastInsertID()
                    /*,$this->request->data['ProblemSet']['course_id']*/
                ));
            }
        }
    }

    public function problemset($id,$courseId = -1){
        $allProblem = $this->ProblemsetsProblem->findAllByProblemsetId($id);
        //pr($allProblem);
        $problemset_arr =  $this->ProblemSet->findByProblemsetId($id) ;
        //pr($problemset_arr["ProblemSet"]["course_id"]);
        $course_arr = $this->Course->findByCourseId($problemset_arr["ProblemSet"]["course_id"]) ;
        $lesson_list = $course_arr["Lesson"];
        //pr($lesson_list);
        $num = count($lesson_list);
        $lesson_list_temp = array();
        for($i=0;$i<$num;$i++){
            $lesson_list_temp[$lesson_list[$i]["lesson_id"]] = $lesson_list[$i]["lesson_name"];
            //$lesson_list[$lesson_list[$i]["lesson_id"]] = $lesson_list[$i]["lesson_name"];
            //unset($lesson_list[$i]);
        }

        $this->set('added_problem',$allProblem);
        $this->set('problemset_arr',$problemset_arr);
        $this->set('course_arr',$course_arr);
        $this->set('lesson_list',$lesson_list_temp);
        //$this->params["named"]["id"];
        //$this->params["named"]["course_id"];
    }

    public function problemset_main(){
        $creatorID = $this->Auth->user('id');
        //$this->ProblemSet->recursive = 2 ;
        $problemsetArr = $this->Teacher->findById($creatorID);
        $course_list = $this->Course->find('list');
        //$temp = $this->ProblemSet->find('all');
        //pr($course_list);
        $this->set('course_list',$course_list);
        $this->set('problemset_arr',$problemsetArr);
    }

    public function add($classroomid){
        if ($this->request->is('post')){
            $uses = array('User');
            $this->loadModel('User');
            $sadmin = $this->Auth->user();
            $this->User->set('school_id',$sadmin['school_id']);
            $this->User->set('classroom_id',$classroomid);
            $this->User->set('role','teacher');
            if($this->User->save($this->request->data)){
                $this->redirect(array(
                    'controller' => 'classrooms',
                    'action' => 'index'
                ));
            }
        }
    }

    public function problemsetGetLesson($course_id = -1){
        if($course_id == -1){
            $this->autoRender = false ;
        }else{
            $lesson_list = $this->Lesson->Course->findByCourseId($course_id);
            pr("ddd");
        }
    }

    public function problemsetGetTopic($lesson_id = -1){
        if($lesson_id == -1){
            $this->autoRender=false;
        }else{
            $topic_list = $this->Topic->Lesson->findByLessonId($lesson_id);
            $topic_list = $topic_list["Topic"];
            //pr($topic_list);
            $num = count($topic_list);
            $topic_list_temp = array();
            for($i=0;$i<$num;$i++){
                $topic_list_temp[$topic_list[$i]["topic_id"]] = $topic_list[$i]["topic_name"];
                //$topic_list[$topic_list[$i]["topic_id"]] = $topic_list[$i]["topic_name"];
                //unset($topic_list[$i]);
            }
            //pr($topic_list);
            $this->set('topic_list',$topic_list_temp);
        }
    }

    public function problemsetGetProblem($topic_id = -1){
        if($topic_id == -1){
            $this->autoRender=false;
            echo" ";
        }else{

            $this->Problem->recursive = 2 ;
            $problemArr = $this->Problem->find('all');

            $problemIdArr = $this->Topic->findByTopicId($topic_id);
            $problemIdArr = $problemIdArr["Problem"];
            //pr($problemArr);
            if($problemArr !== array() && $problemIdArr !== array()){
                $problemArr_temp = array();
                for($i=0;$i<count($problemArr);$i++){
                    $problemArr_temp[ $problemArr[$i]["Problem"]["problem_id"] ] = $problemArr[$i]["ProblemLevel"];
                    //$problemArr[ $problemArr[$i]["Problem"]["problem_id"] ] = $problemArr[$i]["ProblemLevel"];
                    //unset($problemArr[$i]);
                }

                for($i=0;$i<count($problemIdArr);$i++){
                    $problemIdArr[$i] = $problemIdArr[$i]["problem_id"];
                    //unset($problemIdArr[$i]);
                }

                //debug($problemArr);

                for($i=0;$i<count($problemIdArr);$i++){
                    if( array_key_exists($problemIdArr[$i],$problemArr_temp) ){
                        $problemIdArr[$i] = $problemArr_temp[ $problemIdArr[$i] ] ;
                    }
                }
            }

            //debug($problemIdArr);
            $this->set('problemArr',$problemIdArr);
        }
    }

    public function class_report(){

    }

    public function save_problemset($problemset_id,$problem_level_id,$problem_status){
        $this->autoRender = false ;

        $problem_level_id_array = explode(";",$problem_level_id);
        $problem_status_array = explode(";",$problem_status);

        $conditions = array (
            "ProblemsetsProblem.problemset_id" => $problemset_id,
        );
        $this->ProblemsetsProblem->deleteAll($conditions);

        $len = count($problem_level_id_array);
        for($i=0;$i<$len;$i++){
            if($problem_status_array[$i] == "add"){
                echo "X";
                $data = $this->ProblemLevel->findByProblemLevelId( $problem_level_id_array[$i]) ;
                $problem_id = $data["Problem"]["problem_id"];
                $saveData = array(
                    'problemset_problem_id' =>'',
                    'problemset_id'     => $problemset_id ,
                    'problem_id'        => $problem_id,
                    'problem_level_id'  => $problem_level_id_array[$i]
                );
                $this->ProblemsetsProblem->save($saveData);
            }
        }
        //debug($problem_level_id);
        //debug($problem_status);

    }

    public function compare($psid)
    {
        $assignments = $this->Assignment->findAllByProblemsetId($psid);
        $classroom_list = array();
        foreach ($assignments as $assignment)
        {
            $classroom_list[$assignment['Assignment']['id']] = $assignment['Classroom']['room'];
        }
        $this->set('classroom_list',$classroom_list);
        $this->set('result',false);

        if ($this->request->is('post'))
        {
            $compare_rooms = $this->request->data('CompareRoom');
            $score1 = $this->AssignmentScore->findAllByAssignmentId($compare_rooms[1]);
            $score2 = $this->AssignmentScore->findAllByAssignmentId($compare_rooms[2]);
            $score1_num = count($score1);
            $score2_num = count($score2);
            $score1['Average'] = 0;
            $score2['Average'] = 0;
            for ($i = 0;$i< $score1_num ;$i++)
            {
                $score1['Average'] += $score1[$i]['AssignmentScore']['score'];
            }
            for ($i = 0;$i< $score2_num ;$i++)
            {
                $score2['Average'] += $score2[$i]['AssignmentScore']['score'];
            }
            $num1 = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $score1[0]['User']['classroom_id'],
                    'role' => 'student'
                )
            ));
            $num2 = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $score2[0]['User']['classroom_id'],
                    'role' => 'student'
                )
            ));
            $score1['Average'] /= $num1;
            $score2['Average'] /= $num2;
            $this->set('score1',$score1);
            $this->set('score2',$score2);
            $this->set('score1_num',$score1_num);
            $this->set('score2_num',$score2_num);
            $this->set('num1',$num1);
            $this->set('num2',$num2);
            $this->set('result',true);
        }
    }

    public function compareWithCourse($psid)
    {
        $assignments = $this->Assignment->findAllByProblemsetId($psid);
        $classroom_list = array();
        $course_score['Average'] = 0;
        $course_score_num = 0;
        $course_num = 0;
        foreach ($assignments as $assignment)
        {
            $classroom_list[$assignment['Assignment']['id']] = $assignment['Classroom']['room'];
            $score = $this->AssignmentScore->findAllByAssignmentId($assignment['Assignment']['id']);
            $score_num = count($score);
            $score['Average'] = 0;
            for ($i = 0;$i< $score_num ;$i++)
            {
                $score['Average'] += $score[$i]['AssignmentScore']['score'];
            }
            $num = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $score[0]['User']['classroom_id'],
                    'role' => 'student'
                )
            ));
            $course_score['Average'] += $score['Average'];
            $course_score_num += $score_num;
            $course_num += $num;
        }
        $course_score['Average'] /= $course_num;
        $this->set('classroom_list',$classroom_list);
        $this->set('result',false);

        if ($this->request->is('post'))
        {
            //Calculate Class Average Score
            $compare_room = $this->request->data('CompareRoom');
            $score = $this->AssignmentScore->findAllByAssignmentId($compare_room[1]);
            $score_num = count($score);
            $score['Average'] = 0;
            for ($i = 0;$i< $score_num ;$i++)
            {
                $score['Average'] += $score[$i]['AssignmentScore']['score'];
            }
            $num = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $score[0]['User']['classroom_id'],
                    'role' => 'student'
                )
            ));
            $score['Average'] /= $num;

            $this->set('score',$score['Average']);
            $this->set('score_num',$score_num);
            $this->set('num',$num);

            $this->set('course_score',$course_score['Average']);
            $this->set('course_score_num',$course_score_num);
            $this->set('course_num',$course_num);

            $this->set('result',true);
        }
    }
    
    public function view_class_rank($lesson_id){
    	$teacher_id = $this->Auth->user('id');
    	$lesson = $this->Lesson->find('first',array(
    			'conditions' => array('Lesson.lesson_id' => $lesson_id),
    			'recursive' => -1));
    	$lesson_name = $lesson['Lesson']['lesson_name'];
    	 
    	$db = $this->AssignmentScore->getDataSource();
    	$result2 = $db->fetchAll(
    			'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , User.title , User.first_name , User.middle_name , User.last_name 
					FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
							(Assignment.id = AssignmentScore.assignment_id 
        					AND User.id = AssignmentScore.student_id)
					WHERE User.role = "student" 
					AND Assignment.problemset_id IN (SELECT Problemset.problemset_id
														FROM problemset AS Problemset INNER JOIN 
                                							courses_lessons AS CoursesLesson 
                                        					ON (Problemset.course_id = CoursesLesson.course_id)
                                						WHERE CoursesLesson.lesson_id = ?)
					AND User.classroom_id IN (SELECT TeachersClassroom.classroom_id 
    											FROM teachers_classrooms AS TeachersClassroom 
    											WHERE TeachersClassroom.teacher_id = ?)
					GROUP BY User.id
                    ORDER BY total_score DESC , User.id ASC 
                    LIMIT 10',
    			array($lesson_id,$teacher_id)
    	);
    	 
    	$this->set('lesson_name',$lesson_name);
    	$this->set('top10List',$result2);    	 
    	 
    	//     	echo '<br/><br/><br/><br/><br/><br/><br/>';
    	//     	pr($result2);
       
    }
    
    public function view_course_rank($lesson_id){
    	$teacher_id = $this->Auth->user('id');
    	
    	$lesson = $this->Lesson->find('first',array(
    			'conditions' => array('Lesson.lesson_id' => $lesson_id),
    			'recursive' => -1));
    	$lesson_name = $lesson['Lesson']['lesson_name'];
    
    	$db = $this->AssignmentScore->getDataSource();
    	$result2 = $db->fetchAll(
    			'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , User.title , User.first_name , User.middle_name , User.last_name 
					FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
							(Assignment.id = AssignmentScore.assignment_id 
        					AND User.id = AssignmentScore.student_id)
					WHERE User.role = "student" 
					AND Assignment.problemset_id IN (SELECT Problemset.problemset_id
														FROM problemset AS Problemset INNER JOIN 
                                							courses_lessons AS CoursesLesson 
                                        					ON (Problemset.course_id = CoursesLesson.course_id)
                                						WHERE CoursesLesson.lesson_id = ?)
					AND User.classroom_id IN (SELECT CoursesClassroom.classroom_id
			  									FROM courses_classrooms AS CoursesClassroom , 
                          							courses_classrooms AS CoursesClassroom2
                          						WHERE CoursesClassroom.course_id = CoursesClassroom2.course_id
                          						AND CoursesClassroom2.classroom_id IN (SELECT TeachersClassroom.classroom_id 
    																					FROM teachers_classrooms AS TeachersClassroom 
    																					WHERE TeachersClassroom.teacher_id = ?))
					GROUP BY User.id
                    ORDER BY total_score DESC , User.id ASC 
                    LIMIT 10',
    			array($lesson_id,$teacher_id)
    	);
    
    	$this->set('lesson_name',$lesson_name);
    	$this->set('top10List',$result2);
    
    	//     	echo '<br/><br/><br/><br/><br/><br/><br/>';
    	//     	pr($result2);
        
    }

}

?>