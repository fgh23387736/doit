<?php
	header("Content-type: text/html; charset=utf-8");
	session_start();
	/**用户登录后会自动写入session
	*$_SESSION['type']='user|admin';
	*$_SESSION['id']=1;
	*/
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

	function toPut($request_data){
		$myecho=array();
		$imgs=new Imgs();
		$mypdo=new MySqlPDO();
		//print_r($request_data);
		if(!isset($request_data['Type'])||!isset($request_data['Update'])||!isset($request_data['Id'])){
			https(442);
			$myecho['Error']='请求格式错误1';
			echo json_encode($myecho);
			exit();
		}
		$sql_f="UPDATE `user` SET ";
		$sql_i="";
		$insidevalues=array();
		$wherevalues=array();
		$Ids=explode('+', $request_data['Id']);
		$sql_b="`Id` IN (";
		foreach ($Ids as $key => $value) {
			$sql_b.="?,";
			$wherevalues[]=$value;
		}
		$sql_b=substr($sql_b, 0,strlen($sql_b)-1);
		$sql_b.=")";
		switch ($request_data['Type']) {
			case '0':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误2";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				if(substr($request_data['Update']['HeadImg'],0, 4)=='data'){
					$request_data['Update']['HeadImg']=$imgs->saveBase64toImg('/yora/uploaddate/users/showphotos',$request_data['Update']['HeadImg']);
				}
				$sql="SELECT `HeadImgUrl` FROM `user` WHERE ".$sql_b;
				$mypdo->prepare($sql);
				if(!$mypdo->executeArr($wherevalues)){
					$myecho['Error']="系统错误";
					https(500);
					echo json_encode($myecho);
					exit();
				}else{
					$root=$_SERVER['DOCUMENT_ROOT'];
					while ($rs=$mypdo->fetch()) {
						if(file_exists($root.$rs['HeadImgUrl'])&&$rs['HeadImgUrl']!=$request_data['Update']['HeadImg']){
							unlink($root.$rs['HeadImgUrl']);
						}
					}
				}
				$sql_i="
					`Name`=?,
					`NickName`=?,
					`HeadImgUrl`=?,
					`Sex`=?,
					`Birthday`=?,
					`ProvinceId`=?,
					`CityId`=?,
					`SchoolId`=?,
					`StudentNumber`=?,
					`Phone`=?
				";
				$insidevalues=array(
					$request_data['Update']['Name'],
					$request_data['Update']['NickName'],
					$request_data['Update']['HeadImg'],
					$request_data['Update']['Sex'],
					$request_data['Update']['Birthday'],
					$request_data['Update']['ProvinceId'],
					$request_data['Update']['CityId'],
					$request_data['Update']['SchoolId'],
					$request_data['Update']['StudentNumber'],
					$request_data['Update']['Phone']
				);
				break;
			}	
			case '1':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误2";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="
					`ProvinceId`=?,
					`CityId`=?,
					`SchoolId`=?
				";
				$insidevalues=array(
					$request_data['Update']['ProvinceId'],
					$request_data['Update']['CityId'],
					$request_data['Update']['SchoolId']
				);
				break;
			}		
			default:
				$myecho['Error']="请求格式错误3";
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
		$sql_f="SELECT * FROM `user` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `user` WHERE ";
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
				    'Name',
				    'NickName',
				    'OpenId',
				    'HeadImgUrl',
				    'Sex',
				    'Birthday',
				    'ProvinceId',
				    'CityId',
				    'SchoolId',
				    'Province',
				    'City',
				    'School',
				    'StudentNumber',
				    'Phone'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			  //按分隔符把字符串打散为数组
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