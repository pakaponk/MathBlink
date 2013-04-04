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




<script>
    //$('#3').tooltip('show');

    $(function() {
        var ready_count = $('#ready li').length ;
        var assigned_count = $('#assigned li').length;

        $( "#ready, #assigned" ).sortable({
            connectWith: ".connectedSortable",
            dropOnEmpty: true,
            start : function(event, ui){
                //alert("start");
                //get current element being sorted
            },
            stop : function(event, ui){

                var new_ready_count = $('#ready li').length ;

                var new_assigned_count = $('#assigned li').length;
                if( ready_count > new_ready_count ){
                    //alert("From ready to assign");
                    $.ajax({
                        url: callUrl,
                        cache: false,
                        type: 'GET',
                        dataType: 'HTML',
                        success: function (data) {}
                    });
                }
                if( assigned_count > new_assigned_count){
                    //alert("From assign to ready");
                    $.ajax({
                        url: callUrl,
                        cache: false,
                        type: 'GET',
                        dataType: 'HTML',
                        success: function (data) {}
                    });
                }
                //alert( ready_count +" " + assigned_count + " -> " + new_ready_count +" " +new_assigned_count);
                ready_count= new_ready_count;
                assigned_count = new_assigned_count;
                //alert(ready_count);
                //alert(assigned_count);
                //get current element being sorted
            },
            receive: function( event, ui ) {

                //This function is called whenever you drag between
                //your javascript here to update your property.
                //alert("foo");
            }
        }).disableSelection();
    });

</script>

<div style="display: none;background-color: #FAFAFA;padding: 20px;position: relative;
z-index: 10010;width:600px;margin: 0px auto;" id="selectCourseDiv">
    <h4>Please Select Course/Class to View</h4>
    <?php
        echo $this->Form->input('course_id',array('style'=>array('width'=>'500')));
    ?>

</div>

<h3 style="padding: 10px;border-bottom: 1px solid #e5e5e5;margin-left: 50px;margin-right: 50px">
    Assignment Portal
    <span style="float: right">
    <a class="btn btn-primary" href="<?php echo  $this->Html->url(array(
        'controller' => 'Teacher' ,
        'action' => 'create_problemset'
    )) ;?> ">Create New</a>
    <a class="btn" href="<?php echo  $this->Html->url(array(
        'controller' => 'Teacher' ,
        'action' => 'problemset_main'
    )) ;?> ">Choose New Course/Classroom</a>    </span>
</h3>

<div id="course_id" style="display: none"><?php echo $this->params["pass"][0] ;?></div>
<div id="class_id" style="display: none"><?php echo $this->params["pass"][1] ;?></div>

    <!--<div style="background-color#333333;color: #a1a1a1;margin-left: 50px;margin-right: 50px;width: 600px"><h4 style="padding: 10px">No Problem set</h4></div>-->


<div style="border:1px solid #e5e5e5;padding: 5px;width:800px;margin: 0px auto;background-color: #FAFAFA" class="hero-unit">
    <h4 style="padding-left: 10px;width: 300px;float: left">Ready Problem Set</h4>
    <span style="float: right;width: 50px"><span class="label label-success">Ready</span></span>
    <div style="clear: both"></div>
    <ul id="ready" class="connectedSortable" style="padding: 5px ;">
<?php foreach($ready_list as $id): ?>
               <li class="problemset_block" id="<?php echo $problemset[$id]["problemset_id"] ; ?>">
                   <h5><?php echo $problemset[$id]["problemset_name"];?>

                    <span style="float: right;margin-top: -4px">

                            <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">View</a>
                        <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>
                    </span>
                </h5></li>
            <?php endforeach  ?>
        </ul>
</div>

<br/>
<div style="border:1px solid #e5e5e5;padding: 5px;width:800px;margin: 0px auto;background-color: #FAFAFA" class="hero-unit">
<h4 style="padding-left:10px;float: left ">Assigned Assignment</h4>
    <span style="float: right;width: 90px;text-align: right"><span class="label label-warning">Assigned</span></span>
    <div style="clear: both"></div>

    <ul id="assigned" class="connectedSortable" style="padding: 5px ;">
    <?php if($assigned_list == array() ) { ?>
        <?php } ?>
            <?php foreach($assigned_list as $id): ?>
        <li class="problemset_block">        <h5><?php echo $problemset[$id]["problemset_name"];?>

                    <span style="float: right; margin-top: -4px;">

                            <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">View</a>
                        <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>
                    </span>

        </h5></li>
            <?php endforeach  ?>
</ul>
</div>
<br/>
<div style="border:1px solid #e5e5e5;padding: 5px;width:800px;margin: 0px auto;background-color: #FAFAFA" class="hero-unit">
    <h4 style="padding-left: 10px;float: left">Released Assignment</h4>
    <span style="float: right;width: 90px;text-align: right"><span class="label label-important">Released</span></span>
    <div style="clear: both"></div>

    <ul id="released" class="connectedSortable" style="padding: 5px ;">
        <?php foreach($released_list as $id): ?>
        <li class="problemset_block" id="<?php echo $problemset[$id]["problemset_id"] ; ?>">
            <h5><?php echo $problemset[$id]["problemset_name"];?>

                <span style="float: right;margin-top: -4px">

                            <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">View</a>
                        <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>
                    </span>

            </h5></li>
        <?php endforeach  ?>
    </ul>
</div>
<br/>
<div style="border:1px solid #e5e5e5;padding: 5px;width:800px;margin: 0px auto;background-color: #FAFAFA" class="hero-unit">
    <h4 style="padding-left: 10px;float: left">Ended Assignment</h4>

    <span style="float: right;width: 90px;text-align: right"><span class="label">Released</span></span>
    <div style="clear: both"></div>
    <ul id="ended" class="connectedSortable" style="padding: 5px ;">
        <?php if($ended_list == array() ) { ?>
        <li id="empty_4" class="empty_problemset">Empty</li>
        <?php } ?>
        <?php foreach($ended_list as $id): ?>
        <li class="problemset_block" id="<?php echo $problemset[$id]["problemset_id"] ; ?>">
            <h5><?php echo $pbs["problemset_name"];?>

                <span style="float: right;margin-top: -4px">

                            <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$problemset[$id]["problemset_id"]); ?>">View</a>
                        <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $problemset[$id]["problemset_id"]
                        )); ?>">Delete</a>
                    </span>
                <span class="label">Ended</span>

            </h5></li>
        <?php endforeach  ?>
    </ul>
</div>

<br/>



