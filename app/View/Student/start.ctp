<?php
/**
 * @var $this View
 */
?>
<!--MathJax.Hub.Typeset();-->
<script>
    MathJax.Hub.Typeset();
</script>
<?php
echo $this->Html->script('jquery-1.4.2.min');
echo $this->Html->script('script.js');
?>
<h3 id="header" style="width:800px;padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5;">
    <div style="float: left;padding: 10px"">Do Assignment</div>
    <div style="float: right;padding: 0px">
        <div id="show"><h4 class="btn btn-danger">Hide Time Remaining</h4></div>
        <div>
            <h4 id="date" style="text-align: center">00:10:00</h4>
        </div>
    </div>
    <div style="clear: both"></div>
</h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 22/3/2556
 * Time: 12:02 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<div style="padding: 20px;width: 800px;margin: 0px auto;">
    <?php
    echo $this->Form->create('StudentsAssignment');
    ?>
    <table class="table table-bordered table-striped">
        <?php $i = 1;foreach ($problems as $problem):?>
        <tr>
            <td>
                <div style="padding: 10px;margin-top: 10px">
                    <p><strong>Problem <span class="badge badge-info"><?php echo $i; ?></span></strong><p>

                    <div class="help-block">
                            <span class='help-inline'><?php

                                $main = $problem['ProblemLevel']['main_text'];
                                //Random Dataset
                                $dataset = rand(0,count($problem['DataSet'])-1);

                                //Get inputs from random dataset
                                $input = $problem['DataSet'][$dataset]['ProblemDataSet']['dataset'];
                                $input_num = $problem['ProblemLevel']['input_num'];
                                $output_num = $problem['ProblemLevel']['output_num'];
                                for ($j = 0;$j < $input_num;$j++)
                                {
                                    $start = strrpos($input,',',null);
                                    $input = substr($input,0,$start);
                                }
                                //Replace inputs field in main text
                                $start = 0;
                                for ($j = 1;$j <= $output_num;$j++)
                                {
                                    $find = 'o_{' . "$j" . "}";
                                    $end = strpos($input,',',$start);
                                    if ($j<$output_num)
                                        $main = str_replace($find,substr($input,0,$end),$main);
                                    else
                                        $main = str_replace($find,substr($input,0),$main);
                                    $input = substr($input,$end+1);
                                }

                                $start = 0;
                                $output = array();
                                $chr = array_fill(0,26,0);
                                for ($j = 1;$j <= $input_num;$j++)
                                {
                                    $find = 'i_{' . "$j" . "}";
                                    do{
                                        $rand = rand(97,98);
                                    }
                                    while($chr[$rand-97] == 1);
                                    $output[$j-1] = chr($rand);
                                    $chr[$rand-97] =1;
                                    $main = str_replace($find,$output[$j-1],$main);
                                }
                                echo $main;
                                ?></span>
                    </div>
                    <?php for ($j = 1;$j <= $problem['ProblemLevel']['input_num'];$j++): ?>
                    <span class="help-inline"> <?php echo '$$' . $output[$j-1] . " = " . "$$"?></span>
                    <?php echo $this->Form->text('Problem'. $i . ' ' .$j,array('class'=>'input-mini')); ?>
                    <?php
                endfor;
                    echo $this->Form->hidden('Problem'. $i . ' hidden',array('value' => $dataset));
                    ?>
                </div>
            </td>
        </tr>
        <?php $i++;endforeach?>
    </table>
    <?php
    echo $this->Form->submit("Submit",array('id' => 'submit','class' => 'btn btn-primary','div' => 'form-actions'));
    ?>
</div>