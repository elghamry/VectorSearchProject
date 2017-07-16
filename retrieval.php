<?php

echo "<head>
<link rel='stylesheet' type='text/css' href='style.css'>
</head>";


session_start(); 


if(isset($_SESSION['pos'])){

foreach ($_SESSION['pos'] as $arpos) {

	echo "<table border='1' class='heavyTable'>";


	// foreach ($_SESSION['value'][$arpos] as $arval) {

		 echo "<tr>";
		  echo "<th>";
		 
		  echo "Title: ".$_SESSION['value'][$arpos]['title'];
		

		 // echo $arpos;
		  echo "</th>";
		 echo "</tr>";


		 echo "<tr>";
		  echo "<td>";
		 if(isset($_SESSION['value'])){
		
		  echo "ISBN : ".$_SESSION['value'][$arpos]['isbn'];


		 // echo $arpos;
		  echo "</td>";
		 echo "</tr>";

		 echo "<tr>";
		  echo "<td>";
		 
		  echo "Author: ".$_SESSION['value'][$arpos]['author'];
		

		 // echo $arpos;
		  echo "</td>";
		 echo "</tr>";

		 	
		 		 echo "<tr>";
		  echo "<td>";
		 
		  echo "Description: ".$_SESSION['value'][$arpos]['description'];
		

		 // echo $arpos;
		  echo "</td>";
		 echo "</tr>";
		 		 echo "<tr>";
		  echo "<td>";
		 
		  echo "Place Of Publication: ".$_SESSION['value'][$arpos]['placeOfPublication'];
		

		 // echo $arpos;
		  echo "</td>";
		 echo "</tr>";
		 		 echo "<tr>";
		  echo "<td>";
		 
		  echo "Name Of Publisher: ".$_SESSION['value'][$arpos]['nameOfPublisher'];
		

		 // echo $arpos;
		  echo "</td>";
		 echo "</tr>";
		 		 echo "<tr>";
		  echo "<td>";
		 
		  echo "Date Of Publisher: ".$_SESSION['value'][$arpos]['dateOfPublication'];
		

		 // echo $arpos;
		  echo "</td>";
		 echo "</tr>";
		 		 echo "<tr>";
		  echo "<td>";
		 
		  echo "Extent: ".$_SESSION['value'][$arpos]['Extent'];
		

		 // echo $arpos;
		  echo "</td>";
		 echo "</tr>";



}

	
      
    
    // }

    echo "</table>";


      
        
    }
   ?>

  <div align='center'> <button type="submit" value="search again" id='submit' class='button' onclick="location.href='./search.html'" style="vertical-align:center"><span>search again </span></button></div>
   <?php




}

unset($_SESSION['value']);
unset($_SESSION['pos']);


?>