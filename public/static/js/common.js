//查看javascript对象的所有属性，的函数：在这里没有使用上，只是作为检测javascript对象的属性用，检测完了就不用了(此函数是网上下的)-----------
function showAttrib(e) {
 var ret = "Properties: ";
 for (var prop in e) {
     var val = e[prop];
     if (typeof (val) === "function") {
         ret += (prop + "()");
     }
     else {
         ret += prop + ": " + val;
     }
     ret += " \n";
 }
 alert(ret);

}

function attrib(e) {
 var ret = "Properties: ";
 for (var prop in e) {
     var val = e[prop];
     if (typeof (val) === "function") {
         ret += (prop + "()");
     }
     else {
         ret += prop + ": " + val;
     }
     ret += " \n";
 }
 alert(ret);

}


//查看javascript对象的所有属性，的函数：***********
function showTips(tips , height , time){ 
	//tips 信息内容
	//height 显示信息的窗口的高度
	//time=1 表示1秒钟后消失。
	
	if(height == ''){
		var height = 100;
	}
	
	if(time == ''){
		var time = 1;
	}

	var windowWidth = document.documentElement.clientWidth;
	var tipsDiv = '<div class="tipsClass">' + tips + '</div>';
	$( 'body' ).append( tipsDiv );
	$( 'div.tipsClass' ).css({
	'top' : height + 'px',
	'left' :  (windowWidth/2-25)   + 'px',
	'position' : 'absolute',
	'padding' : '10px 15px',
	'background': '#8FBC8F',
	'font-size' :  '12px',
	'margin' : '0 auto',
	'text-align': 'center',
	'width' : 'auto',
	'z-index' : '500',
	'color' : '#fff',
	'opacity' : '0.8',
	'border' : '1px',
	'border-color' : '#999',
	'border-style' : 'solid'
	}).show();
	setTimeout( function(){$( 'div.tipsClass' ).fadeOut();}, ( time * 1000 ) );
} 



function showBread(){
	document.write($.cookie("onParentMenuName") + "&nbsp;&raquo;&nbsp;" + $.cookie("onSubMenuName"));
}


//cookie 排序，使用jquery -----------
function sortby(field){ 
	var sort; 
	var last_field;
	
	sort = $.cookie('sort');  
	last_field = $.cookie("last_field");
	
	if(last_field==field){ 
		if(sort=='ASC'){
			sort = 'DESC';
		}else{
			sort = 'ASC';
		}
	}else{  
		if(sort == null){
			sort = 'ASC';
		}
	    $.cookie("last_field", field, {path:'/'});
	}
	
	$.cookie('sort', sort , {path:'/'});
	$.cookie('orderby', field , {path:'/'});
	$.cookie('flag_click', 1, {path:'/'});
	window.location.reload();
}
// cookie排序，使用jquery ***************









/***********************************************************
 * Document Type: JavaScript
 * Update: 2006/11/10
 * Author: Akon
 * Remark: JavaScript Common Libray
 ***********************************************************/

// --- Show Element
function Show(obj) {var o=$(obj);o.style.display = '';}

// --- Hidden Element
function Hidden(obj) {var o=$(obj);o.style.display = 'none';}

// --- Get URL Param
function GetUrlParam( paramName )
{
    var oRegex = new RegExp( '[\?&]' + paramName + '=([^&]+)', 'i' ) ;
    var oMatch = oRegex.exec( window.location.search ) ;
    if ( oMatch && oMatch.length > 1 )
        return oMatch[1] ;
    else
        return '' ;
}

// --- Select All Checkbox
function CheckAll(eName){       
    var checks = document.getElementsByName(eName);
    var chkAlls = document.getElementsByName("chkAll") //取第一个[0],还不可以用同名，要改为另一个，如chkAlls

    for (var i=0;i<checks.length;i++){
        checks[i].checked=chkAlls[0].checked; //取第一个[0] firefox
    }
}  
// --- Return checkbox selected values "," separation can be used in batch operation
function getOperaValue(eName) {
    var checks = document.getElementsByName(eName);
    var res = "";
    for (var i=0;i<checks.length;i++) {
        if (checks[i].checked) {
            if (!isNaN(checks[i].value)) {
                if (!res=="") res += ",";
                res += checks[i].value;
            }
        }
    }
    return res;
}

