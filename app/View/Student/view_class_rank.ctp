<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Class <?php echo $classroom_name; ?> Ranking</h3>

<div style="padding: 10px">

<?php 
	if(!empty($top10List)){
		?>
	<table class="table table-bordered" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">
		<thead>
			<th style="text-align:center;">Rank No.</th>
			<th>Student Name</th>
		</thead>
		<tbody>
			<?php 
			$length = count($top10List);
			for($i=0;$i<$length;$i++){
				if($top10List[$i]['Users']['id'] == $student_id){
					echo '<tr class="alert-success">';
					echo '<td style="width:10%;text-align:center;">';
					echo $i+1;
					echo '</td>';
				
					echo '<td>';
					echo $top10List[$i]['Users']['title'].$top10List[$i]['Users']['first_name'].' '.$top10List[$i]['Users']['last_name'];
					echo '<span class="label label-success pull-right">Your Rank</span>';
				
					echo '</td>';
				
					echo '</tr>';
				}else{
					echo '<tr>';
				
					echo '<td style="width:10%;text-align:center;">';
					echo $i+1;
					echo '</td>';
				
					echo '<td>';
					echo $top10List[$i]['Users']['title'].$top10List[$i]['Users']['first_name'].' '.$top10List[$i]['Users']['last_name'];
	
					echo '</td>';
				
					echo '</tr>';
				}
			}
			if ($complete_assignment){
				if(!$beTop10){
					echo '<tr class="alert alert-block">';
					echo '<td style="width:10%;text-align:center;">';
					echo $student[0]['Student']['rank'];
					echo '</td>';
				
					echo '<td>';
					echo $student[0]['Student']['title'].$student[0]['Student']['first_name'].' '.$student[0]['Student']['last_name'];
					echo '<span class="label label-important pull-right">Your Rank</span>';
					echo '</td>';
				
					echo '</tr>';
				}
			}
			?>
		</tbody>
	</table>
	<?php
		if(!$complete_assignment){
			echo '<div class="alert alert-error" style="margin-top:20px;">';
			echo 'You\'re not complete all of assignments';
			echo '</div>';
		}
	}else {
		echo '<div class="alert alert-error">';
		echo 'No one has complete all of assignments';
		echo '</div>';
		} ?>
</div>
