<?php
$url = "http://127.0.0.1/api/compartment/read.php";
$json = file_get_contents($url);
$result = json_decode($json, true);

//var_dump($result);

echo $result['records'][0]['comp_id'];
echo $result['records'][1]['comp_id'];
echo $result['records'][2]['comp_id'];
echo $result['records'][3]['comp_id'];

echo $result['records'][0]['status'];
echo $result['records'][1]['status'];
echo $result['records'][2]['status'];
echo $result['records'][3]['status'];

echo $result['records'][0]['upd_dt'];
echo $result['records'][1]['upd_dt'];
echo $result['records'][2]['upd_dt'];
echo $result['records'][3]['upd_dt'];
?>
