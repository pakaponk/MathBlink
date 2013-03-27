<ul class="breadcrumb"
	style="background-color: #FFF; padding: 10px; margin-left: 50px; padding-top: 20px; margin-right: 50px; margin-bottom: -10px;">
	<li><?php echo $this->Html->link('Course',array(
			'controller' => 'course',
			'action' => 'index')); ?> <span class="divider">/</span>
	</li>
	<li class="active"><?php echo 'Course '.$course_name; ?>
	</li>
</ul>
<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	<?php echo $course[0]['Course']['course_name']; ?>
	Course <span style="float: right"> <a class="btn btn-primary "
		href='<?php echo $this->html->url(array(
        'controller' => 'lesson' ,
        'action' => 'add'
    )).'/'.$course[0]['Course']['course_id']; ?>'>Add new lesson</a> <a
		class="btn"
		href='<?php echo $this->html->url(array(
            'controller' => 'lesson' ,
            'action' => 'addWithList'
        )).'/'.$course[0]['Course']['course_id']; ?>'>Add exist lesson</a>
	</span>
</h3>

<div style="padding: 10px">

	<table class="table table-bordered" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">
		<th>Lesson ID</th>
		<th>Lesson Name</th>
		<th>Lesson Description</th>
		<th>Creator ID</th>
		<th>Topic</th>
		<?php
		foreach( $course[0]['Lesson'] as $lesson ){
		$lesson_id = $lesson['lesson_id'];
		$lesson_name = $lesson['lesson_name'];
		$lesson_description = $lesson['lesson_description'];
		$creator_id = $lesson['creator_id'];

		echo '<tr>';
		echo '<td>'.$lesson_id.'</td>';
		echo '<td>'.$lesson_name.'</td>';
		echo '<td>'.$lesson_description.'</td>';
		echo '<td>'.$creator_id.'</td>';
		echo '<td><a class="btn btn-mini" href="'.$this->html->url('/topic/index').'/'.$course_id.'/'.$lesson_id.'">See Topic</a> ';
		?>
		<a class="btn btn-mini"
			href='<?php echo $this->html->url('/lesson/edit/'.$lesson_id.'/'.$course[0]['Course']['course_id']);
				?>'>Edit Lesson</a>
		<a class="btn btn-mini"
			href='<?php echo $this->html->url('/lesson/del/'.$lesson_id.'/'.$course[0]['Course']['course_id']);
				?>'
			onclick="return confirm('Are you sure?')">Delete Lesson</a>
		<?php '</td>';
		echo '</tr>';
	}
	?>
	</table>
</div>
