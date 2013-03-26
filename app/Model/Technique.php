<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:34 AM
 * To change this template use File | Settings | File Templates.
 */

class Technique extends AppModel{
    public $primaryKey = 'technique_id';
    public $useTable = 'technique';
    var $belongsTo = 'Unit';

}

?>