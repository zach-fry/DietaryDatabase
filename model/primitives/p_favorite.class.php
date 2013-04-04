<?php

	// see User::addProductFavorite(), User::deleteProductFavorite()

    class ProductFavorite extends Primitive {

        public $id;
        public $user;
        public $product;
        public $timestamp;

	public function ProductFavorite ( $id, $user, $product, $timestamp ) {

		$this->id = $id;
		$this->user = $user;
		$this->product = $product;
		$this->timestamp = $timestamp;	

	}

    }

?>
