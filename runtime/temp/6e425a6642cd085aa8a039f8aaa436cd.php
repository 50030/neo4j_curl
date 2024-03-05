<?php /*a:3:{s:57:"D:\www\zheng\application\home\view\index\edit_person.html";i:1709474205;s:59:"D:\www\zheng\application\home\view\public\header_popup.html";i:1709119610;s:53:"D:\www\zheng\application\home\view\public\footer.html";i:1576652582;}*/ ?>
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



<link rel="stylesheet" type="text/css" href="/myLibrary/dtree/dtree.css" />
<script type="text/javascript" src="/myLibrary/dtree/dtree.js"></script>

<div class="container-fluid">

<div class="row">
	<div class="col-sm-12">
			<form name="form2" action="" method="post">
	    			<table class="table">
	                    <tbody>
	                        <tr>
	                            <td class="span2">id：</td>
	                            <td>
	                               <?php echo htmlentities($edit['id']); ?>
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="span2">世代：</td>
	                            <td>
	                               <input type="text" name="generation" class="essentialtexr" value="<?php echo htmlentities($edit['generation']); ?>" />
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="span2">姓名：</td>
	                            <td>
	                               <input type="text" name="name" class="essentialtexr" value="<?php echo htmlentities($edit['name']); ?>" />
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="span2">亲属：</td>
	                            <td>
	                               <input type="text" name="offspring" class="essentialtexr" value="<?php echo htmlentities($edit['offspring']); ?>" placeholder="长子、次子、三子，长女、次女、三女" />
	                            </td>
	                        </tr>
	                        
	                        <tr>
	                            <td class="span2">排行：</td>
	                            <td>
	                               <input type="text" name="ranking" class="essentialtexr" value="<?php echo htmlentities($edit['ranking']); ?>" placeholder="使用数字" />
	                            </td>
	                        </tr>
	                        
	                        <tr>
	                            <td class="span2">有亲属关系：</td>
	                            <td>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="HAS_FATHER" /> 有父亲 &nbsp;&nbsp;
	                                </label>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="HAS_MOTHER" /> 有母亲 &nbsp;&nbsp;
	                                </label>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="HAS_SON" /> 有儿子 &nbsp;&nbsp;
	                                </label>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="HAS_DAUGHTER" /> 有女儿 &nbsp;&nbsp;
	                                </label>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="HAS_HUSBAND" /> 有丈夫 &nbsp;&nbsp;
	                                </label>
	                            	<label>
	                                	<input type="radio" name="skinship" class="essentialtexr" value="HAS_WIFE" /> 有妻子 &nbsp;&nbsp;
	                                </label>
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="span2">有关系人：</td>
	                            <td>
	    							<input type="text" id="skinship" name="skinship" value="" disabled readonly />
	    							<input type="button" class="btn btn-primary" value="查找关系人" onclick="searchSkinship();" />
	    							<input type="hidden" id="skinship_id" name="skinship_id" value="" />
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
					<input type="hidden" name="id" value="<?php echo htmlentities($edit['id']); ?>" />
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