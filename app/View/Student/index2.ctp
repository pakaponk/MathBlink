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
        <?php
        //if( strlen($assignments) == 0 ) $assignments = array() ;
        foreach($assignments as $assignment):?>
        <div id="innerLeft-1">
            <div id="as-name"><h4><?php echo $assignment['ProblemSet']['problemset_name']?></h4></div>

            <!--Still Mock Up-->
            <div id="as-button">
                <?php echo $this->Html->link("Do Now!",array('controller' => 'student','action' => 'assignment',$assignment['Assignment']['id']),array('class'=>'btn btn-danger'));?>
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
    <div id="right">
        <!--<div id="innerRight">
            <div id="headerText"><h5><i class="icon-th-large"></i> Point</h5></div>
            <div id="seemore">See more</div>
        </div>-->
        <div id="innerRight">
            <div id="headerText"><h4><i class="icon-star"></i> Badges</h4></div>
            <div id="badges">

                <div>
                    <?php echo $this->Html->image('Badge1.png',array('width'=>'126px'))?>
                    <?php echo $this->Html->image('Badge2.png',array('width'=>'126px'))?>
                    <?php echo $this->Html->image('Badge3.png',array('width'=>'126px'))?>
                </div>

                <!--<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Ski_trail_rating_symbol-green_circle.svg/600px-Ski_trail_rating_symbol-green_circle.svg.png" width="100" class="img-circle" />
                <img src="http://openclipart.org/people/nlyl/nlyl_blue_circle.svg" width="100" class="img-circle" />-->

            </div>

            <!-- <div id="seemore">See more</div>-->
        </div>

        <div id="innerRight">
            <div id="subLeft">
                <div id="headerText"><h5><i class="icon-road"></i> Your Rank</h5></div>
                <!--<ul>
                    <li>Supplementary Class</li>
                    <li>Fundamental Class</li>
                </ul>-->
                <table class="table table-hover" id="rank">
                    <tr bgcolor="#FCFCDC" ><td><strong><u>Supplementary Class<u></strong></td><td>2nd</td></tr>
                    <tr bgcolor="#FBFBFB" ><td><strong>Fundamental Class</strong></td><td>23rd</td></tr>
                </table>
                <!--<div id="seemore">See more</div>-->
            </div>

            <div id="subRight">
                <div id="headerText"><h5><i class="icon-road"></i> Leader Board</h5></div>
                <table class="table table-hover" id="rank">
                    <tr bgcolor="#FBFBFB" ><td><strong>1. Worapol Ratanapan</strong></td></tr>
                    <tr bgcolor="#FCFCDC" ><td><strong><u>2. Weeratouch Pongruengkiat<u></strong></td></tr>
                    <tr bgcolor="#FBFBFB" ><td><strong>3. Bun Suwanparsert</strong></td></tr>
                </table>
                <!-- <div id="seemore">See more</div>-->
            </div>
            <div style="clear:both"></div>

        </div>

        <div id="innerRight">
            <div style="width:190px ;float: left;">
                <span id="headerText"><h4><i class="icon-th-list"></i> Lesson Plan</h4></span>
                <table class="table table-hover" id="rank">
                    <tr bgcolor="#FBFBFB" ><td><strong>Next Week</strong> : Equation Systems</td></tr>
                    <tr bgcolor="#FCFCDC" ><td><strong><u>This Week</u></strong> : Linear Inequalities</td></tr>
                    <tr bgcolor="#FBFBFB" ><td><strong>Last Week</strong> : Linear Equations</td></tr>
                </table>
            </div>

            <div style="width:50%;background-color:#FFF ;float: right;"><img src="c.png"></div>

            <div style="clear: both;"></div>
            <!--<div id="seemore">See more</div>-->
        </div>
    </div> <!--Still Mock up-->
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