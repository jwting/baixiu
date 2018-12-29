<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
     
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong><span id="error">用户名或密码错误！</span> 
      </div>

      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="text" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <!-- <a class="btn btn-primary btn-block" href="index.php">登 录</a> -->
      <input type="submit" class="btn btn-primary btn-block" value="登 录">
      <!-- <input type="button" class="btn btn-primary btn-block" value="登 录"> -->
    </form>
  </div>
</body>
<script src="../static/assets/vendors/jquery/jquery.js"></script>d
<script>
   $(function(){

    $('.login-wrap').submit(function(){
      // 第二步：收集数据
      var email = $('#email').val();
      var pwd = $('#password').val();
      // 第三步：验证数据合法性并通过ajax提交数据
      $.ajax({
        type:'post',
        url:"./api/userLogin.php",
        data:{"email":email,"pwd":pwd},
        beforeSend:function(){
          var reg = /^\w+[@]\w+[.]\w+$/;
          if(!reg.test(email)){
            $('#error').html("您输入的邮箱不合法！！！");
            $('.alert-danger').show();
            return false;
          }
          if(pwd.trim()==""){
            $('#error').html("密码不能为空");
            $('.alert-danger').show();
            return false;
          }
        },
        dataType:'json',
        success:function(res){
          if(res.code==0){
            $('#error').html("邮箱或密码错误！！");
            $('.alert-danger').show();
          }else{
            location.href="index.php";
          }
        }
      })
      // 第一步：阻止事件的默认行为
      event.preventDefault();
      // return false;
    })

   })




</script>
</html>
