
	// AJAX-y things, favoriting

	function addRestaurantFavorite ( id ) {

		$.get (
			'/restaurant-favorite/add',
			{ 'id' : id },
			function ( data, textStatus, jq ) {
				if ( data == "1" )
					return true;
				return false;
			}
		);

		return true;

	}

	function addProductFavorite ( id ) {

		$.get (
			'/product-favorite/add',
			{ 'id' : id },
			function ( data, textStatus, jq ) {
				if ( data == "1" )
					return true;
				return true;
			}
		);
		return false;

	}

	function removeRestaurantFavorite ( id ) {

		$.get (
			'/restaurant-favorite/remove',
			{ 'id' : id },
			function ( data, textStatus, jq ) {
				if ( data == "1" )
					return true;
				return false;
			}
		);

		return true;

	}

	function removeProductFavorite ( id ) {

		$.get (
			'/product-favorite/remove',
			{ 'id' : id },
			function ( data, textStatus, jq ) {
				if ( data == "1" )
					return true;
				return false;
			}
		);
		return false;

	}


	$(document).ready ( function () {


		// in a big table, make the big cell act like a link

		$("td.tablist-w45").on ({ 
			"click": function (ev) {
				//console.log ( ev );
				window.location = ev.currentTarget.children[0].href;
			}
		});

		// on the restaurant/product page, make the favorite button
		// forge a request to associate the restaurant with user's favorites.

		// on success, change the icon and text of the button.
		// on failure, show message on the button
	
		$("#favorite-button").on ({
			"click": function ( ev ) {
				var target_type = $("#target-type").html();
				var target_id = $("#target-id").html();
				if (( target_type == 'r' && addRestaurantFavorite ( target_id ) ) || 
					( target_type == 'p' && addProductFavorite ( target_id ) ) ) {
					$(this).attr ( 'id', 'favorite-button-pushed' );
					$(this).html ( 'Favorited!' );
				} else {
					$(this).html ( "Error adding favorite..." );
				}	
			}
		});

		// the same process as above, but in the opposite direction --
		// un-favorite a restaurant

		$("favorite-button-pushed").on ({
			"click" : function ( ev ) {
				var target_type = $("#target-type").html();
				var target_id = $("#target-id").html();
				if (( target_type == 'r' && removeRestaurantFavorite ( target_id ) ) || 
					( target_type == 'p' && removeProductFavorite ( target_id ) ) ) {
					$(this).attr ( 'id', 'favorite-button' );
					$(this).html ( 'Add to favorites' );
				} else {
					$(this).html ( "Error removing favorite..." );
				}	

			}
		});

	});

	// keep google map from freaking out

	$(window).resize(function () { 
		google.maps.event.trigger(map, 'resize');
	});
