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

	// we pollute $_SESSION-space, so unset it pre-emptively

	unset ( $_SESSION['req'] );

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

	// site-based functions need an instance of DD

	$site = new DietaryDatabase ();

	// route.

	if ( !isset ( $_GET['section'] ) )
		require ( './views/homepage.php' );
    else {
        switch ( $_GET['section'] ) {
            case 'grocery':
                if ( !isset ( $_GET['action'] ) )
                    require ( './views/grocery_index.php' );
                else {
                    switch ( $_GET['action'] ) {
                        case 'recent':
                            require ( './views/grocery_index.php' );
                        break;
                        case 'most_reviewed':
                            require ( './views/grocery_most_reviewed.php' );
                        break;
                        case 'highest_rated':
                            require ( './views/grocery_highest_rated.php' );
                        break;
                        case 'post_comment':
                            require ( './views/p_post_comment.php' );
                        break;
                        default:
                            if ( is_int( intval( $_GET['action'] ) ) ) {
                                require ( './views/grocery.php' );
                            }
                        break;
                    }
                }
                break;

                case 'restaurant':
                    if ( !isset ( $_GET['action'] ) )
                        require ( './views/restaurant_index.php' );
                    else {
                        switch ( $_GET['action'] ) {
                            case 'recent':
                                require ( './views/restaurant_index.php' );
                            break;
                            case 'most_reviewed':
                                require ( './views/restaurant_most_reviewed.php' );
                            break;
                            case 'highest_rated':
                                require ( './views/restaurant_highest_rated.php' );
                            break;
                            case 'post_comment':
                                require ( './views/r_post_comment.php' );
                            break;
                            default:
                                if ( is_int( intval( $_GET['action'] ) ) ) {
                                    require ( './views/restaurant.php' );
                                }
                            break;
                        }
                    }
                break;

                case 'user':
                    require ( './views/user.php' );
                break;

                case 'search':
                    if (!isset ( $_POST['keywords'] ) ) {
                        require ( './views/search_index.php' );
                    } else {
                        require ( './views/search_list.php' );
                    }
                break;
                
                case 'company':
                    require ( './views/company_index.php' );
                break;

                case 'register':
                    
                    // if trying to submit a register request,

                    if ( isset ( $_POST ) && !empty ( $_POST ) ) {

                        // do some preliminary checks

                        if ( $_POST['password'] !== $_POST['password2'] ) {
                            $_SESSION['req']['status'] = 0;
                            $_SESSION['req']['message'] = "Password/confirmation mismatch.";
                        }

                        foreach ( $_POST as $p )
                            if ( empty ( $p ) ) {					
                                $_SESSION['req']['status'] = 0;
                                $_SESSION['req']['message'] = "Not all fields completed.";
                            }

                        // pass it along to $site->register()

                        // take its result and assign a flag to $_SESSION,
                        // where ./views/register.php will display the 
                        // appropriate message
                        // (always invoke that view)
                        
                        if (  $site->registerUserAccount( $_POST['username'], $_POST['password'], $_POST['email'] ) ) {
                            $_SESSION['req']['status'] = 1;
                        }


                    }

                    require ( './views/register.php' );

                break;

                case 'login':

                    if ( isset ( $_POST['user'] ) && isset ( $_POST['pass'] ) ) {
                         $u = $site->userLogin ( $_POST['user'], $_POST['pass'] );
                        if ( $u !== false ) {
                            $site->user = $u;
                            $_SESSION['user'] = $u;
                            header ( "Location: /" );
                        } else {
                            $_SESSION['req']['status'] = 0;
                            require ( './views/login.php' );
                            break;
                        }
                    }
                
                    require ( './views/login.php' );

                break;

                case "logout":
                    session_destroy();
                    header ( "Location: /" );
                break;

                case 'test':
                    require ( './views/dummy.php' );
                break;


                default:
                break;
        }
    }

?>
