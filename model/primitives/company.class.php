<?php

    class Company extends Primitive {

        // this object's properties

        public $id;
        public $name;
        public $address;
        public $phone;
        public $website;
	public $thumbnail;

        public function create ( $name, $address, $phone, $website, $thumbnail ) {

		$qr = "insert into `company` ( name, address, phone, website, 
			thumbnail ) values ( '?', '?', '?', '?', '?' )";

		if ( $this->db()->q ( $qr, $name, $address, $phone, $website, $thumbnail ) ) {

			// on successful insert, populate and save()

			$this->id = $this->db()->last_inserted();
       			$this->name = $name;
	       		$this->address = $address;
			$this->phone = $phone;
	      		$this->website = $website;
			$this->thumbnail = $thumbnail;

			$this->save();
			return TRUE;


		} else {

			// non-specific failure

			return FALSE;

		}

        }

	public function update () {

		// if there isn't an id set, we know this isn't
		// well-formed enough to push

		if ( !isset  ( $this->id ) ) return false;

		// if what we understand to be in the database now
		// reflects what we already have contined, quit

		if ( !$this->modified() ) return true;

		$qr = "update `company` set name = '?', address ='?', 
			phone ='?', website ='?', thumbnail ='?'
			where id = ? limit 1";

		if ( $this->db()->q ( 
			$qr, 
			$this->name, 
			$this->address, 
			$this->phone, 
			$this->website, 
			$this->thumbnail, 
			$this->id ) 
		) {

			// update was successful

			$this->save();

			return TRUE;

		} else {

			// non-specific failure

			echo $this->db()->qs();

			return FALSE;

		}

		

	}

        public function getById ( $id  ) {

		// build query

		$id = intval ( $id );
		$query = "select * from `company` where id = $id limit 1";

		// run query -- was it successful? was there a result?

		if ( 
			$this->db()->q( "select * from `company` where id = $id limit 1" ) &&
			( $res = $this->db()->pop()  )
		) {

			// yes, populate, save, return true

			$this->id = $res['id'];
			$this->name = $res['name'];
			$this->address = $res['address'];
			$this->phone = $res['phone'];
			$this->website = $res['website'];
			$this->thumbnail = $res['thumbnail'];

			$this->save();

			return TRUE;

		} else {

			// non-specific failure

			return FALSE;

	        }    

	}

	public function delete () {

		// does this object represent a row in the DB?

		if ( !$this->is_set() ) return FALSE;

		// attempt the delete, return the

		$qr = "delete from `company` where id = ? limit 1";
		$this->db()->q ( $qr, $this->id );
		
		if ( $this->db()->num() ) {
			$this->clear();
			return TRUE;
		} else {
			return FALSE;
		}

	}

    };

?>
