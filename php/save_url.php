<?php
    include("config.php");
    $long_url = mysqli_real_escape_string($conn, $_POST['shorten_url']);
    $full_url = str_replace(" ", "", $long_url); //remove spaces from url
    $hidden_url = mysqli_real_escape_string($conn, $_POST['hidden_url']);

    if(!empty($full_url)){
        $domain = "localhost";
        //check if user entered a valid url
        if(preg_match("/{$domain}/i", $full_url) && preg_match("/\//i", $full_url)){
            $explode_url = explode("/", $full_url);
            $short_url = end($explode_url);
            if(!empty($short_url)){
                $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '$short_url' && shorten_url != '$hidden_url'");
                if(mysqli_num_rows($sql) == 0){
                    //update url
                    $sql2 = mysqli_query($conn, "UPDATE url SET shorten_url = '$short_url' WHERE shorten_url = '$hidden_url'");
                    if($sql2){
                        echo "success";
                    }else{
                        echo "Something went wrong";
                    }
                }else{
                    echo "URL already exists";
                }
            }else{
                echo "Please enter a short URL";
            }
        }else{
            echo "You can't edit the domain name of the URL. Please enter a valid URL.";
        }
    }else{
        echo "Please enter a short URL";
    }
