<?php 
// 收集数据
$id = $_POST['id'];
$name = $_POST['name'];
$slug = $_POST['slug'];
$classname = $_POST['classname'];

// 连接数据库
include_once '../../common/mysql.php';
$conn = connect();

$sql = "update categories set name='$name',slug='$slug',classname='$classname' where id=$id ";

$bool = mysqli_query($conn,$sql);

$res = array('code'=>0,'msg'=>"更新分类信息失败");

if($bool){
	$res['code'] = 1;
	$res['msg'] = "更新分类信息成功";
}

echo json_encode($res);









 ?>