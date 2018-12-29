<?php 

$currentPage = $_POST['currentPage'];   // 1
$pageSize = $_POST['pageSize']; //20
$category =$_POST['category'];  // all  1
$status = $_POST['status'];  // all  pub

$offset = ($currentPage-1)*$pageSize;

include_once '../../common/mysql.php';

$where = " where 1=1 ";

if($category !='all'){
	 $where .= " and p.category_id ='$category'";
}
if($status !='all'){
	 $where .= " and p.status ='$status'";
}

$conn = connect();
$sql = "select p.id,p.title,p.created, u.nickname,c.name,p.status from posts as p
        left join users as u on u.id = p.user_id
        left join categories as c on c.id = p.category_id
        $where
        limit $offset,$pageSize";
$arr = query($conn,$sql);


$totalSql = "select count(*) as count from posts as p $where";
$count = query($conn,$totalSql)[0]['count'];

$res = array('code'=>0,'msg'=>'请求文章列表页失败');
if($arr){
	$res['code'] = 1;
	$res['msg'] = '请求文章列表页成功';
	$res['data'] = $arr;
	$res['count'] = $count;
}

echo json_encode($res);






 ?>