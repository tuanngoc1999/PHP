<?php 

$a = 1;
$b = 2;

label1:
echo $a."</br>";
$a += 1;
$b += 1;

if ($a < 100){
  goto label1;
}



?>