<?php
session_start();
if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
header("location:index.html");
}
if(isset($_POST['insert']))
{
	$xml=new DOMDocument("1.0","UTF-8");
	$xml->load('books.xml');
	
	$isbn=$_POST['isbn'];
	$author=$_POST['author'];	
	$title=$_POST['title'];	
	$description=$_POST['description'];	
	$statementOfResponsibility=$_POST['statementOfResponsibility'];	
	$placeOfPublication=$_POST['placeOfPublication'];	
	$nameOfPublisher=$_POST['nameOfPublisher'];	
	$dateOfPublication=$_POST['dateOfPublication'];	
	$Extent=$_POST['Extent'];		

		

	$rootTag=$xml->getElementsByTagName("books")->item(0);
	
	$infoTag=$xml->createElement("book");
		$isbnTag=$xml->createElement("isbn",$isbn);
		$authorTag=$xml->createElement("author",$author);
		$titleTag=$xml->createElement("title",$title);
		$descriptionTag=$xml->createElement("description",$description);
		$statementOfResponsibilityTag=$xml->createElement("statementOfResponsibility",$statementOfResponsibility);
		$placeOfPublicationTag=$xml->createElement("placeOfPublication",$placeOfPublication);
		$nameOfPublisherTag=$xml->createElement("nameOfPublisher",$nameOfPublisher);
		$dateOfPublicationTag=$xml->createElement("dateOfPublication",$dateOfPublication);
		$ExtentTag=$xml->createElement("Extent",$Extent);
		

		$infoTag->appendChild($isbnTag);
		$infoTag->appendChild($authorTag);
		$infoTag->appendChild($titleTag);
		$infoTag->appendChild($descriptionTag);
		$infoTag->appendChild($statementOfResponsibilityTag);
		$infoTag->appendChild($placeOfPublicationTag);
		$infoTag->appendChild($nameOfPublisherTag);
		$infoTag->appendChild($dateOfPublicationTag);
		$infoTag->appendChild($ExtentTag);

	$rootTag->appendChild($infoTag);
	$xml->save('books.xml');
}
if(isset($_POST['delete']))
{
	$xml =new DOMDocument("1.0","UTF-8");
	$xml->load('books.xml');
	
	$isbn=$_POST['isbn'];
	
	$xpath =new DOMXPATH($xml);

	foreach($xpath->query("/books/book[isbn='$isbn']")as $node)

	{
		$node->parentNode->removeChild($node);
	}
	$xml->formatoutput =true;
	$xml->save('books.xml');
}
if(isset($_POST['log_out']))
{

	unset($_SESSION['username']);
unset($_SESSION['password']);
session_unset ();

	header("location:index.html");
}


?>
<html>
   <head>

	<title> insert new book</title>
	  <link rel='stylesheet' type='text/css' href='search.css'>
	   <body>
		<form action="admin.php" method="POST" class="form-wrapper">
		
		<input type="text" name="isbn" id='search' placeholder='ISBN'>
		<input type="text" name="author" id='search' placeholder='Author'></br>
	    <input type="text" name="title" id='search'id='search' placeholder='Title'></br>
		<input type="text" name="description" id='search' placeholder='Description'></br>
		<input type="text" name="statementOfResponsibility" id='search' placeholder='Statement of Responsibility '></br>
		<input type="text" name="placeOfPublication" id='search' placeholder='Place of publication'></br>
		<input type="text" name="nameOfPublisher" id='search' placeholder='Name of publisher '></br>
	    <input type="text" name="dateOfPublication" id='search' placeholder='Date of publication'></br>
		<input type="text" name="Extent" id='search' placeholder='Extent'></br>
		<input type="submit" name="insert" value="add" id='submit'>
		
</form>

<form action="admin.php" method="POST" class="form-wrapper">
		
		<input type="text" name="isbn" id='search' placeholder='Enter ISBN to delete the book'>
		
		<input type="submit" name="delete" value="delete" id='submit'>
</form>



<div align='center'><form action="admin.php" method="POST" class="form-wrapper">
		
		<div align='center'><input type="submit" name="log_out" value="logout" id='submit'></div>
</form>
</div>
</body>
</html>
			