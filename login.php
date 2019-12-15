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
    $email = $pass = "";
    if(isset($_POST['logIn']))
    {
        
        //input Email or NomPrenom
        $email = $_POST['nomPrenom'];
        $pass = $_POST['password'];
        if(empty($email))
        {
            array_push($arr, "خانة البريد الإلكتروني فارغة.<br>");
        }
        else
        {
            if(strlen($email) < 6 && strlen($email) > 98)
            {
                array_push($arr, "يجب أن لا يتجاوز 100 حرف.<br>");
            }
            else
            {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    array_push($arr, "يجب أيكون البريد الإلكترونى صحيح.<br>");
                }
                else
                {
                    $email= filter_var($email, FILTER_VALIDATE_EMAIL);
                    $email = htmlspecialchars($email);
                    $query = mysqli_query($cnx,"SELECT * FROM user WHERE emailUser like '".$email."'");
                    $rslt = mysqli_num_rows($query);
                    if($rslt == 0)
                    {
                        array_push($arr, "البريد الإلكترونى غير صحيح.<br>");
                    }
                }   
            }
        }
        
        //input password
        
        if(empty($pass))
        {
            array_push($arr, "خانة كلمة المرور فارغة.<br>");
        }
        else
        {
            if(strlen($email) < 7 && strlen($email) > 29)
            {
                array_push($arr, "يجب أن تكون كلمة المرور بين 6 و 39 حرف.<br>");
            }
            else
            {
                $pass = htmlspecialchars($pass);
                $query = mysqli_query($cnx,"SELECT * FROM user WHERE motPass like '".$pass."' and closeUser = 'no'");
                $rslt = mysqli_num_rows($query);
                if($rslt == 0)
                {
                    array_push($arr, "كلمة المرور غير صحيح.<br>");
                }
            }
        }
        
        
        if(empty($arr))
        {
            $query = mysqli_query($cnx, 'SELECT NomPrenom FROM user WHERE emailUser LIKE "'.$email.'"');
            $rslt = mysqli_fetch_array($query);
            $nomUser = $rslt['NomPrenom'];
            
            $_SESSION['email'] = $email;
            $_SESSION['NomPrenom'] = $nomUser;
            
            header("location: accountTrue.php");
            exit();
        }
    }
    }
    

?>


<!DOCETYPE html>
<html lang="ar">
    <head>
        <title>دخول إلى حسابك</title>
        <meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width = device-width, initial-scale = 1.0" />
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/styleLogin.css" />
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
                <div id="logIn">
                    <form action="" method="post">
                        <ul>
                            <h2>دخول إلى حسابك</h2>
                            <li>
                                <p>البريد الإلكتروني</p>
                                <input type="text" name="nomPrenom" maxlength="99" value="<?php 
                                    echo $email;
                                ?>"
                                required/>
                                <p>
                                    <?php
                                        if(in_array("خانة البريد الإلكتروني فارغة.<br>",$arr))
                                        {
                                            echo "خانة البريد الإلكتروني فارغة.<br>";
                                        }
                                       elseif(in_array("يجب أن لا يتجاوز 100 حرف.<br>",$arr))
                                       {
                                           echo "يجب أن لا يتجاوز 100 حرف.<br>";
                                       }
                                       elseif(in_array("يجب أيكون البريد الإلكترونى صحيح.<br>",$arr))
                                       {
                                           echo "يجب أيكون البريد الإلكترونى صحيح.<br>";
                                       }
                                       elseif(in_array("البريد الإلكترونى غير صحيح.<br>",$arr))
                                       {
                                           echo "البريد الإلكترونى غير صحيح.<br>";
                                       }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <p>كلمة المرور</p>
                                <input type="password" name="password" maxlength="39" required/>
                                <p>
                                    <?php
                                        if(in_array("خانة كلمة المرور فارغة.<br>",$arr))
                                        {
                                            echo "خانة كلمة المرور فارغة.<br>";
                                        }
                                       elseif(in_array("يجب أن تكون كلمة المرور بين 6 و 39 حرف.<br>",$arr))
                                       {
                                           echo "يجب أن تكون كلمة المرور بين 6 و 39 حرف.<br>";
                                       }
                                       elseif(in_array("كلمة المرور غير صحيح.<br>",$arr))
                                       {
                                           echo "كلمة المرور غير صحيح.<br>";
                                       }
                                    ?>
                                </p>
                            </li>
                            <li>
                                <input type="submit" value="دخول" name="logIn" />
                            </li>
                            <li>
                                <a href="singup.php">ليس لديك حساب؟</a>
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
