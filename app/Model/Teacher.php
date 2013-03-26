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
}
?>