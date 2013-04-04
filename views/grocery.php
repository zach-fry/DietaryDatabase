<?php include ('/var/www/views/snippets/header.php'); ?>
		<section>

			<h1>Udi's White Sandwich Bread</h1>
			<div class="two-col">
				<div class="two-col-left">
					<div class="two-col-img">
                        <center>
                            <img src="/views/img/p_thumbs/1.jpg" />
                        </center>
					</div>
                    <div>
                        <center>
                            <a href="#" onclick="document.getElementById('bkmrk_img').src='/views/img/bookmarked.png'">Favorite this Product</a>
                            <a href="#" onclick="document.getElementById('bkmrk_img').src='/views/img/bookmarked.png'">
                                <img id="bkmrk_img" src="/views/img/notbookmarked.png" align="top" width=20 height=20 />
                            </a>
                        </center>
                    </div>
                    
                    <br>
                    <div>The bread that started it all is now a customer favorite. Our signature light and fluffy white sandwich bread is made with all natural ingredients without added fillers. Reward yourself during your next meal and enjoy the luxury of bread again.</div>

                    <p>
                    <div>
                        <table class="tablist-product" width=100%>
                            <tr>
                                <th class="tablist-product-rating">Texture</th>
                                <th class="tablist-product-rating">Quality</th>
                                <th class="tablist-product-rating">GF Reliability</th>
                            </tr>
                            <tr>
                                <td class="tablist-rating">7.5</td>
                                <td class="tablist-rating">9.0</td>
                                <td class="tablist-rating">9.1</td>
                            </tr>
                        </table>
                                
                    </div>
				</div>
				<div class="two-col-right">
                    <div><b>Brand Name: </b>Udi's</div>
                    <div><b>Company Name: </b>Udi's Gluten Free</div>
                    <div><b>Company Website: </b><a href="udisglutenfree.com/">udisglutenfree.com/</a></div>

					<h2>Review this Product</h2>
					<div>
						<form name="submit_r_comment" method="POST" action="/grocery/post_comment">
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

					<div>Comments Go Here</div>
				</div>
			</div>

		</section>
<?php include ('/var/www/views/snippets/footer.php'); ?>
