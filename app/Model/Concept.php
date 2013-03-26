<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/15/13 AD
 * Time: 11:34 AM
 * To change this template use File | Settings | File Templates.
 */

class Concept extends AppModel{
    public $primaryKey = 'concept_id';
    public $useTable = 'concept';
    var $belongsTo = 'Unit';
}

?>