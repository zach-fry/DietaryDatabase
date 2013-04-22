<?php

    class DietaryDatabase {

        private $db;
	public $session;
	public $user;

        public function __construct () {

		// grab DB handler

		$this->db = DB::getInstance();

		// create a Session

		$this->session = new Session();

        }

	public function getProducts ( $search_term='', $order_by='', $num=0 ) {
        if( $search_term != '') {
		//query for all products that contain the search term
            $q = "
            select p.`id` as id, p.`name` as name, p.`company` as company, p.`description` as description, p.`tags` as tags, 0 as avg_text, 0 as avg_qual, 0 as avg_gfre
            from (select *
            from `product` p
            where (p.name like '%". $search_term ."%')) as p
            left outer join `p_comment` c on p.`id` = c.`product`
            where c.`id` is null
            union
            select p.`id` as id, p.`name` as name, p.`company` as company, p.`description` as description, p.`tags` as tags, avg(c.`p_text`) as avg_text, avg(c.`p_qual`) as avg_qual, avg(c.`p_gfre`) as avg_gfre
            from (select *
            from `product` p
            where (p.name like '%". $search_term ."%')) as p, `p_comment` c
            where p.`id` = c.`product`
		group by p.`id`, p.`name`, p.`company`, p.`description`, p.`tags`;
            ";
        }
        else {
		//query for all products
            $q = "
            select p.`id` as id, p.`name` as name, p.`company` as company, p.`description` as description, p.`tags` as tags, 0 as avg_text, 0 as avg_qual, 0 as avg_gfre
            from `product` p 
            left outer join `p_comment` c on p.`id` = c.`product`
            where c.`id` is null
            union
            select p.`id` as id, p.`name` as name, p.`company` as company, p.`description` as description, p.`tags` as tags, avg(c.`p_text`) as avg_text, avg(c.`p_qual`) as avg_qual, avg(c.`p_gfre`) as avg_gfre
            from `product` p, `p_comment` c
            where p.`id` = c.`product`
		group by p.`id`, p.`name`, p.`company`, p.`description`, p.`tags`;
            ";
        }
	    if ( !$this->db->q ( $q ) ) {
            echo 'Query Failed';
            return array();    

        }
        $result = $this->db->pop_all();
        return $result;
	}

	public function getRestaurants ( $search_term='', $order_by='', $num=0 ) {

        if ($search_term != '') {
		//query for all restaurants that contain the search term
            $q = "
                select r.`id`, r.`blurb`, r.`name` as name, 0 as avg_serv, 0 as avg_qual, 0 as avg_pric, 0 as avg_gfrel
                from (select *
                from `restaurant` r
                where (r.name like '%". $search_term ."%')) as r left outer join `r_comment` c on 
                    r.`id` = c.`restaurant`
                    where c.`id` is null
                    union
                    select r.`id`, r.`blurb`, r.`name` as name, avg(c.`r_serv`) as avg_serv, avg(c.`r_qual`) as avg_qual, avg(c.`r_pric`) as avg_pric, avg(c.`r_gfrel`) as avg_gfrel
                    from (select *
                    from `restaurant` r
                    where (r.name like '%". $search_term ."%')) as r, `r_comment` c
                where r.`id` = c.`restaurant`    
		group by r.`id`, r.`name`, r.`blurb`
            ";
        }
        else {
		//query for all restaurants
            $q = " 
                SELECT r.`id` , r.`blurb` , r.`name` AS name, 0 AS avg_serv, 0 AS avg_qual, 0 AS avg_pric, 0 AS avg_gfrel, r.`address` as address
                FROM `restaurant` r
                LEFT OUTER JOIN `r_comment` c ON r.`id` = c.`restaurant`
                WHERE c.`id` IS NULL
                UNION
                SELECT r.`id` , r.`blurb` , r.`name` AS name, avg( c.`r_serv` ) AS avg_serv, avg( c.`r_qual` ) AS avg_qual, avg( c.`r_pric` ) AS avg_pric, avg( c.`r_gfrel` ) AS avg_gfrel, r.`address` as address
                FROM `restaurant` r, `r_comment` c
                WHERE r.`id` = c.`restaurant`
		group by r.`id`, r.`name`, r.`blurb`; 
            ";
        }
 
        if ( !$this->db->q ( $q ) ) {
            return array();
        }
        
        $res = array();

        foreach ( $this->db->pop_all() as $rest ) {
            $r = new Restaurant;
            $r->getById( $rest['id'] );
            $res[] =  $r;
            //print_r($r);
        }
        return $res;
	}

	public function registerUserAccount ( $user, $pass, $email ) {

		// check user with same name or email
		// if yes, set flag and quit

		$this->db->q("select * from user where username = '?' or email = '?' limit 1", $user, $email );

		if ( $this->db->num() ) {
			$_SESSION['req']['message'] = "User with that email/username already exists.";
			return false;
		}

		// try to create user
		// if yes, return true
		// if not return, false

		$u = new User ();
		if ( $u->create ( $email, $user, $pass, '', 0, '' ) )
			return true;

		$_SESSION['req']['message'] = "Unresolved backend error. Please try again later.";
		return false;

	}

	public function userLogin ( $user, $pass ) {

		$u = new User();
		if ( !$u->getByUsername ( $user ) )
			return false;
		if ( !$u->password_is ( $pass ) )
			return false;

		return $u;

	}
        

    };

?>
