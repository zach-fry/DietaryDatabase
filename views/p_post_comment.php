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
        $author = 0;
        //$author = {INSERT USER ID HERE}


        $pc->create($author, $id, $timestamp, $txture, $qual, $gfre, $text); 
    }
    
    header("Location: /grocery/".$id);
?>
