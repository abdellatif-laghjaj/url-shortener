<?php
    include("php/config.php");
    $new_url = "";
    if(isset($_GET)){
        foreach($_GET as $key=>$val){
            $u = mysqli_real_escape_string($conn, $key);
            //remove / from url
            $new_url = str_replace("/", "", $u);
        }
        $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '$new_url'");
        if(mysqli_num_rows($sql) > 0) {
            //redirect user to full url
            $full_url = mysqli_fetch_assoc($sql);
            header("Location:".$full_url['full_url']);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>URL Shortener</title>
</head>
<body>
    <div class="wrapper">
        <!-- Form -->
        <form action="#" method="post">
            <input type="text" name="full_url" placeholder="Paste your URL here..." required>
            <i class="url-link" data-feather="link-2"></i>
            <button type="submit">slash</button>
        </form>

        <?php
                $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
                if(mysqli_num_rows($sql2) > 0) {
                    ?>
                    <!-- Counts -->
                    <div class="count">
                        <span>
                            Total URLs : <span>0</span> and Total clicks : <span>0</span>
                        </span>
                        <a href="">Clear All</a>
                    </div>

                    <!-- Links -->
                    <div class="urls-area">
                        <!-- List of URLs -->
                        <div class="title">
                            <li>Shortde URL</li>
                            <li>Original URL</li>
                            <li>Clicks</li>
                            <li>Action</li>
                        </div>       
                        <?php
                            while($row = mysqli_fetch_assoc($sql2)) {
                        ?>
                        <!-- URLs data -->  
                        <div class="data">
                            <li>
                                <a href="<?php echo $row['shorten_url'] ?>" target="_blank">
                                    <?php
                                        if("localhost/url-shortener/".$row['shorten_url'] > 50){
                                            echo substr("localhost/url-shortener/".$row['shorten_url'], 0, 50)."...";
                                        }else{
                                            echo "localhost/url-shortener/".$row['shorten_url'];
                                        }
                                    ?>
                                </a>
                            </li>
                            <li>
                            <?php
                                if(strlen($row['full_url']) > 50){
                                    echo substr($row['full_url'], 0, 50)."...";
                                }else{
                                    echo $row['full_url'];
                                }
                            ?>
                            </li>
                            <li><?php echo $row['clicks']?></li>
                            <li>
                                <a href="">
                                    <i data-feather="trash"></i>
                                </a>
                            </li>
                        </div>
                        <?php
                    }
                    ?>  
                    </div>
                    <?php
                }
                ?>
    </div>

    <!-- blur effect -->
    <div class="blur-effect"></div>
 
    <!-- popup box -->
    <div class="popup-box">
        <div class="info-box">
            Your URL has been successfully shortened. You can edit it or copy it. But once it's saved, it can't be edited.
        </div>
        <form action="#">
            <label>Edit your shorten URL</label>
            <input type="text" value="" spellcheck="false">
            <i class="copy-icon" data-feather="copy"></i>
            <button>Save</button>
        </form>
    </div>

    <!-- ICONS -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace()
    </script>

    <!-- JAVASCRIPT -->
    <script src="js/main.js"></script>
</body>
</html>