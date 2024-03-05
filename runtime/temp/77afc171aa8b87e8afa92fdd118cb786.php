<?php /*a:3:{s:51:"D:\www\zheng\application\home\view\index\lists.html";i:1709641484;s:53:"D:\www\zheng\application\home\view\public\header.html";i:1709119675;s:53:"D:\www\zheng\application\home\view\public\footer.html";i:1576652582;}*/ ?>
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
						<li <?php if($__CONTROLLER__ .'/'.$__ACTION__ == 'Index/index'): ?>class="active"<?php endif; ?>><a href="">首页 <span class="sr-only">(current)</span></a></li>
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


<style type="text/css">
	#cy {
		height: 610px;
		width: 610px;
		border: 1px solid #ccc;
		background-color: #f8f8f8;
	}

tbody tr.searchName {
	cursor: pointer;
}
tbody tr.searchName:hover {
	background-color: #eee;
}
</style>
<!-- 面包屑路径 -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
				<ol class="breadcrumb">
					<li><a href="/Index">首页</a></li>
					<li class="active">族谱列表</li>
				</ol>
		</div>
	</div>
</div>

<div class="container-fluid">
<div class="row">


	<!-- 查询表单 -->
	<div class="row">
		<div class="col-sm-12">
				<form name="form2" class="form-inline" action="" method="GET">
					<div class="form-group" style="margin:10px;">
						<input type="text" class="form-control" name="name" value="<?php if(isset($search['name'])): ?><?php echo htmlentities($search['name']); endif; ?>" placeholder="输入姓名" />
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn btn-primary" value="查询" onclick="checkForm()"/>
					</div>
				</form>
				<table class="table">
	                    <tbody>
	                        
	                    </tbody>
	                </table>
		</div>
	</div>
	<!-- 查询表单 END -->
	
	
	<div class="col-sm-12">
		<div id="cy" style="display:none;"></div>
	</div>
</div>	
</div>

<script src="/myLibrary/js/jquery.js"></script>
<script src="/myLibrary/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
</body>
</html>
<script src="https://cdn.bootcss.com/cytoscape/3.2.3/cytoscape.js"></script>
<!--<script src="/myLibrary/cytoscape.js"> //为什么就是不能用这种方式引入？ </script>-->

<script>

function checkForm(){
	var name = $("input[name='name']").val();
	
	if(name == ''){
		layer.msg('名称');
		$("input[name='name']").focus();
		return false;
	}

	$.ajax({
		url: "searchSkinship",
		type: "post",
		data: $("form").serialize(),
		dataType: "json",
		success: function(res){
			if(res.status == 200){
				
				for(i in res.data){
					$("tbody").append("<tr class='searchName'><td></td><td onclick='showRelationship(" + res.data[i]['id'] + ")'>" + res.data[i]['str'] + "</td></tr>");
				}
			}else{
				alert(res.msg);
			}
		}
	});
}

function showRelationship(id){

	var nodes = [];
	var edges = [];

	$.ajax({
		url: 'lists',
		type: 'post',
		data: { id: id},
		dataType: 'json',
		success: function(res){
			for(i in res){
				nodes.push({ data: {id: res[i]['id'], name: res[i]['generation'] + ' ' + res[i]['name'] + ' ' + res[i]['offspring']} });
				edges.push({ data: {source: res[i]['id'], target: res[i]['relationship_id'], relationship: res[i]['relationship']} });
			}
			
			$('#cy').show();
			cytoscape({
				//container: document.getElementById('cy'),
				container: $('#cy'),
				style: [
							{
								selector: 'node',
								css: {'background-color': '#6fb1fc', 'content': 'data(name)'}
							},
							{
								selector: 'edge',
								css: {'curve-style': 'bezier','target-arrow-shape': 'triangle','line-color': '#ffaaaa','target-arrow-color': '#ffaaaa','content': 'data(relationship)'}
							}
				],
				
				elements: {
					nodes: nodes,
					
					edges: edges
				},
				
				layout: {name: 'grid'}
			});
			
		}
	});
	
}
</script>
