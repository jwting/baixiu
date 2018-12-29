<?php 

$ids = $_POST['ids'];

include_once '../../common/mysql.php';
$conn = connect();
$sql ="delete from categories where id in(1,2,3)";
$bool = mysqli_query($conn,$sql);

$res = array('code'=>0,'msg'=>'批量删除数据失败');
if($bool){
	$res['code']=1;
	$res['msg']='批量删除数据成功';
}

echo json_encode($res);

 ?>