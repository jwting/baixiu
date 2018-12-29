<?php 
	// 接收前端的参数
	$categoryId = $_POST['categoryId'];
	$currentPage = $_POST['currentPage'];
	$pageSize = $_POST['pageSize'];
// 生成sql语句limit语法中的偏移量
	$offset = ($currentPage-1)*$pageSize;
// 连接数据库并生成结果数据
	include_once "../common/mysql.php";
	$conn = connect();
	$sql = "select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,c.name,u.nickname,
	(select count(*) from comments where post_id = p.id) as commentsCount
	from posts as p
	join categories as c on p.category_id=c.id
	join users as u on p.user_id =u.id
	where p.category_id = $categoryId
	limit $offset,$pageSize";

	$list_arr = query($conn,$sql);
		// 获取文章总数
	$count_sql = "select count(*) as count from posts where category_id =$categoryId";
	$count = query($conn,$count_sql)[0]['count'];
		// 设置成功或失败的返回数据json字符串
	$res = array('code' =>0 , 'msg' => "请求分页列表数据失败" );

	if($list_arr){
		$res['code'] = 1;
		$res['msg'] = "请求分页列表数据成功";
		$res['data'] =$list_arr;
		$res['count'] =$count;
	}

	echo json_encode($res);
 ?>