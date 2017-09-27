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
			https(500);
			echo json_encode(array("Error" => "请求错误"));
			break;
	}

	function toPost($request_data){
		$myecho = array();
		$mypdo = new MySqlPDO();
		$Ids = explode(',', $request_data['UserId']);
		$sql = 'INSERT INTO `message_receiver`(
			`MessageId`,
			`UserId`
		) VALUES (
			?,?
		)';
		foreach ($Ids as $key => $value) {
			# code...
			$myarr = array(
				$request_data['MessageId'],
				$value
			);
			$mypdo->prepare($sql);
			if ($mypdo->executeArr($myarr)) {
				# code...
				$myecho['Id'][] = $mypdo->lastInsertId();
			}else{
				$myecho['Error']="增加失败";
				echo json_encode($myecho);
				https(422);
				exit();
			}
		}
		https(201);
		echo json_encode($myecho);
	}

	function toDelete($request_data){
		$myecho = array();
		$mypdo = new MySqlPDO();
		if (!isset($request_data['Type']) || !isset($request_data['Search'])) {
			# code...
			$myecho['Error'] = "请求格式错误";
			https(406);
			echo json_encode($myecho);
			exit();
		}
		$sql_f = "DELETE FROM `message_receiver` WHERE ";
		$sql_b = "";
		$wherevalues = array();
		switch ($request_data['Type']) {
			case '0':
				# code...
				$Ids = explode('+', $request_data['Search']['Id']);
				$sql_b .= "`Id` IN (";
				foreach ($Ids as $key => $value) {
					# code...
					$sql_b .= "?,";
					$wherevalues[] = $value;
				}
				$sql_b = substr($sql_b, 0, strlen($sql_b)-1);
				$sql_b .= ")";
				break;
			
			default:
				$myecho['Error']="请求格式错误";
				https(403);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql = $sql_f.$sql_b;
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

	function toGet($request_data){
		$myecho = array();
		$mypdo = new MySqlPDO();
		$mypdo_temp = new MySqlPDO();
		if(!isset($request_data['Type']) || !isset($request_data['Keys']) || !isset($request_data['Search'])){
		//	echo "string";
			$myecho['Error']="请求格式错误";
			https(406);
			echo json_encode($myecho);
			exit();
		}
		$sql_f = "SELECT * FROM `message_receiver` WHERE ";
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
						$wherevalues[] = $value;

					}
					$sql_b = substr($sql_b, 0, strlen($sql_b)-1);
					$sql_b .= ")";
				}else{
					$sql_b = "1=1";
				}
				break;
			case '1':
				# code...
				if (isset($request_data['Search']['MessageId']) && !empty($request_data['Search']['MessageId'])) {
					# code...
					$sql_b = "`MessageId` = ?";
					$wherevalues[] = $request_data['Search']['MessageId'];
				}else{
					$sql_b = "1=1";
				}
				break;
			default:
				$myecho['Error'] = "请求格式错误";
				https(406);
				echo json_encode($myecho);
				exit();
				break;
		}
		if(isset($request_data['Page'])&&isset($request_data['PageSize'])){
			if(is_numeric($request_data['Page'])&&is_numeric($request_data['PageSize'])){
					$sql_b .= " LIMIT ".$request_data['PageSize'] * ($request_data['Page'] - 1).",".$request_data['PageSize'];
			}
		}
		$sql = $sql_f.$sql_b;
		$mypdo->prepare($sql);
		if (!$mypdo->executeArr($wherevalues)) {
			# code...
			$myecho['Error'] = "系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$myecho['ResultList'] = array();
			if (empty($request_data['Keys'])) {
				# code...
				$attrs = array(
					'Id',
					'MessageId',
					'UserId',
					'Content',
					'Title',
					'TitleUrl',
					'Time',
					'AdminId'
				);
			}else{
				$attrs = explode('+', $request_data['Keys']); 
			}

			while ($rs = $mypdo->fetch()) {
				$temp = array();
				foreach ($attrs as $key => $value) {
					# code...
					if ($value == "Content" || $value == "Title" || $value == "TitleUrl" || $value == "Time" || $value == "AdminId") {
						# code...
						$sql_temp = "SELECT * FROM `message` WHERE `Id` = ?";
						$wherevalues_temp = array();
						$wherevalues_temp[] = $rs['MessageId'];
						$mypdo_temp->prepare($sql_temp);
						if(!$mypdo_temp->executeArr($wherevalues_temp)){
							$myecho['Error']="系统错误";
							echo json_encode($myecho);
							https(500);
							exit();
						}else{
							$rs_temp = $mypdo_temp->fetch();
							$temp[$value] = $rs_temp[$value];
						}
					}else{
						$temp[$value] = $rs[$value];
					}
				}
				$myecho['ResultList'][] = $temp;
			}
		}
		https(200);
		echo json_encode($myecho);
	}
?>




































