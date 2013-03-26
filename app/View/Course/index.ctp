<h3
	style="padding: 10px; padding-top: 0px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Overview of all the courses <span style="float: right"> <a
		class="btn btn-primary"
		href='<?php echo $this->Html->url('/course/add/');?>'> Add Course </a>
	</span>
</h3>


<div style="padding: 10px">
	<table class="table table-bordered" cellpadding="10"
		style="text-align: center; width: 800px; margin: 0px auto;">
		<thead>
			<th>Course ID</th>
			<th>Course Name</th>
			<th>Course Description</th>
			<th>School ID</th>
			<th>Modify</th>
		</thead>
		<tbody>
			<?php
			foreach( $courses as $course ){
        $course_id = $course['Course']['course_id'];
        $course_name = $course['Course']['course_name'];
        $course_description = $course['Course']['course_description'];
        $school_id = $course['Course']['school_id'];

        echo '<tr>';
        echo '<td>'.$course_id.'</td>';
        echo '<td>'.$course_name.'</td>';
        echo '<td style="text-align: left;">'.$course_description.'</td>';
        echo '<td>'.$school_id.'</td>';
        echo '<td><a class="btn btn-mini" href="'.$this->Html->url('/lesson/index').'/'.$course_id.'">See Lesson</a>';
        ?>
			<a class="btn btn-mini"
				href='<?php echo $this->Html->url('/course/edit/'.$course_id);
               ?>'>Edit Course</a>
			<a class="btn btn-mini"
				href='<?php echo $this->Html->url('/course/del/'.$course_id);
               ?>'
				onclick="return confirm('Are you sure?')">Delete Course</a>
			<?php '</td>';
			echo '</tr>';
    }
    ?>
		</tbody>
	</table>
</div>
