<?php include ('/var/www/views/snippets/header.php'); ?>
<pre>
</pre>
		<section>

            <!--
			<h1>Restaurants</h1>
			<table class="tablist">
				<caption></caption>
				<thead>
					<tr>
						<th class="tablist-w45">Restaurant</th>
						<th class="tablist-loc">Location</th>
						<th class="tablist-rating">Service</th>
						<th class="tablist-rating">Quality</th>
						<th class="tablist-rating">GF Reliability</th>
					</tr>
				</thead>
				<tbody>
					<?php for ( $i = 0; $i < 10; $i++ ) { ?>
					<tr>
						<td class="tablist-w45">
							<a href="#">Restaurant Name</a>
							<p>100-percent gluten free dedicated facility. Come in for a meal, a delicious baked good, or even to do your gluten-free grocery shopping.</p>
						</td>
						<td class="tablist-loc centered">
							Latham, NY<br />
							<span class="relative-distance">~3mi away</span>
						</td>
						<td class="tablist-rating">7.5</td>
						<td class="tablist-rating">9.0</td>
						<td class="tablist-rating">9.1</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
            --!>
			<h1>Basic Style Test</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="#">Cras sed tortor est</a>. Praesent at tempor felis. Cras sollicitudin adipiscing tempus. In hac habitasse platea dictumst. Aenean imperdiet, erat quis auctor sollicitudin, eros ante ornare mauris, ac accumsan est tortor sed nulla. Donec id adipiscing lorem. Donec ac sollicitudin mauris. Vestibulum ullamcorper tristique tellus, nec rutrum purus vulputate sit amet. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam erat volutpat. Aliquam in odio sed eros mattis dictum. Maecenas vitae nisl nibh, sed iaculis orci. Aliquam a diam eu tellus cursus rhoncus.</p>

		<ul>
			<?php for ( $i = 0; $i < 10; $i++ ) { ?>
			<li><?php echo rand ( 2, 25 ) . " bottles of beer on the wall"; ?></li>
			<?php } ?>
		</ul>
		</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
