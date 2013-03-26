<?php
/**
 *@property Classroom $classrooms
 */

/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 19/3/2556
 * Time: 11:02 น.
 * To change this template use File | Settings | File Templates.
 */

class ClassroomsController extends AppController{

    public function beforeFilter(){
        parent::beforeFilter();
        if($this->Auth->user('role') === 'school_admin'){
            $this->layout = 'school_admin';
        }
    }

    public function index(){
        $sadmin = $this->Auth->user();
        $classrooms = $this->Classroom->findAllBySchoolId($sadmin['school_id']);
        $this->set('classrooms',$classrooms);
    }

    public function create(){
        if ($this->request->is('post')){
            $sadmin = $this->Auth->user();
            //pr($sadmin);
            $this->request->data["Classroom"]["school_id"] = $sadmin["school_id"];
            if($this->Classroom->save( $this->request->data)){
                $this->redirect(array(
                    'controller' => 'classrooms',
                    'action' => 'index'
                ));
            }
        }
    }

    public function edit($classroomid){
        if ($this->request->is('post')){
            $this->Classroom->id = $classroomid;
            $this->Classroom->save($this->request->data);
            $this->redirect(array(
                'controller' => 'classrooms',
                'action' => 'index'
            ));
        }
    }
}