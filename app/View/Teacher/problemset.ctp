<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/19/13 AD
 * Time: 1:52 PM
 * To change this template use File | Settings | File Templates.
 */
//pr($lesson_list);
$problemset_arr = $problemset_arr["ProblemSet"];
$course_arr = $course_arr["Course"];
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<style>
</style>
<?php

echo $this->Javascript->link('bootstrap');
echo $this->Javascript->link('bootstrap.min');
?>
<!--<a href="#" id="example_bottom" class="btn btn-success" rel="popover"
   data-content="$$x^2+3x$$"
   data-original-title="Twitter Bootstrap Popover">hover for popover</a>-->
<script>
    var is_add = false ;
    var currently_item ;
    var len ;
    $(function() {
        if($('#pq li').length == 0 ){
            //$('#pq').html("<li>Empty</li>");
        }

        $('#trash').droppable({
            drop: function(event, ui) {
                //alert( $( ui.item ).parent().attr("id"));
                //console.log($( ui.item).attr());
                $(ui.draggable).remove();
                //var target = event.target.classList;
                //alert(target);
            }
        });

        $( "#problemset_array ,#pq " ).sortable({
            connectWith: ".connectedSortable",
            dropOnEmpty: true,
            placeholder: "problemset_drag_hover",
            start : function(event, ui){
                currently_item = $(ui.item).attr("id");
                var a = $('#pq').find("."+currently_item);
                len = a.length;
                var target = event.target.id;

                if(len !=0 && target == "problemset_array"){
                    //$('#problemset_array').$('#'+currently_item).addClass('ui-state-disabled');
                    //$('#problemset_array').$('#'+currently_item);
                    moveAnimate("#problemset_array #"+currently_item, "#problemset_array");
                    $('#warning_add_exists').modal('show');
                }
                //alert(a.length);
                //alert(currently_item);
            },
            stop : function(event, ui){
               /* if( $('#pq').has('#'+currently_item)){
                    moveAnimate("#"+currently_item, "#problemset_array");
                }*/
                //console.dir(event);
                ///
            },
            cancel: ".ui-state-disabled",
            receive: function( event, ui ) {
                //alert(  $('#pq li').length );

                    var target = event.target.id;
                    //alert(currently_item);
                    if(target =="pq"){
                        var callUrl = '/mathblink/problem_set/get_problem/'+currently_item ;
                        $.ajax({
                            url: callUrl,
                            cache: false,
                            type: 'GET',
                            dataType: 'HTML',
                            success: function (data) {
                                $('#problemset_modal_body').html(data);
                            }
                        });
                        $('#add_to_problemset_modal').modal('show');
                    }
                    if(target == "problemset_array"){
                        moveAnimate("#"+currently_item, "#pq");
                    }

            }
        }).disableSelection();

        $('#add_to_problemset_modal').on('hidden', function () {
            if(!is_add){
                moveAnimate("#"+currently_item, "#problemset_array");
            }

            is_add = false ;
        });

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

    /*
    * TODO:Please change url here
    * */
    function save_add_to_problemset(){
        //alert("test");
        var problem_level_id ;
            $.ajax({
                url: "/mathblink/problem_set/get_problem_level_id_array/"+currently_item ,
                type: 'POST',
                dataType:"json",
                success: function(data) {
                    //alert(data);
                    //$('#debug').html(data);
                    problem_level_id = data;
                    var amount_value = new Array() ;
                    //alert(problem_level_id);
                    //amount+id
                    for(var i =0;i< problem_level_id.length ; i++){
                        amount_value[i] = $('#amount'+problem_level_id[i]).val();
                        //alert($('#amount'+problem_level_id[i]).val());
                    }
                    $('#add_to_problemset_modal').modal('hide');
                    /*
                    * TODO: send data to controller for saving new created problemset
                    * and done..
                    * */
                    //alert(amount_value);
                    //alert(problem_level_id[0] + " " + problem_level_id[1] + " " + problem_level_id[2]) ;
                }
            });

        //alert(currently_item);
        is_add = true ;
    }
</script>

<ul class="breadcrumb"
    style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
    <li><?php echo $this->Html->link('Problem Set',array(
        'controller' => 'teacher',
        'action' => 'problemset_main')); ?> <span class="divider">/</span></li>
    <li class="active"> <?php echo $this->Html->link($problemset_arr["problemset_name"],array(
        'controller' => 'problem_set',
        'action' => 'view' , $problemset_arr["problemset_id"])); ?>
        <span class="divider">/</span> </li>
    <li class="active">Edit Problem set</li>
</ul>
    <div id="debug" style="z-index: 20100"></div>

<h3 style="padding: 10px;margin-left: 50px;margin-right: 50px;border-bottom: 1px solid #e5e5e5">
    <?php echo $problemset_arr["problemset_name"]; ?> <!--<span class="badge badge-info">Step 2</span>-->
</h3>
<div style="padding: 10px;margin: 0px auto;margin-left: 40px">

    <div class="span5">
    <ul class="problemset_queue connectedSortable"  id="pq" style="padding: 0px;width:370px;margin-left: 0px">
        <li class="problemset2_block ui-state-disabled" style="text-align: center;border-top: 1px solid #e5e5e5">        <h4>Drag here to add</h4>        </li>

        <?php
        foreach($added_problem as $problem):
            $problem = $problem["ProblemLevel"];
            $latex = $problem["main_text"];
            $id = $problem["problem_level_id"];
            $id = $problem["problem_id"];
            ?>
            <li class="problemset2_block <?php echo $id; ?>" id="<?php echo $id; ?>">
                <script>
                    problemId[problemCount] = <?php echo $id ; ?>;
                    problemStatus[problemCount++] = "add" ;

                    $(function() {

                        $("#latex<?php echo $id ; ?>").popover({placement:'bottom'});
                        $("#latex<?php echo $id ;?>").click(function(){  MathJax.Hub.Typeset(); });
                    });
                </script>
                <div style="width:220px;float: left;word-wrap: break-word">
                    <?php
                        $len = strlen($latex);
                    if( $len > 50 ){
                        $str = str_replace("$$","",$latex);
                        $str = substr($str,0,50);
                        echo "$$".$str."....$$";
                       /*echo '<a href="#" id="latex'.$id.'" class="btn btn-success btn-mini" rel="popover"
                                data-content="'.$latex.'"
                                data-original-title="Twitter Bootstrap Popover">Full</a>';*/
                    }else{
                        echo $latex;
                    }
                    ?>

                </div>
                <div style="width: 110px;float: right;margin-top: 10px">
                    <a href="#" rel="popover" id="latex<?php echo $id ; ?>" data-content="<?php echo $latex;?>" class="btn btn-mini btn-success">View</a>
                    <a href="javascript:removeProblem('<?php echo $id ?>')" class="btn btn-mini">Remove</a>
                </div>
                <div style="clear: both"></div>
            </li>
          <?php endforeach ?>
    </ul>




        <ul id="trash" class="problemset_queue" style="padding: 0px;width:370px;margin-left: 0px">
            <li class="problemset2_block ui-state-disabled" style="text-align: center;border-top: 1px solid #e5e5e5"><h4>Drag here to remove</h4></li>
        </ul>
    </div>


    <!---Start--->
    <!--<div style="" class="span5" id="problemset_queue_wrapper">
        <div class="hero-unit connectedSortable" id="problemset_queue" style="padding: 10px">
            <h4>Problem Set
                <div style="float: right;margin-top: -10px">
                    <a href="javascript:save_problemset(<?php echo $problemset_arr["problemset_id"]; ?>);" class="btn btn-primary">Save</a>
                </div></h4>

            <?php
                foreach($added_problem as $problem):
                $problem = $problem["ProblemLevel"];
                $latex = $problem["main_text"];
                $id = $problem["problem_level_id"];
            ?>
            <script>
                problemId[problemCount] = <?php echo $id ; ?>;
                problemStatus[problemCount++] = "add" ;
            </script>

            <div class="drag_item" style="font-size: 13px;margin-bottom: -5px;border-bottom: 1px solid #b3b3b3" id="<?php echo $id ; ?>">
                <div style="width:200px;float: left"><?php echo $latex ; ?></div>
                <div style="width: 100px;float: right;margin-top: 10px">
                    <a href="javascript:removeProblem('<?php echo $latex ;?>','<?php echo $id ; ?>')" class="btn btn-mini">remove</a>
                </div>
            </div>
                <div style="clear:both"></div>
            <?php endforeach ?>

        </div>
    </div>
    <!---End--->




    <div style="" class="span5">
        <div class="hero-unit" style="padding: 5px;padding-left: 10px;margin-bottom: 5px">
        <h4 class="problemset_title">Course</h4>
        <h4 style="padding-bottom: 10px"><?php echo $course_arr["course_name"]; ?></h4>
        <h4><?php //echo $course_arr["course_description"]; ?></h4>
        <h4 class="problemset_title">Lesson</h4>
        <?php
        echo $this->Form->input('lesson_id',
            array(
                'empty' => '-- Select a Lesson --',
                'type'=>'select',
                'options'=>$lesson_list,
                'label'=>false,
                'style'=>'width:330px',
                'onchange'=>'javascript:problemsetGetTopic("/mathblink/teacher/problemsetGetTopic","lesson_id");'));
        /*  TODO :
            /mathblink/teacher/problemsetGetTopic should be changed next time we deploy
        */
        ?>
        <?php
        ?>
        <div id="TopicDiv"></div>
        <div id="ProblemDiv"></div>

        <div id="debug_save"></div>
        </div>

        <ul class="problemset_queue connectedSortable" style="padding: 10px;margin-bottom: 15px;margin-left: -10px;margin-top: -10px" id="problemset_array" >
        </ul>
    </div>




    <div id="add_to_problemset_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Add Problem To Problem Set</h3>
        </div>
        <div class="modal-body" id="problemset_modal_body">

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <a href="javascript:save_add_to_problemset()" class="btn btn-primary">Add to Problem Set</a>
        </div>
    </div>



    <div id="warning_add_exists" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>You have already added this problem</h3>
        </div>
        <div class="modal-body" id="warning_add_exists_body">

        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <!--<a href="javascript:save_add_to_problemset()" class="btn btn-primary">Add to Problem Set</a>-->
        </div>
    </div>





    <div id="problemset_problem_id" style="visibility: hidden"></div>
<div id="problemset_problem_status" style="visibility: hidden"></div>
    <div style="clear: both"></div>
</div>


