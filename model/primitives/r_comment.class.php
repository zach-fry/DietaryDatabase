<?php

    class RestaurantComment extends Primitive {

        public $id;
        public $author;
        public $restaurant;
        public $timestamp;
        public $r_serv;
        public $r_qual;
        public $r_pric;
        public $r_gfrel;
        public $comment_text;

        public function create($a, $r, $t, $s, $q, $p, $gf, $txt) {
            $qr = "
                insert into `r_comment` ( author, restaurant, timestamp, r_serv, r_qual, r_pric, r_gfrel, comment_text )
                values ( '?', '?', '?', '?', '?', '?', '?', '?')
            "; 
            
            if ( $this->db()->q($qr, $a, $r, $t, $s, $q, $p, $gf, $txt) ) {
                $this->id = $this->db()->last_inserted();
                $this->author = $a;
                $this->restaurant = $r;
                $this->timestamp = $t;
                $this->r_serv = $s;
                $this->r_qual = $q;
                $this->r_pric = $p;
                $this->r_gfrel = $gf;
                $this->comment_text = $txt;

                $this->save();
                return TRUE;
            } else {
                return FALSE;
            }
        }
    };

?>
