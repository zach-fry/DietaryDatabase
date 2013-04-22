<?php include ('/var/www/views/snippets/header.php'); ?>
<?php
	$p = new Product();
	if ( !$p->getById ( intval ( $_GET['action'] ) ) )
		echo "failed get_by_id";
?>
<pre></pre>
<section>

    <div class="two-col">
        <div class="two-col-left">
        <h1><?php echo $p->name; ?></h1>
            <div><center><img src="/views/img/p_thumbs/<?php echo $p->thumbnail; ?>" /></center></div>
            <div>
                <center>
                    <a href="#" onclick="document.getElementById('bkmrk_img').src='/views/img/bookmarked.png'">Favorite this Product</a>
                    <a href="#" onclick="document.getElementById('bkmrk_img').src='/views/img/bookmarked.png'">
                        <img id="bkmrk_img" src="/views/img/notbookmarked.png" align="top" width=20 height=20 />
                    </a>
                </center>
            </div>
            <div> <?php echo $p->description ?> </div>
            <h2>Ratings</h2>
            <?php $ratings = $p->getRatings(); ?>
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
             <div class="reviews-container">
                <h2>Reviews</h2>
                <table class="review-list">
                    <thead>
                        <tr>
                            <th class="review-header">User</th>
                            <th class="review-header">Comment</th>
                            <th class="review-header">Texture</th>
                            <th class="review-header">Quality</th>
                            <th class="review-header">GF Reliability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php foreach ( $p->getReviews() as $pc ) { ?>
                            <td class="user-col"><?php echo "Anon"; ?></td>
                            <td class="review-col"><?php echo $pc['comment_text']; ?></td>
                            <td class="rating-col"><?php echo $pc['text']; ?></td>
                            <td class="rating-col"><?php echo $pc['qual']; ?></td>
                            <td class="rating-col"><?php echo $pc['gfre']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="two-col-right">
            <h2>Review this Product</h2>
            <div>
                <form name="submit_p_comment" method="POST" action="/grocery/post_comment">
                <input type="hidden" name="id" value="<?php echo $p->id; ?>" />
                    <textarea name="comment_text" class="comment_text"></textarea>
                    <b>Texture</b>
                    <select name="p_text">
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
                    <select name="p_qual">
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
                    <select name="p_gfre">
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
                <input type="submit" value="Post review" />
                </form>
            </div>

        </div>
    </div>

</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
