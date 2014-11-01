<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \metalguardian\models\StackUser $user
 */
list($labels, $data) = \metalguardian\models\StackUser::createChart($user);
?>
<script>
	var barChartData = {
		labels : <?= json_encode($labels); ?>,
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : <?= json_encode($data); ?>
			}
		]
	};
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
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
				<canvas id="canvas" height="450" width="600"></canvas>
			</div>
			<ul class="list-inline list-unstyled">
				<li><span><i class="glyphicon glyphicon-calendar"></i> <?= date('Y-m-d H:i:s', $user->last_access_date); ?> </span></li>
				<li>|</li>
				<span><i class="glyphicon glyphicon-comment"></i> <?= $user->reputation; ?> reputation</span>
				<li>|</li>
				<li>
					<span class="glyphicon glyphicon-star" style="color: gold;"></span>
					<?= $user->badge_counts->gold; ?>
				</li>
				<li>|</li>
				<li>
					<span class="glyphicon glyphicon-star" style="color: silver;"></span>
					<?= $user->badge_counts->silver; ?>
				</li>
				<li>|</li>
				<li>
					<span class="glyphicon glyphicon-star" style="color: brown;"></span>
					<?= $user->badge_counts->bronze; ?>
				</li>
			</ul>
		</div>
	</div>
</div>
