<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>inContext Sensing</title>
<link rel="shortcut icon" href="images/favicon.ico" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/arial.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>

<script>
var counter = 1;
var limit = 3;
function addInput(divName){
//     if (counter == limit)  {
//          alert("You have reached the limit of adding " + counter + " inputs");
//     }
//     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "Sensor Capability("+ (counter + 1) +"): <input type='text' name='myInputs[]' value='' /> Property - min/max";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
//     }
}
</script>
</head>
<body onload="javascript:hidediv('hideShow'); hidediv('rain')">
<div class="main">
<div class="header" title="Philips bubble mood sensing dress">
<div class="header_resize">
<div class="logo">
<h1><a href="#">inContext<span>Sensing</span> <small>Augment your sensor
data</small></a></h1>
</div>
<div class="clr"></div>
<div class="htext">
<h2>Linked Sensor Data</h2>
<p>Augment Pachube sensor data with additional contextual information
from the Web of Data.</p>
</div>
<div class="clr"></div>
<div class="menu_nav">
<ul>
	<li><a href="index.php">Home</a></li>
	<li class="active"><a href="snippetGen.php">Snippet Generator</a></li>
	<li><a href="about.html">About Us</a></li>
</ul>

</div>
<div class="clr"></div>
</div>
</div>
<div class="content">
<div class="content_resize">
<div class="mainbar">
<div class="article" style="color: black;">

<div class="clr"></div>

<?php
require_once 'lib/semsol-arc2/ARC2.php';
require_once 'resources/AbstractResource.php';
require_once 'resources/TripleCreator.php';

$intrinsic_index = array();
$additional_node_index = array();
$additional_owner_index = array();
$ser_intrinsic = '';
$ser_intrinsic_sider = '';
$ser_additional_node = '';
$ser_additional_owner = '';


if(isset($_POST['generate'])) {
	if (!$_POST['sensor_id'] ||
	!$_POST['uom'] ||
	!$_POST['observed_property'] ||
	!$_POST['observed_value']){
		?>
<p><span style="color: red">Error: One or more of the required fields
have been left empty</span></p>
		<?php
	}else{

		$sensor_id = $_POST['sensor_id'];
		$sensor_id = str_ireplace(" ", "_", $sensor_id);
		$arr = split(" - ", $_POST['uom']);
		if (sizeof($arr) == 2){
			$uom = str_ireplace(" ", "_", $arr[0]);
			$uom_symbol = str_ireplace(" ", "_", $arr[1]);
		}else{
			$uom = str_ireplace(" ", "_", $_POST['uom']);
			$uom_symbol = '';
		}
		$observed_property = str_ireplace(" ", "_", $_POST['observed_property']);
		$observed_property_uri = AbstractResource::$resource_base.'observed_property/'.$observed_property;
		$observed_value = $_POST['observed_value'];
		$sensor_id_uri = AbstractResource::$resource_base.'sensor/'.$sensor_id;
		$uom_uri = AbstractResource::$resource_base.'uom/'.trim($uom);
		$intrinsic_index += getIntrinsicTriples($sensor_id_uri, $observed_property_uri, $uom_symbol, $uom_uri, $observed_value);

		// 		---------------------------------------------------------------------

		$capabilities = $_POST["myInputs"];
		$model = $_POST['sensor_model'];
		$model_uri = '';
		$manual_uri = '';
		$stimulus_uri = '';
		if ($model){
			$model = str_ireplace(" ", "_",$model);
			if (startsWith($model, "http")){
				$model_uri = $model;
			}else{
				$model_uri = AbstractResource::$resource_base.'sensormodel/'.trim($model);
			}
		}

		$manual = $_POST['sensor_manual'];
		if ($manual){
			$manual = str_ireplace(" ", "_", $manual);
			if (startsWith($manual, "http")){
				$manual_uri = $manual;
			}else{
				$manual_uri = AbstractResource::$resource_base.'sensormanual/'.trim($manual);
			}
		}
		$stimulus = $_POST['sensor_stimulus'];
		if ($stimulus){
			$stimulus = str_ireplace(" ", "_",$stimulus);
			if (startsWith($stimulus, "http")){
				$stimulus_uri = $stimulus;
			}else{
				$stimulus_uri = AbstractResource::$resource_base.'stimulus/'.trim($stimulus);
			}
		}
		$additional_node_index = getAdditionalNodeTriples($sensor_id_uri, $model_uri, $manual_uri, $stimulus_uri, $capabilities, $observed_property_uri);


		//		---------------------------------------------------------------------

		$sensor_owner = $_POST['sensor_owner'];
		if ($sensor_owner){
			$sensor_owner = str_ireplace(" ", "_", $sensor_owner);
		}
		$sensor_publisher = $_POST['sensor_publisher'];
		if ($sensor_publisher){
			$sensor_publisher = str_ireplace(" ", "_", $sensor_publisher);
		}
		$foi = $_POST['sensor_foi'];
		if ($foi){
			$foi = str_ireplace(" ", "_",foi);
			// search for FOI in externa knowledge bases
		}
		$platform_uri = $_POST['sensor_platform'];
		if ($platform_uri){
			$platform_uri = str_ireplace(" ", "_", $platform_uri);
		}
		$history_uri = $_POST['sensor_history'];
		if ($history_uri){
			$history_uri = str_ireplace(" ", "_", $history_uri);
		}
		$additional_owner_index +=	getAdditionalOwnerTriples($sensor_id_uri, $sensor_owner, $sensor_publisher, $foi, $platform_uri, $history_uri);

		//		---------------------------------------------------------------------
		$serialization_pref = $_POST['serialization'];
		$temp = array($sensor_id_uri => $intrinsic_index[$sensor_id_uri]);
		unset($intrinsic_index[$sensor_id_uri]);
		$ser_intrinsic = getRDFSerialization($serialization_pref, $temp);
		$ser_intrinsic_sider = getRDFSerialization($serialization_pref, $intrinsic_index);
		$ser_additional_node = getRDFSerialization($serialization_pref, $additional_node_index);
		$ser_additional_owner = getRDFSerialization($serialization_pref, $additional_owner_index);
	}
}

