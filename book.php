<?php
    require './config/config.php';
    $db = new Config();
    $cnx = $db->Connect();
    session_start();

    $arr = array();
    $username = $commenter = $NomPre = null;
    
    //idbook
    $idbook = null;
    

    if(isset($_SESSION['NomPrenom']))
    {
        $NomPre = $_SESSION['NomPrenom'];       
    }

    if(isset($_POST['commentaire']))
    {
        $username = $_POST['UserName'];
        if(!empty($username))
        {
            if($username > 6 && $username < 80)
            {
                $username = htmlspecialchars($username);
                $username = strip_tags($username);
                $username = stripslashes($username);
            }
            else
            {
                array_push($arr, "يجب أيكون الإسم كامل بين 7 و 79 حرف.<br>");
            }
        }
        else
        {
            array_push($arr, "خانة الإسم كامل فارغة.<br>");
        }
        
        
        $commenter = $_POST['com'];
        if(!empty($commenter))
        {
            $commenter = htmlspecialchars($commenter);
            $commenter = strip_tags($commenter);
            $commenter = stripslashes($commenter);
        }
        else
        {
            array_push($arr, "خانة تعليق فارغة.<br>");
        }
        
        if(empty($arr))
        {
            if(isset($NomPre))
            {
                mysqli_query($cnx, "INSERT INTO commentaire VALUES('','".$NomPre."','".$commenter."','".$idbook."')");
            }
            else
            {
                mysqli_query($cnx, "INSERT INTO commentaire VALUES('','".$username."','".$commenter."','".$idbook."')");
            }
            
        }
    }
    

?>
<!DOCETYPE html>
<html lang="ar">
    <head>
        <title>كتب</title>
        <meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width = device-width, initial-scale = 1.0" />
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/styleBook.css" />
        
    </head>
    <body>
        
        <?php
            if(isset($_SESSION['email']))
            {
                include './inc/headerHome.php';
            }
            else
            {
                include './inc/headerLogin.php';
            }
        ?>
        <?php
            include './inc/nav.php';
        ?>
        
        <div id="container">
            <div id="content">
                <?php
                    include './inc/aside.php';
                ?>
                <article>
                    <header>
                        <img src="img/banner.jpg" title="ads" />
                    </header>
                    <div id="mainBook">
                        <?php
                            if(!empty($_GET['idbook']))
                            {
                                $idbook = $_GET['idbook'];
                                $idbook = trim($idbook);
                                $idbook = htmlspecialchars($idbook);
                                $idbook = strip_tags($idbook);
                                $idbook = stripslashes($idbook);
                                $query = mysqli_query($cnx, "SELECT B.*, C.nomCate, U.NomPrenom FROM book B, categories C, user U WHERE C.idCate=B.idCate and B.idUser = U.idUser and idBook = '".$idbook."'");
                                $row = mysqli_fetch_array($query);
                                
                                echo'<div id="aside1Book">';
                                echo'<img src="'.$row[8].'" title="img" />';
                                echo'</div>';
                                echo'<div id="aside2Book">';
                                echo'<ul>';
                                echo'<li>';
                                echo'<p>اسم الكتاب:<span>'.$row[1].'</span></p>';
                                echo'</li>';
                                echo'<li>';
                                echo'<p>اسم الكاتب:<span>'.$row[2].'</span></p>';
                                echo'</li>';
                                echo'<li>';
                                $row[4] = trim($row[4]);
                                $row[4] = htmlspecialchars($row[4]);
                                $row[4] = strip_tags($row[4]);
                                $row[4] = stripslashes($row[4]);
                                echo'<p>التصنيفات:<span><a href="books.php?categorie='.$row[4].'">'.$row[9].'</a></span></p>';
                                echo'</li>';
                                echo'<li><p><span>'.$row[10].'</span>: بواسطة</p></li>';
                                echo'<li><p>عدد التحميلات:<span>69839</span></p></li>';
                                echo'<li>';
                                echo'<ul>';
                                echo'<li><p>:شارك الكتاب مع أصدقائك</p></li>';
                                echo'<li><a href="#"><img src="img/socilaMedia/facebook.png" /></a></li>';
                                echo'<li><a href="#"><img src="img/socilaMedia/twitter.png" /></a></li>';
                                echo'<li><a href="#"><img src="img/socilaMedia/whatsapp.png" /></a></li>';
                                echo'</ul>';
                                echo'</li>';
                                echo'</ul>';
                                echo'</div>';
                                echo'</div>';
                                echo'<div id="descriptionBook">';
                                echo'<p>وصف الكتاب:<span>'.$row[3].'</span></p>';
                                echo'</div>';
                                echo'<div id="footer">';
                                echo'<h2>روابط تحميل و قراءة الكتاب</h2>';
                                echo'<div id="adsBook">';
                                echo'<img src="img/banner.jpg" title="ads" />';
                                echo'</div>';
                                echo'<div id="doalond">';
                                echo'<ul>';
                                echo'<li><a href="'.$row[7].'" target="_black">روابط تحميل</a></li>';
                                echo'<li><a href="'.$row[7].'" target="_black">قراءة الكتاب</a></li>';
                                echo'</ul>';
                                echo'</div>';
                            }
                        ?>
                        
                        <div id="adsBook">
                            <img src="img/banner.jpg" title="ads" />
                        </div>
                    </div>
                    <div id="commentaire">
                        <h3>تعليقات</h3>
                        <ul>
                            <?php
                                $query = mysqli_query($cnx, "SELECT * FROM commentaire WHERE idBook = '".$idbook."'");
                            
                                while($row = mysqli_fetch_array($query))
                                {
                                    echo'<li>';
                                    echo'<div id="logoCom">';
                                    echo'<img src="img/head_green_sea.png" />';
                                    echo'</div>';
                                    echo'<div id="UserDesc">';
                                    echo'<p>'.$row[1].'</p>';
                                    echo'<p>'.$row[2].'</p>';
                                    echo'</div>';
                                    echo'</li>';
                                }
                            ?>
                        </ul>
                        <div id="txtCom">
                            <form action="" method="post">
                                <?php
                                   if(isset($_SESSION['email']))
                                    {
                                        echo'<p>'.$NomPre.' :الإسم كامل</p>';
                                    }
                                    else
                                    {
                                        echo'<p>:الإسم كامل</p>';
                                        echo'<input type="text" name="UserName" value="'.$username.'" required />';
                                        echo'<p class="error">';
                                            if(in_array("يجب أيكون الإسم كامل بين 7 و 79 حرف.<br>", $arr))
                                            {
                                                echo"يجب أيكون الإسم كامل بين 7 و 79 حرف.<br>";
                                            }
                                            elseif(in_array("خانة الإسم كامل فارغة.<br>", $arr))
                                            {
                                                echo"خانة الإسم كامل فارغة.<br>";
                                            }
                                        echo'</p>';
                                    }
                                ?>
                                
                                <p>:تعليق</p>
                                <textarea name="com" required></textarea>
                                <?php
                                    echo'<p class="error">';
                                        if(in_array("خانة تعليق فارغة.<br>", $arr))
                                        {
                                            echo'خانة تعليق فارغة.<br>';
                                        }
                                    echo'</p>';
                                ?>
                                <input type="submit" name="commentaire" value="أضف تعليق" />
                            </form>
                        </div>
                    </div>
                </article>
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