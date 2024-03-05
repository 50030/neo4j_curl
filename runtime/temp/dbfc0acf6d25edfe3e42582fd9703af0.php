<?php /*a:3:{s:61:"D:\www\zheng\application\home\view\index\search_skinship.html";i:1709474028;s:59:"D:\www\zheng\application\home\view\public\header_popup.html";i:1709119610;s:53:"D:\www\zheng\application\home\view\public\footer.html";i:1576652582;}*/ ?>
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



<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
				<form name="form2" action="" method="post">
				<table class="table">
	                    <tbody>
	                        <tr>
	                            <td class="span2">有关系人：</td>
	                            <td>
	                               <input type="text" name="name" class="essentialtexr" value="" />
	                               <input type="button" class="btn btn-primary" value="查询" onclick="checkForm();" />
	                            </td>
	                        </tr>
	                    </tbody>
	                </table>
				</form>
		</div>		
	</div>			
</div>


<script src="/myLibrary/js/jquery.js"></script>
<script src="/myLibrary/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
</body>
</html>
<style>
tbody tr.searchCategory {
	cursor: pointer;
}
tbody tr.searchCategory:hover {
	background-color: #eee;
}
</style>

<script src="/myLibrary/js/jquery.form.min.js"></script>
<script src="/myLibrary/layer/layer.js"></script>
<script src="/myLibrary/jscolor/jscolor.min.js"></script>
<script>
function checkForm(){
	var name = $("input[name='name']").val();
	
	if(name == ''){
		layer.msg('请输入关系人名称');
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
					$("tbody").append("<tr class='searchCategory'><td></td><td onclick='selectItem(" + res.data[i]['id'] + ", \"" + res.data[i]['str'] + "\""  + ")'>" + res.data[i]['str'] + "</td></tr>");
				}
			}else{
				alert(res.msg);
			}
		}
	});
}


function selectItem(id, str){
	parent.$("#skinship_id").val(id);
	parent.$("#skinship").val(str);
	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	parent.layer.close(index);  // 关闭layer
}
</script>