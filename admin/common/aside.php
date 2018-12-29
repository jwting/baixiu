<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $_SESSION['userInfo'][0]['avatar'] ?>">
      <h3 class="name"><?= $_SESSION['userInfo'][0]['nickname'] ?></h3>
    </div>
    <ul class="nav">
      <li>
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
        <a href="#menu-posts" class="collapsed" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse">
          <li><a href="posts.php">所有文章</a></li>
          <li><a href="post-add.php">写文章</a></li>
          <li><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse">
          <li><a href="nav-menus.php">导航菜单</a></li>
          <li><a href="slides.php">图片轮播</a></li>
          <li><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
</div>
<script src="/static/assets/vendors/jquery/jquery.js"></script>
<script>
    // console.log(location);
    var as = $('.aside a');
    // console.log(as);
    as.each(function(index,value){
       if(value.pathname==location.pathname&&value.hash==''){
          $(value).parent().addClass('active');
          $(value).parent().parent().addClass('in');
       }else if(location.pathname=='/admin/'){
          $(as.get(0)).parent().addClass('active');
       }
    });
</script>