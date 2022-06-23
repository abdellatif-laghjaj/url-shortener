<?php
include("php/config.php");

$new_url = "";
$domain = "localhost/url-shortener/";

if (isset($_GET)) {
    foreach ($_GET as $key => $val) {
        $u = mysqli_real_escape_string($conn, $key);
        //remove / from url
        $new_url = str_replace("/", "", $u);
    }
    $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '$new_url'");
    if (mysqli_num_rows($sql) > 0) {
        $count_query = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '$new_url'");

        if ($count_query) {
            //redirect user to full url
            $full_url = mysqli_fetch_assoc($sql);
            header("Location:" . $full_url['full_url']);
        }
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
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css">
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
        if (mysqli_num_rows($sql2) > 0) {
        ?>
            <!-- Counts -->
            <div class="count">
                <?php
                $sql3 = mysqli_query($conn, "SELECT SUM(clicks) AS total_clicks FROM url");
                $sql4 = mysqli_query($conn, "SELECT COUNT(*) AS total_urls FROM url");
                $total_clicks = mysqli_fetch_assoc($sql3);
                $total_urls = mysqli_fetch_assoc($sql4);
                ?>
                <span>
                    Total URLs : <span><?php echo end($total_urls) ?></span> and Total clicks : <span><?php echo end($total_clicks) ?></span>
                </span>
                <a href="php/delete.php?delete=all">Clear All</a>
            </div>

            <!-- Links -->
            <div class="urls-area">
                <!-- List of URLs -->
                <div class="title">
                    <li>Shorten URL</li>
                    <li>Original URL</li>
                    <li>Clicks</li>
                    <li>Action</li>
                </div>
                <?php
                while ($row = mysqli_fetch_assoc($sql2)) {
                ?>
                    <!-- URLs data -->
                    <div class="data">
                        <li>
                            <a href="<?php echo $row['shorten_url'] ?>" target="_blank">
                                <?php
                                if ($domain . $row['shorten_url'] > 50) {
                                    echo substr($domain . $row['shorten_url'], 0, 50) . "...";
                                } else {
                                    echo $domain . $row['shorten_url'];
                                }
                                ?>
                            </a>
                        </li>
                        <li>
                            <?php
                            if (strlen($row['full_url']) > 50) {
                                echo substr($row['full_url'], 0, 50) . "...";
                            } else {
                                echo $row['full_url'];
                            }
                            ?>
                        </li>
                        <li><?php echo $row['clicks'] ?></li>
                        <li>
                            <a href="php/delete.php?id=<?php echo $row['shorten_url'] ?>">
                                <i data-feather="trash-2"></i>
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


    <section class="copyright">
        <p>
            Made with ❤️ by <a href="https://github.com/abdellatif-laghjaj" target="_blank">Abdellatif Laghjaj</a>
        </p>
    </section>

    <!-- ICONS -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace()
    </script>

    <!-- JAVASCRIPT -->
    <script src="js/main.js"></script>
    <script src="https://unpkg.com/notie"></script>
</body>

</html>