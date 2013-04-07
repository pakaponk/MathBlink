<h3
	style="padding: 10px; margin-left: 50px; margin-right: 50px; border-bottom: 1px solid #e5e5e5">Leaderboard</h3>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: CloudStrife
 * Date: 30/3/2556
 * Time: 10:45 น.
 * To change this template use File | Settings | File Templates.
 */

echo $this->Html->script("jquery-1.9.1.min.js");
echo $this->Html->script('bootstrap.js');
echo $this->Html->script('bootstrap.min.js');
?>

<div class="row-fluid">

	<div class="span4" style="padding-left: 5%;">
		<div id="navbarExample">
			<ul class="nav nav-list">
				<li class="nav-header">Course</li>
				<li class="active"><a href="#classleaderboard"">Leader Board -
						Classroom <?php echo $classroom_name; ?>
				</a></li>

				<?php foreach ($course_list AS $course):?>
				<li><a
					href="#course<?php echo $course['CoursesClassroom']['course_id']; ?>"><?php echo $course['Course']['course_name']; ?>
				</a>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>

	<div class="span8">
		<div id="headerText">
			<h5 id="classleaderboard">
				<i class="icon-road"></i>Leader Board - Classroom
				<?php echo $classroom_name; ?>
			</h5>
		</div>
		<table class="table table-hover" id="rank" style="width: 90%">
			<thead>
				<th>No.</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Total Score</th>
			</thead>

			<tbody>
				<?php
				$classroom_num = count($leaderboard['List']);
				for ($i=0;$i<$classroom_num;$i++):
				?>
				<?php if($leaderboard['List'][$i]['User']['student_id'] == $leaderboard['Student']['student_id']): ?>
				<tr class="success">
					<td><?php echo $i+1 ?></td>
					<td><?php echo $leaderboard['List'][$i]['User']['first_name'] ?></td>
					<td><?php echo $leaderboard['List'][$i]['User']['last_name']; ?></td>
					<td><?php echo $leaderboard['List'][$i][0]['total_score']; ?></td>
				</tr>
				<?php endif ?>
				<?php if ($leaderboard['List'][$i]['User']['student_id'] != $leaderboard['Student']['student_id']): ?>
				<tr>
					<td><?php echo $i+1 ?></td>
					<td><?php echo $leaderboard['List'][$i]['User']['first_name'] ?></td>
					<td><?php echo $leaderboard['List'][$i]['User']['last_name']; ?></td>
					<td><?php echo $leaderboard['List'][$i][0]['total_score']; ?></td>
				</tr>
				<?php endif ?>
				<?php endfor ?>
			</tbody>
		</table>
	</div>
</div>
<hr />
<div class="row-fluid">
	<?php $i=0;?>
	<?php foreach ($course_list AS $course):
		$course_id = $course['CoursesClassroom']['course_id']; ?>
	<div class="span8" style="padding-left: 5%;">
		<div id="headerText">
			<h5
				id="course<?php echo $course['CoursesClassroom']['course_id']; ?>">
				<i class="icon-road"></i>Course
				<?php echo $course['Course']['course_name']; ?>
			</h5>
		</div>
		<ul class="nav nav-tabs" id="course<?php echo $course_id;?>tab">
			<li class="active"><a href="#course<?php echo $course_id; ?>class" data-toggle="pill">Class
					Rank</a></li>
			<li><a href="#course<?php echo $course_id; ?>course" data-toggle="pill">Course Rank</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active fade in"
				id="course<?php echo $course_id; ?>class">
				<table class="table table-hover" id="rank">
					<thead>
						<th>No.</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Total Score</th>
					</thead>
					<tbody>
						<?php for($j=0;$j<count($studentClassRankList[$i]['List']) && ($j<5);$j++):?>
						<?php $list = $studentClassRankList[$i]['List'][$j]; ;?>
						<?php if($list['User']['student_id'] == $student_id):?>
						<tr class="success">
							<?php else: ?>
						
						
						<tr>
							<?php endif ?>
							<td><?php echo $j+1;?></td>
							<td><?php echo $list['User']['first_name'];?></td>
							<td><?php echo $list['User']['last_name'];?></td>
							<td><?php echo $list[0]['total_score'];?></td>
						</tr>
						<?php endfor ?>
						<?php if(!empty($studentClassRankList[$i]['Student']) && ($studentClassRankList[$i]['Student'][0]['Student']['rank'] > 10)):?>
						<tr class="success">
							<td><?php echo $studentClassRankList[$i]['Student'][0]['Student']['rank'];?>
							</td>
							<td><?php echo $studentClassRankList[$i]['Student'][0]['Student']['first_name'];?>
							</td>
							<td><?php echo $studentClassRankList[$i]['Student'][0]['Student']['last_name'];?>
							</td>
							<td><?php echo $studentClassRankList[$i]['Student'][0]['Student']['total_score'];?>
							</td>
						</tr>
						<?php endif ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade in" id="course<?php echo $course_id; ?>course">
				<table class="table table-hover" id="rank">
					<thead>
						<th>No.</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Total Score</th>
					</thead>
					<tbody>
						<?php for($j=0;$j<count($studentCourseRankList[$i]['List']) && ($j<5);$j++):?>
						<?php $list = $studentCourseRankList[$i]['List'][$j]; ;?>
						<?php if($list['User']['student_id'] == $student_id):?>
						<tr class="success">
							<?php else: ?>
						
						
						<tr>
							<?php endif ?>
							<td><?php echo $j+1;?></td>
							<td><?php echo $list['User']['first_name'];?></td>
							<td><?php echo $list['User']['last_name'];?></td>
							<td><?php echo $list[0]['total_score'];?></td>
						</tr>
						<?php endfor ?>
						<?php if(!empty($studentCourseRankList[$i]['Student']) && ($studentCourseRankList[$i]['Student'][0]['Student']['rank'] > 10)):?>
						<tr class="success">
							<td><?php echo $studentCourseRankList[$i]['Student'][0]['Student']['rank'];?>
							</td>
							<td><?php echo $studentCourseRankList[$i]['Student'][0]['Student']['first_name'];?>
							</td>
							<td><?php echo $studentCourseRankList[$i]['Student'][0]['Student']['last_name'];?>
							</td>
							<td><?php echo $studentCourseRankList[$i]['Student'][0]['Student']['total_score'];?>
							</td>
						</tr>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="span3">
		<table class="table table-hover">
			<thead>
				<div id="headerText" style="padding: 2px; padding-left: 5px;">
					<h5>Rank by Lesson</h5>
				</div>
			</thead>
			<tbody>
				<?php for($j=0;$j<count($lesson_list[$i]);$j++): ?>
				<?php $lesson = $lesson_list[$i][$j];?>
				<tr>
					<td><strong><?php echo $lesson['Lesson']['lesson_name']; ?> </strong><span
						class="pull-right"><a
							href="<?php echo $this->Html->url('/student/view_rank_by_lesson/'.$lesson['CoursesLesson']['lesson_id']); ?>">
								<i class="icon-signal" style="margin-top: -3px;"></i>
						</a> </span></td>
				</tr>
				<?php endfor ?>
			</tbody>
		</table>
	</div>
	<?php endforeach ?>
	<script>
    	$('a[data-toggle="pill"]').on('shown', function (e) {
    		e.target.addClass("active"); // activated tab
    		e.relatedTarget.removeClass('active');
        });
    </script>
	<div style="clear: both"></div>
</div>