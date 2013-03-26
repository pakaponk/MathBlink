<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 2:21 PM
 * To change this template use File | Settings | File Templates.
 */

class CourseController extends AppController{
    public $uses = array('Lesson','Course','Topic','CoursesLesson');

    public function index(){
        $courses = $this->Course->find('all');
        $this->set('courses',$courses);
    }

    public function add(){
        $this->set('school_id',$this->Auth->user('school_id'));
        if( $this->request->is('post') ){
            //Get School id from user
            $this->Course->create();
            if ($this->Course->save($this->request->data)) {
                $this->Session->setFlash(__('The course has been saved'),'flash_complete');
            } else {
                $this->Session->setFlash(__('The course could not be saved. Please, try again.'),'flash_notification');
            }
            $this->redirect(array('action' => 'index'));
        }
    }

    public function edit($course_id){
        $courseData = $this->Course->findAllByCourseId($course_id);
        $this->set('data',$courseData);
        $this->set('school_id',$this->Auth->user('school_id'));

        $this->Course->id = $course_id;
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Course->save($this->request->data)) {
                $this->Session->setFlash(__('The course has been saved'),'flash_complete');
                $this->redirect('/course/index/');
            } else {
                $this->Session->setFlash(__('The course could not be saved. Please, try again.'),'flash_notification');
            }
        } else {
            $this->request->data = $this->Course->read(null, $this->Course->id);
        }
    }

    public function del($course_id){
        $this->Course->delete($course_id,false);
        $this->CoursesLesson->deleteAll(array('CoursesLesson.course_id' => $course_id));
        $this->Session->setFlash(__('The course has been deleted'),'flash_complete');
        $this->redirect($this->referer());
    }


    public function beforeFilter(){
        parent::beforeFilter();
        if($this->Auth->user('role') === 'school_admin'){
            $this->layout = 'school_admin';
        }
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'school_admin' ) {
            return true;
        }else{
            $this->Session->setFlash('You have no authoritative here','flash_notification');
        }
        return false;
    }

}
