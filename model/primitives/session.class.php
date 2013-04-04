<?php

	class Session {

		// automatically try to pull token from cookie
		// and match it to session in DB

		public function Session () {

			if ( !isset ( $_COOKIE['token'] ) ) return;

			$q = "select * from `sessions` where token = '?' and timestamp < ? limit 1";
			$this->db()->q( $q, $_COOKIE['token'], time() - 2419200 );
			if ( !$this->db()->num() ) return;

			// grab user id, query again for User stuff,
			// store in _SESSION['user']

			$s = $this->db()->pop();
			$q = "select * from `user` where id = ? limit 1";
			$this->db()->q ( $q, $s['user'] );

			if ( !$this->db()->num() ) return;

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

	};

?>
