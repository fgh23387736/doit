<?php
header("Content-type: text/html; charset=utf-8"); 
	session_start();
	/**用户登录后会自动写入session
	*$_SESSION['type']='user|admin';
	*$_SESSION['id']=1;
	*/
	// $_SESSION['type']='admin';
	// $_SESSION['id']=1;
	$_SESSION['type']='admin';
	$_SESSION['id']=1;
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/MySqlPDO.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/Imgs.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/request.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/https.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/public_functions.php';
	if(!isset($_SESSION['type'])){
		https(401);
		echo json_encode(array('Error'=>"您还未登录"));
		exit();
	}
	switch ($request_method) {
		case 'POST':
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用管理员账号登录"));
				exit();
			}else{
				toPost($request_data);
			}
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
		$sql='INSERT INTO `punish_record`
		(
			`UserId`,
   			`StartTime`,
    		`EndTime`,
    		`Reason`,
    		`AdminId`
		) VALUES (
			?,?,?,?,?
		);';
		$mypdo->prepare($sql);
		$myarr=array(
			$request_data['UserId'],
			$request_data['StartTime'],
			$request_data['EndTime'],
			$request_data['Reason'],
			$_SESSION['id']      //处理管理员ID
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
		//生成message
		if(isset($request_data['IsMessage'])&&$request_data['IsMessage']==1){
			$M_sql='INSERT INTO `message`
			(
				`Time`,
				`Content`,
				`Title`,
				`TitleUrl`,
				`AdminId`
			) VALUES (
				?,?,?,?,?
			)';
			$mypdo->prepare($M_sql);
			$myM_arr=array(
				$request_data['StartTime'],
				"您的账号已暂停使用",
				"封号通知",
				"0",
				$_SESSION['id']
			);
			if($mypdo->executeArr($myM_arr)){
				$myecho['MessageId']=$mypdo->lastInsertId();
			}else{
				$myecho['Error']="增加失败";
				https(400);
				echo json_encode($myecho);
				exit();
			}
			$Mr_sql='INSERT INTO `message_receiver`
			(
				`MessageId`,
				`UserId`,
				`IsRead`
			) VALUES (
				?,?,?
			)';
			$mypdo->prepare($Mr_sql);
			$myMr_arr=array(
				$myecho['MessageId'],
				$request_data['UserId'],
				"0"
			);
			if($mypdo->executeArr($myMr_arr)){
				$myecho['ReceivedRecordId']=$mypdo->lastInsertId();
			}else{
				$myecho['Error']="增加失败";
				https(400);
				echo json_encode($myecho);
				exit();
			}
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
		$sql_f="DELETE FROM `punish_record` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch ($request_data['Type']) {
			case '0':{
				$Ids=explode('+', $request_data['Search']['Id']);
				$sql_b="`Id` in (";
				foreach ($Ids as $key => $value) {
					$sql_b.="?,";
					$wherevalues[]=$value;
				}
				$sql_b=substr($sql_b,0,strlen($sql_b)-1);
				$sql_b.=")";
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
		if(!isset($request_data['Type'])||!isset($request_data['Update'])||!isset($request_data['Id'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="UPDATE `punish_record` SET "; 
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
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="
					`StartTime`=?,
					`EndTime`=?
				";
				$insidevalues=array(
					$request_data['Update']['StartTime'],
					$request_data['Update']['EndTime']
				);
				break;
			}
			case '1':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="
					`StartTime`=?
				";
				$insidevalues=array(
					$request_data['Update']['StartTime']
				);
				break;
			}
			case '2':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="
					`EndTime`=?
				";
				$insidevalues=array(
					$request_data['Update']['EndTime']
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
		$myecho['Id']=$request_data['Id'];
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
		$sql_f="SELECT * FROM `punish_record` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `punish_record` WHERE ";
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
				if(isset($request_data['Search']['UserId'])&&!empty($request_data['Search']['UserId'])){
					$Ids=explode('+', $request_data['Search']['UserId']);
					$sql_b="`UserId` IN (";
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
			    	'UserId',
			    	'AdminId',
			    	'StartTime',
			    	'EndTime',
			    	'Reason',
			    	'Time'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			while ($rs=$mypdo->fetch()) {
				$temp=array();
				$arr_DistrictText=array();
				foreach ($attrs as $key => $value) {
					if(isset($rs[$value])){
						$temp[$value]=$rs[$value];
					}
				}
				$myecho['ResultList'][]=$temp;
			}
		}
		https(200);
		echo json_encode($myecho);
	}
?>