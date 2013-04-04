<?php

    class Restaurant extends Primitive {

        public $id;
        public $name;
        public $website;
        public $phone;
        public $address;
        public $lat;
        public $long;
        public $menu_url;
        public $thumbnail;
        public $blurb;

	public function create ( $n, $w, $p, $a, $la, $lo, $m, $t, $b ) {

		$qr = "insert into `restaurant` ( name, website, phone, address,
			geo_lat, geo_long, menu_url, thumbnail, blurb ) values (
			'?', '?', '?', '?' ,'?', ?, '?', '?', '?' )";

		if ( $this->db()->q( $qr, $n, $w, $p, $a, $la, $lo, $m, $t, $b ) ) {

			$this->id = $this->db()->last_inserted();
			$this->name = $n;
			$this->website = $w;
			$this->phone = $p;
			$this->address = $a;
            $this->lat = $la;
            $this->long = $lo;
			$this->menu_url = $m;
			$this->thumbnail = $t;
			$this->blurb = $b;

			$this->save();
			return TRUE;

		} else {

			return FALSE;

		}

	}

	public function update () {

		if ( !$this->is_set() ) return false;
		if ( !$this->modified() ) return true;

		$q = "
			update `restaurant` set
			name = '?', website = '?', phone = '?',
			address = '?', geo_lat = '?', geo_long= '?', menu_url = '?',
			thumbnail = '?', blurb = '?' limit 1
		";

		if ( $this->db()->q ( 
			$q,
			$this->name,
			$this->website,
			$this->phone,
			$this->address,
            $this->lat,
            $this->long,
			$this->menu_url,
			$this->thumbnail,
			$this->blurb
		) ) {

			$this->save();
			return TRUE;

		} else {

			return FALSE;

		}

	}

	// public function getComments()

	}

?>
