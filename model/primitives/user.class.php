<?php

    class User extends Primitive {

        public $id;
        public $username;
        public $email;
	public $salt;
        public $password;
        public $avatar;
        public $why_gf;
        public $blurb;

	public function create ( $e, $u, $p, $a, $g, $b ) {

		// generate salt, hash password

		$salt_bank = "abcdefghijklmABCDEFGHIJKLM123457890~!@#$%^&";
		$salt = "";
		for ( $i = 0; $i < 64; $i++ )
			$salt += substr ( $salt_bank, rand ( 0, strlen ( $salt_bank ), 1 ) );
		$password = sha512 ( $salt . $p );

		// attempt to insert

		if ( !$this->db()->q ( 
			"insert into `user` ( email, username, salt, password, 
			 avatar, why_gf, blurb ) values ( '?', '?', '?', '?', '?', '?', '?' )",
			$e, $u, $salt, $password, $a, $g, $b ) )

			return false;

		// set values

		$this->id = $this->db()->last_inserted();
		$this->username = $u;
		$this->email = $e;
		$this->password = $password;
		$this->avatar = $a;
		$this->why_gf = $g;
		$this->blurb = $b;

		return TRUE;
			 

	}

	public function getById ( $id ) {

		if ( !isset ( $id ) || !is_int ( $id ) )
			return FALSE;

		if (
			!$this->db()->q ( 'select * from `user` where id = ? limit 1', $id ) ||
			!$this->db()->num()
		   )
			return FALSE;

		$res = $this->db->pop();

		$this->id = $res['id'];
		$this->email = $res['email'];
		$this->username = $res['name'];
		$this->salt = $res['salt'];
		$this->password = $res['password'];
		$this->avatar = $res['avatar'];
		$this->why_gf = $res['why_gf'];
		$this->blurb = $res['blurb'];

		return TRUE;

	}

	public function getByUsername ( $username ) {

		$q = "select * from `users` where username = '?' limit 1";
		if ( !$this->db()->q ( $q, $username ) )
			return FALSE;
		$res = $this->db()->pop();

		$this->id = $res['id'];
		$this->email = $res['email'];
		$this->username = $res['name'];
		$this->salt = $res['salt'];
		$this->password = $res['password'];
		$this->avatar = $res['avatar'];
		$this->why_gf = $res['why_gf'];
		$this->blurb = $res['blurb'];

		return TRUE;

	}

	public function addFavoriteProduct ( $p_id ) {

		$q = "insert into `p_favorite ( user, product, timestamp )
			values ( ?, ?, ? )";

		$this->db()->q( $q, $this->id, $p_id, time() );
		return $this->db()->num() ? TRUE : FALSE;

	}

	public function removeFavoriteProduct ( $p_id ) {

		$q = "delete from `p_favorite` where user = ? and 
			product = ? limit 1";

		$this->db->q( $q, $this->id, intval ( $pid ) );
		return $this->db()->num() ? TRUE : FALSE;

	}

	public function getFavoriteProducts ( $num = 50 ) {

		$q = "select * from `p_favorite` where user = ? limit ?";
		$this->db()->q( $this->id, $num );
		$retval = array();
		if ( !$this->db()->num() ) return $retval;

		while ( $result = $this->db()->pop() ) {
			$p = new Product();
			if ( $p->getById ( $result['product'] ) )
				$retval .= $p;
		}

		return $retval;

	}

	public function addFavoriteRestaurant ( $r_id ) {

		$q = "insert into `r_favorite` ( user, restaurant, timestamp )
			values ( ?, ?, ? )";

		$this->db()->q ( $q, $this->id, intval ( $r_id ), time() );
		return $this->db()->num() ? TRUE : FALSE;

	}

	public function removeFavoriteRestaurant ( $r_id ) {

		$q = "delete from `r_favorite` where user = ? and restaurant = ? limit 1";
		$this->db()->q( $q, $this->id, intval ( $r_id ) );
		return $this->db()->num() ? TRUE : FALSE;

	}

	// public function getFavoriteRestaurants ())

	public function addProductComment ( $texture, $quality, $gfre, $text ) {

		$q = "insert into `p_comment` ( author, timestamp, p_text,
			p_qual, p_gfre, comment_text ) values ( ?, ?, ?, ?, ?, '?' )  ";

		$this->db()->q( $q, $this->id, time(), intval ( $texture ),
			intval ( $quality ), intval ( $gfre ), Markdown ( $text ) );

		return $this->db()->num() ? TRUE : FALSE;

	}


	public function deleteProductComment ( $p_id ) {

		$q = "delete from `p_comment` where product = ? and user = ? limit 1";
		$this->db()->q ( $q, $p_id, $this->id );

		return $this->db()->num() ? TRUE : FALSE;

	}

	public function addRestaurantComment ( $r_id, $serv, $qual, $pric, $gfre ) {

		$q = "insert into `r_comment` ( author, restaurant, r_serv, r_qual, r_pric,
		r_gfrel, comment_text )	values ( ?, ?, ?, ? ,? ,?, '?') ";

		$this->db()->q( $q, $this->id, $r_id, intval ( $serv ), intval ( $qual ),
			intval ( $pric, $gfre ) );

		return $this->db()->num() ? TRUE : FALSE;

	}

	public function removeRestaurantComment ( $r_id ) {

		$q = "delete from `r_comment` where author = ? and restaurant = ? limit 1";
		$this->db()->q ( $q, $this->id, $r_id );

	}

	public function delete () {

		if ( !isset ( $this->id ) ) return FALSE;

		if ( !$this->db()->q ( 'delete from `user` where id = ? limit 1' , $this->id ) )
			return FALSE;

		$this->clear();
		return TRUE;

	}

	public function password_is ( $p ) {

		return sha512 ( $p . $this->salt ) == $this->password;

	}

    };

?>
