<?php include ('/var/www/views/snippets/header.php'); ?>

<?php if ( isset ( $_POST['user'] ) && !$_SESSION['req']['status'] ) { ?>
<div class="notice error">
	<p>The username/password combination you've provided does not match any of our user records. Typing carefully, please try again.</p>
</div>
<?php } ?>

		<section>
			<h1>Login</h1>
			<form name="login" method="POST" action="/login" class="full-width">
				<label>Username</label>
				<input name="user" type="text" />	
				<label>Password</label>
				<input name="pass" type="password" />
				<a href="javascript:document.forms[1].submit();" class="button">Login</a>
			</form>
		</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
