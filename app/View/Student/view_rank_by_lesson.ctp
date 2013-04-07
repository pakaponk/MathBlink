<ul class="breadcrumb" style="background-color:#FFF;padding-top: 20px;">
	<li><a href="<?php echo $this->Html->url('/student/leaderboard'); ?>">Leaderboard</a>
		<span class="divider">/</span></li>
	<li class="active">Class & Course Ranking by Lesson <?php echo $lesson_name; ?>
	</li>
</ul>

<div class="row-fluid">
	<div class="span6">
		<h5>
			<i class="icon-signal"></i>Class
			<?php echo $classroom_name; ?>
			Ranking of Lesson
			<?php echo $lesson_name; ?>
		</h5>
		<table class="table table-hover" id="rank">
			<thead>
				<th>No.</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Total Score</th>
			</thead>
			<tbody>
				<?php 
				for($i=0;$i<count($top10ClassList);$i++){
					if($top10ClassList[$i]['User']['student_id'] == $student_id){
						echo '<tr class="success">';
						echo '<td>';
						echo $i+1;
						echo '</td>';

						echo '<td>';
						echo $top10ClassList[$i]['User']['first_name'];
						echo '</td>';

						echo '<td>';
						$top10ClassList[$i]['User']['last_name'];
						echo '</td>';

						echo '<td>';
						echo $top10ClassList[$i][0]['total_score'];
						echo '<span class="label label-success pull-right">Your Rank</span>';
						echo '</td>';

						echo '</tr>';
					}else{
						echo '<tr>';

						echo '<td>';
						echo $i+1;
						echo '</td>';

						echo '<td>';
						echo $top10ClassList[$i]['User']['first_name'];
						echo '</td>';

						echo '<td>';
						$top10ClassList[$i]['User']['last_name'];
						echo '</td>';

						echo '<td>';
						echo $top10ClassList[$i][0]['total_score'];
						echo '</td>';

						echo '</tr>';
					}
				}
				if(!$beTop10InClass && !empty($studentClass)){
					echo '<tr class="success">';
					echo '<td>';
					echo $studentClass[0]['Student']['rank'];
					echo '</td>';

					echo '<td>';
					echo $studentClass[0]['Student']['first_name'];
					echo '</td>';

					echo '<td>';
					$studentClass[0]['Student']['last_name'];
					echo '</td>';

					echo '<td>';
					echo $studentClass[0][0]['total_score'];
					echo '<span class="label label-success pull-right">Your Rank</span>';
					echo '</td>';

					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>

	<div class="span6">
		<h5>
			<i class="icon-signal"></i>Course Ranking of Lesson
			<?php echo $lesson_name; ?>
		</h5>
		<table class="table table-hover" id="rank">
			<thead>
				<th>No.</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Total Score</th>
			</thead>
			<tbody>
				<?php 
				for($i=0;$i<count($top10CourseList);$i++){
				if($top10CourseList[$i]['User']['student_id'] == $student_id){
					echo '<tr class="success">';

					echo '<td>';
					echo $i+1;
					echo '</td>';

					echo '<td>';
					echo $top10CourseList[$i]['User']['first_name'];
					echo '</td>';

					echo '<td>';
					echo $top10CourseList[$i]['User']['last_name'];
					echo '</td>';

					echo '<td>';
					echo $top10CourseList[$i][0]['total_score'];
					echo '<span class="label label-success pull-right">Your Rank</span>';
					echo '</td>';

					echo '</tr>';
				}else{
					echo '<tr>';

					echo '<td>';
					echo $i+1;
					echo '</td>';

					echo '<td>';
					echo $top10CourseList[$i]['User']['first_name'];
					echo '</td>';

					echo '<td>';
					echo $top10CourseList[$i]['User']['last_name'];
					echo '</td>';

					echo '<td>';
					echo $top10CourseList[$i][0]['total_score'];
					echo '</td>';

					echo '</tr>';
				}
			}
			if(!$beTop10InCourse && !empty($studentCourse)){
					echo '<tr class="success">';
					echo '<td>';
					echo $studentCourse[0]['Student']['rank'];
					echo '</td>';

					echo '<td>';
					echo $studentCourse[0]['Student']['first_name'];
					echo '</td>';
						
					echo '<td>';
					$studentCourse[0]['Student']['last_name'];
					echo '</td>';
						
					echo '<td>';
					echo $studentCourse[0][0]['total_score'];
					echo '<span class="label label-success pull-right">Your Rank</span>';
					echo '</td>';

					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>








