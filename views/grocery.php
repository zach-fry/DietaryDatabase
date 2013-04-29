<?php include ('/var/www/views/snippets/header.php'); ?>
<?php
	$p = new Product();
	if ( !$p->getById ( intval ( $_GET['action'] ) ) )
		echo "failed get_by_id";
        if ( isset ( $_SESSION['user'] ) )
                $isFavorite = $_SESSION['user']->isAFavoriteProduct ( $p->id );
        else
                $isFavorite = FALSE;

?>
<pre></pre>
<section>

        <h1><?php echo $p->name; ?></h1>
    <div class="two-col">
        <div class="two-col-left">
            <div><center><img src="/views/img/p_thumbs/<?php echo $p->thumbnail; ?>" /></center></div>

               <?php if ( isset ( $_SESSION['user'] ) && !$isFavorite ) { ?>
                        <a href="#" id="favorite-button" class="button">Favorite this Product</a>
                <?php } else if ( isset ( $_SESSION['user'] ) && $isFavorite ) { ?>
                        <a href="#" class="button" id="favorite-button-pushed">Favorited!</a>
                <?php } ?>


            <div> 
	            <?php $ratings = $p->getRatings(); ?>
	<label>Ratings</label>
            <div class="ratings-box-container">
                <div class="rating-box">
                    <div class="aspect">Texture</div>
                    <div class="rating"><?php echo number_format($ratings['text'], 2); ?></div>
                </div>
                <div class="rating-box">
                    <div class="aspect">Quality</div>
                    <div class="rating"><?php echo number_format($ratings['qual'], 2);?></div>
                </div>
                <div class="rating-box">
                    <div class="aspect">GF Reliabilty</div>
                    <div class="rating"><?php echo number_format($ratings['gfre'], 2); ?></div>
                </div>
             </div>



        </div>
	</div>
        <div class="two-col-right">
		<label>Description</label>
		<p>
			<?php echo $p->description ?>
		</p>
		</div>

            </div>


        
    </div>

           <div class="reviews-container">
                <h2>Reviews</h2>
                <?php foreach ( $p->getReviews() as $pc ) { ?>
                <?php
                        $author = new User ();
                        $author->getById ( $pc['author'] );
                ?>
                <article class="review">
                        <header>
                                <a href="#"class="review-author"><?php echo $author->username; ?></a>
                                <span class="timestamp"><?php echo date("F j, Y, g:i a", $pc['timestamp'] );?></span>
                        </header>
                        <div class="review-text">
                                <?php echo $pc['comment_text']; ?>
                                <div class="review-figures">
                                        <div class="aspect">
                                                <span class="aspect-title">GF</span>
                                                <span class="aspect-rating"><?php echo $pc['gfre']; ?><span>
                                        </div>

                                        </div>
                                        <div class="aspect">
                                                <span class="aspect-title">Texture</span>
                                                <span class="aspect-rating"><?php echo $pc['text'];?><span>
                                        </div>
                                        <div class="aspect">
                                                <span class="aspect-title">Quality</span>
                                                <span class="aspect-rating"><?php echo $pc['qual']; ?></span>
					</div>
				</div>
			</div>
                </article>
                <?php } ?>
            </div>


</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
