<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/21/13 AD
 * Time: 2:56 PM
 * To change this template use File | Settings | File Templates.
 */
class Teacher extends AppModel{
    public $useTable = 'user';
    public $hasMany = array(
        'ProblemSet'
    );
    public $belongsTo = array(
        'Classroom'
    );

    public $hasAndBelongsToMany = array(
        'Course' =>
        array(
            'className'              => 'Course',
            'joinTable'              => 'teachers_courses',
            'foreignKey'             => 'teacher_id',
            'associationForeignKey'  => 'course_id',
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

    public function beforeFind(){

    }
}
?>