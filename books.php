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
                <div id="main">
                    <div id="welcome">
                        <h2>مكتبة الكتب لتحميل الكتب مجانا</h2>
                        <p>قراءة أونلاين وتحميل كتب عربية وأجنبية فى شتى المجالات بروابط مباشرة</p>
                    </div>
                    <?php
                        if(!empty($_GET['categorie']))
                        {
                            $id = $_GET['categorie'];
                            $id = trim($id);
                            $id = htmlspecialchars($id);
                            $id = strip_tags($id);
                            $id = stripslashes($id);
                            $query = mysqli_query($cnx, "SELECT * FROM categories WHERE idCate = ".$id."");
                            $rslt = mysqli_fetch_array($query);
                            echo'<section>';
                            echo'<header>';
                            echo'<p class="title">'.$rslt[1].'</p>';
                            echo'</header>';
                            
                            $rslt = mysqli_query($cnx, "SELECT * FROM book WHERE idCate = ".$id." AND accepter LIKE 'yes'");
                            while($row = mysqli_fetch_array($rslt))
                            {
                                echo'<article>';
                                $row[0] = trim($row[0]);
                                $row[0] = htmlspecialchars($row[0]);
                                $row[0] = strip_tags($row[0]);
                                $row[0] = stripslashes($row[0]);
                                echo'<a href="book.php?idbook='.$row[0].'" title="'.$row[1].'">';
                                echo'<img src="'.$row[8].'" />';
                                echo'<p>'.$row[1].'</p>';
                                echo'</a>';
                                echo'</article>';
                            }
                            echo'</section>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
            include './inc/footer.php';
        ?>
        <script src="js/js.js"></script>
    </body>
</html>
<?php
    $db->Disconnect($cnx);
?>