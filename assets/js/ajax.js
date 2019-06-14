function ckradd(e,f){
  if($("#"+e+"pname").val()==""){
  errmsg("请输入昵称后再提交");
  $("#"+e+"pname").focus();
  return false;
  }
  var val=$("#"+e+"plog").val();
  if(val.length<5 || val.length>200){
	errmsg("评论内容必须在5-200字之间，请修改后再提交！");
   $("#"+e+"plog").focus();
   return false;  	  
  }
  var code=$("#safecode").val();
  if (f=='1'&&code==''){	
      errmsg("请正确输入右侧答案！");$("#safecode").focus();return false; 
 } 
 return true
}
function errmsg(s,el=''){ 
   $(el+'#errmsg').show().text(s).fadeOut(2000);
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
		log = editor.$txt.html(),
		pic = upic,
		pics = pic_arr.join(','),
		id = $("#id").val(),
		c = $("#c").val(),
		pass=$("#pass").val(),
		atime = $("#atime").val();
	    hide = $('#hide').prop("checked")?1:0;
		lock = $('#lock').prop("checked")?1:0;
		log = log.replace(/<p>[<br>]*<\/p>/g,'')
  if(log =="" && pic =="" ){
    errmsg("写点什么吧！");   
    $("#log").focus();
    return false;
  }
	$.post("./app/class/api.php?act=savelog&id=" + id, {
		tit:tit,
		sum:sum,
		logs: log,
		pic: pic,
		pics: pics,
		atime:atime,
		pass:pass,
	    hide:hide,
		lock:lock,
		c: c
	}, function(data) {
		if (data.result == '200') {
			if(c=='add'){
				$("#tit").val('');
				$(".nicEdit-main").html('');
				$("#log").val('');
			    $("#pic").val('');
				pic_arr = [];
                $(".picls").remove();
			}
		}
		errmsg(data.message);
		window.location.href = 'index.php?act=pl&id='+data.id;
	}, 'json');

}
function saveset(){
    var data = $("#formset").serialize();
    $.post("./app/class/api.php?act=saveset",data , function(data) {
		errmsg(data.message)
	}, 'json');

}
function savewid(id){
   var el = $("#formwid"+id+" input[name='title']")
   var data = $("#formwid"+id).serialize();
   if(el.val()=='') { 
	   el.focus();
	   errmsg("标题不能为空！","#formwid"+id+" ");
	   return false
   }; 
   $.post("./app/class/api.php?act=savewid&id="+id,data , function(data) {
		errmsg(data.message,"#formwid"+id+" ")
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
		$.get("./app/class/api.php?act=delpl&id="+id+"&cid="+pid,function(data){if(data.result=='200'){$("#Com-"+id).fadeOut();}else{alert(data.message);}},'json');
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
		 $(".comment_list").append(data.message);$("#plog").val('');$("#safecode").val('');reloadcode();StopButton('add',9);
		 errmsg('')
	 }else{
	     errmsg(data.message);$("#safecode").val('');reloadcode();$("#safecode").focus();
	 }											 
	},'json');		
}
function repl(pid,cid){
	var ore = $('#Ctext-'+pid).find('.re span').text();
	var x = 1;
	if (ore == ""){x=0;}
    var rebox = '<div class="rebox"><textarea required="required" placeholder="请输入回复内容..." name="rlog" rows="3" id="rlog" class="input_narrow relog">'+ore+'</textarea> <button name="re" id="re" class="btn" onclick="plsave('+cid+','+pid+','+x+')"> 回 复 </button> <button onclick="capl()" class="btn"> 取 消 </button></div>';
	$('.rebox').remove();
	$('#Ctext-'+pid).append(rebox);
}
function capl(){
	$('.rebox').remove();
}
function plsave(id,pid,x){	
	var rlog = $("#rlog").val();
	if(rlog==''){
		$("#rlog").focus();
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
	$.post("./app/class/api.php?act=ckpass&id="+id, {ps:ps}, function(data) {if(data.result=='200'){ $("#article .text").html(data.message)}else{alert(data.message);}},'json');}else{
	$("#password").focus();
	}	
}

function DotRoll(elm) {
    $("body,html").animate({ scrollTop: $("a[name='" + elm + "']").offset().top }, 500);
}

function reloadcode(){$('#codeimg').attr('src','./app/class/codes.php?t='+Math.random());}

function getFileName(o){
    var pos=o.lastIndexOf("\\");
    return o.substring(pos+1);  
}

$(document).ready(function () {
$('#menu_toggle').on("click","i",function(e){
   e.preventDefault();
   $(this).toggleClass('close');
   $('#nav').slideToggle();
})
 
$(window).resize(function(){
	 var w = $(window).width();
	 if(w>650) {$('#nav').show();}else{
       $('#menu').removeClass('close');
	   $('#nav').hide();
	 } 
});				

var url = String(window.location);
var last = url.charAt(url.length - 1);
$("#nav li a").each(function(e){         
        if(last=='/'){
		   $(this).addClass("on");
		   return false;
		}
		else if(url==$(this)[0].href){
		   $(this).addClass("on");
		   return false;
		}
          
});
})