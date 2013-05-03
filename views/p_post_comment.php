<pre>
</pre>
<?php
    if ( !isset($_POST['id']) ) {
        header('Location: /grocery');
    } else {
        //print_r($_POST);
        $pc = new ProductComment();
        $id = $_POST['id'];
        $text = $_POST['comment_text'];
        $txture = $_POST['p_text'];
        $qual = $_POST['p_qual'];
        $gfre = $_POST['p_gfre'];
        $timestamp = time();
        if (!isset($_SESSION['user'])) {
            $author = 0;
        } else {
            $author = $_SESSION['user']->id;
        }


        $pc->create($author, $id, $timestamp, $txture, $qual, $gfre, $text); 
    }
    
    header("Location: /grocery/".$id);
?>
