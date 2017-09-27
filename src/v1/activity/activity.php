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
		$request_data['Introduction']=saveContentToFile('/yora/uploaddate/activity/Introduction',$request_data['Introduction']);
		$sql='INSERT INTO `activity`
			(
				`Name`,
				`StartTime`,
				`EndTime`,
				`MinNumber`,
				`MaxNumber`,
				`Place`,
				`ProvinceId`,
				`CityId`,
				`SchoolId`,
				`Introduction`,
				`Money`,
				`UserId`,
				`Type`
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?
			)';
		$mypdo->prepare($sql);
		$myarr=array(
			$request_data['Name'],
			$request_data['StartTime'],
			$request_data['EndTime'],
			$request_data['MinNumber'],
			$request_data['MaxNumber'],
			$request_data['Place'],
			$request_data['ProvinceId'],
			$request_data['CityId'],
			$request_data['SchoolId'],
			$request_data['Introduction'],
			$request_data['Money'],
			$_SESSION['id'],
			0
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
		$sql_f="DELETE FROM `activity` WHERE ";
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
			}
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql="SELECT `ImgUrl`,`Introduction`,`QRCode`,`Process`,`Attention` FROM `activity` WHERE ".$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$root=$_SERVER['DOCUMENT_ROOT'];
			while ($rs=$mypdo->fetch()) {
				if(file_exists($root.$rs['ImgUrl'])){
					unlink($root.$rs['ImgUrl']);
				}
				if(file_exists($root.$rs['Introduction'])){
					unlink($root.$rs['Introduction']);
				}
				if(file_exists($root.$rs['QRCode'])){
					unlink($root.$rs['QRCode']);
				}
				if(file_exists($root.$rs['Process'])){
					unlink($root.$rs['Process']);
				}
				if(file_exists($root.$rs['Attention'])){
					unlink($root.$rs['Attention']);
				}
			}
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
		$sql_f="UPDATE `activity` SET ";
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
				if(substr($request_data['Update']['Img'],0,4)=='data'){
					$request_data['Update']['Img']=$imgs->saveBase64toImg('/yora/uploaddate/activity/showphotos',$request_data['Update']['Img']);
				}
				if(substr($request_data['Update']['QRCode'],0,4)=='data'){
					$request_data['Update']['QRCode']=$imgs->saveBase64toImg('/yora/uploaddate/activity/QRCode',$request_data['Update']['QRCode']);
				}
				$request_data['Update']['Introduction']=saveContentToFile('/yora/uploaddate/activity/Introduction',$request_data['Update']['Introduction']);
				$request_data['Update']['Process']=saveContentToFile('/yora/uploaddate/activity/Process',$request_data['Update']['Process']);
				$request_data['Update']['Attention']=saveContentToFile('/yora/uploaddate/activity/Attention',$request_data['Update']['Attention']);
				$sql="SELECT `Introduction`,`Process`,`Attention`,`ImgUrl` FROM `activity` WHERE ".$sql_b;
				$mypdo->prepare($sql);
				if(!$mypdo->executeArr($wherevalues)){
					$myecho['Error']="系统错误";
					https(500);
					echo json_encode($myecho);
					exit();
				}else{
					$root=$_SERVER['DOCUMENT_ROOT'];
					while ($rs=$mypdo->fetch()) {
						if(!empty($rs['ImgUrl'])&&file_exists($root.$rs['ImgUrl'])&&$rs['ImgUrl']!=$request_data['Update']['Img']){
							unlink($root.$rs['ImgUrl']);
						}
						if(!empty($rs['QRCode'])&&file_exists($root.$rs['QRCode'])&&$rs['QRCode']!=$request_data['Update']['QRCode']){
							unlink($root.$rs['QRCode']);
						}
						if(!empty($rs['Introduction'])&&file_exists($root.$rs['Introduction'])){
							unlink($root.$rs['Introduction']);
						}
						if(!empty($rs['Process'])&&file_exists($root.$rs['Process'])){
							unlink($root.$rs['Process']);
						}
						if(!empty($rs['Attention'])&&file_exists($root.$rs['Attention'])){
							unlink($root.$rs['Attention']);
						}
					}
				}
				$sql_i="
					`ImgUrl`=?,
					`QRCode`=?,
					`Name`=?,
					`StartTime`=?,
					`EndTime`=?,
					`MinNumber`=?,
					`MaxNumber`=?,
					`Place`=?,
					`ProvinceId`=?,
					`CityId`=?,
					`SchoolId`=?,
					`Introduction`=?,
					`Process`=?,
					`Attention`=?
					";
				$insidevalues=array(
					$request_data['Update']['Img'],
					$request_data['Update']['QRCode'],
					$request_data['Update']['Name'],
					$request_data['Update']['StartTime'],
					$request_data['Update']['EndTime'],
					$request_data['Update']['MinNumber'],
					$request_data['Update']['MaxNumber'],
					$request_data['Update']['Place'],
					$request_data['Update']['ProvinceId'],
					$request_data['Update']['CityId'],
					$request_data['Update']['SchoolId'],
					$request_data['Update']['Introduction'],
					$request_data['Update']['Process'],
					$request_data['Update']['Attention']
				);
				if(isset($request_data['Update']['Questions'])){
					$insert_question=array();
					$update_question=array();
					foreach ($request_data['Update']['Questions'] as $key => $value) {
						if($value['Id']==0){
							$insert_question[]=$value['Question'];
						}else{
							$update_question[$value['Id']]=$value['Question'];
						}
					}
					$sql_question="SELECT `Id` FROM `activity_question` WHERE `ActivityId`=?";
					$mypdo_temp->prepare($sql_question);
					if(!$mypdo_temp->executeArr($Ids)){
						$myecho['Error']="系统错误";
						https(500);
						echo json_encode($myecho);
						exit();
					}else{
						while ($rs_dd=$mypdo_temp->fetch()) {
							if(!isset($update_question[$rs_dd['Id']])){
								$mypdo_temp_temp->prepare('DELETE FROM `activity_question` WHERE `Id`=?');
								if(!$mypdo_temp_temp->executeArr(array($rs_dd['Id']))){
									$myecho['Error']="系统错误";
									https(500);
									echo json_encode($myecho);
									exit();
								}
							}else{
								$mypdo_temp_temp->prepare('UPDATE `activity_question` SET `Question`=?  WHERE `Id`=?');
								if(!$mypdo_temp_temp->executeArr(array($update_question[$rs_dd['Id']],$rs_dd['Id']))){
									$myecho['Error']="系统错误";
									https(500);
									echo json_encode($myecho);
									exit();
								}
							}
						}
						foreach ($insert_question as $key => $value) {
							$mypdo_temp_temp->prepare('INSERT INTO `activity_question` (`ActivityId`,`Question`) VALUES (?,?)');
								if(!$mypdo_temp_temp->executeArr(array($Ids[0],$value))){
									$myecho['Error']="系统错误";
									https(500);
									echo json_encode($myecho);
									exit();
								}
						}
					}
				}
				break;
			}
			case '1':{
				if(!isset($request_data['Update']['Type'])){
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="
					`Type`=?
					";
				$insidevalues=array(
					$request_data['Update']['Type']
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
		$sql_f="SELECT * FROM `activity` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `activity` WHERE ";
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
				if(isset($request_data['Search']['ProvinceId'])&&isset($request_data['Search']['CityId'])&&isset($request_data['Search']['SchoolId'])){
					if(empty($request_data['Search']['SchoolId'])){
						if(empty($request_data['Search']['CityId'])){
							if(empty($request_data['Search']['ProvinceId'])){
								$sql_b="1= ?";
								$wherevalues[]=1;
							}else{
								$sql_b="`ProvinceId` = ?";
								$wherevalues[]=$request_data['Search']['ProvinceId'];
							}
						}else{
							$sql_b="`CityId` = ?";
							$wherevalues[]=$request_data['Search']['CityId'];
						}
					}else{
						$sql_b="`SchoolId` = ?";
						$wherevalues[]=$request_data['Search']['SchoolId'];
					}
					
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				break;
			}
			case '2':{
				if(isset($request_data['Search']['Type'])&&!empty($request_data['Search']['Type'])){
					$sql_b="`Type` = ?";
					$wherevalues[]=$request_data['Search']['Type'];
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				break;
			}
			case '3':{
				if(!isset($_SESSION['type'])||$_SESSION['type']!='user'){
					https(401);
					echo json_encode(array('Error' => "您不具有权限操作请用普通用户账号登录"));
		    		exit();
				}
				if(isset($request_data['Search']['Type'])&&!empty($request_data['Search']['Type'])){
					$sql_b="`Type` = ?";
					$wherevalues[]=$request_data['Search']['Type'];
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_temp="SELECT `ProvinceId`,`CityId`,`SchoolId` FROM `user` Where `Id`=?";
				$mypdo_temp->prepare($sql_temp);
				$mypdo_temp->executeArr(array($_SESSION['id']));
				if($rs_dd=$mypdo_temp->fetch()){
					if(empty($rs_dd['SchoolId'])){
						if(empty($rs_dd['CityId'])){
							if(empty($rs_dd['ProvinceId'])){
							}else{
								$sql_b.=" AND `ProvinceId` = ?";
								$wherevalues[]=$rs_dd['ProvinceId'];
							}
						}else{
							$sql_b=" AND `CityId` = ?";
							$wherevalues[].=$rs_dd['CityId'];
						}
					}else{
						$sql_b.=" AND `SchoolId` = ?";
						$wherevalues[]=$rs_dd['SchoolId'];
					}

				}else{
					https(401);
					echo json_encode(array('Error' => "您不具有权限操作请用普通用户账号登录"));
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
					'ImgUrl',
					'QRCode',
					'Name',
					'StartTime',
					'EndTime',
					'MinNumber',
					'MaxNumber',
					'Place',
					'UserId',
					'ProvinceId',
					'CityId',
					'SchoolId',
					'Province',
					'City',
					'School',
					'Introduction',
					'Process',
					'Attention',
					'Type',
					'Reason',
					'AdminId',
					'Questions',
					'Apply',
					'People',
					'Money'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			while ($rs=$mypdo->fetch()) {
				$temp=array();
				$arr_Province=array();
				$arr_City=array();
				$arr_School=array();
				foreach ($attrs as $key => $value) {
					if($value=="Introduction"){
						if(file_exists($_SERVER['DOCUMENT_ROOT'].$rs['Introduction'])){
							$temp[$value]=file_get_contents($_SERVER['DOCUMENT_ROOT'].$rs['Introduction']);
						}else{
							$temp[$value]="";
						}
					}else if($value=="Process"){
						if(file_exists($_SERVER['DOCUMENT_ROOT'].$rs['Process'])){
							$temp[$value]=file_get_contents($_SERVER['DOCUMENT_ROOT'].$rs['Process']);
						}else{
							$temp[$value]="";
						}
					}else if($value=="Attention"){
						if(file_exists($_SERVER['DOCUMENT_ROOT'].$rs['Attention'])){
							$temp[$value]=file_get_contents($_SERVER['DOCUMENT_ROOT'].$rs['Attention']);
						}else{
							$temp[$value]="";
						}
					}else if($value=="Province"){
						if(isset($arr_Province[$rs['ProvinceId']])){
							$temp[$value]=$arr_Province[$rs['ProvinceId']];
						}else{
							$sql_temp="SELECT `Name` FROM `province` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['ProvinceId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_Province[$rs['ProvinceId']]=$rs_dd['Name'];
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=="City"){
						if(isset($arr_City[$rs['CityId']])){
							$temp[$value]=$arr_City[$rs['CityId']];
						}else{
							$sql_temp="SELECT `Name` FROM `city` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['CityId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_City[$rs['CityId']]=$rs_dd['Name'];
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=="School"){
						if(isset($arr_School[$rs['SchoolId']])){
							$temp[$value]=$arr_School[$rs['SchoolId']];
						}else{
							$sql_temp="SELECT `Name` FROM `school` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['SchoolId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_School[$rs['SchoolId']]=$rs_dd['Name'];
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=="Questions"){
						$sql_temp="SELECT `Id`,`Question` FROM `activity_question` Where `ActivityId`=?";
						$mypdo_temp->prepare($sql_temp);
						$temp[$value]=array();
						if($mypdo_temp->executeArr(array($rs['Id']))){
							while ( $rs_dd=$mypdo_temp->fetch()) {
								$temp_question=array();
								$temp_question['Id']=$rs_dd['Id'];
								$temp_question['Question']=$rs_dd['Question'];
								$temp[$value][]=$temp_question;
							}
						}else{
							$myecho['Error']="系统错误";
							https(500);
							echo json_encode($myecho);
							exit();
						}
					}else if($value=="Apply"){
						$sql_temp="SELECT `Id` FROM `activity_apply` Where `ActivityId`=?";
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
					}else if($value=="People"){
						$sql_temp="SELECT `Id` FROM `activity_user` Where `ActivityId`=?";
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

