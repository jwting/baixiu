<?php 
// 收集数据
$email = $_POST['email'];
$pwd = $_POST['pwd'];

// 连接数据库查询数据
include_once "../../common/mysql.php";
$conn = connect();
$sql  = "select * from users where email='$email' and password='$pwd' and status='activated'";
$userInfo = query($conn,$sql);

// 返回登录成功或失败的json数据
$res = array('code'=>0,'msg'=>'登录失败');
if($userInfo){
   // 登录成功 将用户信息在服务器端进行保存
   session_start();
   $_SESSION['userInfo'] = $userInfo;

   $res['code'] = 1;
   $res['msg']  = '登录成功';
}

echo json_encode($res);

?>