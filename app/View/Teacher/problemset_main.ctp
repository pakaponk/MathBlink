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

<h3 style="padding: 10px;border-bottom: 1px solid #e5e5e5;margin-left: 50px;margin-right: 50px">
    Problem set
    <span style="float: right">
    <a class="btn btn-primary" href="<?php echo  $this->Html->url(array(
        'controller' => 'Teacher' ,
        'action' => 'create_problemset'
    )) ;?> ">Create new</a>
    </span>
</h3>


<div style="padding: 10px;width:800px;margin: 0px auto;">
    <table class="table table-bordered table-hover" >
        <tbody>
<?php foreach($problemset_arr["ProblemSet"] as $pbs): ?>
        <tr>
            <td>
                <h4><?php echo $pbs["problemset_name"];?>

                    <span style="float: right; margin-top: -20px;">
<br/>
                            <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url('/problem_set/view/'.$pbs["problemset_id"]); ?>">View</a>
                            <br/><br/>
                        <a class="btn " style="width: 50px"  href="<?php echo $this->Html->url(array(
                            'controller' => 'problem_set',
                            'action' =>'del',
                            $pbs["problemset_id"]
                        )); ?>">Delete</a>
                    </span><br/>
                <small>
                    Course <?php echo $course_list[ $pbs["course_id"] ] ; ?>
                    <div style=" width: 630px; word-wrap: break-word"><?php echo $pbs["guideline"];?></div>
                </small>
                </h4>
                <?php
                if($pbs["ready"] == 1){
                    echo "<span class=\"label label-success\">Ready</span>";
                }else{
                    echo "<span class=\"label label-important\">Creating</span>";
                }
                ?>
            </td>
        </tr>
            <?php endforeach  ?>
        </tbody>
    </table>



</div>