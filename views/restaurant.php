<?php include ('/var/www/views/snippets/header.php'); ?>
<?php
	//load up data of the particular restaurant you intend to display
	$r = new Restaurant();
	if ( !$r->getById ( intval ( $_GET['action'] ) ) )
		echo "failed get_by_id";
	$tags = explode ( ', ', $r->blurb );
	if ( isset ( $_SESSION['user'] ) )
		$isFavorite = $_SESSION['user']->isAFavoriteRestaurant ( $r->id );
	else
		$isFavorite = FALSE;
?>
<span id="target-type" style="display:none;">r</span>
<span id="target-id" style="display:none;"><?php echo $r->id; ?></span>
<?php if ( isset ( $_SESSION['user'] ) && $isFavorite ) { ?>
	<span id="target-status" style="display:none;">1</span>
<?php } else { ?>
	<span id="target-status" style="display:none;">0</span>
<?php } ?>
<section>
        <h1><?php echo $r->name; ?></h1>
    <div class="two-col">
        <div class="two-col-left">
        <img src="/views/img/r_thumbs/<?php echo $r->thumbnail; ?>" class="restaurant-thumbnail"/>
		
		<?php if ( isset ( $_SESSION['user'] ) && !$isFavorite ) { ?>         
			<a href="#" id="favorite-button" class="button">Favorite this Restaurant</a>
		<?php } else if ( isset ( $_SESSION['user'] ) && $isFavorite ) { ?>
			<a href="#" class="button" id="favorite-button-pushed">Favorited!</a>
		<?php } ?>

			<h2>Tags</h2>
            <div class="tag-cloud">
		<?php foreach ( $tags as $t ) { ?>
			<a href="/tag/<?php echo $t; ?>" class="tag-blob"><?php echo $t; ?></a>
		<?php } ?>
		</div>
            <h2>Ratings</h2>
            <?php $ratings = $r->getRatings(); /*get average ratings for this restaurant listing */?>
            <div class="rating-box-container">
                <div class="rating-box">
                    <div class="aspect">GF Reliability</div>
                    <div class="rating"><?php echo number_format($ratings['gfrel'], 2); ?></div>
                </div>
                <div class="rating-box">
                    <div class="aspect">Service</div>
                    <div class="rating"><?php echo number_format($ratings['serv'], 2);?></div>
                </div>
                <div class="rating-box">
                    <div class="aspect">Quality</div>
                    <div class="rating"><?php echo number_format($ratings['qual'], 2); ?></div>
                </div>
                <div class="rating-box">
                    <div class="aspect">Price</div>
                    <div class="rating"><?php echo number_format($ratings['pric'], 2); ?></div>
                </div>
            </div>
        </div>

        <div class="two-col-right">
            <h2>Contact and location</h2>
            <div id="map_canvas" style="width: 450px; height: 500px;"></div>
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"> </script>
            <script type="text/javascript">
                function initialize(x, y) {
                    var latlng = new google.maps.LatLng(x,y);
                    var myOptions = {zoom: 17, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP};
			//generate map
                    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			//place pin
                    var marker = new google.maps.Marker({position: new google.maps.LatLng(x,y), map: map});
                }
                initialize('<?php echo $r->geo_lat.'\',\''.$r->geo_long; ?>');
                </script>
            <div>
            <?php
                echo $r->address . '<br/>';
                echo $r->phone . '<br/>';
                echo '<a href="' . $r->website . '">';
                echo  $r->website . '</a><br/>'
            ?>
            </div>
              </div>
    </div>
            <h2>Review this restaurant</h2>
            <div>
                <form name="submit_r_comment" method="POST" action="/restaurant/post_comment">
                    <input type="hidden" name="id" value="<?php echo $r->id;?>" />
                    <textarea name="comment_text" class="comment_text" style="width:100%;height: 150px;"></textarea>
			<div class="w75">
                    <b>Service</b>
                    <select name="r_serv">
                        <option value="1" selected="selected">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <b>Quality</b>
                    <select name="r_qual">
                        <option value="1" selected="selected">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <b>GF Reliability</b>
                    <select name="r_gfre">
                        <option value="1" selected="selected">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <b>Price</b>
                    <select name="r_pric">
                        <option value="1" selected="selected">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
            </div>
			<a href="javascript:document.forms[1].submit();" class="button">Submit review</a>
                </form>
            </div>

            <div class="reviews-container">
                <h2>Reviews</h2>
		<?php foreach ( $r->getReviews() as $rc ) { ?>
		<?php
			$author = new User ();
			$author->getById ( $rc['author'] );
		?>
		<article class="review">
			<header>
				<a href="#"class="review-author"><?php echo $author->username; ?></a>
				<span class="timestamp"><?php echo date("F j, Y, g:i a", $rc['timestamp'] );?></span>
			</header>
			<div class="review-text">
				<?php echo $rc['comment_text']; ?>
				<div class="review-figures">
					<div class="aspect">
						<span class="aspect-title">GF</span>
						<span class="aspect-rating"><?php echo $rc['gfrel']; ?><span>
					</div>
					<div class="aspect">
						<span class="aspect-title">Price</span>
						<span class="aspect-rating"><?php echo $rc['pric'];?><span>
					</div>
					<div class="aspect">
						<span class="aspect-title">Quality</span>
						<span class="aspect-rating"><?php echo $rc['qual']; ?></span>
					</div>
					<div class="aspect">
						<span class="aspect-title">Service</span>
						<span class="aspect-rating"><?php echo $rc['serv']; ?></span>
					</div>
	
	
		</article>
		<?php } ?>
            </div>

</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
