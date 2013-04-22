<?php include ('/var/www/views/snippets/header.php'); ?>
		<section>
			<h1>Register</h1>
			<form name="register" method="POST" action="/register" class="full-width">
				<label>Username</label>
				<input name="username" type="text" />	
				<label>E-mail address</label>
				<input name="email" type="text" />
				<label>Password</label>
				<input name="password" type="password" />
				<label>Password confirm</label>
				<input name="password2" type="password" />
				<a href="javascript:document.forms[1].submit();" class="button">Register</a>
			</form>
		</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
