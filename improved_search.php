<?php

if (!$_POST["query"]) {
    header("Location:index.html");
}
$query = $_POST["query"];
$query_arr = explode(" ", $query);
$query_unique = array_unique($query_arr);
print_r($query_unique);
echo "<br>";
$Alpha_name=array("A","B","C","D","E");

for ($i = 0; $i < 5; $i++) {
    $filename = $Alpha_name[$i] . ".txt";
    $file_content[$i] = file_get_contents($filename);
    $file_arr[$i] = explode(" ", $file_content[$i]);
    print_r($file_arr[$i-1]);
    echo "<br>";

}

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
//print_r($f_arr);
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
//print_r($df);
//kolo kda gahez na2es idf


for ($i = 0; $i < count($query_unique); $i++) {
    if ($df[$i] != 0) {
        $idf[$i] = log(count($file_content)/ $df[$i], 2);
    }
    else
    $idf[$i]=0;


}

//print_r($idf);
//idf in the query_itself

// s
//print_r($self_idf);
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
//print_r($weights);
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
print_r($cos_sim);
echo "<br>";
arsort($cos_sim);
foreach($cos_sim as $pos => $value)
{
    echo "file number ".($pos+1)." value = ".$value;
    echo "<br>";
}
echo "<br>
<p>_____________________________________________________________________________________________________________________</p>";


for($i=0;$i<5;$i++)
{
    for($j=0;$j<5;$j++)
    {
        $adj[$i][$j]=0;
        if(in_array($Alpha_name[$i],$file_arr[$j]))
        {
            $adj[$i][$j]=1;
        }
    }
}
echo "<br>";
//print_r($adj);

function M_mult($_A,$_B) {
    // AxB outcome is C with A's rows and B'c cols
    $r = count($_A);
    $c = count($_B[0]);
    $in= count($_B); // or $_A[0]. $in is 'inner' count

    if ( $in != count($_A[0]) ) {
        print("ERROR: need to have inner size of matrices match.\n");
        print("     : trying to multiply a ".count($_A)."x".count($_A[0])." by a ".count($_B)."x".count($_B[0])." matrix.\n");
        print("\n");
        exit(1);
    }

    // allocate retval
    $retval = array();
    for($i=0;$i< $r; $i++) { $retval[$i] = array(); }
    // multiplication here
    for($ri=0;$ri<$r;$ri++) {
        for($ci=0;$ci<$c;$ci++) {
            $retval[$ri][$ci] = 0.0;
            for($j=0;$j<$in;$j++) {
                $retval[$ri][$ci] += $_A[$ri][$j] * $_B[$j][$ci];
            }
        }
    }
    return $retval;
}
for($i=0;$i<5;$i++)
{
    for($j=0;$j<1;$j++)
    {
        $a[$i][$j]=1;
        $h[$i][$j]=1;
    }
}
function transpose($array) {
    return array_map(null, ...$array);
}
//print_r($a);
//$a=transpose($a);
//print_r($a);
for($i=0;$i<20;$i++)
{
    $a=M_mult(transpose($adj),$h);
    $h=M_mult($adj,$a);
}


echo "<br>";
print_r($a);
echo "<br>";
print_r($h);
echo "<br>";
echo "<br>";
$temp1=array(array(1,2,3),array(4,5,6),array(7,8,9));
$temp2=array(array(5,8,9),array(6,4,5),array(2,8,9));
print_r(M_mult($temp1,$temp2));



//
//echo $maxs[0];
$print_a=transpose($a)[0];

    arsort($print_a);
$print_h=transpose($h)[0];

    arsort($print_h);
foreach($print_a as $pos => $value)
{
    echo "Authority Value of file ".($pos+1)." = ".$value;
    echo "<br>";
}
echo "<br>";
foreach($print_h as $pos => $value)
{
    echo "Hub Value of file ".($pos+1)." = ".$value;
    echo "<br>";

}

?>