function getIntrinsicTriples($sensor_id_uri, $observed_property_uri, $uom_symbol, $uom_uri, $observed_value){
	$retarr = array();
	$retarr= getSensorTriple($sensor_id_uri);
	$retarr= getPropertyTriple($retarr, $observed_property_uri, $sensor_id_uri);
	$retarr= getUnitOfMeasurementTriple($retarr, $observed_property_uri, $uom_uri, $uom_symbol, $sensor_id_uri);
	$retarr = getValueTriple($retarr, $observed_value, $sensor_id_uri);
	
	return $retarr;
}

function getAdditionalNodeTriples($sensor_id_uri, $model_uri, $manual_uri, $stimulus_uri, $capabilities, $observed_property_uri){
	$retarr = array();
	$retarr =  getModelTriple($retarr, $model_uri, $sensor_id_uri);
	$retarr= getManualTriple($retarr, $manual_uri, $sensor_id_uri);
	$retarr = getStimulusTriple($retarr, $stimulus_uri, $sensor_id_uri, $observed_property_uri);
	$retarr += getCapabilitiesTriple($capabilities, $sensor_id_uri);

	return $retarr;
}


function getAdditionalOwnerTriples($sensor_id_uri, $sensor_owner, $sensor_publisher, $foi, $platform_uri, $history_uri){
	$retarr = array();
	$retarr = getOwnerTriple($retarr, $sensor_id_uri, $sensor_owner);
	$retarr =	getPublisherTriple($retarr, $sensor_id_uri, $sensor_publisher);
	$retarr = getFOITriple($retarr, $sensor_id_uri, $foi);
	$retarr = getPlatformTriple($retarr, $sensor_id_uri, $platform_uri);
	$retarr = getHistoryTriple($retarr, $sensor_id_uri, $history_uri);

	return $retarr;
}

function getRDFSerialization($serialization_language, $index){
	$ser = '';
	if (isset($serialization_language)){
		$arc_ser = ARC2::getRDFXMLParser();
		if (strcasecmp($serialization_language, 'XML') == 0){
			//				echo ' in xml ';
			$ser = $arc_ser->toRDFXML($index);
		}else if (strcasecmp($serialization_language, 'JSON') == 0){
			//				echo ' in json ';
			$ser = $arc_ser->toRDFJSON($index);
		}else if (strcasecmp($serialization_language, 'TURTLE') == 0){
			//				echo ' in turtle ';
			$ser = $arc_ser->toTurtle($index);
		}else{
			$ser = $arc_ser->toNTriples($index);
		}
		$ser = getPrintableCode($ser);
	}
	return $ser;
}

