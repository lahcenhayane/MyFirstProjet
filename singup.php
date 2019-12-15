<?php    
    require '../WebSiteBook/config/config.php';
    $db = new Config();
    $cnx = $db->Connect();
    
    session_start();

    if(isset($_SESSION['email']))
    {
        header("location: home.php");
    }
    else
    {
        $arr = array();

    $dateInscription = date("Y-m-d h:i:s");
    $nom = $prenom = $nomUtil = $email = $pass = $confPass = $sexe = $date = "";

    if(isset($_POST["singup"])){
        
        //input name
        $nom = $_POST["nom"];
        if(empty($nom))
        {
            array_push($arr, "خانة الإسم فارغة.<br>");
        }
        else
        {
            if(is_numeric($nom))
            {
                array_push($arr, "لايجد إسم بأرق.<br>");
            }
            else
            {
                if(strlen($nom) > 4 && strlen($nom) < 30)
                {
                    $nom = htmlspecialchars($nom);
                    $nom = trim($nom);
                    $nom = stripslashes($nom);
                }
                else
                {
                    array_push($arr, "يجب أيكون الإسم بين 3 و 29 حرف.<br>");
                }
            }
        }
        
        //input prenom
        $prenom = $_POST["prenom"];
        if(empty($prenom))
        {
            array_push($arr, "خانة الإسم العائلي فارغة.<br>");
        }
        else
        {
            if(is_numeric($prenom))
            {
                array_push($arr, "لايجد إسم العائلي بأرق.<br>");
            }
            else
            {
                if(strlen($prenom) > 4 && strlen($prenom) < 39)
                {
                    $prenom = htmlspecialchars($prenom);
                    $prenom = trim($prenom);
                    $prenom = stripslashes($prenom);
                }
                else
                {
                    array_push($arr, "يجب أيكون الإسم بين 3 و 39 حرف.<br>");
                }
            }
        }
        
        //input nomPrenom
        $nomUtil = $_POST["nomPrenom"];
        if(empty($nomUtil))
        {
            array_push($arr, "خانة الإسم فارغة.<br>");
        }
        else
        {
            if(is_numeric($nomUtil))
            {
                array_push($arr, "لايجد إسم المستخدم  بأرق.<br>");
            }
            else
            {
                if(strlen($nomUtil) > 8 && strlen($nomUtil) < 99)
                {
                    $nomUtil = htmlspecialchars($nomUtil);
                    $nomUtil = trim($nomUtil);
                    $nomUtil = stripslashes($nomUtil);
                    
                    $query = mysqli_query($cnx,"SELECT * FROM user WHERE NomPrenom LIKE '".$nomUtil."'");
                    $rslt = mysqli_num_rows($query);
                    if($rslt != 0)
                    {
                        array_push($arr, "معرف المستخدم مستخدم من قبل.<br>");
                    }
                }
            }
        }
        
        //input email
        $email = $_POST["email"];
        if(empty($email))
        {
            array_push($arr, "خانة البريد الإلكترونى فارغة.<br>");
        }
        else
        {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                array_push($arr, "يجب أيكون البريد الإلكترونى صحيح.<br>");
            }
            else
            {
                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                $email = trim($email);
                $email = strtolower($email);
                $query = mysqli_query($cnx,"SELECT * FROM user WHERE emailUser LIKE '".$email."'");
                $rslt = mysqli_num_rows($query);
                if($rslt != 0)
                {
                    array_push($arr, "البريد الإلكترونى مستخدم من قبل.<br>");
                }
            }
                
        }
        
        //input pass and confPass
        $pass = $_POST['pass'];
        $confPass = $_POST['confPass'];
        if(empty($pass) || empty($confPass))
        {
            array_push($arr, "خانة كلمة المرور فارغة.<br>");
        }
        else
        {
            if($pass == $confPass)
            {
                if((strlen($pass) > 7 && strlen($pass) < 30) || (strlen($confPass) > 7 && strlen($confPass) < 30))
                {
                    $confPass = htmlspecialchars($confPass);
                    $pass = htmlspecialchars($pass);
                }
                else
                {
                    array_push($arr, "يجب أن تكون كلمة المرور بين 6 و 39 حرف.<br>");
                }
            }
            else
            {
                array_push($arr, "كلمة المرور غير متطابقة مع كلمة المرور الأولى.<br>");
            }
        }
        
        //input dateNaissance
        $date = $_POST["dateNaiss"];
        
        //input sexe
        $sexe = $_POST["sexe"];
        if($sexe == "choose")
        {
            array_push($arr, "المرجو إختيار الجنس.<br>");
        }
        elseif($sexe == "homme")
        {
            $sexe = "homme";
        }
        elseif($sexe == "femme")
        {
            $sexe = "femme";
        }
        
        
        if(empty($arr))
        {
            $rslt = mysqli_query($cnx,"INSERT INTO user VALUES('', '".$nom."', '".$prenom."', '".$nomUtil."', '".$pass."', '".$email."', '".$date."', '".$sexe."', '".$dateInscription."','no')");
            if(!$rslt)
            {
                die("error 404");
            }
            else
            {
                header("location: login.php");
            }
        }
    } 
    }
    
    
?>

