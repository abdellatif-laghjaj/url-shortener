<?php
    include("config.php");
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = mysqli_query($conn, "DELETE FROM url WHERE shorten_url = '$id'");
        if($sql){
            header("Location: ../");
        }else{
            echo "Something went wrong. Please try again.";
            header("Location: ../");
        }
    }
?>