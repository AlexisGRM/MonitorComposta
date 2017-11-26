<?php
    //access control
	header('Access-Control-Allow-Orgin');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	

	require_once('models/station.php');
	//GET
	if($_SERVER['RREQUEST_METHOD']=='GET'){
		//echo 'get';
		if(isset($_GET['id'])){
			try{
	$s = new State($_GET['id']);
	echo json_encode(array('status'=>0, 'station'=>json_decode($s->toJson())));
	
	}
	catch(RecordNotFoundException $ex){
		echo json_encode(array('status'=>1, 'errorMessage'=>$ex->get_message()));
	}
		}else{
			/*foreach(State:: getAll() as $s){
				echo $s->toJson();
			}*/
			echo json_decode(array('status'=>0, 'station'=>State::getAllToJson()));
			
		}
	}
	if($_SERVER['RREQUEST_METHOD']=='POST'){
		echo 'post';
	}
	
	if($_SERVER['RREQUEST_METHOD']=='PUT'){
		echo 'put';
	}
	
	if($_SERVER['RREQUEST_METHOD']=='DELETE'){
		echo 'delete';
	}
?>
