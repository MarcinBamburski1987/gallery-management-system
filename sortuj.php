
<?php

session_start();
require_once "connect.php";

 $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

 if($polaczenie->connect_errno!=0)
	{ 
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$sql="SELECT `user` FROM `uzytkownicy` order BY `user` ";
		$result = $polaczenie->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table ><tr><th>Name</th></tr>";
	
    while($row = $result->fetch_assoc()) {
		
        echo  "<tr><td>".$row["user"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
	$polaczenie->close();
	}
?>
