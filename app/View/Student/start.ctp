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


    <div style="float: right;padding: 10px 40px 0px 0px">
        <div id="show">Time Remaining</div>
        <div>
            <h4 id="date">00:10:00</h4>
        </div>
    </div>
    <h3 id="header" style="width:800px;display: inline-block;padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">Do Assignment</h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 22/3/2556
 * Time: 12:02 น.
 * To change this template use File | Settings | File Templates.
 */
?>
    <div style="padding: 10px;width: 800px;margin: 0px auto;">
        <?php
            echo $this->Form->create('StudentsAssignment');
        ?>
        <?php $i = 1;foreach ($problems as $problem):?>
        <div style="padding: 10px;margin-top: 10px">
            <p><strong>Problem <?php echo $i; ?></strong><p>
            <div class="help-block">
            <span class='help-inline'><?php
                $main = $problem['ProblemLevel']['main_text'];
                //Random Dataset
                $dataset = rand(0,count($problem['DataSet'])-1);

                //Get inputs from random dataset
                $input = $problem['DataSet'][$dataset]['ProblemDataSet']['dataset'];
                $input_num = $problem['ProblemLevel']['input_num'];
                $start = strlen($input);
                for ($j = 0;$j < $input_num;$j++)
                {
                    $start = strrpos($input,',',$start)-1;
                }
                $start--;
                $input = substr($input,0,$start);

                //Replace inputs field in main text
                $start = 0;
                for ($j = 1;$j <= $input_num;$j++)
                {
                    $find = 'o_{' . "$j" . "}";
                    $end = strpos($input,',',$start);
                    if ($j<$input_num)
                        $main = str_replace($find,substr($input,0,$end),$main);
                    else
                        $main = str_replace($find,substr($input,0),$main);
                    $input = substr($input,$end+1);
                }

                $output_num = $problem['ProblemLevel']['output_num'];
                $start = 0;
                $output = array();
                for ($j = 1;$j <= $output_num;$j++)
                {
                    $find = 'i_{' . "$j" . "}";
                    $output[$j-1] = chr(rand(97,122));
                    $main = str_replace($find,$output[$j-1],$main);
                }
                echo $main;
            ?></span>
            </div>
            <?php for ($j = 1;$j <= $problem['ProblemLevel']['output_num'];$j++): ?>
                    <span class="help-inline"> <?php echo '$$' . $output[$j-1] . " = " . "$$"?></span>
                    <?php echo $this->Form->text('Problem'. $i . ' ' .$j,array('class'=>'input-mini')); ?>
            <?php
                endfor;
                echo $this->Form->hidden('Problem'. $i . ' hidden',array('value' => $dataset));
            ?>

        </div>

        <?php $i++;endforeach?>

        <?php
            echo $this->Form->submit("Submit",array('id' => 'submit','class' => 'btn btn-primary','div' => 'form-actions'));
        ?>
    </div>