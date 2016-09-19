<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<title><?php echo (isset($this->pageTitle) ? $this->pageTitle : 'Silent Framework - it Work'); ?></title>
</head>
<html>
<body>
	<div class="container border-container">
		<div class="header clearfix">
			<nav>
				<ul class="nav nav-pills pull-right">
					<li role="presentation"><a href="/">Home</a></li>
					<li role="presentation"><a href="/default/test">Home test</a></li>
					<li role="presentation"><a href="/test">Test Controller</a></li>
					<li role="presentation"><a href="/test/test">Test Controller test action</a></li>
				</ul>
			</nav>
			<h3 class="text-muted"> Silent Framework</h3>
		</div>

		<div class="jumbotron">
			<div class="lead">
				<h2>Run controller <strong><?php echo ucfirst($this->getControllerId().'Controller') ;?></strong>.</h2>
				<?php echo $content; ?>
			</div>
		</div>

		<footer class="footer">
			<p>© Silent Framework</p>
		</footer>
	</div>
</body>
</html>