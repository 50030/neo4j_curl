<?php /*a:3:{s:56:"D:\www\zheng\application\home\view\index\add_person.html";i:1708988943;s:59:"D:\www\zheng\application\home\view\public\header_popup.html";i:1576653776;s:53:"D:\www\zheng\application\home\view\public\footer.html";i:1576652582;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<link rel="stylesheet" href="/myLibrary/bootstrap-3.3.7-dist/css/bootstrap.css" />
	<link rel="stylesheet" href="/static/mmm/css/admin.css" />
	<title><?php if(isset($title)): ?><?php echo htmlentities($title); endif; ?></title>
</head>
<body>



<link rel="stylesheet" type="text/css" href="/myLibrary/dtree/dtree.css" />
<script type="text/javascript" src="/myLibrary/dtree/dtree.js"></script>

<div class="container-fluid">

<div class="row">
	<div class="col-sm-12">
			<form name="form2" action="" method="post">
	    			<table class="table">
	                    <tbody>
	                        <tr>
	                            <td class="span2">姓名：</td>
	                            <td>
	                               <input type="text" name="name" class="essentialtexr" value="" />
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="span2">性别：</td>
	                            <td>
	                            	<label>
	                                	<input type="radio" name="gender" class="essentialtexr" value="1" />男
	                                </label>
	                            	<label>
	                                	<input type="radio" name="gender" class="essentialtexr" value="2" />女
	                                </label>
	                            </td>
	                        </tr>
	                        
	                        <tr>
	                            <td class="span2">排行：</td>
	                            <td>
	                               <input type="text" name="ranking" class="essentialtexr" value="" />
	                            </td>
	                        </tr>
	                        
	                        <tr>
	                            <td class="span2">备注：</td>
	                            <td>
	                               <input type="text" name="remark" class="jscolor" value="" />
	                            </td>
	                        </tr>
	                        
	                        <tr>
	                            <td class="span2">排序：</td>
	                            <td>
	                               <input type="text" name="orderno" class="essentialtexr" value="" />
	                            </td>
	                        </tr>
	                        
	                        <tr>
	                            <td class="span2">有亲属关系：</td>
	                            <td>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="has_husband" />有丈夫
	                                </label>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="has_wife" />有妻子
	                                </label>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="has_father" />有父亲
	                                </label>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="has_mather" />有母亲
	                                </label>
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="span2">有关系人：</td>
	                            <td>
	    							<input type="text" id="skinship" name="skinship" class="jscolor" value="" readonly />
	    							<input type="button" class="btn btn-primary" value="查找关系人" onclick="searchSkinship();" />
	    							<input type="hidden" id="shinship_id" name="skinship_id" value="" />
	                            </td>
	                        </tr>
	                        
	                        
	                        <tr>
	                        	<td></td>
	                            <td>
	                				<input type="button" class="btn btn-primary" value="确定" onclick="checkForm();" />
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

<script src="/myLibrary/js/jquery.form.min.js"></script>
<script src="/myLibrary/layer/layer.js"></script>
<script src="/myLibrary/jscolor/jscolor.min.js"></script>
<script>	
function checkForm(){
	document.forms['form2'].submit();
}

function searchSkinship(){
	layer.open({
		type: 2,
		title: '查找关系人',
		shadeClose: true,
		shade: 0.2,
		area: ['95%', '95%'],
		content: 'searchSkinship',
		end: function(){
			//location.reload();
		}
	});
}

</script>