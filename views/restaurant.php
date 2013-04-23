<?php include ('/var/www/views/snippets/header.php'); ?>
<?php
	//load up data of the particular restaurant you intend to display
	$r = new Restaurant();
	if ( !$r->getById ( intval ( $_GET['action'] ) ) )
		echo "failed get_by_id";
?>
<pre></pre>
<section>
    <div class="two-col">
        <div class="two-col-left">
        <h1><?php echo $r->name; ?></h1>
            <div><center><img src="/views/img/r_thumbs/<?php echo $r->thumbnail; ?>" /></center></div>
            <div>
                <center>
                    <a href="#" onclick="document.getElementById('bkmrk_img').src='/views/img/bookmarked.png'">Favorite this Restaurant</a>
                    <a href="#" onclick="document.getElementById('bkmrk_img').src='/views/img/bookmarked.png'">
                        <img id="bkmrk_img" src="/views/img/notbookmarked.png" align="top" width=20 height=20 />
                    </a>
                </center>
            </div>
            <div><?php echo $r->blurb; ?></div>
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
            <div class="reviews-container">
                <h2>Reviews</h2>
                <table class="review-list">
                    <thead>
                        <tr>
                            <th class="review-header">User</th>
                            <th class="review-header">Comment</th>
                            <th class="review-header">GF Reliability</th>
                            <th class="review-header">Service</th>
                            <th class="review-header">Quality</th>
                            <th class="review-header">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php foreach ( $r->getReviews() as $rc ) { ?>
                            <td class="user-col">
                            <?php 
                                if($rc['author'] == 0) echo 'Anon';
                                else {
                                    $u = new User;
                                    $u->getById($rc['author']);
                                    echo ($rc['author']);
                                    //print_r($u);
                                    //echo $u->username; 
                                }
                            ?>
                           
                            </td>
                            <td class="review-col"><?php echo $rc['comment_text']; ?></td>
                            <td class="rating-col"><?php echo $rc['gfrel']; ?></td>
                            <td class="rating-col"><?php echo $rc['serv']; ?></td>
                            <td class="rating-col"><?php echo $rc['qual']; ?></td>
                            <td class="rating-col"><?php echo $rc['pric']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="two-col-right">
            <h2>Contact and location</h2>
            <div id="map_canvas" style="width: 500px; height: 500px;"></div>
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
                initialize(<?php echo $r->geo_lat.','.$r->geo_long?>);
                </script>
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
                <form name="submit_r_comment" method="POST" action="/restaurant/post_comment">
                    <input type="hidden" name="id" value="<?php echo $r->id;?>" />
                    <textarea name="comment_text" class="comment_text"></textarea>
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
                    <br>
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
                    <br>
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
                    <br>
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
            
                    <input type="submit" class="submit_button" value="Post review" />
                </form>
            </div>
        </div>
    </div>

</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
