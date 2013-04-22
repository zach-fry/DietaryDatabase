<?php

	session_start();

	class Session {

		// automatically try to pull token from cookie
		// and match it to session in DB

		public function Session () {

			// if session already exists, quit

			if ( isset ( $_SESSION['id'] ) ) return;

			// if session doesn't exist and no token to pull from, quit

			if ( !isset ( $_COOKIE['token'] ) ) return;

			// session not set, but cookie is,
			// try to locate that one and revive it.

			$q = "select * from `sessions` where token = '?' and timestamp < ? limit 1";
			$this->db()->q( $q, $_COOKIE['token'], time() - 2419200 );

			// no session like that in our records, quit.

			if ( !$this->db()->num() ) return;

			// grab user id, query again for User stuff,
			// store in _SESSION['user']

			$s = $this->db()->pop();
			$q = "select * from `user` where id = ? limit 1";
			$this->db()->q ( $q, $s['user'] );

			// found the session, but user doesn't exist, quit.

			if ( !$this->db()->num() ) return;

			// glob to session

			$_SESSION['user'] = $this->db()->pop();

			return;			

		}

		public function create ( $u_id ) {

			// create a session entry in DB
			// come up with a token
			// do time() math

			$token_bank = "abcdefghijklmnopqrstuvwxyz";	
			$token_bank .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$token_bank .= ".,:;'][}{|-=+_!@#%&*()";

			$token = "";

			for ( $i = 0; $i < 64; $i++ )
			$token .= substr ( $token_bank, rand ( 0, strlen ( $token_bank ), 1 ) );

			$q = "insert into `session` ( user, token, timestamp ) values ( ?, '?', ? )";
			$this->db()->q( $q, $token, time() );

			setcookie ( 'token', $token, time() + 2419200 );

			return TRUE;

		}

		public function destroy () {

			unset ( $_SESSION['user'] );
			setcookie ( "token", ":^)", time() - 30 );

			// remove session row? too lazy. let it stay.	

		}

		public function isLoggedIn () {

			return isset ( $_SESSION['user']['id'] );	

		}

	};

?>
