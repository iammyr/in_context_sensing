<?php

require_once 'RestUtils.php';


$GLOBALS['RESTmap'] = array();
$GLOBALS['RESTmap']['GET'] = "handleGet";
$GLOBALS['RESTmap']['POST'] = "handleGet";
//$GLOBALS['RESTmap']['PUT'] = "handleGet";

routing();

function routing(){
	$resource_obj = null;
	$req_uri = $_SERVER['REQUEST_URI'];

	/** (1)find the type of resource requested **/
	$splitted_uri = split("/", $req_uri);
	$splitted_uri_size = sizeof($splitted_uri);
	$last_uri_var = $splitted_uri[$splitted_uri_size-1];
	$serialization = true;
	if (strcasecmp($las_uri_var, "external_link") === 0){
		require_once 'LinkResource.php';
		//$serialization = false;
		$resource_obj = new LinkResource();
	}else if (strcasecmp($last_uri_var, "intrinsic") === 0){
		require_once 'IntrinsicResource.php';

		$resource_obj = new IntrinsicResource();

	}else if (strcasecmp($last_uri_var, "intrinsic_sider") === 0){
		require_once 'IntrinsicSiderResource.php';
		$resource_obj = new IntrinsicSiderResource();

	}else if (strcasecmp($last_uri_var, "node_dependent") === 0){
		require_once 'NodeDependentResource.php';
		$resource_obj = new NodeDependentResource();

	}else if (strcasecmp($last_uri_var, "owner_dependent") === 0){
		require_once 'OwnerDependentResource.php';
		$resource_obj = new OwnerDependentResource();
	}else{
		RestUtils::sendResponse(404);
		return;
	}
	processingRequest($resource_obj, $serialization);
}

function processingRequest($resource_obj, $serialization){
	global $GLOBALS;
	$req_method = $_SERVER['REQUEST_METHOD'];

	/** (1)find the function/method to call **/
	if (isset($GLOBALS['RESTmap'][$req_method])) {
		$callback = array($resource_obj, $GLOBALS['RESTmap'][$req_method]);
		if (is_callable($callback)) {
			/** (3)get the data required by the requested function/method **/
			$data = NULL;


			//			$parameters = array("sensor_id" => "123456",
			//				"uom" => "Centigrades - C",
			//				"observed_property" => "Temperature",
			//				"observed_value" => "10.2");
			//			$parameters = array('sensor_id' => '12', 'uom' => 'Centigrades - C', 'observed_property' => 'Temperature', 'observed_value' => '10.2');
			//			$json_data = json_encode($parameters);
			//			$data = json_decode($json_data);
			//			$data = $parameters;


			switch ($req_method){
				case "GET":
					if ($tmp = file_get_contents('php://input')) {
						$data = json_decode($tmp);
					}
					break;
				default:
					if ($tmp = file_get_contents('php://input')) {
						$data = json_decode($tmp);
					}
			}

			/** (4)execute the function/method and return the results **/
			//			header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
			//			header('Content-Type: text/plain');

			$serialization_pref = $_SERVER['HTTP_ACCEPT'];
			$index = call_user_func($callback, $data);
			if (!$index){
				RestUtils::sendResponse(400);
				return;
			}
			$answer = '';
			if ($serialization){
				$answer = getRDFSerialization($serialization_pref, $index);
				//			$rdf_representation = getRDFSerialization("TURTLE", $index);
			}else{
				$answer = json_encode($index);
			}
			RestUtils::sendResponse(200, $answer);
		} else {
			//			header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
			RestUtils::sendResponse(404);

		}
	}else{
		RestUtils::sendResponse(501);
	}
}

//function handleGet(){
//	$json_answer = array("answer" => "hello");
//	return $json_answer;
//}

?>
