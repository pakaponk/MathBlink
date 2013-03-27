<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/26/13 AD
 * Time: 4:57 PM
 * To change this template use File | Settings | File Templates.
 */
class LeaderBoardController extends AppController{
    function index(){

    }

    //This function will give top 10 in the specific class and specefic lesson
    function top_class($class_id,$lesson_id){

    }

    function top_course($course_id,$lesson_id){

    }

    function beforeFilter(){
        parent::beforeFilter();
    }

    function isAuthorized($user){
        parent::isAuthorized($user);
    }
}
?>