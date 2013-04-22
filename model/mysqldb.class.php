<?php

	/*
	
		MySQL Database class
	
		 @author		Maxwell Vu <maxwell.vu@gmail.com>
		 @copyright		2011 Maxwell Vu
		 @license		http://www.gnu.org/licenses/gpl.txt GNU GPLv3
		 @version		1

		Generic MySQL class -- nothing fancy here. We like C's sprintf() and the handling
		sanitization on one line, so our querying methods are a little curious.
		
	*/

	class DB {

		public static $dh = NULL;

		public static function setup ( $host, $user, $pass, $db = NULL ) {

	            self::$dh = new MySQLDB ( $host, $user, $pass, $db );

		}

		public static function getInstance () {

			return self::$dh;

		}

	}
	
	class MySQLDB {
	
		private $dh;								// database handle resource
		private $status;							// status flag
		private $res;								// result resource
		private $num;								// number of results matched/affected
		private $qs;								// last query to be sent to DB
		private $db_sel;							// selected database
	
		public function __construct ( $host, $user, $pass, $db = null ) {
		
			// All good.
			
			$this->status = 1;
			$this->db_sel = "";
			$this->qs = "";
		
			// Try to connect!
			
			if ( ! ( $this->dh = @mysql_connect ( $host, $user, $pass ) ) )
				$this->status = 0;
				return false;
			if ( $db )
				if ( ! ( @mysql_select_db ( $db, $this->dh ) ) ) {
					$this->status = 0;
					
				} else {
					$this->db_sel = $db;
				}
				
			return true;
		
		}
		
		function __destruct() {
		
			// Free result, close connection
			
            $this->free();
            if ( is_resource ( $this->dh ) )
    			mysql_close ( $this->dh );
		
		}
		
		public function _q ( $qs ) {

			// Perform a query.

			// Determine the direction in which the query's going:
			// insert/update/drop/delete's are inward,
			// select is outward

			$qRet = !preg_match ( 
				"/[insert|update|delete|drop]/i", 
				substr ( $qs, 0, 8 ) 
			);
			
			$this->qs = $qs;
			
			$this->res = @mysql_query ( $qs, $this->dh );
			if ( $this->res === FALSE ) {
                echo mysql_error();
				$this->status = 0;
				return false;
			}
			
			if ( $qRet )
				$this->num = @mysql_num_rows ( $this->res );
			else
				$this->num = mysql_affected_rows ();
				
			return true;
		
		}
		
		public function q () {

		
			// Clean arguments, string it togehter, then 
			// pass it to _q() to perform the query.
			
			$input = func_get_args();
			$na = func_num_args();

			// case: given nothing

			if ( $na == 0 ) return FALSE;
	
			// if passed a string, assume it represents the entire query
			// in this case, just pass it along

			if ( $na == 1 )
				return $this->_q ( $input[0] );
			
			// otherwise, assume an array whose first element represents
			// the skeleton for the query, and each element after corresponds
			// to a marker symbol within it.

			// in this case, we'll clean() each subsequent argument and
			// preg_replace() them into it and then pass the resultant
			// string to _q() for querying.

			// Use a simple replacement pattern to insert dynamic 
			// values on-the-fly: a question mark (?)

			for ( $i = 1; $i < $na; $i++ ) {
				$input[$i] = $this->clean ( $input[$i] );
				$input[0] = preg_replace ( "/\?/", $input[$i], $input[0], 1 );
			}

				
			// Pass to _q()
				
			return $this->_q ( $input[0] );
		
		}
		
		public function selected_db () {
		
			// Which database are we using right now?
		
			return $this->db_sel;
		
		}
		
		public function list_db () {
		
			// Show all the databases on this server.
		
			$this->qs = "show databases;";
			$this->res = mysql_query ( $this->qs );
			$this->num = mysql_num_rows ( $this->res );
			return $this->pop_serial();
		
		}
		
		public function select_db ( $db ) {
			
			// Wrapper for _select_db.
			// Returns success/failure boolean.
			
			if ( $this->db_sel == $db ) return true;
			
			$successful = mysql_select_db ( $db );
			
			if ( $successful ) {
				$this->db_sel = $db;
				return true;
			} else {
				return false;
			}
			
		}
		
		public function list_tables ( $db = null ) {
		
			// List the tables in a database, two flavors:
			// Implied currently-selected database, and specified
			
			if ( !$db ) $db = $this->db_sel;
			
			$this->qs = "show tables in `$db`;";
            $this->res = mysql_query ( $this->qs );
            if ( is_resource ( $this->res ) )
                $this->num = mysql_num_rows ( $this->res );
                return $this->pop_serial();

            return NULL;

		}
		
		public function num () {
		
			// Get the already-stored _num_rows or _affected_rows result
			
			return $this->num;
		
		}
		
		public function pop () {
			
			// Get one result item
			
			if ( $this->num == 0 ) { 
				unset ( $this->res );
				return null;
			}
			
			$this->num--;
			return mysql_fetch_assoc ( $this->res );
			
		}
		
		public function pop_all () {
		
			// Get all result items
		
			if ( $this->num ) {
				$out = array();
				while ( $this->num ) { 
					$this->num--;
					$out[] = mysql_fetch_assoc ( $this->res );
				}
				return $out;
			} else {
				return array();
			}

		}
		
		public function pop_serial () {
		
			// Return a single-column result in a single array
			
			if ( $this->num && $this->num_fields() == 1 ) {
				$out = array();
				while ( $this->num ) { 
					$this->num--;
					$tmp = mysql_fetch_row ( $this->res );
					$out[] = $tmp[0];
				}
				return $out;
			} else {
				return null;
			}
		
		}
		
		public function free () {
		
			// Release result of last query.
			
			if ( isset ( $this->res ) && is_resource ( $this->res ) )
				mysql_free_result ( $this->res );
		
		}
		
		public function last_inserted () {
		
			// What was the (A_I) ID of the last-inserted value?
		
			return mysql_insert_id ( $this->dh );
			
		}
		
		public function get_fields ( $table ) {
		
			// Get the fields of a table
			
			if ( !isset ( $table ) )$table = $this->db_sel;
			
			$r = mysql_query ( "show columns from `{$this->db_sel}`.`$table`;" );
			$retval = array();
			
			while ( $field = mysql_fetch_row( $r ) )
				$retval[] = $field[0];
			return $retval;
		
		}
		
		public function num_fields () {
			
			// How many columns are present in the last result?
			
			return mysql_num_fields ( $this->res );
			
		}
		
		public function clean ( $input ) {
		
			// The Purell of PHP/MySQL.
		
			return mysql_real_escape_string ( $input );
		
		}
		
		public function res ( $x, $y = null ) {
		
			// Access one item:
			// 	a the whole result, 1-, or 2d result
			
			if ( !x && !y ) return $this->res;
			if ( !y ) return $this->res[$x];				
			return $this->res[$x][$y];
			
		}
		
		public function qs () {
		
			// What was sent to the DB?
		
			return $this->qs;
		
        }

        public function is_okay () {

            return $this->status;

        }
	
	};
	
?>
