<?php include ('/var/www/views/snippets/header.php'); ?>

<?php if ( !isset ( $_SESSION['user'] ) ) { ?>
<div class="notice error">
	<p>You are not logged in! Please login at this time!</p>
</div>
<?php } else { ?>

<a href="/logout">Log Out</a>

<?php } ?>
<?php include ('/var/www/views/snippets/footer.php'); ?>
