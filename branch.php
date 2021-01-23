<?php

    if(isset($_POST['edit'])==true){
        $id=$_POST['id'];
        header('Location:edit.php?id='.$id);
        exit();
    }

    if(isset($_POST['delete'])==true){
        $id=$_POST['id'];
        header('Location:delete_check.php?id='.$id);
        exit();
    }
?>