<?php
/*
	header ( "Content-type: text/plain" );
	echo file_get_contents ( "./model/mysqldb.class.php" );
*/

	header ( "Content-type: text/plain" );
	include ( "index.php" );

	$db = DB::getInstance();
	echo ( $db->is_okay() ? 'okay()' : 'not okay()' ) . "\n";

?>
