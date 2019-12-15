<div id="nav">
    <div id="content">
        <a class="logoNav" href="../../../dashboard/WebSiteBook/index.php"><img src="img/open-book.png" alt="Home.png" title="الرئيسية" /></a>
        <ul>
            <?php
                $query = mysqli_query($cnx, "SELECT * FROM categories");
                while($row = mysqli_fetch_array($query))
                {
                    $row[0] = trim($row[0]);
                    $row[0] = htmlspecialchars($row[0]);
                    $row[0] = strip_tags($row[0]);
                    $row[0] = stripslashes($row[0]);
                    echo'<li><a href="books.php?categorie='.$row[0].'">'.$row[1].'</a></li>';
                }
            ?>
        </ul>
    </div>
</div>