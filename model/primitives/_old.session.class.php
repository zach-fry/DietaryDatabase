<?php

	// stick a user object right into $_SESSION
	// (quick and dirty)

	class Session {

		public $id;
		public $user;
		public $token;
		public $timestamp;

		public function Session () {

			// go go go

			session_start();

		}

		// try to reclaim a session-in-progress stored in cookie
		// return TRUE on "is logged in, session is set"
		// return FALSE on "no such session" or "has expired"

		public function isLoggedIn () {
			
			// is there a cookie? does it have a token?

			if ( 
				!isset ( $_COOKIE ) ||
				!isset ( $_COOKIE['token'] )
			)
				return FALSE;

			// yes, verify it with our own records

			$q = "select * from `sessions` where token = '?' limit 1";
			$this->db()->q ( $q, $_COOKIE['token'] );

			// if there isn't such a session, quit

			if ( !$this->db()->num() )
				return false;

			// yes, find the matching user
			// and put it into _SESSION

			$result = $this->db()->pop();
			$q = "select * from `users` where id = ? limit 1";
			$this->db()->q ( $q, intval ( $result['user'] ) );

			// if that user doesn't exist, quit.

			if ( !$this->db()->num() )
				return false;

			// take that user and push it into _SESSION

			$_SESSION = $this->db()->pop();		

			return TRUE;

		}

		public function login ( $user, $pass ) {

			// test password

			$u = new User();
			if ( !$u->getByUsername ( $user ) )
				return FALSE;
			if ( !$u->password_is ( $pass ) )
				return FALSE;

			// create session

			

		}

		public function logout {


			// destory cookie

		}

		public function currentUser () {

			if ( !isset ( $_SESSION['user'] ) )
				return NULL;
			return $_SESSION['user'];

		}

		// public function currentUser()

	};

?>
