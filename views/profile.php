<?php include ('/var/www/views/snippets/header.php'); ?>

<!--

	/profile

	simple markup stuff
		h1 username
		p blurb

	my lists (my favorite products, my favorite restaurants)

	homepage-style table, favorite products
		User class has methods getFavoriteProducts() 
			lol, not tested tho
		probably should clip each to 5 or 10

	same thing, but with restaurants
-->
<?php $u = $_SESSION['user']; ?>
<h1>Username</h1>
<form name="update-profile" method="post" action="profile">
	<h2>Account Information</h2>
	<div class="two-col">
		<div class="two-col-left">
			<label for="username">Username</label>
			<input type="text" name="username" disabled value="<?php echo $u->username; ?>"/>
			<label for="email">E-mail address</label>
			<input type="text" name="mail" value="<?php echo $u->email; ?>" />
			<label for="password">Change password</label>
			<input type="password" name="password" />
			<label for="password2">Change password, confirm</label>
			<input type="password" name="password2" />
		</div>
	
		<div class="two-col-right">
			<label for="why_gf">My gluten-free status</label>
			<select name="why_gf">
				<option value="0">I have celiac disease.</option>
				<option value="1">I have a wheat allergy.</option>
				<option value="2">I have idiopathic gluten intolerance.</option>
				<option value="3">Someone I love has a gluten intolerance.</option>
				<option value="4">I'm interested in learning more about gluten intolerance.</option>
			</select>
			<label for="blurb">Blurb</label>
			<textarea name="blurb" style="width:100%;height:200px;"><?php echo $_SESSION['user']->blurb; ?></textarea>
		</div>
	
	</div>
		<a href="javascript:document.forms['update-profile'].submit()" class="button">Update profile</a>
</form>

<?php
	$u = new User();
	$u->getById( $_SESSION['user']->id );
?>

<section>
    <h1>My Favorite Restaurants</h1>

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
            <?php foreach ( $u->getFavoriteRestaurants() as $r) { ?>
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

<section>
    <h1>My Favorite Groceries</h1>

    <table class="tablist">
        <caption></caption>
        <thead>
            <tr>
                <th class="tablist-w45"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
		$favs = $u->getFavoriteProducts();
		foreach ($favs as $p) { ?>
            <tr>
                <td class="tablist-w45">
                    <a href="/grocery/<?php echo $p->id; ?>"><?php echo $p->name; ?></a>
                    <p><?php echo $p->description; ?></p>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</section>


<?php include ('/var/www/views/snippets/footer.php'); ?>
