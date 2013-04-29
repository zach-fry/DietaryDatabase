<?php
    if ( !isset($_POST['id']) ) {
        header('Location: /restuarant');
    } else {
        //print_r($_POST);
        $rc = new RestaurantComment();
        $id = $_POST['id'];
        $text = $_POST['comment_text'];
        $serv = $_POST['r_serv'];
        $qual = $_POST['r_qual'];
        $gfre = $_POST['r_gfre'];
        $pric = $_POST['r_pric'];
        $timestamp = time();
        if (!isset($_SESSION['user'])) {
            $author = 0;
        } else {
            $author = $_SESSION['user']->id;
        }
        
        //$author = {INSERT USER ID HERE}
        
        $rc->create($author, $id, $timestamp, $serv, $qual, $pric, $gfre, $text); 
    }
    
    header("Location: /restaurant/".$id);
?>
