<?php  
// 收集数据
$name = $_POST['name'];
$slug = $_POST['slug'];
$classname = $_POST['classname'];

// 连接数据库
include_once '../../common/mysql.php';
$conn = connect();
// 查看是否有重名的情况
$sql = "select count(*) as count from categories where name='$name'";
$arr = query($conn,$sql);
$count = $arr[0]['count'];


$res = array('code'=>0,'msg'=>'请求分类信息失败');
if($count >=1){
	$res['msg']="分类信息有重名！！";
}else{
	$add_sql = "insert into categories values(null,'$slug','$name','$classname')";
	$bool = mysqli_query($conn,$add_sql);
	$id = mysqli_insert_id($conn);

	if($bool){
	$res['code']=1;
	$res['msg']="添加分类信成功";
	$res['id'] = $id;
	}
}

echo json_encode($res);

?>