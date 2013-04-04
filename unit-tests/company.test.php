<?php
/*
	header ( "Content-type: text/plain" );
	echo file_get_contents ( "./model/mysqldb.class.php" );
*/

	header ( "Content-type: text/plain" );
	include ( "index.php" );

	$db = DB::getInstance();
	echo ( $db->is_okay() ? 'okay()' : 'not okay()' ) . "\n";

	$c = new Company ();
	print_r ( $c );
	echo $c->create ( "test_company_name", "100 elm st", "555-5555", "www.company.com", "aaaaa" ) ? "created well\n" : "create failed\n";
	print_r ( $c );
	$c->name = "new_company_name";
	echo $c->modified() ? "was modified\n" : "was not modified\n";
	print_r ( $c );
	echo $c->update() ? "updated fine" : "update failed";
	print_r ( $c );

	echo ( $c->delete() ? "deleted fine" : "delete failed" ) . "\n";

	echo mysql_error();

?>
