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

	public function getRestaurants ( $search_term, $order_by, $num ) {

		// FUCK IT.

		$q = "select `restaurant`.*, avg ( `r_comment`.`r_serv` ) as service, avg ( `r_comment`.`r_qual` ) as quality, avg ( `r_comment`.`r_pric`) as price, avg ( `r_comment`.`r_gfrel` ) as reliability
from `restaurant`
join `r_comment` on `restaurant`.`id` = `r_comment`.`restaurant`
group by `restaurant`.`id`
order by service
limit 50";
		$this->db->q ( $q );
		if ( $this->db->num() )
			return $this->db->pop_all();
		return FALSE;

	}
        

    };

?>
