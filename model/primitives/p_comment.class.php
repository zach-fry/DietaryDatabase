<?php

	// dumb object, operated exclusively upon by User's
	// createProductComment() and deleteProductComment()

    class ProductComment extends Primitive {

        public $id;
        public $author;
        public $product;
        public $timestamp;
        public $p_text;
        public $p_qual;
        public $p_gfre;
        public $comment_text;

        public function create($a, $p, $t, $tx, $q, $gf, $txt) {
            $qr = "
                insert into `p_comment` ( author, product, timestamp, p_text, p_qual, p_gfre, comment_text )
                values ( '?', '?', '?', '?', '?', '?', '?')
            "; 
            
            if ( $this->db()->q($qr, $a, $p, $t, $tx, $q, $gf, $txt) ) {
                $this->id = $this->db()->last_inserted();
                $this->author = $a;
                $this->product = $p;
                $this->timestamp = $t;
                $this->p_text = $tx;
                $this->p_qual = $q;
                $this->r_gfre = $gf;
                $this->comment_text = $txt;

                $this->save();
                return TRUE;
            } else {
                return FALSE;
            }
        }

    };

?>
