<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8 />
		<title></title>
		<link rel="stylesheet" type="text/css" media="screen" href="/views/css/main.css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css' />
		<script type="text/javascript" src="/views/js/jquery-2.0.0.min.js"></script>
		<script type="text/javascript" src="/views/js/main.js"></script>
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	</head>
	<body>
    
		<header>
			<hgroup>
				<h1>Dietary Databases</h1>
				<h2>Architecting an edible world</h2>
			</hgroup>
			<nav>
				<a href="/">Home</a>
				<a href="/restaurant">Restaurants</a>
				<a href="/grocery">Groceries</a>
				<div class="user-nav">
					<?php if ( !isset ( $_SESSION['user'] ) ) { ?>
					<a href="/login">Login</a>
					<a href="/register">Register</a>
					<?php } else { ?>
					<a href="/logout">Logout</a>
					<a href="/profile">
						<?php echo $_SESSION['user']->username; ?>
					</a>
					<?php } ?>
				</div>
			</nav>
			<form name="main_search" id="main_search" method="POST" action="/search">
				<input type="text" name="keywords" placeholder="search..." />
			</form>
		</header>


