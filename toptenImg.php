<?php
    require "header.php";

    //Connect to the server
    $user="root";
    $password="usbw";
    $database="movies"; /*This DB must exist on the server */
    $host = "localhost:3307";
    $conn=mysqli_connect($host, $user, $password, $database)or die("Cannot connect");

    echo "<b>Top 10 Movies</b>";

    //Qry to select the top10 most searched movies
    //$Qry = "SELECT `Name`, `Email` FROM `users`;";
    $Qry = "SELECT * FROM `movies` ORDER BY `ViewCount` DESC";
    $res = mysqli_query($conn, $Qry);

if (mysqli_num_rows($res) > 0) {
    ?>
    <!--<table style=width:100%>
    <tr>
    <th>Ranking</th>
    <th>Title</th>
    <th>View Count</th>
    </tr>-->
    <?php

    $Image = @imagecreate(400, 300) or die;
    $Background = imagecolorallocate($Image, 255, 255, 255);
    $Red = imagecolorAllocate($Image, 255, 0, 0);
    imagestring($Image, 10, 0, 2, "Ranking", $Red);
    imagestring($Image, 10, 100, 2, "Title", $Red);
    imagestring($Image, 10, 300, 2, "View Count", $Red);
    for ($i= 1; $i < 11; $i++) {
        $inc = $i * 20;
        $display = mysqli_fetch_assoc($res);
        $Title = $display['Title'];
        $ViewCount = $display['ViewCount'];
        imagestring($Image, 10, 20, $inc, $i, $Red);
        imagestring($Image, 10, 40, $inc, $Title, $Red);
        imagestring($Image, 10, 380, $inc, $ViewCount, $Red);
        //imagestring(
    }
    imagepng($Image, "AyLmao.png");
    echo "<img src='AyLmao.png'/>";
    imagedestroy($Image);
    //echo "<br></table>";
}

mysqli_close($conn);
require "footer.php";

?>