<?php

require('controller_purchase.php');
global $item;
$m = $_POST['basketRow'];
var_dump($m);
foreach($m as $k => $v) {
echo "Kaup nr. $k - $v";
}



?>