function startsWith($haystack, $needle)
{
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

function getPrintableCode($data){
	$data_4html = str_ireplace("<", "&lt", $data);
	$data_4html = str_ireplace(">", "&gt", $data_4html);
	$data_4html = '<pre><code>'.$data_4html.'</pre></code>';
	return $data_4html;
}


?>

<p>Generate a RDF representation which describes your sensor.<br />
</p>
<form method="post"><span style="color: red">*required fields</span><br />
<br />

Preferred RDF serialization: <select name="serialization">
	<option value="JSON"
	<?php if (isset($_POST['serialization']) && strcasecmp($_POST['serialization'], 'JSON') == 0) echo 'selected="selected"';  ?>>RDF/JSON</option>
	<option value="XML"
	<?php if (isset($_POST['serialization']) && strcasecmp($_POST['serialization'], 'XML') == 0) echo 'selected="selected"';  ?>>RDF/XML</option>
	<option value="NTRIPLES"
	<?php if (isset($_POST['serialization']) && strcasecmp($_POST['serialization'], 'NTRIPLES') == 0) echo 'selected="selected"';  ?>>N-Triples</option>
	<option value="TURTLE"
	<?php if (isset($_POST['serialization']) && strcasecmp($_POST['serialization'], 'TURTLE') == 0) echo 'selected="selected"';  ?>>Turtle</option>
</select>

<div style="border-style: solid; border-width: thin;" id="intrinsicInfo">
<span style="font-weight: bold;">Intrinsic Node Information</span><br />
<span style="color: red">* Sensor ID :</span> <input type="text"
	name="sensor_id"
	value="<?php if (isset($sensor_id)) echo $sensor_id; else echo ""; ?>" /><br />
<span style="color: red">* Unit of Measurement:</span> <input
	type="text" name="uom"
	value=<?php if (isset($uom)) echo '"'.$uom. ' - '.$uom_symbol.'"'; else echo '"Centigrades - C"'; ?> /><br />
<span style="color: red">* Observed Property:</span> <input type="text"
	name="observed_property"
	value="<?php if (isset($observed_property)) echo $observed_property; else echo "Temperature"; ?>" /><br />
	<span style="color: red">* Observed Value:</span> <input type="text"
	name="observed_value"
	value="<?php if (isset($observed_value)) echo $observed_value; else echo "10.2"; ?>" /><br />
</div>
<br />
<div style="border-style: solid; border-width: thin;"
	id="additional_nodeDepenedentInfo"><span style="font-weight: bold;">Additional
Node-Dependent Information</span><br />
Sensor Model : <input type="text" name="sensor_model"
	value="<?php if (isset($model)) echo $model; else echo ""; ?>" /><br />
Sensor Manual: <input type="text" name="sensor_manual"
	value="<?php if (isset($manual)) echo $manual; else echo ""; ?>" /><br />
Sensor Stimulus: <input type="text" name="sensor_stimulus"
	value="<?php if (isset($stimulus)) echo $stimulus; else echo ""; ?>" /><br />


<div id="capabilities"><?php if (isset($capabilities)&& $capabilities){
	$count = 1;
	foreach ($capabilities as $capab){
		?> <br />
Sensor Capability(<?php echo $count++;?>): <input type="text"
	name="myInputs[]" value="<?php echo $capab; ?>" /> Property - min/max <?php
	if ($count === 2){
		?> <input type="button" value="Add more"
	onclick="addInput('capabilities');" /> <?php 
	}
	}
}else{?> <br />
Sensor Capability(1): <input type="text" name="myInputs[]"
	value="Accuracy - 0.5/0.8" /> Property - min/max; <input type="button"
	value="Add more" onclick="addInput('capabilities');" /> <?php }?></div>

</div>

<div style="border-style: solid; border-width: thin;"
	id="additional_ownerDepenedentInfo"><span style="font-weight: bold;">Additional
Owner-Dependent Information</span><br />
Sensor Owner: <input type="text" name="sensor_owner"
	value="<?php if (isset($sensor_owner)) echo $sensor_owner; else echo ""; ?>" /><br />
Sensor Data Publisher: <input type="text" name="sensor_publisher"
	value="<?php if (isset($sensor_publisher)) echo $sensor_publisher; else echo ""; ?>" /><br />
Attached Platform URI: <input type="text" name="sensor_platform"
	value="<?php if (isset($platform_uri)) echo $platform_uri; else echo ""; ?>" /><br />
History Archive URI: <input type="text" name="sensor_history"
	value="<?php if (isset($history_uri)) echo $history_uri; else echo ""; ?>" /><br />
Feature of Interest(FOI): <input type="text" name="sensor_foi"
	value="<?php if (isset($foi)) echo $foi; else echo "Room"; ?>" /><br />

</div>


<br />

<input type="submit" name="generate" value="Generate" /></form>

<?php
if ($ser_intrinsic){ ?>

<h3>Generated description of your Sensor</h3>
<p>Your Sensor Unique Resource Identifier(URI) is <?php echo $sensor_id_uri; ?><br />
<br />
Chosen RDF serialization language = <?php echo $serialization_pref; ?></p>

<div><span style="font-weight: bold;">Intrinsic node description - to be stored on the sensor node:</span>
<div id="serialization_intrinsic" style="overflow: auto"><?php echo $ser_intrinsic; ?>
</div>
</div>

<div><span style="font-weight: bold;">Sider information regarding the intrinsic node description - to be
stored anywhere:</span>
<div id="serialization_intrinsic_sider" style="overflow: auto"><?php echo $ser_intrinsic_sider; ?></div>
</div>

<?php if ($ser_additional_node){ ?>
<div><span style="font-weight: bold;">Additional node-dependent description - to be stored anywhere:</span>
<div id="serialization_additional_node" style="overflow: auto"><?php echo $ser_additional_node; ?></div>
</div>

<?php } if ($ser_additional_owner){ ?>
<div><span style="font-weight: bold;">Additional owner-dependent description - to be stored anywhere:</span>
<div id="serialization_additional_owner" style="overflow: auto"><?php echo $ser_additional_owner; ?></div>
</div>

<?php }?> <?php }?></div>
</div>
</div>
</div>
</div>
</body>
</html>

