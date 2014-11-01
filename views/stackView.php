<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \metalguardian\models\StackUser $user
 */
list($labelsTags, $data) = \metalguardian\models\StackUser::createChartTags($user);
list($labels, $answerCount, $answerScore, $questionCount, $questionScore) = \metalguardian\models\StackUser::createChartTopTags($user);
?>
<script>
	var barChartData1 = {
		labels: <?= json_encode($labelsTags); ?>,
		datasets: [
			{
				fillColor: "black",
				data: <?= json_encode($data); ?>
			}
		]
	};
	var barChartData2 = {
		labels : <?= json_encode($labels); ?>,
		datasets : [
			{
				fillColor : "blue",
				data : <?= json_encode($answerCount); ?>
			},
			{
				fillColor : "red",
				data : <?= json_encode($answerScore); ?>
			}
		]
	};
	var barChartData3 = {
		labels : <?= json_encode($labels); ?>,
		datasets : [
			{
				fillColor : "green",
				data : <?= json_encode($questionCount); ?>
			},
			{
				fillColor : "aqua",
				data : <?= json_encode($questionScore); ?>
			}
		]
	};
	window.onload = function(){
		var ctx1 = document.getElementById("canvasTags").getContext("2d");
		window.myBar1 = new Chart(ctx1).Bar(barChartData1, {
			responsive : true
		});
		var ctx2 = document.getElementById("canvasTopTagsAnswers").getContext("2d");
		window.myBar2 = new Chart(ctx2).Bar(barChartData2, {
			responsive : true
		});
		var ctx3 = document.getElementById("canvasTopTagsQuestions").getContext("2d");
		window.myBar3 = new Chart(ctx3).Bar(barChartData3, {
			responsive : true
		});
	}
</script>
<div class="well">
	<div class="media">
		<h1>Stack Overflow profile</h1>
		<a class="pull-left" href="#">
			<img class="media-object" src="<?= $user->profile_image; ?>">
		</a>
		<div class="media-body">
			<h4 class="media-heading"><?= $user->display_name; ?></h4>
			<p class="text-right">Location: <?= $user->location; ?>; Age: <?= $user->age; ?></p>
			<p>Tags active in:</p>
			<div style="width: 50%">
				<canvas id="canvasTags" height="450" width="600"></canvas>
			</div>
			<p>Tags answers count and score:</p>
			<div style="width: 50%">
				<canvas id="canvasTopTagsAnswers" height="450" width="600"></canvas>
			</div>
			<p>Tags questions count and score:</p>
			<div style="width: 50%">
				<canvas id="canvasTopTagsQuestions" height="450" width="600"></canvas>
			</div>

			<ul class="list-inline list-unstyled">
				<li><span><i class="glyphicon glyphicon-calendar"></i> <?= date('Y-m-d H:i:s', $user->last_access_date); ?> last online</span></li>
				<li>|</li>
				<li>
				<span><i class="glyphicon glyphicon-comment"></i> <?= $user->reputation; ?> reputation</span>
				</li>
				<li>|</li>
				<li>
					<span class="glyphicon glyphicon-star" style="color: gold;"></span>
					<?= $user->badge_counts->gold; ?> gold badges
				</li>
				<li>|</li>
				<li>
					<span class="glyphicon glyphicon-star" style="color: silver;"></span>
					<?= $user->badge_counts->silver; ?> silver badges
				</li>
				<li>|</li>
				<li>
					<span class="glyphicon glyphicon-star" style="color: brown;"></span>
					<?= $user->badge_counts->bronze; ?> bronze badges
				</li>
			</ul>
		</div>
	</div>
</div>
