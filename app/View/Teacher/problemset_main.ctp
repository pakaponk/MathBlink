<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/21/13 AD
 * Time: 10:36 AM
 * To change this template use File | Settings | File Templates.
 */
//pr($problemset_arr);

?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<style>
</style>
<?php

echo $this->Javascript->link('bootstrap');
echo $this->Javascript->link('bootstrap.min');
echo $this->Javascript->link('zebra_datepicker');
echo $this->Html->css('daterangepicker.css');
echo $this->Html->css('bootstrap-datetimepicker.min.css');

echo $this->Javascript->link('date');
echo $this->Javascript->link('daterangepicker');
echo $this->Javascript->link('bootstrap-datetimepicker.min');

?>

<script>
    var currently_item ;
    var is_submit = false ;
    var is_move = false ;
    $(function() {

        $('#set_start_end').on('hidden', function () {
            if(!is_submit){
                moveAnimate("#"+currently_item, "#ready");
            }

            is_submit = false ;
        });

        $('#confirm_move_to_ready').on('hidden', function () {
            if(!is_move){
                moveAnimate("#"+currently_item, "#assigned");
            }
            is_move = false ;
        });

        $('#start_time').datetimepicker({
            pickDate: false
        });
        $('#end_time').datetimepicker({
            pickDate: false
        });


        var ready_count = $('#ready li').length ;
        var assigned_count = $('#assigned li').length;

        /*$("#ready").droppable({
            activeClass: 'test-class',
            hoverClass:'test-class'
        });

        $("#assigned").droppable({
            activeClass: 'test-class',
            hoverClass:'test-class'
        });*/


        $( "#ready, #assigned" ).sortable({
            connectWith: ".connectedSortable",
            dropOnEmpty: true,
            placeholder: "assignment_drag_hover",
            start : function(event, ui){
                //alert("start");
                //get current element being sorted
                //var role = $(this).attr("id");
                //alert(role);
            },
            stop : function(event, ui){



                //console.dir(event);
                ///
            },
            cancel: ".ui-state-disabled",
            receive: function( event, ui ) {
                var target = event.target.id;
                currently_item = $(ui.item).attr("id");
                if(target =="assigned"){
                    $('#set_start_end').modal('show');
                }
                if(target == "ready"){
                    $('#confirm_move_to_ready').modal('show');
                }



            }
        }).disableSelection();
    });


    function moveAnimate(element, newParent){
        element = $(element); //Allow passing in either a JQuery object or selector
        newParent= $(newParent); //Allow passing in either a JQuery object or selector
        var oldOffset = element.offset();
        element.appendTo(newParent);
        var newOffset = element.offset();

        var temp = element.clone().appendTo('body');
        temp    .css('position', 'absolute')
                .css('left', oldOffset.left+20)
                .css('top', oldOffset.top+30)
                .css('zIndex', 1000);
        element.hide();
        temp.animate( {'top': newOffset.top, 'left':newOffset.left+20}, 'slow', function(){
            element.show();
            temp.remove();
        });
    }

    function save_start_end(){
        var date = $('#date').val();
        var start_time = $('#start_time_value').val();
        var end_time = $('#end_time_value').val();
        var class_id = $('#class_id').html();
        var problemset_id = currently_item ;
        //alert(date);
         date=date.replace(/\//g, '-');

        start_time=start_time.replace(/:/g,";");
        end_time = end_time.replace(/:/g,";");

        //alert(start_time);
        //alert(end_time);
        //alert(problemset_id);
        /*
        *
        * TODO:Please change url here
        * */

        var callUrl = '/mathblink/teacher/assign_problemset/'+problemset_id+'/'+class_id+'/'+date+'/'+start_time+'/'+end_time ;

        $.ajax({
            url: callUrl,
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function (data) {
                //alert("save finished");
                //$('#debug').html(data);
            }
        });
        is_submit = true ;
        $('#date').val("");
        $('#start_time_value').val("");
        $('#end_time_value').val("");
        $('#set_start_end').modal('hide')
    }

    function confirm_move_to_ready(){
        var class_id = $('#class_id').html();
        var problemset_id = currently_item ;
        var callUrl = '/mathblink/teacher/unassign_problemset/'+problemset_id+'/'+class_id ;
        $.ajax({
            url: callUrl,
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function (data) {
                //alert("save finished");
                //$('#debug').html(data);
            }
        });
        is_move = true ;
        $('#confirm_move_to_ready').modal('hide')
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#date').daterangepicker();
    });
