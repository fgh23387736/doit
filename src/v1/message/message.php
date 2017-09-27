<?php
	session_start();

	/**用户登录后会自动写入session
	*$_SESSION['type']='user|admin';
	*$_SESSION['id']=1;
	*/

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
			if($_SESSION['type'] != 'admin'){
				https(401);
				echo json_encode(array("Error" => "您不具有操作权限请用管理员账号登录"));
			}else{
				toPost($request_data);
			}
			break;

		case 'DELETE':
			# code...
			if($_SESSION['type'] != 'admin'){
				https(401);
				echo json_encode(array("Error" => "您不具有操作权限请用管理员账号登录"));
			}else{
				toDelete($request_data);
			}
			break;

		case 'GET':
			# code...
			toGet($request_data);
			break;

		default:
			# code...
			https(500);
			echo json_encode(array("Error" => "请求错误"));
			break;
	}


//not null: Id, Time, Content, Title, AdminId
	function toPost($request_data){ //增
		$myecho = array();
		$mypdo = new MySqlPDO();
		$sql = 'INSERT INTO `message`(
			`Time`,
			`Content`,
			`Title`,
			`TitleUrl`, #消息链接
			`AdminId`
		) VALUES (
			?,?,?,?,?
		)';
		//print_r($request_data);
		$mypdo->prepare($sql);
		$myarr = array(
			date('y-m-d h:i:s', time()),
			$request_data['Content'],
			$request_data['Title'],
			$request_data['TitleUrl'],
			$_SESSION['id']
		);
		//echo "string1  ";
		if ($mypdo->executeArr($myarr)) {
			# code...
			$myecho['Id'] = $mypdo->lastInsertId();
		}else{
			$myecho['Error'] = "增加失败";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql = 'INSERT INTO `message_receiver`(
			`MessageId`,
			`UserId`
		) VALUES (
			?,?
		)';
		$mypdo->prepare($sql);
		$Ids = explode(',', $request_data['UserId']);
		//print_r($Ids);
		foreach ($Ids as $key => $value) {
			# code...
			$myarr = array(
				$myecho['Id'],
				$value	
			);
			if ($mypdo->executeArr($myarr)) {
				# code...
				$myecho['ReceivedRecordId'][] = $mypdo->lastInsertId();
			}else{
				$myecho['Error'] = "增加失败";
				https(422);
				echo json_encode($myecho);
				# $myecho['Id']
				# $myecho['ReceivedRecordId'][]
				# $myecho['Error']
				exit();
			}
		}
		https(201);
		echo json_encode($myecho);
	}

	function toDelete($request_data){ //删
		$myecho = array();
		$mypdo = new MySqlPDO();
		# 根据$request_data['Type']和$request_data['Search']来做删除操作
		if(!isset($request_data['Type']) || !isset($request_data['Search'])){
			$myecho['Error'] = "请求格式错误";
			https(406);
			echo json_encode($myecho);
			exit();
		}
		$sql_f = "DELETE FROM `message` WHERE ";
		$sql_b = "";
		$sql_f2 = "DELETE FROM `message_receiver` WHERE ";
		$sql_b2 = "";
		$wherevalues = array();
		switch ($request_data['Type']) {
			case '0':
				# code...
				$Ids = explode('+', $request_data['Search']['Id']);
				$sql_b = "`Id` IN (";
				$sql_b2 = "`MessageId` IN (";
				foreach ($Ids as $key => $value) {
					# code...
					$sql_b .= "?,";
					$sql_b2 .="?,";
					$wherevalues[] = $value;
				}
				$sql_b = substr($sql_b, 0, strlen($sql_b)-1);
				$sql_b .=")";
				$sql_b2 = substr($sql_b2, 0, strlen($sql_b2)-1);
				$sql_b2 .=")";
				break;
			default:
				$myecho['Error']="请求格式错误";
				https(403);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql = $sql_f.$sql_b;
		$sql2 = $sql_f2.$sql_b2;
		$mypdo->prepare($sql);
		if (!$mypdo->executeArr($wherevalues)) {
			# code...
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}
		$mypdo->prepare($sql2);
		if (!$mypdo->executeArr($wherevalues)) {
			# code...
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}
		https(204);
		echo json_encode($myecho);
	}

	function toGet($request_data){
		$myecho = array();
		$mypdo = new MySqlPDO();
		$mypdo_temp = new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Search'])||!isset($request_data['Keys'])){
			$myecho['Error']="请求格式错误";
			echo json_encode($myecho);
			https(406);
			exit();
		}
		$sql_f = "SELECT * FROM `message` WHERE ";
		$sql_b = "";
		$wherevalues = array();
		switch ($request_data['Type']) {
			case '0':
				# code...
				if(isset($request_data['Search']['Id']) && !empty($request_data['Search']['Id'])){
					$Ids = explode('+', $request_data['Search']['Id']);
					$sql_b = "`Id` IN (";
					foreach ($Ids as $key => $value) {
						# code...
						$sql_b .= "?,";
						$wherevalues[] .= $value; 
					}
					$sql_b = substr($sql_b, 0, strlen($sql_b)-1);
					$sql_b .= ")";
				}else{
					$sql_b = "1=1";
				}
				break;
			case '1':
				# code...
				if (isset($request_data['Search']['AdminId']) && !empty($request_data['Search']['AdminId'])) {
					# code...
					$Ids = explode('+', $request_data['Search']['AdminId']);
					$sql_b = "`AdminId` IN (";
					foreach ($Ids as $key => $value) {
						# code...
						$sql_b .= "?,";
						$wherevalues[] = $value;
					}
					$sql_b = substr($sql_b, 0, strlen($sql_b)-1);
					$sql_b .= ")";
				}else{
					$sql_b = "1=1";
				}
				break;
			default:
				# code...
				$myecho['Error'] = "请求格式错误";
				https(406);
				echo json_encode($myecho);
				exit();
				break;
		if(isset($request_data['Page'])&&isset($request_data['PageSize'])){
			if(is_numeric($request_data['Page'])&&is_numeric($request_data['PageSize'])){
					$sql_b .= " LIMIT ".$request_data['PageSize'] * ($request_data['Page'] - 1).",".$request_data['PageSize'];
			}
		}
		$sql = $sql_f.$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error'] = "系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$myecho['ResultList'] = array();
			if (empty($request_data['Keys'])) {
				# code...
				$attrs = array(  //根据接口文档列出要取的属性(keys),整理成数组,用的时候在根据属性来取值
					'Id',
					'Content',
					'Title',
					'TitleUrl',
					'Time',
					'AdminId',
					'UserId',
					'ReceivedRecordId',
					'Number'
				); 
			}else{
				$attrs = explode('+', $request_data['Keys']);
			}
			while ($rs = $mypdo->fetch()) {
				# code...
				$temp = array();
				$arr_UserId = array();
				$arr_ReceivedRecordId = array();
				foreach ($attrs as $key => $value) {
					# code...
					if ($value == "UserId") {
						$sql_temp = "SELECT `UserId` FROM `message_receiver` WHERE `MessageId` = ?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id']))){
							while ($rs_dd = $mypdo_temp->fetch()) {
							# code...
							$temp[$value][] = $rs_dd[$value];
							}
						}else{
							$myecho['Error']="系统错误";
							echo json_encode($myecho);
							https(500);
							exit();
						}
					}else if($value == "ReceivedRecordId"){
						$sql_temp = "SELECT `Id` FROM `message_receiver` WHERE `MessageId` = ?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id']))){
							while ($rs_dd = $mypdo_temp->fetch()) {
							# code...
								$temp[$value][] = $rs_dd['Id'];
							}
						}else{
							$myecho['Error']="系统错误";
							echo json_encode($myecho);
							https(500);
							exit();
						}
					}else if($value == "Number"){
						$sql_c = "SELECT count(*) AS `AllNumber` FROM `message_receiver` WHERE `MessageId` = ?";
						$mypdo_temp->prepare($sql_c);
						if(!$mypdo_temp->executeArr(array($rs['Id']))){
							$myecho['Error']="系统错误";
							https(500);
							echo json_encode($myecho);
							exit();
						}else{
							$temp[$value] = $mypdo_temp->fetch();
						}
					}else{
						if(isset($rs[$value])){
							$temp[$value]=$rs[$value];
						}
					}
				}
				$myecho['ResultList'][] = $temp;
			}
		}
		echo json_encode($myecho);
		https(200);
	}
}
?>