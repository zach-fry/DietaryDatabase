<?php

    class Restaurant extends Primitive {

        public $id;
        public $name;
        public $website;
        public $phone;
        public $address;
        public $geo_lat;
        public $geo_long;
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

	public function getById ( $id ) {

		$q = "select * from `restaurant` where id = $id limit 1";
		$this->db()->q( $q, $id );
		if ( !$this->db()->num() ) return false;

		$res = $this->db()->pop();
		$this->id = $res['id'];
		$this->name = $res['name'];
		$this->website = $res['website'];
		$this->phone = $res['phone'];
		$this->address = $res['address'];
		$this->geo_lat = $res['geo_lat'];
		$this->geo_long = $res['geo_long'];
		$this->menu_url = $res['menu_url'];
		$this->thumbnail = $res['thumbnail'];
		$this->blurb = $res['blurb'];

		$this->save();
		return TRUE;

	}

	public function getRatings () {
		if ( !isset ( $this->id ) ) return array();
        $q = "select avg(c.`r_serv`) as serv, avg(c.`r_qual`) as qual, avg(c.`r_pric`) as pric, avg(c.`r_gfrel`) as gfrel from `r_comment` c where restaurant = $this->id";
        $this->db()->q( $q );
        if (!$this->db()->num() ) return array();
        $res = $this->db()->pop();
        return $res;
	}

    public function getReviews() {
        if ( !isset ( $this->id ) ) return array();
        $q = "
            select c.`id` as cid, c.`author` as author, c.`timestamp` as timestamp, c.`r_serv` as serv, c.`r_qual` as qual, c.`r_pric` as pric, c.`r_gfrel` as gfrel, c.`comment_text` as comment_text, c.`tags` as tags
            from `r_comment` c
            where c.`restaurant` = $this->id 
        ";    
        $this->db()->q( $q );
        if (!$this->db()->num() ) return array();
        $res = $this->db()->pop_all();
        return $res;
    }

    };
?>
