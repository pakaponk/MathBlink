<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/20/13 AD
 * Time: 1:11 PM
 * To change this template use File | Settings | File Templates.
 */
//pr($problemArr["Problem"]);

$salt = rand()%1000;
?>


    <script>
        MathJax.Hub.Typeset();
        for(var i=0;i<problemCount;i++){
            if(problemStatus[i] == "add"){
                /*
                TODO:Change .val to .html()
                 */
                changeStatus('$$'+ $('#latexTemp'+problemId[i]).val()+'$$' , problemId[i] );
            }
        }
        $(function() {


        $( "#problemset_array tbody,#pq tbody" ).sortable({
            connectWith: ".table .table-hover .connectedSortable",
            dropOnEmpty: true,
            placeholder: "assignment_drag_hover",
            start : function(event, ui){

            },
            stop : function(event, ui){



                //console.dir(event);
                ///
            },
            cancel: ".ui-state-disabled",
            receive: function( event, ui ) {

            }
        }).disableSelection();

        });

    </script>

<!--<script type="text/x-mathjax-config">
    MathJax.Hub.Config({tex2jax: {inlineMath: [['$$','$$'], ['\\(','\\)']]}});
</script>
-->
<!--<script type="text/x-mathjax-config">
    MathJax.Hub.Config({tex2jax: {inlineMath: [['$$','$$'], ['\\(','\\)']]}});
</script>-->





<!--<script>
    $(function () {
        $(".latex").latex();
    });
</script>-->
<div style="width: 330px;float: left" id="problem_header">
<h3>Problem</h3>
<?php
if($problemArr == array()){
    echo "<h4 style='color: #999999'>empty problem</h4>";
}
$i=1;
?>
<table class="table table-hover connectedSortable" style="padding: 10px;margin-bottom: 5px" id="problemset_array" >
<tbody>
<?php foreach($problemArr as $pbs): ?>
        <!--<tr style="background-color: #efefef"><td><span><strong><h4><?php echo $i++ ?></h4></strong></span></td></tr>-->
        <tr class="drag_problem_sortable_row" style="background-color: #Efefef;cursor: pointer">
            <td>
            <?php
            $middle = count($pbs)/2;
            $latexTemp = str_replace("$$","",$pbs[$middle]["main_text"]);
            //pr($latexTemp);
            $arg = $pbs[$middle]["main_text"];
            $id = $pbs[$middle]["problem_level_id"];
            ?>
            <div style="width: 200px;float: left"> <?php echo $arg ; ?></div>
            <span style="float: right" id="button<?php echo $id ; ?>"><a class="btn" href="javascript:addProblem('<?php echo $arg ;?>','<?php echo $id ; ?>')">Add</a></span>
            <!--<span style="visibility: hidden" id="latexTemp<?php echo $pbs[$middle]['problem_level_id'] ;?>"><?php echo $latexTemp ; ?></span>-->
            <input type="hidden" value="<?php echo $latexTemp ; ?>" id="latexTemp<?php echo $pbs[$middle]['problem_level_id'] ;?>">
        </td>
        </tr>

          <!--<?php foreach($pbs as $pb_level): ?>
            <tr><td>
                <h4>Level <?php echo $pb_level["level_id"] ; ?></h4>
            <?php
                $latexTemp = str_replace("$$","",$pb_level["main_text"]);
                //pr($latexTemp);
                $arg = $pb_level["main_text"];
                $id = $pb_level["problem_level_id"];
                echo '<div class="latex">'.$pb_level["main_text"]."</div>" ;
            ?>
                <div style="visibility: hidden" id="latexTemp<?php echo $pb_level['problem_level_id'] ;?>"><?php echo $latexTemp ; ?></div>
                <span style="float: right" id="button<?php echo $id ; ?>"><a class="btn" href="javascript:addProblem('<?php echo $arg ;?>','<?php echo $id ; ?>')">Add</a></span>
            </td></tr>
        <?php endforeach ?>-->



<?php endforeach ?>
</tbody>

</table>
</div>


    <div style="clear: both"></div>