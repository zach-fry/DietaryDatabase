<?php include ('/var/www/views/snippets/header.php'); ?>
<?php
	$r = new Restaurant();
	if ( !$r->getById ( intval ( $_GET['action'] ) ) )
		echo "failed get_by_id";
?>
<pre></pre>

			<div class="two-col">
				<div class="two-col-left">
				<h1><?php echo $r->name; ?></h1>
					<div><img src="/views/img/r_thumbs/<?php echo $r->thumbnail; ?>" /></div>
					<div><?php echo $r->blurb; ?></div>
					<h2>Ratings</h2>
					<div class="rating-box-container">
						<div class="rating-box">
							<div class="aspect">GF Reliability</div>
							<div class="rating">7.4</div>
						</div>
						<div class="rating-box">
							<div class="aspect">Service</div>
							<div class="rating">8.3</div>
						</div>
						<div class="rating-box">
							<div class="aspect">Quality</div>
							<div class="rating">7.4</div>
						</div>
					</div>

				</div>
				<div class="two-col-right">
					<h2>Contact and location</h2>
<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/?ie=UTF8&amp;t=m&amp;ll=<?php echo $r->geo_lat . ',' . $r->geo_long; ?>&amp;spn=25.695122,37.441406&amp;z=13&amp;output=embed"></iframe>
					<div>
					<?php
						echo $r->address . '<br/>';
						echo $r->phone . '<br/>';
						echo '<a href="' . $r->website . '">';
						echo  $r->website . '</a><br/>'
					?>
					</div>
					<h2>Review this restaurant</h2>
					<div>
						<form name="submit_r_comment" method="POST" action="/restaurant/">
							<textarea name="comment_text" class="comment_text"></textarea>
							<select name="r_serv">
								<option value="">1</option>
								<option value="">2</option>
								<option value="">3</option>
								<option value="">4</option>
								<option value="">5</option>
								<option value="">6</option>
								<option value="">7</option>
								<option value="">8</option>
								<option value="">9</option>
								<option value="">10</option>
							</select>
							<select name="r_qual">
								<option value="">1</option>
								<option value="">2</option>
								<option value="">3</option>
								<option value="">4</option>
								<option value="">5</option>
								<option value="">6</option>
								<option value="">7</option>
								<option value="">8</option>
								<option value="">9</option>
								<option value="">10</option>
							</select>
							<select name="r_gfre">
								<option value="">1</option>
								<option value="">2</option>
								<option value="">3</option>
								<option value="">4</option>
								<option value="">5</option>
								<option value="">6</option>
								<option value="">7</option>
								<option value="">8</option>
								<option value="">9</option>
								<option value="">10</option>
							</select>
							<input type="submit" value="Post review" />
						</form>
					</div>
					<h2>Others' Reviews</h2>
				</div>
			</div>

		</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
