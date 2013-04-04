<?php

    class DietaryDatabase {

        private $db;

        public function __construct () {

		$this->db = DB::getInstance();

        }

	public function getProducts ( $search_term, $order_by, $num ) {

		$q = "select `product`.*, avg ( `p_comment`.`p_text` ) as texture, avg ( `p_comment`.`p_qual`) as quality, avg ( `p_comment`.`p_gfre` ) as reliability from `product` join `p_comment` on `product`.`id` = `p_comment`.`product` group by `product`.`id` order by quality;";
		$this->db->q ( $q );
		if ( $this->db->num() )
			return $this->db->pop_all();
		return FALSE;

	}

	public function getRestaurants ( $search_term='', $order_by='', $num=0 ) {

		// FUCK IT.

        $q = " 
SELECT r.`id` , r.`blurb` , r.`name` AS name, 0 AS avg_serv, 0 AS avg_qual, 0 AS avg_pric, 0 AS avg_gfrel
FROM `restaurant` r
LEFT OUTER JOIN `r_comment` c ON r.`id` = c.`restaurant`
WHERE c.`id` IS NULL
UNION
SELECT r.`id` , r.`blurb` , r.`name` AS name, avg( c.`r_serv` ) AS avg_serv, avg( c.`r_qual` ) AS avg_qual, avg( c.`r_pric` ) AS avg_pric, avg( c.`r_gfrel` ) AS avg_gfrel
FROM `restaurant` r, `r_comment` c
WHERE r.`id` = c.`restaurant` 
            ";
    

        if ( !$this->db->q ( $q ) ) {
            return array();
        }

        return $this->db->pop_all();
	}
        

    };

?>
