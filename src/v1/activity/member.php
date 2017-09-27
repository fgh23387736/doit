<?php
	session_start();

	/**用户登录后会自动写入session
	*$_SESSION['type']='user|admin';
	*$_SESSION['id']=1;
	*/

	//$_SESSION['id'] = 2;
	//$_SESSION['type'] = "admin";

	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/MySqlPDO.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/Imgs.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/request.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/https.php';
	include $_SERVER['DOCUMENT_ROOT'].'/yora/src/public_functions.php';
	if (!isset($_SESSION['type'])) {
		# code...
		https(401);
		echo json_encode(array("Error" => "您还未登录"));
	}

	switch ($request_method) {
		case 'POST':
			# code...
			toPost($request_data);
			break;
		case 'DELETE':
			toDelete($request_data);
			break;
		case 'PUT':
			if($_SESSION['type'] != 'admin'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用管理员账号登录"));
				exit();
			}else{
				toPut($request_data);
			}
			break;
		case 'GET':
			toGet($request_data);
			# code...
			break;
		default:
			# code...
			break;
	}

	function toPost($request_data){
		if ($request_data['UserId'] != $_SESSION['id']) {
			# code...
			https(401);
			echo json_encode(array('Error' => "您不是活动发起者"));
			exit();
		}else{
			$myecho=array();
			$mypdo=new MySqlPDO();
			$sql = 'INSERT INTO `activity_user`(
				`ActivityId`,
				`UserId`,
				`Type`,
				`Money`
			) VALUES (
				?,?,?,?
			)';
			$mypdo->prepare($sql);
			$myarr = array(
				$request_data['ActivityId'],
				$request_data['UserId'],
				$request_data['Type'],
				$request_data['Money']
			);
			if ($mypdo->executeArr($myarr)) {
				# code...
				$myecho['Id'] = $mypdo->lastInsertId();
			}else{
				$myecho['Error']="添加发起活动失败";
				https(422);
				echo json_encode($myecho);
				exit();
			}
		}
		https(201);
		echo json_encode($myecho);
	}

	function toDelete($request_data){
		$myecho = array();
		$mypdo = new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Search'])) {
			$myecho['Error']="请求格式错误";
			https(406);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="DELETE FROM `activity_user` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch ($request_data['Type']) {
			case '0':
				# code...
				if (isset($request_data['Search']['Id']) && !empty($request_data['Search']['Id'])) {
					# code...
					$Ids = explode('+', $request_data['Search']['Id']);
					$sql_b .= "`Id` IN (";
					foreach ($Ids as $key => $value) {
						# code...
						$sql_b .= "?,";
						$wherevalues[] = $value;
					}
					$sql_b = substr($sql_b, 0, strlen($sql_b)-1);
					$sql_b .=")";
				}else{
					$myecho['Error']="请求格式错误";
					https(406);
					echo json_encode($myecho);
					exit();
				}
				break;
			default:
				# code...
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql=$sql_f.$sql_b;
		//echo $sql;
		//print_r($request_data['Search']['Id']);
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
		$myecho = array();
		$mypdo = new MySqlPDO();
		if (!isset($request_data['Type']) || !isset($request_data['Id']) || !isset($request_data['Update'])) {
			# code...
			$myecho['Error']="请求格式错误";
			https(406);
			echo json_encode($myecho);
			exit();
		}
		$sql_f = "UPDATE `activity_user` SET ";
		$sql_i = "";
		$insidevalues = array();
		$wherevalues = array();
		//$thelastvalues = array();
		$uuu = array();
		$Ids = explode('+', $request_data['Id']);
		$sql_b = " `Id` IN (";
		foreach ($Ids as $key => $value) {
			# code...
			$sql_b .= "?,";
			$wherevalues[] = $value;
		}
		$sql_b = substr($sql_b, 0, strlen($sql_b)-1);
		$sql_b .= ")";
		//echo $sql_b;
		switch ($request_data['Type']) {
			case '0':
				if (isset($request_data['Update']['Type'])) {
					# code...
					$sql_i .= "`Type` = ? ";
					$insidevalues = $request_data['Update']['Type'];
				}
				break;
			default:
				$myecho['Error']="请求格式错误";
				https(406);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql = $sql_f.$sql_i."WHERE".$sql_b;
		//echo $sql;
		$thelastvalues[]=$insidevalues;
		foreach ($wherevalues as $key => $value) {
			$thelastvalues[]=$value;
		}
		//print_r($thelastvalues);
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($thelastvalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}
		https(201);
		echo json_encode($myecho);
	}

	function toGet($request_data){
		$myecho = array();
		$mypdo = new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Search'])||!isset($request_data['Keys'])){
			$myecho['Error']="请求格式错误";
			https(406);
			echo json_encode($myecho);
			exit();
		}
		$sql_f = "SELECT * FROM `activity_user` WHERE ";
		$sql_c = "SELECT COUNT(*) AS `AllNumber` FROM `activity_user` WHERE ";
		$sql_b = "";
		$wherevalues = array();
		switch ($request_data['Type']) {
			case '0':
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
			case '1':
				# code...
				if (isset($request_data['Search']['ActivityId']) && !empty($request_data['Search']['ActivityId'])) {
					# code...
					$sql_b = "`ActivityId` = ?";
					$wherevalues[] = $request_data['Search']['ActivityId'];
				}else{
					$sql_b = "1=1";
				}
				break;
			default:
				$myecho['Error']="请求格式错误";
				https(406);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql = $sql_c.$sql_b;
		//echo $sql;
		$mypdo->prepare($sql);
		//print_r($wherevalues);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$rs = $mypdo->fetch();
			$myecho['Total'] = $rs['AllNumber'];
		}
		if(isset($request_data['Page'])&&isset($request_data['PageSize'])){
			if(is_numeric($request_data['Page'])&&is_numeric($request_data['PageSize'])){
				$sql_b.=" LIMIT ".$request_data['PageSize'] * ($request_data['Page'] - 1).",".$request_data['PageSize'];
			}
		}
		$sql = $sql_f.$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$myecho['ResultList'] = array();
			if(empty($request_data['Keys'])){
				$attrs=array(
					'Id',
					'ActivityId',
					'UserId',
					'AdminId',
					'Type',
					'Money'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			while ($rs = $mypdo->fetch()) {
				$temp = array();
				foreach ($attrs as $key => $value) {
					# code...
					$temp[$value] = $rs[$value];
				}
				$myecho['ResultList'][] = $temp;
			}
		}
		https(200);
		echo json_encode($myecho);
	}
?>
