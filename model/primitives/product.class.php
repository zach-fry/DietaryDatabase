<?php

    class Product extends Primitive {

        public $id;
        public $name;
        public $company;
        public $thumbnail;
        public $description;

	public function create ( $name, $company, $thumbnail, $description ) {

		$qr = "insert into `product` ( name, company, thumbnail,
			description ) values ( '?', ?, '?', '?' ) ";

		if ( $this->db()->q( $qr, $name, $company, $thumbnail, $description ) ) {

			$this->id = $this->db()->last_inserted();
			$this->name = $name;
			$this->company = $company;
			$this->thumbnail = $thumbnail;
			$this->description = $description;

			$this->save();
			return TRUE;

		}

		// non-specific failure

		return FALSE;

	}

	public function update () {


		// not set? quit.

		if ( !$this->is_set() ) return FALSE;

		// not modified? quit.

		if ( !$this->modified() ) return TRUE;

		$qr = "update `product` set name = '?', company = ?,
			thumbnail = '?', description = '?' limit 1 ";

		if ( $this->db->q ( 
			$qr,
			$this->name,
			intval ( $this->company ),
			$this->thumbnail,
			$this->description )
		) {

			$this->save();
			return TRUE;

		} else {

			// non-specific failure

			return FALSE;

		}

	}

	public function getById ( $id ) {

		$id = intval ( $id );
		$q = "select * from `product` where id = ? limit 1";

		if ( $this->db()->q ( $q, $id ) ) {

			$r = $this->db()->pop();
			$this->name = $r['name'];
			$this->company = intval ( $r['company'] );
			$this->thumbnail = $r['thumbnail'];
			$this->description = $r['description'];

			$this->save();
			return TRUE;

		} else {

			return FALSE;

		}

	}

	public function delete () {

		// initialized?

		if ( !$this->is_set () ) return FALSE;

		// try deleting

		$q = "delete from `product` where id = ? limit 1";
		$this->db()->q( $q, $this->id );

		if ( $this->db()->num() ) {
			$this->clear();
			return TRUE;
		} else {
			return FALSE;
		}

	}

	// public function getComments()

    };

?>
