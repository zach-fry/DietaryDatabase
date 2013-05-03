<?php include ('/var/www/views/snippets/header.php'); ?>
<?php 
    echo '<pre></pre>';
    $raw_keywords = $_POST["keywords"];
    $r_results = array();
    $p_results = array();

    foreach ( explode(",", $raw_keywords) as $tmp_key ) {
        foreach ( explode(" ", $tmp_key) as $keyword) {
            foreach ( $site->getRestaurants($search_term=$keyword) as $r) {
                //print_r($r);
                //echo '<br>';
                $found = 0;
                foreach ( $r_results as $r2 ) {
                    if ($r2->id == $r->id) {
                        $found = 1;
                        break;
                    }
                }
                if($found == 0) {
                    array_push($r_results, $r);                   
                }
            }
            //print_r($r_results);
            foreach ( $site->getProducts($search_term=$keyword) as $p) {
                $found = 0;
                foreach ( $p_results as $p2 ) {
                    if ($p2['id'] == $p['id']) {
                        $found = 1;
                        break;
                    }
                }
                if($found == 0) {
                    array_push($p_results, $p);                   
                }
            }
        }
    }

    if(count($r_results) == 0) { $r_results = array(); }
    if(count($p_results) == 0) { $p_results = array(); }

?>


<pre> </pre>
<section>
    <h1>Search Results for keyword: <?php echo($_POST["keywords"]); ?> </h1>
    <p></p>
    <h1>Restaurants</h1>
    <table class="tablist">
        <caption></caption>
        <?php 
            if (count($r_results) == 0) {
        ?>
        No Results
        <?php
            } else {
        ?>

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
            <?php foreach ($r_results as $r) { ?>
            <tr>
                <td class="tablist-w45">
                <a href="/restaurant/<?php echo $r->id;?>"><?php echo $r->name;?></a>
                <p><?php echo $r->blurb; ?></p>
                </td>
                <td class="tablist-loc centered">
                    <?php echo $r->address; ?>
                </td>
                <?php $ratings = $r->getRatings(); ?>
                <td class="tablist-rating"><?php echo number_format($ratings['gfrel'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($ratings['serv'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($ratings['qual'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($ratings['pric'], 2); ?></td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>

    <h1>Grocery Products</h1>
    <table class="tablist">
        <caption></caption>
        <?php 
            if (count($p_results) == 0) {
        ?>
        No Results
        <?php
            } else {
        ?>
        <thead>
            <tr>
                <th class="tablist-w45">Grocery Product</th>
                <th class="tablist-loc">Texture</th>
                <th class="tablist-rating">Quality</th>
                <th class="tablist-rating">GF Reliability</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($p_results as $p) { ?>
            <tr>
                <td class="tablist-w45">
                <a href="/product/<?php echo $p['id'];?>"><?php echo $p['name'];?></a>
                <p><?php echo $p['description']; ?></p>
                </td>
                <td class="tablist-rating"><?php echo number_format($p['avg_text'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($p['avg_qual'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($p['avg_gfre'], 2); ?></td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>


</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
