<?php include ('/var/www/views/snippets/header.php'); ?>

		<section>

			<h1>Restaurant Listings</h1>

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
                    <?php foreach ( $site->getRestaurants() as $r) { ?>
					<tr>
						<td class="tablist-w45">
                        <a href="/restaurant/<?php echo $r['id'];?>"><?php echo $r['name'];?></a>
                        <p><?php echo $r['blurb']; ?></p>
						</td>
						<td class="tablist-loc centered">
						    ???<br />
						</td>
                        <td class="tablist-rating"><?php echo number_format($r['avg_serv'], 2); ?></td>
						<td class="tablist-rating"><?php echo number_format($r['avg_qual'], 2); ?></td>
						<td class="tablist-rating"><?php echo number_format($r['avg_gfrel'], 2); ?></td>
					</tr>
                    <?php } ?>
				</tbody>
			</table>
		</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
