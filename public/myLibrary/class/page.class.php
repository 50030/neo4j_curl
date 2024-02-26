<?php

/**
 * 分页函数
 * dafei.net@gmail.com
 * www.dafei.net
 */

/*
//附css代码
<style type="text/css">
.page{color:#333;padding:2px;font-size:12px; line-height:24px;} 
.page a { border:1px solid #ccc;padding:2px 5px 2px 5px;margin:2px;text-decoration:none;color:#333; height:24px; line-height:24px; } 
.page a:hover { background:#fff; color:#ff0000; text-decoration:none; }
.page a.actived_page { background:#fff; color:#ff0000; }
.page span{padding:0 5px 0 5px;margin:2px;background:#09f;color:#fff;border:1px solid #09c;} 
</style> 
*/

//function web_page($page,$num,$pagenum, $pageselect = true){//当前页数 总页数 可分页数,下拉列表
function page2($sql,$page_size=10,$num=0,$pageselect = true){//原sql,每页条数,下拉列表，返回的是数组:新sql，分页，总页数
	
    //获取链接的其他参数
	$pageurl = '';
	
	foreach ($_GET as $k=>$v){
		if($k!='_URL_'){
			if($k != 'page'){
				if($k != 'count'){
		  			$pageurl .= "&".$k."=".str_replace('&&','%26%26',$v); 
				}
			}
		}
	}
    $pageurl .= "&count={$num}";
    $pagenum = ceil($num/$page_size);          //总页数
	if(!isset($_GET['page']) or !intval($_GET['page']) or !is_numeric($_GET['page']) or $_GET['page'] > $pagenum){
		$page = 1; //当页数不存在 不为十进制数 不是数字 大于可分页数 为1
	}else{
		$page = $_GET['page'];  //当前页数
	}
	
    //zaj--------------
	
	if($pagenum>5){
		$str_page = "共".$num."条记录 <font color=\"red\">$page</font>/$pagenum 页，每页{$page_size}条 <br />"; 
	}else{
		$str_page = "共".$num."条记录，每页{$page_size}条 "; 
	}
	$uppage = $page - 1;           //上一页
	$downpage = $page + 1;         //下一页
	$lr = 10;                      //显示多少个页数连接
	$left = floor(($lr-1)/2);      //左显示多少个页数连接
	$right = floor($lr/2);         //右显示多少个页数连接

	//下面求开始页和结束页
	if($page <= $left){            //如果当前页左不足以显示页数
		$leftpage = 1;
		$rightpage = (($lr<$pagenum)?$lr:$pagenum);
	}elseif(($pagenum-$page) < $right){  //如果当前页右不足以显示页数
		$leftpage = (($pagenum<$lr)?1:($pagenum-$lr+1));
		$rightpage = $pagenum;
	}else{                               //左右可以显示页数
		$leftpage = $page - $left;
		$rightpage = $page + $right;
	}

	//前$lr页和后$lr页
	$qianpage = (($page-$lr) < 1?1:($page-$lr));
	$houpage = (($page+$lr) > $pagenum?$pagenum:($page+$lr));

	//输出分页
	if($page != 1){
		if($pagenum>5){             //如果页数小于于5页就简化
			$str_page .= "<a href=\"".$_SERVER['REDIRECT_URL']."?page=$qianpage$pageurl\">前".$lr."页</a> <a title=\"首页\" href=\"".$_SERVER['REDIRECT_URL']."?$pageurl\">首页</a> <a title=\"上一页\" href=\"".$_SERVER['REDIRECT_URL']."?page=$uppage$pageurl\">&nbsp;&laquo;&nbsp;</a> ";
		}else{
			$str_page .= "<a title=\"上一页\" href=\"".$_SERVER['REDIRECT_URL']."?page=$uppage$pageurl\">&nbsp;&laquo;&nbsp;</a> ";
		}
	}else{
		$str_page .= " ";
	}

	for($pages = $leftpage; $pages <= $rightpage; $pages++){
		if($pages == $page){
			$str_page .=  "<a href=\"".$_SERVER['REDIRECT_URL']."?page=$pages$pageurl\" class=\"actived_page\">$pages</a> ";
		}else{
			$str_page .=  "<a href=\"".$_SERVER['REDIRECT_URL']."?page=$pages$pageurl\">$pages</a> ";
		}
	}

	if($page != $pagenum){
		if($pagenum>5){              //如果页数小于于5页就简化
			$str_page .=  "<a title=\"下一页\" href=\"".$_SERVER['REDIRECT_URL']."?page=$downpage$pageurl\">&nbsp;&raquo;&nbsp;</a> <a title=\"末页\" href=\"".$_SERVER['REDIRECT_URL']."?page=$pagenum$pageurl\">尾页</a> <a href=\"".$_SERVER['REDIRECT_URL']."?page=$houpage$pageurl\">后".$lr."页</a> ";
		}else{
			$str_page .=  "<a title=\"下一页\" href=\"".$_SERVER['REDIRECT_URL']."?page=$downpage$pageurl\">&nbsp;&raquo;&nbsp;</a> ";
		}
	}else{
		$str_page .=  " ";
	}

	//跳转
	
	$javapage = <<<EOM
<style type="text/css">

.page_only_use_here{clear:both; color:#333;padding:2px;font-size:12px; line-height:24px;} 
.page_only_use_here a { border:1px solid #ccc;padding:2px 5px 2px 5px;margin:2px;text-decoration:none;color:#333; height:24px; line-height:24px; } 
.page_only_use_here a:hover { background:#fff; color:#ff0000; text-decoration:none; }
.page_only_use_here a.actived_page { background:#fff; color:#ff0000; }

</style> 
<script language="javascript">
function pageGoToUrl(targ,selObj,restore) {
	eval("self"+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
}
</script>
EOM;

	$str_page .= $javapage;
	
	$url = $pageurl;          //链接
	$rows = $num;             //总记录数
	$pageNow = $page;         //当前页数
	$nbTotalPage = $pagenum;  //总页数
	$showAll = 200;
	$sliceStart = 5;
	$sliceEnd = 5;
	$percent = 20;
	$range = 10;
	$prompt = '';
	
    $gotopage = $prompt . "<select class=\"chzn-select\" style=\"width:100px;\" onchange=\"pageGoToUrl('parent',this,0)\" name=\"menu1\">";
              
    if ($nbTotalPage < $showAll) {
        $pages = range(1, $nbTotalPage);
    } else {
        $pages = array();

        // Always show first X pages
        for ($i = 1; $i <= $sliceStart; $i++) {
            $pages[] = $i;
        }

        // Always show last X pages
        for ($i = $nbTotalPage - $sliceEnd; $i <= $nbTotalPage; $i++) {
            $pages[] = $i;
        }

        // garvin: Based on the number of results we add the specified
        // $percent percentate to each page number,
        // so that we have a representing page number every now and then to
        // immideately jump to specific pages.
        // As soon as we get near our currently chosen page ($pageNow -
        // $range), every page number will be
        // shown.
        $i = $sliceStart;
        $x = $nbTotalPage - $sliceEnd;
        $met_boundary = false;
        while ($i <= $x) {
            if ($i >= ($pageNow - $range) && $i <= ($pageNow + $range)) {
                // If our pageselector comes near the current page, we use 1
                // counter increments
                $i++;
                $met_boundary = true;
            } else {
                // We add the percentate increment to our current page to
                // hop to the next one in range
                $i = $i + floor($nbTotalPage / $percent);

                // Make sure that we do not cross our boundaries.
                if ($i > ($pageNow - $range) && !$met_boundary) {
                    $i = $pageNow - $range;
                }
            }

            if ($i > 0 && $i <= $x) {
                $pages[] = $i;
            }
        }

        // Since because of ellipsing of the current page some numbers may be double,
        // we unify our array:
        sort($pages);
        $pages = array_unique($pages);
    }

    foreach ($pages as $i) {
        if ($i == $pageNow) {
            $selected = 'selected="selected" style="font-weight: bold"';
        } else {
            $selected = '';
        }
        
        $gotopage .= "<option value=\"".$_SERVER['REDIRECT_URL']."?page=$i$pageurl\"{$selected}>{$i}</option>";
    }

    
    $str_page .= $gotopage.' </select>';
    

	
	$str_page = "<div class=\"page_only_use_here\">" . $str_page . "</div>";
    $sql = $sql . ' limit '. ($page-1)*$page_size. ',' .$page_size; //返回新的分页后的sql语句
	return array('sql'=>$sql,'page'=>$str_page,'recode_count'=>$num,'page_count'=>$pagenum,'curr_page'=>$page);
}

?>