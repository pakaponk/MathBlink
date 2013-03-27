<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Compare average class score of a problem set to average course score</h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 26/3/2556
 * Time: 11:58 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<div style="padding: 10px;width: 800px;margin: 0px auto;">
    <div>
        <?php
        /*
        echo $this->Form->input('ProblemSet', array(
            'empty' => '-- Select a ProblemSet --',
            'type'=>'select',
            'options'=>$problemsets,
            'label'=>false,
            'style'=>'width:350px',
            'onchange'=>'javascript:problemsetGetTopic("/mathblink/teacher/problemsetGetTopic","lesson_id");'
        ));
        */
        echo $this->Form->create('CompareRoom');

        echo $this->Form->input('1', array(
            'empty' => '-- Select Room --',
            'type' => 'select',
            'options' => $classroom_list,
            'label' => 'Select Room'
        ));

        echo $this->Form->submit('Compare',array(
            'class' => 'btn btn-primary'
        ));

        ?>
        <?php if($result == true): ?>
        <br />
        <h4>Compare Result</h4>
        <table class="table table-bordered table-striped">
            <th>
                Course : Average Score
            </th>
            <th>
                Classroom : Average Score
            </th>
            <tr>
                <td> <?php echo sprintf("%.2f",$course_score) . " ( " . $course_score_num . " students sent the assignment from " . $course_num . " in classroom )" ; ?></td>
                <td> <?php echo sprintf("%.2f",$score) . " ( " . $score_num . " students sent the assignment from " . $num . " in classroom )" ; ?></td>
            </tr>
            <?php endif ?>
        </table>