<?php
    include("config.php");
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = mysqli_query($conn, "DELETE FROM url WHERE shorten_url = '$id'");
        if($sql){
            header("Location: ../");
        }else{
            header("Location: ../");
        }
    }elseif(isset($_GET['delete'])){
        $delete = mysqli_real_escape_string($conn, $_GET['delete']);
        if($delete == "all"){
            $sql = mysqli_query($conn, "DELETE FROM url");
            if($sql){
                header("Location: ../");
            }else{
                header("Location: ../");
            }
        }else{
            header("Location: ../");
        }
    }
    else{
        header("Location: ../");
    }
