<?php

    echo "<pre>";

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

    if ( !isset ( $config['db'] ) )
        die ( 'Database configuration not found.' );

    DB::setup (
        $config['db']['host'],
        $config['db']['user'],
        $config['db']['pass'],
        $config['db']['db']
    );

    if ( DB::$dh == NULL )
        die ( 'setup() didn\'t set' );

    $db = DB::getInstance();
    
    if ( DB::$dh == NULL || !$db->is_okay () )
            die ( 'Failed to establish a connection to the database with the given credentials.' );

?>
