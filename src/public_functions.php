<?php 
/*
*将文本保存到制定目录并返回Url
*$path:路径起始为根目录eg：/yora/uploaddata/house
*路径中没有的文件夹会自动创建
 */
	function saveContentToFile($path,$content){
    if (is_dir($_SERVER['DOCUMENT_ROOT'].$path)){  
    }else{
       $res=@mkdir($_SERVER['DOCUMENT_ROOT'].$path,0777,true); 
       if ($res){
           //echo "目录 $path 创建成功";
       }else{
           return "";
       }
    }
    //修改照片
    date_default_timezone_set('PRC');//设置时区
    $t=date('Y-m-d', time());
    $str="qwertyuiopasdghjklzxcvbnm1234567890";
    $file=$t.substr(str_shuffle($str),0,6);
    $new_file = "$path/$file.txt";
    if (file_put_contents($_SERVER['DOCUMENT_ROOT'].$new_file,$content)){
      return $new_file;
    }
    return "";
  }
/*
*返回用户Ip
 */
  function getIP(){
      static $realip;
      if (isset($_SERVER)){
          if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
              $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
          } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
              $realip = $_SERVER["HTTP_CLIENT_IP"];
          } else {
              $realip = $_SERVER["REMOTE_ADDR"];
          }
      } else {
          if (getenv("HTTP_X_FORWARDED_FOR")){
              $realip = getenv("HTTP_X_FORWARDED_FOR");
          } else if (getenv("HTTP_CLIENT_IP")) {
              $realip = getenv("HTTP_CLIENT_IP");
          } else {
              $realip = getenv("REMOTE_ADDR");
          }
      }
      return $realip;
  }
?>