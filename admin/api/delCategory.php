<?php 
// 收集数据
$id = $_POST['id'];

// 连接数据库删除数据
include_once '../../common/mysql.php';
$conn = connect();
$sql = "delete from categories where id = $id";
$bool = mysqli_query($conn,$sql);
// 返回成功或失败的json数据
$res = array('code'=>0,'msg'=>'删除数据失败');
if($bool){
	$res['code']=1;
	$res['msg']='删除数据成功';
}

echo json_encode($res);

 ?>