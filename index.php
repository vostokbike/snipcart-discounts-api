<?php

function parse_excel_file( $filename ){
	require_once $_SERVER['DOCUMENT_ROOT'].'/PHPExcel/Classes/PHPExcel.php';
	$result = array();
	$file_type = PHPExcel_IOFactory::identify($filename);
	$objReader = PHPExcel_IOFactory::createReader($file_type);
	$objPHPExcel = $objReader->load($filename); 
	$result = $objPHPExcel->getActiveSheet()->toArray(); 

return $result;
}

$res = parse_excel_file($_SERVER['DOCUMENT_ROOT'].'/discounts-taga-accessories.xlsx');
$count = count($res);
$array_new = array();
foreach($res as $value) {
	$array = array( 
	$res[0][0] => $value[0],
	$res[0][1] => $value[1],
	$res[0][2] => $value[2],
	$res[0][3] => $value[3],
	$res[0][4] => $value[4],
	$res[0][5] => $value[5], );
	addGiftCardToDiscounts($array);
	//array_push($array_new, $array);

}
//var_dump($array);
//var_dump($array_new);


 function addGiftCardToDiscounts($discount){

    $ch = curl_init();
    $key = "ST_ODJiZTM2MGUtZmNlMy00NjQ2LTk4YzAtMWRhZGNjMWM3OTUxNjM2MzQxNDM2MjQ2NDExNDg1";
    $options = array(
        CURLOPT_URL            => "https://app.snipcart.com/api/discounts",
        CURLOPT_USERPWD        => $key,
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER     => array(
            'Accept: application/json',
            'Content-Type: application/json'
        ),
        CURLOPT_POSTFIELDS     => "{ 
            name: '".$discount['Name']."',
            maxNumberOfUsages: '".$discount['maxNumberOfUsages']."',
            trigger: '".$discount['trigger']."',
            code: '". $discount['code']."',
            type: '".$discount['type']."',
            amount: '".$discount['amount']."'
        }"
        
    );
    curl_setopt_array($ch, $options);
	curl_exec($ch);
    curl_close($ch);
}

?>

