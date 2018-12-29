<?php 
// 连接数据库查询数据
include_once '../../common/mysql.php';
$conn = connect();
$sql = "select * from categories";
$arr = query($conn,$sql);

// 返回分类信息成功或失败的json数据
$res = array('code'=>0,'msg'=>'请求分类信息列表失败');
if($arr){
	$res['code'] = 1;
	$res['msg'] = '请求分类信息列表成功';
	$res['data'] = $arr;
}

echo json_encode($res);


?>