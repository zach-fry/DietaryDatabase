<?php include ('/var/www/views/snippets/header.php'); ?>
<pre>
<?php print_r ( $site->getRestaurants (1,1,1) ); ?>
</pre>
		<section>

			<h1>Product name</h1>
			<div class="two-col">
				<div class="two-col-col"></div>
			</div>

			<h1>Basic Style Test</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="#">Cras sed tortor est</a>. Praesent at tempor felis. Cras sollicitudin adipiscing tempus. In hac habitasse platea dictumst. Aenean imperdiet, erat quis auctor sollicitudin, eros ante ornare mauris, ac accumsan est tortor sed nulla. Donec id adipiscing lorem. Donec ac sollicitudin mauris. Vestibulum ullamcorper tristique tellus, nec rutrum purus vulputate sit amet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam erat volutpat. Aliquam in odio sed eros mattis dictum. Maecenas vitae nisl nibh, sed iaculis orci. Aliquam a diam eu tellus cursus rhoncus.</p>

		<ul>
			<?php for ( $i = 0; $i < 10; $i++ ) { ?>
			<li><?php echo rand ( 2, 25 ) . " bottles of beer on the wall"; ?></li>
			<?php } ?>
		</ul>
		</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
