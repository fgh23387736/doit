<?php
	session_start();
	/**用户登录后会自动写入session
	*$_SESSION['type']='user|admin';
	*$_SESSION['id']=1;
	*/

	/*
	*$_SESSION['Competence']=1;
	*只有type为admin才存在
	*1：全国管理
	*2：全省管理
	*3：全市管理
	*4：全校管理
	 */
	$_SESSION['type']='admin';
	$_SESSION['id']=1;
	$_SESSION['Competence']=1;

	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/MySqlPDO.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/Imgs.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/request.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/https.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/public_functions.php';
	if(!isset($_SESSION['type'])){
	    https(401);
		echo json_encode(array('Error' => "您还未登录"));
		exit();
	}
	switch ($request_method) {
		case 'POST':
			toPost($request_data);
			break;
		case 'DELETE':
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用管理员账号登录"));
	    		exit();
			}else{
				toDelete($request_data);
			}
			break;
		case 'PUT':
			if($_SESSION['type']!='admin'){
	    		https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用管理员账号登录"));
				exit();
			}else{
				toPut($request_data);
			}
			break;
		case 'GET':
			toGet($request_data);
			break;
		default:
	    	https(500);
	    	echo json_encode(array('Error' => "请求错误"));
			exit();
			break;
	}

	function toPost($request_data){
		$myecho=array();
		$imgs=new Imgs();
		$mypdo=new MySqlPDO();
		$sql='INSERT INTO `activity_question`
			(
				`ActivityId`,
				`Question`
			) VALUES (
				?,?
			)';
		$mypdo->prepare($sql);
		$myarr=array(
			$request_data['ActivityId'],
			$request_data['Question']
		);
		//执行预处理
		if($mypdo->executeArr($myarr)){
			$myecho['Id']=$mypdo->lastInsertId();
		}else{
			$myecho['Error']="增加失败";
			https(400);
			echo json_encode($myecho);
			exit();
		}
		https(201);
		echo json_encode($myecho);
	}

	function toDelete($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Search'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="DELETE FROM `activity_question` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch ($request_data['Type']) {
			case '0':{
				if(isset($request_data['Search']['Id'])&&!empty($request_data['Search']['Id'])){
					$Ids=explode('+', $request_data['Search']['Id']);
					$sql_b="`Id` in (";
					foreach ($Ids as $key => $value) {
						$sql_b.="?,";
						$wherevalues[]=$value;
					}
					$sql_b=substr($sql_b,0,strlen($sql_b)-1);
					$sql_b.=")";
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				break;
			}
			case '1':{
				if(isset($request_data['Search']['ActivityId'])&&!empty($request_data['Search']['ActivityId'])){
					$sql_b="`ActivityId` = ?";
					$wherevalues[]=$request_data['Search']['ActivityId'];
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				break;
			}
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql=$sql_f.$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}
		https(204);
		echo json_encode($myecho);
	}

	function toPut($request_data){
		$myecho=array();
		$imgs=new Imgs();
		$mypdo=new MySqlPDO();
		$mypdo_temp=new MySqlPDO();
		$mypdo_temp_temp=new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Update'])||!isset($request_data['Id'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="UPDATE `activity_question` SET ";
		$sql_i="";
		$insidevalues=array();
		$wherevalues=array();
		$Ids=explode('+', $request_data['Id']);
		$sql_b="`Id` IN (";
		foreach ($Ids as $key => $value) {
			$sql_b.="?,";
			$wherevalues[]=$value;
		}
		$sql_b=substr($sql_b,0,strlen($sql_b)-1);
		$sql_b.=")";
		switch ($request_data['Type']) {
			case '0':{
				$sql_i="
					`Question`=?
					";
				$insidevalues=array(
					$request_data['Update']['Question']
				);
				break;
			}
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql=$sql_f.$sql_i." WHERE ".$sql_b;
		$mypdo->prepare($sql);
		$theLastValues=array();
		foreach ($insidevalues as $key => $value) {
			$theLastValues[]=$value;
		}
		foreach ($wherevalues as $key => $value) {
			$theLastValues[]=$value;
		}
		if(!$mypdo->executeArr($theLastValues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}
		https(201);
		echo json_encode($myecho);
	}

	function toGet($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		$mypdo_temp=new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Search'])||!isset($request_data['Keys'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="SELECT * FROM `activity_question` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `activity_question` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch ($request_data['Type']) {
			case '0':{
				if(isset($request_data['Search']['Id'])&&!empty($request_data['Search']['Id'])){
					$Ids=explode('+', $request_data['Search']['Id']);
					$sql_b="`Id` IN (";
					foreach ($Ids as $key => $value) {
						$sql_b.="?,";
						$wherevalues[]=$value;
					}
					$sql_b=substr($sql_b,0,strlen($sql_b)-1);
					$sql_b.=")";
				}else{
					$sql_b="1=1";
				}
				break;
			}
			case '1':{
				if(isset($request_data['Search']['ActivityId'])&&isset($request_data['Search']['Question'])){
					$sql_b="`Question` LIKE ?";
					$wherevalues[]="%".$request_data['Search']['Question']."%";
					if(empty($request_data['Search']['ActivityId'])){
					}else{
						$sql_b.=" and `ActivityId` = ?";
						$wherevalues[]=$request_data['Search']['ActivityId'];
					}
					
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				break;
			}
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql=$sql_c.$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$rs=$mypdo->fetch();
			$myecho['Total']=$rs['AllNumber'];
		}
		if(isset($request_data['Page'])&&isset($request_data['PageSize'])){
			if(is_numeric($request_data['Page'])&&is_numeric($request_data['PageSize'])){
				$sql_b.=" LIMIT ".$request_data['PageSize'] * ($request_data['Page'] - 1).",".$request_data['PageSize'];
			}
		}
		$sql=$sql_f.$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$myecho['ResultList']=array();
			if(empty($request_data['Keys'])){
				$attrs=array(
					'Id',
					'ActivityId',
					'Question',
					'AnswersId'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			while ($rs=$mypdo->fetch()) {
				$temp=array();
				foreach ($attrs as $key => $value) {
					if($value=="AnswersId"){
						$sql_temp="SELECT `Id` FROM `activity_question_answer` Where `QuestionId`=?";
						$mypdo_temp->prepare($sql_temp);
						$temp[$value]=array();
						if($mypdo_temp->executeArr(array($rs['Id']))){
							while ($rs_dd=$mypdo_temp->fetch()) {
								$temp[$value][]=$rs_dd['Id'];
							}
						}else{
							$myecho['Error']="系统错误";
							https(500);
							echo json_encode($myecho);
							exit();
						}
					}else{
						if(isset($rs[$value])){
							$temp[$value]=$rs[$value];
						}
					}
				}
				$myecho['ResultList'][]=$temp;
			}
		}
		https(200);
		echo json_encode($myecho);
	}

?>

