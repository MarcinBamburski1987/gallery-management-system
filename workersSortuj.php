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
		$sql="SELECT `user`, `pozycja` FROM `pracownicy` order BY `user` ";
		$result = $polaczenie->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<table ><tr><th>Imie</th><th>Pozycja</th></tr>";
	
    while($row = $result->fetch_assoc()) {
		
        echo  "<tr><td>".$row["user"]. "</td><td>".$row["pozycja"]."</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
	$polaczenie->close();
	}
?>