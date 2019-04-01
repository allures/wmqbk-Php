function ckradd(e,f){
  if($("#"+e+"pname").val()==""){
  alert("请输入昵称后再提交");
  $("#"+e+"pname").focus();
  return false;
  }
  var val=$("#"+e+"plog").val();
  if(val.length<5 || val.length>200){
	alert("评论内容必须在5-200字之间，请修改后再提交！");
   $("#"+e+"plog").focus();
   return false;  	  
  }
  var code=$("#safecode").val();
  if (f=='1'&&code==''){	
      alert("请正确输入右侧答案！");$("#safecode").focus();return false; 
 } 
 return true
}

function ckse(){
	var val=$("#key").val();
  if(val.length<2 || val.length>10){
	alert("关键词必须在2-10字之间，请修改后再提交！");
   $("#key").focus();
   return false;  	  
  }
}
function StopButton(id,s){
	$("#"+id).attr("disabled",true);　
	$("#"+id).text("提交("+s+")");
	if(--s>0){
		 setTimeout("StopButton('"+id+"',"+s+")",1000);
	}
	if(s<=0){
		$("#"+id).text(' 提 交 ');
	    $("#"+id).removeAttr("disabled");
	} 
}
 
function savelog() {
	var tit=$("#tit").val(),
		sum = $("#sum").val(),
		log = $(".nicEdit-main:eq(0)").html(),
		pic = $("#pic").val(),
		opic = $("#opic").val(),
		id = $("#id").val(),
		c = $("#c").val(),
		pass=$("#pass").val(),
		atime = $("#atime").val();
  if(log =="" && pic =="" ){
    alert("空空如也！");
    $("#log").focus();
    return false;
  }
	$.post("./app/class/api.php?act=savelog&id=" + id, {
		tit:tit,
		sum:sum,
		logs: log,
		pic: pic,
		opic: opic,
		atime:atime,
		pass:pass,
		c: c
	}, function(data) {
		if (data.result == '200') {
			if(c=='add'){
				$("#tit").val('');
				$(".nicEdit-main").html('');
				$("#log").val('');
			    $("#pic").val('')}
		}
		alert(data.message)
	}, 'json');

}
function saveset(){
    var data = $("#formset").serialize();
    $.post("./app/class/api.php?act=saveset",data , function(data) {
		alert(data.message)
	}, 'json');

}
function savewid(id){
   var data = $("#formwid"+id).serialize();
   $.post("./app/class/api.php?act=savewid&id="+id,data , function(data) {
		alert(data.message)
	}, 'json');

}
function delwid(id){
	if(confirm('确定要删除吗?'))
	{	
		$.get("./app/class/api.php?act=delwid&id="+id,function(data){if(data.result=='200'){ window.location.reload();}else{alert(data.message);}},'json');
     }
 }

function dellog(id,v){
	if(confirm('确定要删除吗?'))
	{	
		$.get("./app/class/api.php?act=dellog&id="+id,function(data){if(data.result=='200'){ if(v=='1'){location.href="./";}else{$("#log-"+id).fadeOut();} }else{alert(data.message);}},'json');
     }
}
function delpl(id,pid){
	if(confirm('确定要删除吗?'))
	{	
		$.get("./app/class/api.php?act=delpl&id="+id+"&cid="+pid,function(data){if(data.result=='200'){$("#Com-"+id).fadeOut();}else{alert(s);}},'json');
     }
}
function shpl(id){
		$.get("./app/class/api.php?act=shpl&id="+id,function(data){if(data.result=='200'){$("#sh-"+id).fadeOut();}else{alert(data.message);}},'json');
}
function zdlog(id){
	var zdobj=$("#zd-"+id);
	var xval=0;
	if(zdobj.text()=='置顶'){xval=1};
	$.get("./app/class/api.php?act=zdlog&id="+id+"&d="+xval,function(data){if(data.result=='200'){zdobj.text(data.message);}else{alert(data.message);}},'json');
}
function addpl(id,f){	
	var ck = ckradd('',f);
	if (ck ===false)
	{
		return ck;
	}
	var npname = $("#pname").val(),nplog = $("#plog").val(),nscode=$("#safecode").val();
	 $.post("./app/class/api.php?act=addpl&id="+id, {pname:npname, plog:nplog,scode:nscode}, function(data) {	 
     if(data.result == '200')
	 {
		 $("#comment_list").append(data.message);$("#plog").val('');$("#safecode").val('');reloadcode();StopButton('add',9);
	 }else{
	     alert(data.message);$("#safecode").val('');reloadcode();$("#safecode").focus();
	 }											 
	},'json');		
}
function repl(pid,cid){
	var ore = $('#Ctext-'+pid).find('.re span').text();
	var x = 1;
	if (ore == ""){x=0;}
    var rebox = '<div class="rebox"><input placeholder="随便说点什么吧..." name="rlog" rows="3" id="rlog" class="log relog" value="'+ore+'"> <button name="re" id="re" class="btn" onclick="plsave('+cid+','+pid+','+x+')"> 回 复 </button> <button onclick="capl()" class="btn"> 取 消 </button></div>';
	$('.rebox').remove();
	$('#Ctext-'+pid).append(rebox);
}
function capl(){
	$('.rebox').remove();
}
function plsave(id,pid,x){	
	var rlog = $("#rlog").val();
	if(rlog==''){
		alert('请输入内容后再提交');
		return false;
	}
	$.post("./app/class/api.php?act=plsave&id=" + pid + "&cid=" + pid, {
		rlog: rlog
	}, function(data) {
        capl();
		if (data.result == '200') {
			if(x==1){
				$('#Ctext-'+pid).find('.re span').text(rlog);
			}else{
				$('#Ctext-'+pid).append('<p class="re">&nbsp;&nbsp;<strong style="color:#C00">回复</strong>：<span>'+rlog+'</span></p>');
			}
			 
		} else {
			alert(data.message);
		}
	}, 'json');}
function ckpass(id){	
	var ps= $("#password").val();
	if (ps!=''){
	$.post("./app/class/api.php?act=ckpass&id="+id, {ps:ps}, function(data) {if(data.result=='200'){ $("#password").parent().html(data.message)}else{alert(data.message);}},'json');}	
}
function upCache(){
   $.get("./app/class/api.php?act=upcache",function(data){alert(data.message);},'json');
}
function DotRoll(elm) {
    $("body,html").animate({ scrollTop: $("a[name='" + elm + "']").offset().top }, 500);
}
function reloadcode(){$('#codeimg').attr('src','./app/class/codes.php?n='+Math.random());}
function getFileName(o){
    var pos=o.lastIndexOf("\\");
    return o.substring(pos+1);  
}

$(document).ready(function () {
  $("#menus li a:not(:first)").each(function(){
	    var url = String(window.location)	 
        var $this = $(this);	 
        if(url.indexOf($this[0].href)>-1){
			 $("#menus li:first").removeClass('page_item');
             $this.addClass("on");
        }    
    });
})