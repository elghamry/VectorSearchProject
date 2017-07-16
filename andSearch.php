<?php if ($_POST["query"]) {

$query =strtolower( $_POST["query"]);
$query_arr = explode(" ", $query);
$query_unique = array_unique($query_arr);
//print_r($query_unique);
//echo "<br>";
//$Alpha_name=array("A","B","C","D","E");

$xml=simplexml_load_file("books.xml") or die("Error: Cannot create object");
$i=0;
foreach($xml->children() as $books) {
    // echo $books->title . ", ";
    // echo $books->author . ", ";
    // echo $books->year . ", ";
    // echo $books->price . "<br>"; 


    // $file_arr[$i]=array_merge(explode(" ", $books->title),explode(" ", $books->author),explode(" ", $books->year));

     $file_content[$i]=strtolower($books->isbn." ".$books->author." ".$books->title." ".$books->description." ".$books->statementOfResponsability." ".$books->placeOfPublication." ".$books->nameOfPublisher." ".$books->dateOfPublication." ".$books->Extent);
     $arr_value[$i]["isbn"]=(string)$books->isbn;
     $arr_value[$i]["author"]=(string)$books->author;
     $arr_value[$i]["title"]=(string)(string)$books->title;
     $arr_value[$i]["description"]=(string)$books->description;
     $arr_value[$i]["placeOfPublication"]=(string)$books->placeOfPublication;
     $arr_value[$i]["nameOfPublisher"]=(string)$books->nameOfPublisher;
     $arr_value[$i]["dateOfPublication"]=(string)$books->dateOfPublication;
     $arr_value[$i]["Extent"]=(string)$books->Extent;


   
     // echo "<br>";


    $i++;



}

// print_r($file_content);
$i=0;

// for ($i = 0; $i < 5; $i++) {
//     $filename = $Alpha_name[$i] . ".txt";
//     $file_content[$i] = file_get_contents($filename);
//     $file_arr[$i] = explode(" ", $file_content[$i]);
//     //print_r($file_arr[$i-1]);
//     //echo "<br>";

// }

//loop for freq
//outer loop for docs


for ($j = 0; $j < count($file_content) + 1; $j++) {
    //inner loop for terms in unique query
    for ($i = 0; $i < count($query_unique); $i++) {
        if ($j == count($file_content)) {
            $f_arr[$j][$i] = substr_count($query, $query_unique[$i]);

            continue;

        }
        $f_arr[$j][$i] = substr_count($file_content[$j], $query_unique[$i]);


    }

}
 // print_r($f_arr);
//loop for term freq (normalize)
for ($j = 0; $j < count($file_content) + 1; $j++) {

    //inner loop for terms in unique query
    for ($i = 0; $i < count($query_unique); $i++) {
        if(max($f_arr[$j])!=0)

        $tf_arr[$j][$i] = $f_arr[$j][$i] / max($f_arr[$j]);
        else

            $tf_arr[$j][$i]=0;


    }

}
// print_r($tf_arr);
$i = 0;
foreach ($query_unique as $value) {
    $df[$i] = 0;
    $i++;
}
//print_r($tf_arr);
//loop for df
for ($j = 0; $j < count($file_content); $j++) {
    for ($i = 0; $i < count($query_unique); $i++) {

        if (substr_count($file_content[$j], $query_unique[$i]) > 0) {
            $df[$i]++;


        }


    }
}
// print_r($df);
//kolo kda gahez na2es idf

//here is the problem??
for ($i = 0; $i < count($query_unique); $i++) {
    if ($df[$i] != 0) {
    	if(count($file_content)!=$df[$i]){
        $idf[$i] = log(count($file_content)/ $df[$i], 2);
    }
    else
    {
    	$idf[$i]=1;
    }


    }
    else
    $idf[$i]=0;


}

// print_r($idf);
//idf in the query_itself

for ($i = 0; $i < count($query_unique); $i++) {
    if($df[$i]!=0)
//here is the edit
    {
    	if(count($file_content)!=$df[$i]){

    		$self_idf[$i]=log(count($file_content)/$df[$i],2);
    	}
    	else
    		$self_idf[$i]=1;

    }
    
    else
        $self_idf[$i]=0;



}
// print_r($self_idf);
//weights_vector

for ($j = 0; $j < count($file_content) + 1; $j++) {
    //inner loop for terms in unique query
    for ($i = 0; $i < count($query_unique); $i++) {
        if ($j == count($file_content)) {
            $weights[$j][$i] = $tf_arr[$j][$i]*$self_idf[$i];

            continue;

        }
        $weights[$j][$i] = $tf_arr[$j][$i]*$idf[$i];


    }

}
//echo $weights[3][0];
//echo "<br>";
//echo $weights[5][1];

// print_r($weights);
// echo "<br>";
//similarity calculations
for($j=0;$j<count($file_content);$j++)
{
    $sum=0;
    for ($i = 0; $i < count($query_unique); $i++)
    {
       $sum+=$weights[$j][$i]*$weights[count($file_content)][$i];
    }
$sim[$j]=$sum;
}
//print_r($sim);
//cosinesim
for($j=0;$j<count($file_content);$j++)
{
    $sum1=0;
    $sum2=0;

    for ($i = 0; $i < count($query_unique); $i++)
    {
        $sum1+=pow($weights[$j][$i],2);
            $sum2+=pow($weights[count($file_content)][$i],2);
    }
    if($sim[$j]!=0)
    $cos_sim[$j]=$sim[$j]/sqrt($sum1*$sum2);
    else
        $cos_sim[$j]=0;



}
// print_r($cos_sim);
// echo "<br>";
arsort($cos_sim);

$i=0;


foreach($cos_sim as $pos => $value)
{
    // echo "file number ".($pos+1)." value = ".$value;
    // echo "<br>";
    if($value!=0)
    $arr_pos[$i]=$pos;
$i++;
}




if(!empty($arr_pos)){
   

	$json_Arr["pos"]=$arr_pos;
	$json_Arr["value"]=$arr_value;
	echo json_encode($json_Arr);
}
else
{
     echo " hell ";
    // print_r($arr_value);
}



}
?>