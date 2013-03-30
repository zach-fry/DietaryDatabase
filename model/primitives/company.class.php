<?php

    class Company extends Primitive {

        // this object's properties

        public $id;
        public $name;
        public $address;
        public $phone;
        public $website;
        public $email;

        public function set ( $id, $name, $address, $phone, $website, $email ) {

        		$this->id = $id;
        		$this->name = $name;
        		$this->address = $address;
        		$this->phone = $phone;
        		$this->website = $website;
                $this->email = $email;

        }

        public function get_by_id ( $id  ) {

            $id = intval ( $id );
            $query = "select * from `company` where id = $id limit 1";
            $this->db()->q( "select * from `company` where id = $id limit 1" );


        }    

	    public function delete () {
    
    		$this->db()->q ( "delete from `companies` where id = ? limit 1", $this->id );
    
    	}


    };

?>
