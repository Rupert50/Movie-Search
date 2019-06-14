<?php
    require "header.php";

    //Connect to the server
    $user="root";
    $password="usbw";
    $database="movies"; /*This DB must exist on the server */
    $host = "localhost:3307";
    $conn = mysqli_connect($host, $user, $password, $database) or die("Cannot connect");

    echo "<b>Top 10 Movies</b>";
	
	//Qry to select the top10 most searched movies
    //$Qry = "SELECT `Name`, `Email` FROM `users`;";
	$Qry = "SELECT * FROM `movies` ORDER BY `ViewCount` DESC";
    $res = mysqli_query($conn, $Qry);

if (mysqli_num_rows($res) > 0) {
    ?>
    <table style=width:100%>
    <tr>
	<th>Ranking</th>
    <th>Title</th>
	<th>View Count</th>
    </tr>
    <?php
	for($i= 1; $i < 11; $i++) 
    {
		$display = mysqli_fetch_assoc($res);
        $Title = $display['Title'];
		$ViewCount = $display['ViewCount'];
        echo "<tr>
		<td>$i</td>
        <td>$Title</td>
		<td>$ViewCount</td>
        </tr>";
    }
	echo "<br></table>";
}

mysqli_close($conn);
include "footer.php";

?>