<?php

	// dumb object, operated exclusively upon by User's
	// createProductComment() and deleteProductComment()

    class ProductComment extends Primitive {

        public $id;
        public $author;
        public $timestamp;
        public $t_text;
        public $r_pric;
        public $r_qual;
        public $r_gfre;
        public $comment_text;

    };

?>
