<?php 
include_once './checkLogin.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './common/nav.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong><span id="error"></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form>
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            </div>
            <div class="form-group">
              <label for="classname">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="类名">
            </div>
            <div class="form-group">
              <input type="button" id="btn-add" value="添加" class="btn btn-primary" >
              <input type="button" style="display:none" id="btn-edit" value="完成编辑" class="btn btn-primary" >
              <input type="button" style="display:none" id="btn-cancel" value="取消编辑" class="btn btn-primary" >
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="delAll" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="200">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- 分类信息坑 -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include_once './common/aside.php' ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <script>NProgress.done()</script>

  <script type="text/template" id='cateListTpl'>
    {{each data}}
      <tr  data-categoryId="{{$value.id}}">
        <td class="text-center"><input type="checkbox"></td>
        <td>{{$value.name}}</td>
        <td>{{$value.slug}}</td>
        <td>{{$value.classname}}</td>
        <td class="text-center">
          <a href="javascript:;" data-categoryId="{{$value.id}}" class="btn btn-info btn-xs edit">编辑</a>
          <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>

  <script type="text/template" id="addCateTpl">
      <tr data-categoryId="{{id}}">
        <td class="text-center"><input type="checkbox"></td>
        <td>{{name}}</td>
        <td>{{slug}}</td>
        <td>{{classname}}</td>
        <td class="text-center">
          <a href="javascript:;" data-categoryId="{{id}}" class="btn btn-info btn-xs edit">编辑</a>
          <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
        </td>
      </tr>
  </script>

  <script>
  $(function(){
    // 请求分类列表信息数据
    $.ajax({
      type:'get',
      url:'api/getCategories.php',
      dataType:'json',
      success:function(res){
        // console.log(res);
        if(res.code==1){
          var html = template('cateListTpl',res);
          $('tbody').html(html);
        }
      }
    })

    // 分类信息添加功能
    $('#btn-add').click(function(){
       var name = $('#name').val();
       var slug = $('#slug').val();
       var classname = $('#classname').val();

       $.ajax({
         type:'post',
         url:'api/addCategory.php',
         data:{"name":name,"slug":slug,"classname":classname},
         dataType:'json',
         beforeSend:function(){
          if(name.trim()==''||slug.trim()==''||classname.trim()==''){
             $('.alert-danger').show();
             $('#error').html('请填写完整信息');
             return false;
          }
         },
         success:function(res){
            if(res.code==0){
               $('.alert-danger').show();
               $('#error').html(res.msg);
            }else{
               var html = template('addCateTpl',{"id":res.id,"name":name,"slug":slug,"classname":classname});
               $(html).appendTo('tbody');
               $('.alert-danger').hide();

               $('#name').val("");
               $('#slug').val("");
               $('#classname').val("");
            }
         }
       })
    })
    
    var that = null;
    // 为每一行的编辑按钮绑定编辑事件
    $("tbody").on('click','.edit',function(){
      
      that = this;
      // 将a标签身上的自定义属性值获取到
      var categoryId = $(this).attr("data-categoryId");
      // 把a身上的值 赋值给完成编辑按钮
      $('#btn-edit').attr('data-categoryId',categoryId);

      $('#btn-add').hide();
      $('#btn-edit').show();
      $('#btn-cancel').show();

      var name = $(this).parent().parent().children().eq(1).text();
      var slug = $(this).parent().parent().children().eq(2).text();
      var classname = $(this).parent().parent().children().eq(3).text();

      $('#name').val(name);
      $('#slug').val(slug);
      $('#classname').val(classname);
    })
    // 完成编辑按钮
    $('#btn-edit').click(function(){

       var name = $('#name').val();
       var slug = $('#slug').val();
       var classname = $('#classname').val();

       // 获取自身从编辑按钮传来的自定义属性值  
       var id = $(this).attr('data-categoryId');
       
       $.ajax({
         type:'post',
         url:"./api/updateCategory.php",
         data:{"id":id,"name":name,"slug":slug,"classname":classname},
         beforeSend:function(){
          if(name.trim()==''||slug.trim()==''||classname.trim()==''){
             $('.alert-danger').show();
             $('#error').html('请填写完整信息');
             return false;
          }
         },
         dataType:'json',
         success:function(res){
           if(res.code==1){
             $(that).parent().parent().children().eq(1).text(name)
             $(that).parent().parent().children().eq(2).text(slug)
             $(that).parent().parent().children().eq(3).text(classname)
           }
         }
       })
    })
    
    // 删除按钮事件
    $('tbody').on('click',".del",function(){

       var row = $(this).parent().parent();

       var categoryId = $(this).parent().parent().attr('data-categoryId');

       $.ajax({
        type:'post',
        url:'api/delCategory.php',
        data:{"id":categoryId},
        dataType:'json',
        success:function(res){
          if(res.code==1){
            row.remove();
          }
        }
       })
    })

    // thead中全选按钮事件
    $('thead :checkbox').on('click',function(){
      
      var status = $(this).prop("checked");

      $('tbody :checkbox').prop("checked",status);
      
      if(status){
        $('#delAll').show();
      }else{
        $('#delAll').hide();
      }
    })
    // tbody中选中铵钮事件
    $('tbody').on('click',':checkbox',function(){
       var all = $('thead :checkbox');  //获取thead中的那个复选框
       var ck = $('tbody :checkbox');   //获取tbody中的所有复选框
       
       // 如果tbody中的所有复选框被选中的个数 等于 tbody中的所有复选框的个数
       if($('tbody :checkbox:checked').length==ck.length){
         all.prop('checked',true);
       }else{
         all.prop('checked',false);
       }
       
       if($('tbody :checkbox:checked').length>=2){
         $('#delAll').show();
       }else{
         $('#delAll').hide();
       }
    })
    // 批量删除
    $('#delAll').on('click',function(){
        // 获取选中的复选框
        var cks = $('tbody :checkbox:checked');
        
        var arr = [];
        // 遍历数组获取id值
        cks.each(function(index,value){
           var id = $(value).parent().parent().attr('data-categoryId');
           arr.push(id);
        })
        
        var ids = arr.join(',');
        // console.log(arr);
        $.ajax({
          type:'post',
          url:'api/delCategories.php',
          data:{"ids":ids},
          dataType:'json',
          success:function(res){
            if(res.code==1){
              cks.parent().parent().remove();
            }
          }
        })
    })
  })
  </script>
</body>
</html>
