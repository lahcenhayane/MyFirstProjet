<div id="main">
    <div id="welcome">
        <h2>مكتبة الكتب لتحميل الكتب مجانا</h2>
        <p>قراءة أونلاين وتحميل كتب عربية وأجنبية فى شتى المجالات بروابط مباشرة</p>
    </div>
    <?php
        $query = mysqli_query($cnx, "SELECT * FROM categories");
        
        while($row = mysqli_fetch_array($query))
        {
            echo'<section>';
            echo'<header>';
            echo'<a href="books.php?categorie='.$row[0].'">';
            echo'<p>'.$row[1].'</p>';
            echo'<p>المزيد</p>';
            echo'</a>';
            echo'</header>';
            $rslt = mysqli_query($cnx, "SELECT * FROM book WHERE idCate = '".$row[0]."' and accepter LIKE 'yes'");
            while($iteam = mysqli_fetch_array($rslt))
            {
                echo'<article>';
                echo'<a href="book.php?idbook='.$iteam[0].'" title="'.$iteam[1].'">';
                echo'<img src="'.$iteam[8].'" />';
                echo'<p>'.$iteam[1].'</p>';
                echo'</a>';
                echo'</article>';
                
            }
            echo'</section>';
        }
        
    ?>
</div>