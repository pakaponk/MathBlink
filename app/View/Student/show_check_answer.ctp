
<h3
	style="padding: 10px; margin-right: 50px; margin-left: 50px; border-bottom: 1px solid #e5e5e5">
	Score Summary</h3>

<div style="padding: 10px">
	<table style="width: 800px; cellspacing: 10px;">

		<?php 
		$i=1;
		foreach($studentAssignmentList as $studentAssignment){
			$input_num = $studentAssignment['ProblemLevel']['input_num'];
			$output_num = $studentAssignment['ProblemLevel']['output_num'];
			$dataset = $studentAssignment['ProblemDataSet']['dataset'];
			$student_answer = $studentAssignment['StudentsAssignment']['student_answer'];
			$dataset = explode(",", $dataset);
			$answer = explode(",", $student_answer);
			$solveList = array_slice($dataset, $output_num);
			$dataList = array_slice($dataset, 0 , $output_num);
			$answerStatus = $studentAssignment['StudentsAssignment']['answer_status'];

			// Main text Algorithm
			$main_text = $studentAssignment['ProblemLevel']['main_text'];
            $start = 0;
            for($k=1,$j=0;$k<=$output_num;$k++){
                $find = 'o_{' . "$k" . "}";
                if ($k<$output_num)
                    $main_text = str_replace($find,$dataList[$j++],$main_text);
                else
                    $main_text = str_replace($find,$dataList[$j++],$main_text);
            }

            $start = 0;
            for ($k=1;$k <= $input_num;$k++)
            {
                $find = 'i_{' . "$k" . "}";
                $main_text = str_replace($find,'\Box ',$main_text);
            }


			echo '<tr><table class="table table-bordered" cellpadding="10"
					style="width: 800px; margin: 0px auto; margin-bottom: 20px;">';
			if($answerStatus == 1){
				echo '<tr>';
				echo '<td rowspan="2" width="300"><span class="badge">'.$i.'</span> ';
				echo $main_text;
				echo '</td>';
				echo '<td class="alert-success">Answer : ';
				foreach ((array)$answer as $ans){
					echo $ans.' ';
				}
				echo '<span class="label label-success pull-right">Correct</span></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Solve : ';
				foreach ((array)$solveList as $solve){
					echo $solve.' ';
				}
				echo '</td>';
				echo '</tr>';
			}else{
				echo '<tr>';
				echo '<td rowspan="2" width="300"><span class="badge">'.$i.'</span> ';
				echo $main_text;
				echo '</td>';
				echo '<td class="alert-error">Answer : ';
				foreach ((array)$answer as $ans){
					echo $ans.' ';
				}
				echo '<span class="label label-important pull-right">Wrong</span></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Solve : ';
				foreach ((array)$solveList as $solve){
					echo $solve.' ';
				}
				echo '</td>';
				echo '</tr>';
			}
			$i++;
			echo '</table></tr>';
		}

		echo '<tr><table class="table table-bordered" cellpadding="10"
						style="width: 800px; margin: 0px auto; margin-bottom: 20px;">';
		echo '<tr><td style="text-align: center;">';
		echo '<h4>Score Summary : '.$totalScore.' / '.$totalQuestion.'</h4>';
		echo '</tr></td>';
		echo '<tr><td style="text-align: center;">';
		echo '<div class="progress progress-success progress-striped active"><div class="bar" style="
						width: '.$totalScore*100/$totalQuestion.'%;"></div></div>';
		echo '</tr></td>';
		echo '</table></tr>';

		?>
	</table>

</div>
