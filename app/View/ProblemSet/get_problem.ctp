<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 4/5/13 AD
 * Time: 3:59 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<script>
    MathJax.Hub.Typeset();
</script>

    <?php
    //pr($problem_level);
?>

<?php  foreach($problem_level as $level): ?>
    <div style="padding: 10px;border-bottom: 1px solid #e5e5e5">
        <strong>Level <?php echo $level["ProblemLevel"]["level_id"] ; ?></strong>
           <?php echo $level["ProblemLevel"]["main_text"] ; ?>
        <div style="text-align: right">
            <strong>Amount</strong>&nbsp;&nbsp;
            <input type="number" style="width: 50px" value="0" id="amount<?php echo $level["ProblemLevel"]["problem_level_id"] ;  ?>">
        </div>
    </div>
<?php endforeach ?>
