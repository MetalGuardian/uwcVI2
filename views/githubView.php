<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \metalguardian\models\GithubUser $user
 */
?>

<div class="well">
	<div class="media">
		<h1>Github profile</h1>
		<a class="pull-left" href="#">
			<img style="max-width:100px;" class="media-object" src="<?= $user->avatar_url; ?>">
		</a>
		<div class="media-body">
			<h4 class="media-heading"><?= $user->name; ?></h4>
			<p class="text-right">Hireable: <?= $user->hireable ? 'Yes' : 'No'; ?>; Username: <?= $user->login; ?>; Location: <?= $user->location; ?></p>
			<p><?= $user->bio; ?></p>
			<ul class="list-inline list-unstyled">
				<li>
					<span><i class="glyphicon glyphicon-comment"></i> <?= $user->public_repos; ?> repos</span>
				</li>
				<li>|</li>
				<li>
					<span><i class="glyphicon glyphicon-comment"></i> <?= $user->public_gists; ?> gists</span>
				</li>
				<li>|</li>
				<li>
					<span class="glyphicon glyphicon-star" style="color: gold;"></span>
					<?= $user->followers; ?> followers
				</li>
			</ul>
		</div>
	</div>
</div>
