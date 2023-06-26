<?php
function getTime($time){
	$minutes = floor($time / 60);
    $seconds = sprintf("%02d", $time - ($minutes * 60));
    $miliSeconds = ($time - ($minutes * 60) - $seconds);
    $auxiliar = $seconds + $miliSeconds;
    $auxiliar = round($auxiliar, 2);
    if($auxiliar < 10){$auxiliar = '0' . $auxiliar;}
    if($minutes > 0){return "$minutes.$auxiliar";}
    else{return $auxiliar;}
}

function createTime($time){
	$amountPoints = 0;
    $numbers = array();
    $iteratorAux = 0;
    
    for($i = 0; $i < strlen($time); $i++){
    	if($time[$i] != '0' and $time[$i] != '1' and $time[$i] != '2' and $time[$i] != '3' and $time[$i] != '4' and $time[$i] != '5' and $time[$i] != '6' and $time[$i] != '7' and $time[$i] != '8' and $time[$i] != '9' and $time[$i] != '.' and $time[$i] != ','){
        	return "invalid";
        }
    	if($time[$i] == '.' or $time[$i] == ','){
        	$amountPoints++;
		}
	}

    if($amountPoints == 2 or $amountPoints == 1){
		$numberContainerAux = "";
        for($i = 0; $i < strlen($time); $i++){
            if($time[$i] != '.' and $time[$i] != ','){
            	$numberContainerAux = $numberContainerAux . $time[$i];
            }
            if($time[$i] == '.' or $time[$i] == ',' or $i == strlen($time) - 1){
            	$numbers[$iteratorAux] = $numberContainerAux;
                $numberContainerAux = "";
                $iteratorAux++;
            }
        }  
    }else{
    	return "invalid";
    }
    if($amountPoints == 2){
    	if(strlen($numbers[2]) == 1){$numbers[2] .= '0';}
		return (intval($numbers[0]) * 60 + intval($numbers[1]) + intval($numbers[2]) / 100);
    }else{
    	if(strlen($numbers[1]) == 1){$numbers[1] .= '0';}
    	return (intval($numbers[0]) + intval($numbers[1]) / 100);
    }
}
?>