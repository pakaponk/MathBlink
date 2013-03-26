<?php

class TopicController extends AppController{

    public $uses = array('Lesson','Course','Topic');

    public function index($course_id,$lesson_id){
        $this->set('lesson',$this->Lesson->findAllByLesson_id($lesson_id));
        $courseData = $this->Course->findByCourseId($course_id);
        $this->set('course_id',$course_id);
        $course_name = $courseData['Course']['course_name'];
        $this->set('course_name',$course_name);$lessonData = $this->Lesson->findByLessonId($lesson_id);
        $lesson_name = $lessonData['Lesson']['lesson_name'];
        $this->set('lesson_name',$lesson_name);
    }

    public function add($course_id,$lesson_id){
        $courseData = $this->Course->findByCourseId($course_id);
        $this->set('course_id',$course_id);
        $course_name = $courseData['Course']['course_name'];
        $this->set('course_name',$course_name);
        $lessonData = $this->Lesson->findByLessonId($lesson_id);
        $lesson_name = $lessonData['Lesson']['lesson_name'];
        $this->set('lesson_id',$lesson_id);
        $this->set('lesson_name',$lesson_name);
        $this->set('creator_id',$this->Auth->user('id'));
        if( $this->request->is('post') ){
            //Get School id from user
            $this->Topic->create();
            if ($this->Topic->save($this->request->data)) {
                $this->Session->setFlash(__('The topic has been saved'),'flash_complete');
                $this->redirect('/topic/index/'.$course_id.'/'.$lesson_id);
            } else {
                $this->Session->setFlash(__('The topic could not be saved. Please, try again.'),'flash_notification');
            }
        }
    }

    public function edit($course_id,$topic_id,$lesson_id){
        $topicData = $this->Topic->findAllByTopicId($topic_id);
        $courseData = $this->Course->findByCourseId($course_id);
        $this->set('course_id',$course_id);
        $course_name = $courseData['Course']['course_name'];
        $this->set('course_name',$course_name);
        $lessonData = $this->Lesson->findByLessonId($lesson_id);
        $lesson_name = $lessonData['Lesson']['lesson_name'];
        $this->set('lesson_id',$lesson_id);
        $this->set('lesson_name',$lesson_name);
        $this->set('data',$topicData);
        $this->set('creator_id',$this->Auth->user('id'));

        $this->Topic->id = $topic_id;
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Topic->save($this->request->data)) {
                $this->Session->setFlash(__('The topic has been saved'),'flash_complete');
                $this->redirect('/topic/index/'.$course_id.'/'.$lesson_id);
            } else {
                $this->Session->setFlash(__('The topic could not be saved. Please, try again.'),'flash_notification');
            }
        } else {
            $this->request->data = $this->Topic->read(null, $this->Topic->id);
        }
    }

    public function del($topic_id){
        $this->Topic->delete($topic_id);
        $this->Session->setFlash(__('The topic has been delete'),'flash_complete');
        $this->redirect($this->referer());
    }
}

?>