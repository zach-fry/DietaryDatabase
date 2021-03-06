<?php include ('/var/www/views/snippets/header.php'); ?>

<section>
    <h1>Restaurant Listings</h1>

    <table class="tablist">
        <caption></caption>
        <thead>
            <tr>
                <th class="tablist-w45">Restaurant</th>
                <th class="tablist-loc">Location</th>
                <th class="tablist-rating">GF Reliability</th>
                <th class="tablist-rating">Service</th>
                <th class="tablist-rating">Quality</th>
                <th class="tablist-rating">Price</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ( $site->getRestaurants() as $r) { ?>
			<?php
				// explode tags and style them as blobs
				$tags = explode ( ", ", $r->blurb );
			?>
            <tr>
                <td class="tablist-w45">
                <a href="/restaurant/<?php echo $r->id;?>"><?php echo $r->name;?></a>
                <p>
					<?php foreach ( $tags as $t ) { ?>
						<a href="/tag/<?php echo $t; ?>" class="tag-blob"><?php echo $t; ?></a>
					<?php } ?>
				</p>
                </td>
                <td class="tablist-loc">
                    <?php   
                        echo $r->address;
                    ?>
                </td>
                <?php $ratings = $r->getRatings(); ?>
                <td class="tablist-rating"><?php echo number_format($ratings['gfrel'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($ratings['serv'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($ratings['qual'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($ratings['pric'], 2); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
