<?php
    require '../WebSiteBook/config/config.php';
    $db = new Config();
    $cnx = $db->Connect();

    session_start();

    if(isset($_SESSION['NomPrenom']))
    {
        $NomPrenom = $_SESSION['NomPrenom'];
        header("refresh:3; url=home.php");
    }
    else
    {
        header("location: login.php");
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
        <link rel="stylesheet" href="css/styleAccountTrue.css"/>
    </head>
    <body>
        
        <?php
            include './inc/headerHome.php';
        ?>
        <?php
            include './inc/nav.php';
        ?>
        
        <div id="container">
            <div id="content">
                <div id="logIn">
                    <div id="welcome">
                        <img src="img/head_green_sea.png" alt="LogoUser" />
                        <h2><?php echo"$NomPrenom"; ?></h2>
                        <h3>مرحبا بك في أكبر موقع لمكتبة المستقبل لتحميل مجانا</h3>
                        <p>قراءة أونلاين وتحميل كتب عربية وأجنبية فى شتى المجالات بروابط مباشرة</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            include './inc/footer.php';
        ?>
        <script src="js/js.js"></script>
    </body>
</html>
