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
                        ,'Problem','ProblemLevel','ProblemDataSet','ProblemsetsProblem');
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
        $num = count($lesson_list);
        for($i=0;$i<$num;$i++){
            $lesson_list[$lesson_list[$i]["lesson_id"]] = $lesson_list[$i]["lesson_name"];
            unset($lesson_list[$i]);
        }
        $this->set('added_problem',$allProblem);
        $this->set('problemset_arr',$problemset_arr);
        $this->set('course_arr',$course_arr);
        $this->set('lesson_list',$lesson_list);
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
            for($i=0;$i<$num;$i++){
                $topic_list[$topic_list[$i]["topic_id"]] = $topic_list[$i]["topic_name"];
                unset($topic_list[$i]);
            }
            //pr($topic_list);
            $this->set('topic_list',$topic_list);
        }
    }

    public function problemsetGetProblem($topic_id = -1){
        if($topic_id == -1){
            $this->autoRender=false;
        }else{

            $this->Problem->recursive = 2 ;
            $problemArr = $this->Problem->find('all');

            $problemIdArr = $this->Topic->findByTopicId($topic_id);
            $problemIdArr = $problemIdArr["Problem"];

            for($i=0;$i<count($problemArr);$i++){
                $problemArr[ $problemArr[$i]["Problem"]["problem_id"] ] = $problemArr[$i]["ProblemLevel"];
                unset($problemArr[$i]);
            }/**/

            for($i=0;$i<count($problemIdArr);$i++){
                $problemIdArr[$i] = $problemIdArr[$i]["problem_id"];
                //unset($problemIdArr[$i]);
            }

            //debug($problemArr);

            for($i=0;$i<count($problemIdArr);$i++){
                if( array_key_exists($problemIdArr[$i],$problemArr) ){
                    $problemIdArr[$i] = $problemArr[ $problemIdArr[$i] ] ;
                }
            }

            //debug($problemIdArr);
            $this->set('problemArr',$problemIdArr);
        }
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
}

?>