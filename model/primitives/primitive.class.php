<?php

    class Primitive {

        // This object's "fingerprint" of its state.
        // By computing and storing it at certain times,
        // we can reliably determine if it's been changed
        // before committing changes to the database.
        //
        // This way, we can safely expose its members as
        // public and specify behavior as DB transations
        // are needed.
        //
        // It is computed as a simple hash of of the 
        // serialized array of its member variables.

        private $fingerprint;

        protected function save () {

            // grab this object's vars, sans fingerprint

            $vars = get_object_vars ( $this );
            unset ( $vars['fingerprint'] );

            // sort by key value (order matters)

            ksort ( $vars );

            // store

            $this->fingerprint = md5 ( serialize ( $vars ) );

        }

        public function modified () {

            // compute the fingerprint the same way as 
            // above, but compare it instead of saving

            $vars = get_object_vars ( $this );
            unset ( $vars['fingerprint'] );

            ksort ( $vars );

            return md5 ( serialize ( $vars ) ) == $this->fingerprint;

        }

        protected function db () {

            // provide a reference to the database 
            // handler being used by the application

            return DB::getInstance();

        }

    };

?>
