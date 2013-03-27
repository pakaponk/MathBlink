<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:41 AM
 * To change this template use File | Settings | File Templates.
 */

class Course extends AppModel{
    public $primaryKey = 'course_id';
    public $useTable = 'course';
    public $displayField = 'course_name';

    public $hasMany = array(
        'CoursesClassroom' => array(
            'className' => 'CoursesClassroom',
            'dependent'=> true,
        )
    );


    var $hasAndBelongsToMany = array(
        'Lesson' =>
        array(
            'className'              => 'Lesson',
            'joinTable'              => 'courses_lessons',
            'foreignKey'             => 'course_id',
            'associationForeignKey'  => 'lesson_id',
            'unique'                 => true,
            'conditions'             => '',
            'fields'                 => '',
            'order'                  => '',
            'limit'                  => '',
            'offset'                 => '',
            'finderQuery'            => '',
            'deleteQuery'            => '',
            'insertQuery'            => ''
        )
    );
}

?>
