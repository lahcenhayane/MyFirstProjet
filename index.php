<?php
    require '../WebSiteBook/config/config.php';
    $db = new Config();
    $cnx = $db->Connect();

    session_start();
    if(isset($_SESSION['email']))
    {
        header("location: home.php");
    }
?>
<!DOCETYPE html>
<html lang="ar">
    <head>
        <title>مكتبة الكتب</title>
        <link rel="icon" href="img/icon-Books.ico" />
        <meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width = device-width, initial-scale = 1.0" />
        <link rel="stylesheet" href="css/style.css"/>
    </head>
    <body>
        
        <?php
            include './inc/headerLogin.php';
        ?>
        <?php
            include './inc/nav.php';
        ?>
        
        <div id="container">
            <div id="content">
                <?php
                    include './inc/aside.php';
                ?>
                <?php
                    include './inc/main.php';
                ?>
            </div>
        </div>
        <?php
            include './inc/footer.php';
        ?>
        <script src="js/js.js"></script>
    </body>
</html>
