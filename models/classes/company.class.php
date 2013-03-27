<?php

    class Company {

        public $id;
        public $name;
        public $address;
        public $phone;
        public $website;
        public $email;

	private $dh;

	public function Company ( $id, $name, $address, $phone, $website, $email ) {

		$this->id = id;
		$this->name = name;
		$this->address = address;
		$this->phone = phone;
		$this->website = website;
		$this->email = email;

		$this->dh = new MySQLDB ( DB_HOST, DB_TABLE, DB_USER, DB_PASS );

	}

	public function commit () {

		// make MySQLDB either update or insert this object as a row in ~user~

	}

	public function delete () {

		$this->dh->q ( "delete from users where id = ? limit 1", this->id );

	}

	// public function edit()

    };

?>
