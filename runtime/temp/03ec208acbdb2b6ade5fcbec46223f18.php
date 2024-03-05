<?php /*a:3:{s:51:"D:\www\zheng\application\home\view\index\index.html";i:1708069804;s:53:"D:\www\zheng\application\home\view\public\header.html";i:1709642789;s:53:"D:\www\zheng\application\home\view\public\footer.html";i:1576652582;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<link rel="stylesheet" href="/myLibrary/bootstrap-3.3.7-dist/css/bootstrap.css" />
	<link rel="stylesheet" href="/static/home/css/home.css" />
	<title><?php if(isset($title)): ?><?php echo htmlentities($title); endif; ?></title>
</head>
<body>

<div class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">郑氏族谱</a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
						<li <?php if($__CONTROLLER__ .'/'.$__ACTION__ == 'Index/index'): ?>class="active"<?php endif; ?>><a href="/">首页 <span class="sr-only">(current)</span></a></li>
						<li <?php if($__CONTROLLER__ .'/'.$__ACTION__ == 'Category/listcategory'): ?>class="active"<?php endif; ?>><a href="/Index/relationship">关系</a></li>
						<li <?php if($__CONTROLLER__ .'/'.$__ACTION__ == 'Category/listcategory'): ?>class="active"<?php endif; ?>><a href="/Category/listCategory">族谱</a></li>
						
				</ul>
				
			</div>
	</div>
</div>

<!-- 弹窗：退出登录 -->
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title" id="myModalLabel">退出登录</h4>
				</div>
				<div class="modal-body">
					按确定键退出管理
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						关闭
					</button>
					<button type="button" class="btn btn-primary" onclick="logout();">
						确定
					</button>
				</div>
		</div>
	</div>
</div>
<script>
function logout(){
	window.location.href = "/admin.php/Sign/logout";
}
</script>

<!-- 把内容往下挤，避免被主导航遮盖 -->
<div style="height:60px;"></div>
	
<!-- 面包屑路径 -->
<div class="container">
	<div class="row">
		<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="active">首页</li>
				</ol>
		</div>
	</div>
</div>

<div class="container">
<div class="row">
	<div class="col-sm-10">
		<p>日期：<?php echo htmlentities($date); ?></p>
	</div>
</div>	
</div>

<script src="/myLibrary/js/jquery.js"></script>
<script src="/myLibrary/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
</body>
</html>