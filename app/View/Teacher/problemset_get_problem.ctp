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
<!--<h3>Problem</h3>-->
&nbsp;
<?php
$i=1;
?>
<?php foreach($problemArr as $pbs): ?>
    <?php
    $middle = count($pbs)/2;
    ?>
        <!--<tr style="background-color: #efefef"><td><span><strong><h4><?php echo $i++ ?></h4></strong></span></td></tr>-->
        <li class="problemset2_block problem_queue" id="<?php echo $pbs[$middle]["problem_id"] ?>">
            <?php
            $latexTemp = str_replace("$$","",$pbs[$middle]["main_text"]);
            //pr($latexTemp);
            $arg = $pbs[$middle]["main_text"];
            $id = $pbs[$middle]["problem_level_id"];
            ?>
           <!-- <div style="width: 200px;float: left"> <?php echo $arg ; ?></div>-->
            <div style="width:220px;float: left;word-wrap: break-word">
                <?php
                    $latex = $arg ;
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
                <a href="#" rel="popover" id="latex<?php echo $id ; ?>" data-content="<?php echo $arg;?>" class="btn btn-mini btn-success">View</a>
            </div>
            <!--<span style="float: right" id="button<?php echo $id ; ?>">
             <!--   <a class="btn" href="javascript:addProblem('<?php echo $arg ;?>','<?php echo $id ; ?>')">Add</a></span>
            <!--<span style="visibility: hidden" id="latexTemp<?php echo $pbs[$middle]['problem_level_id'] ;?>"><?php echo $latexTemp ; ?></span>-->
            <input type="hidden" value="<?php echo $latexTemp ; ?>" id="latexTemp<?php echo $pbs[$middle]['problem_level_id'] ;?>">
        </li>


<?php endforeach ?>