</script>

<!-- Modal -->
<div id="set_start_end" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Set Start-End Date</h3>
    </div>
    <div class="modal-body">
<?php
        //echo $this->Form->create('Assignment');
?>
        <div id="debug"></div>

        <form class="form-horizontal">
            <fieldset>
            <div class="control-group">
                <label class="control-label" >Released Dates:</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-calendar"></i></span><input type="text" name="date" id="date" />
                    </div>
                </div>
                <br/>
                <label class="control-label" >Start Time:</label>
                <div class="controls">
                   <div id="start_time" class="input-prepend input-append">
                            <span class="add-on"><i class="icon-time"></i></span>
                            <input data-format="hh:mm:ss" type="text" id="start_time_value">
                        </div>
                   </div>
                <br/>
                <label class="control-label" >End Time:</label>
                <div class="controls">
                    <div id="end_time" class="input-prepend input-append">
                        <span class="add-on"><i class="icon-time"></i></span>
                        <input data-format="hh:mm:ss" type="text" id="end_time_value">
                    </div>
                </div>
            </div>
            </fieldset>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <a href="javascript:save_start_end()" class="btn btn-primary">Submit</a>
        <?php //echo $this->Form->submit(__('Submit'),array('class' => 'btn btn-primary')); ?>
    </div>
</div>




<div id="confirm_move_to_ready" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Confirm unassigned this assignment !</h3>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <a href="javascript:confirm_move_to_ready()" class="btn btn-primary">Confirm</a>
    </div>
</div>






<h3 style="padding: 10px;border-bottom: 1px solid #e5e5e5;margin-left: 50px;margin-right: 50px">
    Assignment Portal
    <span style="float: right">
    <a class="btn btn-primary" href="<?php echo  $this->Html->url(array(
        'controller' => 'teacher' ,
        'action' => 'problemset_management'
    )) ;?> ">Problem Set Management</a>

    <a class="btn" href="<?php echo  $this->Html->url(array(
        'controller' => 'teacher' ,
        'action' => 'problemset_main'
    )) ;?> ">Choose New Course/Classroom</a>    </span>
</h3>

<div id="course_id" style="display: none"><?php echo $this->params["pass"][0] ;?></div>
<div id="class_id" style="display: none"><?php echo $this->params["pass"][1] ;?></div>

    <!--<div style="background-color#333333;color: #a1a1a1;margin-left: 50px;margin-right: 50px;width: 600px"><h4 style="padding: 10px">No Problem set</h4></div>-->


<div style="border:1px solid #e5e5e5;padding: 5px;width:800px;margin: 0px auto;background-color: #ffffff" class=" hero-unit">
    <h4 style="padding-left: 10px;width: 300px;float: left">Ready Problem Set</h4>
    <!--<span style="float: right;width: 50px"><span class="label label-success">Ready</span></span>-->
    <div style="clear: both"></div>
    <ul id="ready" class="connectedSortable" style="padding: 5px ;width: 100%">

        <?php foreach($notready_list as $id): ?>
        <li class="problemset_block ui-state-disabled" id="<?php echo $problemset[$id]["problemset_id"] ; ?>">

            <h5>
                <!--<li class="icon-move"></li>-->&nbsp;<?php echo $problemset[$id]["problemset_name"];?>
                <span class="label label-important">Not Ready</span>

                <span style="float: right;margin-top: -4px">

                            <!--<a class="btn btn-danger" style="width: 50px;z-index:9999999"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">Edit</a>
                        <!--<a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>-->&nbsp;
                    </span>
            </h5></li>
        <?php endforeach  ?>

