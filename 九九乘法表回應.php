<?php
$m=$_POST["m"];
$n=$_POST["n"];
    echo "輸入的m值為:".$m."</br>";
    echo "輸入的n值為:".$n."</br>";
    echo "答案為:".$m*$n."</br>";
    echo "<table border='1'>";
    for($i=1;$i<=$m;$i++){
        echo "<tr>";
        for($j=1;$j<=$n;$j++){
            echo "<td>";
            echo $i."*".$j."=".$i*$j."\t";
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

$grade=array("a","b");
echo $grade[0]."</br>";
foreach($grade as $element){
    echo $element;
}
?>