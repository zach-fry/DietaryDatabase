<?php include ('/var/www/views/snippets/header.php'); ?>
<section>
<pre></pre>
    <h1>Grocery Product Listings</h1>

    <table class="tablist">
        <caption></caption>
        <thead>
            <tr>
                <th class="tablist-w45">Grocery Product</th>
                <th class="tablist-rating">Texture</th>
                <th class="tablist-rating">Quality</th>
                <th class="tablist-rating">GF Reliability</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $site->getProducts() as $p) { ?>
            <tr>
                <td class="tablist-w45">
                    <a href="/grocery/<?php echo $p['id'];?>"><?php echo $p['name']." - ".$p['company']; ?></a>
                    <p><?php echo $p['description'] ?></p>
                </td>
                <td class="tablist-rating"><?php echo number_format($p['avg_text'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($p['avg_qual'], 2); ?></td>
                <td class="tablist-rating"><?php echo number_format($p['avg_gfre'], 2); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
