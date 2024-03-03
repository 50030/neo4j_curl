<?php /*a:1:{s:57:"D:\www\zheng\application\home\view\category\jit_tree.html";i:1686385522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<!--<link rel="stylesheet" href="/myLibrary/bootstrap-3.3.7-dist/css/bootstrap.css" />
	<link rel="stylesheet" href="/static/mmm/css/admin.css" />-->
	
	<link type="text/css" href="/myLibrary/jittree/css/base.css" rel="stylesheet" />
	<link type="text/css" href="/myLibrary/jittree/css/spacetree.css" rel="stylesheet" />
	<title><?php if(isset($title)): ?><?php echo htmlentities($title); endif; ?></title>
</head>
<body>
<div id="container">

 

<div id="center-container">
    <div id="infovis"></div>    
</div>

<div id="right-container">

<h4>更改方向</h4>
<table>
    <tr>
        <td>
          <span> 横向</span>
            <label style="display:none" for="r-left">left </label>
        </td>
        <td>
            <input type="radio" id="r-left" name="orientation" checked="checked" value="left" />
        </td>
    </tr>
    <tr>
         <td>
           <span>纵向</span>
            <label style="display:none"  for="r-top">top </label>
         </td>
         <td>
            <input type="radio" id="r-top" name="orientation" value="top" />
         </td>
    <tr  style="display:none" >
         <td>
            <label for="r-bottom">bottom </label>
          </td>
          <td>
            <input type="radio" id="r-bottom" name="orientation" value="bottom" />
          </td>
    </tr>
    <tr  style="display:none" >
          <td>
            <label for="r-right">right </label>
          </td> 
          <td> 
           <input type="radio" id="r-right" name="orientation" value="right" />
          </td>
    </tr>
</table>

</div>

<div id="log"></div>
</div>
<input type="hidden" name="cat_id" value="<?php echo htmlentities($cat_id); ?>" />

<script src="/myLibrary/js/jquery.js"></script>
<!--<script src="/myLibrary/bootstrap-3.3.7-dist/js/bootstrap.js"></script>-->
<script src="/myLibrary/jittree/js/jit.js"></script>
<script src="/myLibrary/jittree/js/spacetree.js"></script>
</body>
</html>

<script>
var cat_id = $("input[name='cat_id']").val();
$(document).ready(function(){
	$.ajax({
		url: "jitTreeGetJson",
		type: "get",
		data: {"cat_id": cat_id},
		dataType: "json",
		success: function(res){
			init(res);      //example_ok.js
		}
	});
});

</script>
