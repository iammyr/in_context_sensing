<?php


require_once '../resources/TripleCreator.php';
require_once '../resources/AbstractResource.php';



class IntrinsicResource{

	
  public function handleGet($data){
    	if (!$data 
    	|| !isset($data->sensor_id)
    	|| !isset($data->uom)
    	|| !isset($data->observed_property)
    	|| !isset($data->observed_value)){
    		return null;
    	}
    	$intrinsic_index = array();
    	$sensor_id = str_ireplace(" ", "_", $data->sensor_id);
		$arr = split(" - ", $data->uom);
		if (sizeof($arr) == 2){
			$uom = str_ireplace(" ", "_", $arr[0]);
			$uom_symbol = str_ireplace(" ", "_", $arr[1]);
		}else{
			$uom = str_ireplace(" ", "_", $_POST['uom']);
			$uom_symbol = '';
		}
		$observed_property = str_ireplace(" ", "_", $data->observed_property);
		$observed_property_uri = AbstractResource::$resource_base.'observed_property/'.$observed_property;
		$observed_value = $data->observed_value;
		$sensor_id_uri = AbstractResource::$resource_base.'sensor/'.$sensor_id;
		$uom_uri = AbstractResource::$resource_base.'uom/'.trim($uom);
		$intrinsic_index += getIntrinsicTriples($sensor_id_uri, $observed_property_uri, $uom_symbol, $uom_uri, $observed_value);
    	
		$temp = array($sensor_id_uri => $intrinsic_index[$sensor_id_uri]);
		unset($intrinsic_index[$sensor_id_uri]);
		
return $temp;
    }

    
	public function __construct()  
    {  
    		
    }  
      
    	
}

?>