function get_select_id(id){
	return document.getElementById(id).value;
}

// --- Batch delete operation
function batchDel(url,val){
    if (val=="") {
        alert("请选择您要删除的记录!");
        return;
    }
    if (confirm('一旦删除将无法恢复，确认删除吗？')){
    	self.location.href = url + val;
    }
}

// --- Dynamic change forms ClassName
function ChangeTrClassName(ClassName,tr1,tr2) {
    if (!ClassName || !tr1 || !tr2) {return}
    var list = document.getElementsByClassName(ClassName);
    if (!list) {return}
    for (var i=0;i<list.length;i++) {
        var list_tr = list[i].getElementsByTagName("tr");
        for (var j=0;j<list_tr.length;j++){
            if (list_tr[j].className != "blank" && list_tr[j].className != "title") {
                (j%2==0)?(list_tr[j].className = tr1):(list_tr[j].className = tr2);
            }
        }
    }
}

// --- Dynamic change the background color forms
function ChangeTrColor(ClassName,tr1,tr2) {
    if (!ClassName) {return}
    var list = document.getElementsByClassName(ClassName);
    if (!list) {return}
    for (var i=0;i<list.length;i++) {
        var list_tr = list[i].getElementsByTagName("tr");
        for (var j=0;j<list_tr.length;j++){
            if (list_tr[j].className != "blank" && list_tr[j].className != "title") {
                list_tr[j].style.cursor = "default";
                list_tr[j].onmouseover = function() {this.className=tr1;};
                list_tr[j].onmouseout = function() {this.className=tr2;};
            }
        }
    }
}

// --- Automatic zooming image size by ClassName
function ReSizeImg(cName,w,h){
    var reImgs = document.getElementsByTagName("img");
    for (i=0;i<reImgs.length;i++){
        if (reImgs[i].className==cName && (reImgs[i].height>h || reImgs[i].width>w)) {
            if (reImgs[i].height==reImgs[i].width) {
                reImgs[i].height=h;reImgs[i].width=w;
            } else if (reImgs[i].height>reImgs[i].width) {
                reImgs[i].height=h;
            } else if (reImgs[i].height<reImgs[i].width){
                reImgs[i].width=w;
            }
        }
    }
}

// --- Set cookie by sName
function setCookie(sName,sValue,expireHours) {
    var cookieString = sName + "=" + escape(sValue);
    if (expireHours>0) {
         var date = new Date();
         date.setTime(date.getTime + expireHours * 3600 * 1000);
         cookieString = cookieString + "; expire=" + date.toGMTString();
    }
    document.cookie = cookieString;
}

// --- Get cookie by sName
function getCookie(sName) {
  var aCookie = document.cookie.split("; ");
  for (var i=0; i < aCookie.length; i++){
    var aCrumb = aCookie[i].split("=");
    if (escape(sName) == aCrumb[0])
      return unescape(aCrumb[1]);
  }
  return null;
}

// --- Delete cookie by sName
function delCookie(sName) {
  var date = new Date();
  document.cookie = sName + "= ; expires=" + date.toGMTString();
}

// --- Open upload file window
function OpenUpLoad(fName,cName,IsImage) {
    var url = "uploadfile.php?fName="+fName+"&cName="+cName+"&IsImage="+IsImage;
    window.open(url,'UploadFile','height=40,width=400,resizable=no,top=300,left=300');
}

function isMail(mail) {
    var patrn = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    if (!patrn.test(mail))
        return false;
    else
        return true;
}

function isBetween(value, min, max) {
    return (isNaN(value) == false  && value >= min && value <= max);
}

function isDate(value) {
    return (/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/.test(value));
}

function isEmpty(value) {
    return (/^\s*$/.test(value));
}

function isChinese(str) {
    if(escape(str).indexOf("%u")!=-1){return true;}
    return false;
}

/*
* 获取Url参数部分
* 2018-07-30
*/
function getUrlPara(){
	
	var url = document.location.toString();
	var arrUrl = url.split("?");

	var para = arrUrl[1];
	return para;
}