<?php foreach($ready_list as $id): ?>
               <li class="problemset_block" id="<?php echo $problemset[$id]["problemset_id"] ; ?>">

                   <h5>
                       <li class="icon-move"></li> &nbsp;<?php echo $problemset[$id]["problemset_name"];?>

                    <span style="float: right;margin-top: -4px">

                            <a class="btn btn-primary" style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">View</a>
                        <!--<a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>-->&nbsp;
                    </span>
                </h5></li>
            <?php endforeach  ?>
        </ul>
</div>

<br/>
<div style="border:1px solid #e5e5e5;padding: 5px;width:800px;margin: 0px auto;background-color: #ffffff" class="hero-unit">
<h4 style="padding-left:10px;float: left ">Assigned Assignment</h4>
    <!--<span style="float: right;width: 90px;text-align: right"><span class="label label-warning">Assigned</span></span>-->
    <div style="clear: both"></div>

    <ul id="assigned" class="connectedSortable" style="padding: 5px ;">
    <?php if($assigned_list == array() ) { ?>
        <?php } ?>
            <?php foreach($assigned_list as $id): ?>
        <li class="problemset_block" id="<?php echo $problemset[$id]["problemset_id"] ; ?>">
            <h5><li class="icon-move"></li> &nbsp;<?php echo $problemset[$id]["problemset_name"];?>

                    <span style="float: right; margin-top: -4px;">

                            <a class="btn btn-primary" style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">View</a>
                        <!--<a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>-->&nbsp;
                    </span>

        </h5></li>
            <?php endforeach  ?>
</ul>
</div>
<br/>
<div style="border:1px solid #e5e5e5;padding: 5px;width:800px;margin: 0px auto;background-color: #ffffff" class="hero-unit">
    <h4 style="padding-left: 10px;float: left">Released Assignment</h4>
    <!--<span style="float: right;width: 90px;text-align: right"><span class="label label-important">Released</span></span>-->
    <div style="clear: both"></div>

    <ul id="released" class="connectedSortable" style="padding: 5px ;">
        <?php foreach($released_list as $id): ?>
        <li class="problemset_block" id="<?php echo $problemset[$id]["problemset_id"] ; ?>">
            <h5><?php echo $problemset[$id]["problemset_name"];?>

                <span style="float: right;margin-top: -4px">

                            <a class="btn btn-primary" style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">View</a>
                        <!--<a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>-->&nbsp;
                    </span>

            </h5></li>
        <?php endforeach  ?>
    </ul>
</div>
<br/>
<div style="border:1px solid #e5e5e5;padding: 5px;width:800px;margin: 0px auto;background-color: #ffffff" class="hero-unit">
    <h4 style="padding-left: 10px;float: left">Ended Assignment</h4>

    <!--<span style="float: right;width: 90px;text-align: right"><span class="label">Released</span></span>-->
    <div style="clear: both"></div>
    <ul id="ended" class="connectedSortable" style="padding: 5px ;">
        <?php foreach($ended_list as $id): ?>
        <li class="problemset_block" id="<?php echo $problemset[$id]["problemset_id"] ; ?>">
            <h5><?php echo $pbs["problemset_name"];?>
                <span style="float: right;margin-top: -4px">

                            <a class="btn btn-primary" style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">View</a>
                       <!-- <a id="remove_btn<?php echo $pbs["problemset_id"]; ?>" class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>-->&nbsp;
                    </span>
                <span class="label">Ended</span>
            </h5>
        </li>
        <?php endforeach  ?>
    </ul>
</div>

<br/>



