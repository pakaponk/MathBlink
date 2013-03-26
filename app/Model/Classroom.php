<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 19/3/2556
 * Time: 11:03 น.
 * To change this template use File | Settings | File Templates.
 */

/** @noinspection PhpUndefinedClassInspection */
class Classroom extends AppModel{
    public $useTable = 'classrooms';
    public $displayField = 'room';

    public $hasMany = array(
        'User'
    );


    public $validate = array(
        'grade' => array(
            'rule' => 'notEmpty',
            'message' => 'Please fill in a classroom grade'
        ),
        'room' => array(
            'rule' => 'notEmpty',
            'message' => 'Please fill in a classroom name'
        ),
    );
}