<!DOCETYPE html>
<html lang="ar">
    <head>
        <title>تسجيل</title>
        <meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width = device-width, initial-scale = 1.0" />
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/styleSingup.css" />
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
                <div id="singUp">
                    <form action="" method="post">
                        
                        <ul>
                            <h2>تسجيل حساب جديد</h2>
                            <li>
                                <p>الإسم</p>
                                <input type="text" name="nom" maxlength="29" value="<?php echo $nom ;?>" required/>
                                <p>
                                    <?php
                                        if(in_array("خانة الإسم فارغة.<br>", $arr))
                                        {
                                            echo "خانة الإسم فارغة.<br>";
                                        }
                                        elseif(in_array("لايجد إسم بأرق.<br>", $arr))
                                        {
                                            echo"لايجد إسم بأرق.<br>";
                                        }
                                        elseif(in_array("يجب أيكون الإسم بين 3 و 29 حرف.<br>", $arr))
                                        {
                                            echo "يجب أيكون الإسم بين 3 و 29 حرف.<br>";
                                        }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <p>الإسم العائلي</p>
                                <input type="text" name="prenom" maxlength="39" value="<?php echo $prenom ;?>" required/>
                                <p>
                                    <?php
                                        if(in_array("خانة الإسم العائلي فارغة.<br>", $arr))
                                        {
                                            echo"خانة الإسم العائلي فارغة.<br>";
                                        }
                                        elseif(in_array("لايجد إسم العائلي بأرق.<br>", $arr))
                                        {
                                            echo"لايجد إسم العائلي بأرق.<br>";
                                        }
                                        elseif(in_array("يجب أيكون الإسم بين 3 و 39 حرف.<br>", $arr))
                                        {
                                            echo"يجب أيكون الإسم بين 3 و 39 حرف.<br>";      
                                        }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <p>معرف المستخدم</p>
                                <input type="text" name="nomPrenom" maxlength="99" value="<?php echo $nomUtil ;?>" required/>
                                <p>
                                    <?php
                                        if(in_array("خانة الإسم المستخدم فارغة.<br>", $arr))
                                        {
                                            echo"خانة الإسم المستخدم فارغة.<br>";
                                        }
                                        elseif(in_array("لايجد إسم المستخدم  بأرق.<br>", $arr))
                                        {
                                            echo"لايجد إسم المستخدم  بأرق.<br>";
                                        }
                                        elseif(in_array("معرف المستخدم مستخدم من قبل.<br>", $arr))
                                        {
                                            echo"معرف المستخدم مستخدم من قبل.<br>";
                                        }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <p>البريد الإلكترونى</p>
                                <input type="text" name="email" maxlength="99" value="<?php echo $email ;?>" required/>
                                <p>
                                    <?php
                                        if(in_array("خانة البريد الإلكترونى فارغة.<br>", $arr))
                                        {
                                            echo"خانة البريد الإلكترونى فارغة.<br>";
                                        }
                                        elseif(in_array("يجب أيكون البريد الإلكترونى صحيح.<br>",$arr))
                                        {
                                            echo"يجب أيكون البريد الإلكترونى صحيح.<br>";
                                        }
                                        elseif(in_array("البريد الإلكترونى مستخدم من قبل.<br>", $arr))
                                        {
                                            echo"البريد الإلكترونى مستخدم من قبل.<br>";
                                        }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <p>كلمة المرور</p>
                                <input type="password" name="pass" maxlength="29" required/>
                                <p>
                                    <?php
                                        if(in_array("خانة كلمة المرور فارغة.<br>", $arr))
                                        {
                                            echo"خانة كلمة المرور فارغة.<br>";
                                        }
                                        elseif(in_array("يجب أن تكون كلمة المرور بين 6 و 39 حرف.<br>", $arr))
                                        {
                                            echo"يجب أن تكون كلمة المرور بين 6 و 39 حرف.<br>";
                                        }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <p>تأكيد كلمة المرور</p>
                                <input type="password" name="confPass" maxlength="29" required/>
                                <p>
                                    <?php
                                        if(in_array("خانة كلمة المرور فارغة.<br>", $arr))
                                        {
                                            echo"خانة كلمة المرور فارغة.<br>";
                                        }
                                        elseif(in_array("كلمة المرور غير متطابقة مع كلمة المرور الأولى.<br>", $arr))
                                        {
                                            echo"كلمة المرور غير متطابقة مع كلمة المرور الأولى.<br>";
                                        }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <p>تاريخ الزدياد</p>
                                <input type="date" name="dateNaiss" />
                            </li>
                            <li>
                                <p>الجنس</p>
                                <select name="sexe">
                                    <option value = "choose" selected>إختيار الجنس</option>
                                    <option value = "homme">ذكر</option>
                                    <option value = "femme">أنثى</option>
                                </select>
                                <p>
                                    <?php
                                        if(in_array("المرجو إختيار الجنس.<br>", $arr))
                                        {
                                            echo"المرجو إختيار الجنس.<br>";
                                        }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <input type="submit" name="singup" value="تسجيل" />
                            </li>
                            <li>
                                <a href="../../dashboard/WebSiteBook/login.php">لديك حساب بالفعل؟</a>
                            </li>
                        </ul>
                    </form>
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