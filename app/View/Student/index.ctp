<div style="clear:both"></div>

<div style="clear:both"></div>

<div id="title">
    <strong>
        <h4>Welcome to Class
            <?php echo $profile_data['classroom_id'] ?>
            , today is
            <?php $my_t=getdate(date("U"));
            echo $my_t['mday']. " " . $my_t['month'] . " " . $my_t['year'];
            ?>
        </h4>
    </strong>
</div>

<div id="Main">
    <div id="left">
        <div id="xx" style="color:#666"><h4><i class="icon-file"></i> Your Assignment</h4></div>
        <?php foreach($assignments as $assignment):?>
        <div id="innerLeft-1">
            <div id="as-name"><h4><?php echo $assignment['ProblemSet']['problemset_name']?></h4></div>

            <div id="as-button">
                <?php
                if ($assignment['Done'] == 0){
                    echo $this->Html->link("Do Now!",array('controller' => 'student','action' => 'assignment',$assignment['Assignment']['id']),array('class'=>'btn btn-danger'));
                }
                else
                {
                    echo $this->Html->link("Done",array('controller' => 'student','action' => 'showCheckAnswer/' . $profile_data['id'] . "/" . $assignment['Assignment']['id']),array('class' => 'btn btn-success'));
                }
                ?>
            </div>
            <div style="clear:both"></div>
            <!--Still Mock Up-->
            <div id="as-lesson"><h5>Lesson : Equation</h5></div>

            <!--Still Mock Up-->
            <div id="as-problem-count"><h5>10 Problem(s)</h5></div>

            <div id="as-time-left"><h5>
                <?php
                echo $this->Time->timeAgoInWords($assignment['Assignment']['end_date'],array(
                    'accuracy' => array('second' => 'second'),
                    'end' => ''
                ));
                ?>
            </h5></div>
            <div style="clear:both"></div>
        </div>
        <?php endforeach ?>
    </div>

    <div style="clear:both;">
        <?php
        /**
         * Created by JetBrains PhpStorm.
         * User: CloudStrife
         * Date: 21/3/2556
         * Time: 15:16 น.
         * To change this template use File | Settings | File Templates.
         */
        ?>
    </div>