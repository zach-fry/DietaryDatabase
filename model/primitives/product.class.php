<?php

    class Product extends Primitive {

        public $id;
        public $name;
        public $company;
        public $thumbnail;
        public $description;
        public $tags;

	public function create ( $name, $company, $thumbnail, $description, $tags ) {

		$qr = "insert into `product` ( name, company, thumbnail, description, tags ) values ( '?', '?', '?', '?', '?' ) ";

		if ( $this->db()->q( $qr, $name, $company, $thumbnail, $description, $tags ) ) {

			$this->id = $this->db()->last_inserted();
			$this->name = $name;
			$this->company = $company;
			$this->thumbnail = $thumbnail;
            $this->description = $description;
            $this->tags = $tags;

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
			thumbnail = '?', description = '?', tags = ? limit 1 ";

		if ( $this->db->q ( 
			$qr,
			$this->name,
			intval ( $this->company ),
			$this->thumbnail,
            $this->description,
            $this->tags )
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
            $this->id = $r['id'];
			$this->name = $r['name'];
			$this->company = intval ( $r['company'] );
			$this->thumbnail = $r['thumbnail'];
			$this->description = $r['description'];
            $this->tags = $r['tags'];

			$this->save();
			return TRUE;

		} else {

			return FALSE;

		}

	}

	public function getRatings () {
		if ( !isset ( $this->id ) ) return array();
        $q = "select avg(c.`p_text`) as text, avg(c.`p_qual`) as qual, avg(c.`p_gfre`) as gfre 
              from `p_comment` c where product = $this->id";
        $this->db()->q( $q );
        if (!$this->db()->num() ) return array();


        $res = $this->db()->pop();
        return $res;
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

    public function getReviews() {
        if ( !isset ( $this->id ) ) return array();
        $q = "
            select c.`id` as pid, c.`author` as author, c.`timestamp` as timestamp, c.`p_text` as text, c.`p_qual` as qual, c.`p_gfre` as gfre, c.`comment_text` as comment_text
            from `p_comment` c
            where c.`product` = $this->id 
        ";    
        $this->db()->q( $q );
        if (!$this->db()->num() ) return array();
        $res = $this->db()->pop_all();
        return $res;
    }


    };

?>
