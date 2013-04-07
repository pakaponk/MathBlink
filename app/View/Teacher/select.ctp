<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 4/2/13 AD
 * Time: 5:05 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<script>
    $(document).ready(function () {
        //alert("The DOM is now loaded and can be manipulated.");
        //$('#selectCourseDiv').show();
       // $("#selectCourseDiv").fadeIn("slow");
      //  $('#bg').fadeIn("slow");
    });
</script>

<h3 style="padding: 10px;border-bottom: 1px solid #e5e5e5;margin-left: 50px;margin-right: 50px">
    Assignment Portal
    <span style="float: right">
    <a class="btn btn-primary" href="javascript:open_select_course_class()">Select Course/Classroom</a>

            <a class="btn btn-primary" href="<?php echo  $this->Html->url(array(
                'controller' => 'teacher' ,
                'action' => 'problemset_management'
            )) ;?> ">Problem Set Management</a>

    </span>
</h3>

<div id="selectCourseDiv" style="position:relative;z-index:20010;padding: 10px;
margin-left: 50px;margin-right: 50px;width:600px;margin: 0px auto;display: none;background-color: #FAFAFA
;text-align: center" class="hero-unit">
    <h3 style="">Select a Course to Display

        <a style="font-size: 15px" class="muted" href="javascript:close_select_course_class()">
            <button class="close" style="font-size: 15px">&times; close</button></a>

    </h3>
    <?php foreach($course_list as $key => $list){?>
        <a href="javascript:get_class(<?php echo $key ;?>)" id="bt<?php echo $key ?>" class="btn btn-large"><?php echo $list ; ?></a>
    <?php } ?>

<div id="selectClassDiv"></div>
</div>




