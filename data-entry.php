<?php

    ini_set ( 'display_errors', 1 );
    // ini_set ( 'include_path', '.' );

    require ( './config.php' );
    require ( './model/mysqldb.class.php' );
    require ( './model/dd.class.php' );

    // grab all includes in lower directories

    require ( '/var/www/model/primitives/primitive.class.php' );
    require ( '/var/www/model/primitives/company.class.php' );
    require ( '/var/www/model/primitives/p_comment.class.php' );
    require ( '/var/www/model/primitives/p_favorite.class.php' );
    require ( '/var/www/model/primitives/product.class.php' );
    require ( '/var/www/model/primitives/r_comment.class.php' );
    require ( '/var/www/model/primitives/r_favorite.class.php' );
    require ( '/var/www/model/primitives/restaurant.class.php' );
    require ( '/var/www/model/primitives/user.class.php' );
    require ( '/var/www/model/primitives/session.class.php' );

	// M-M-M-Markdown

	require ( '/var/www/includes/markdown.php' );

    if ( !isset ( $config['db'] ) )
        die ( 'Database configuration not found.' );

    DB::setup (
        $config['db']['host'],
        $config['db']['user'],
        $config['db']['pass']
    );

	if ( DB::$dh == NULL )
		die ( 'setup() didn\'t set' );

	$db = DB::getInstance();
	if ( !$db->select_db ( $config['db']['db'] ) )
		die ( "Couldn't select database '{$config['db']['db']}'\n" );    
    
	if ( DB::$dh == NULL || !$db->is_okay () )
		die ( 'Failed to establish a connection to the database with the given credentials.' );

    echo "<pre>";

    $fc = count(glob('/var/www/views/img/r_thumbs/' . '*'));

    $row = 1;
    if (($handle = fopen("Sheet1.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($row == 1) {
                $row += 1;
            }
            else {
                print_r($data);
                $r = new Restaurant;
                //create ( $n, $w, $p, $a, $la, $lo, 
                //         $m, $t, $b )

                $thumb_url = $data[9];
                $img = file_get_contents($thumb_url);
                $img_path = $fc.'.jpg';
                file_put_contents($img_path, $img);
                $fc += 1;

                echo ( $r->create($data[1], $data[2], $data[3], $data[4], $data[5], $data[6], 
                           $data[8], $img_path, $data[10] 
                       ) ? "good" : "bad" . $db->qs() . "\n");
            $row += 1;
            }
        }
        fclose($handle);
    }
?>
