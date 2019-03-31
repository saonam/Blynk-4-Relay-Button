<?php
@error_reporting(0);
@session_start();
@ini_set('output_buffering',0);
@ini_set('display_errors', 0);
@set_time_limit(0);
$password = "chiyeuminhem"; // mật khẩu đăng nhập web
$self = $_SERVER['PHP_SELF'];
$self1 = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
//login đăng nhập
@$pass = $_POST['pass'];
$check_pass = true;
if(isset($_POST['Marion001-Dep-Trai'])) {
session_destroy();
echo'<center><h1>&#272;&#259;ng Xu&#7845;t Th&#224;nh C&#244;ng</h1></center><meta http-equiv="refresh" content="1;URL='.$self1.'">';
exit;
}
if($pass == $password)
{
$_SESSION['checklogin1'] = "$pass";
}
if($check_pass == true)
{
if(!isset($_SESSION['checklogin1']) or $_SESSION['checklogin1'] != $password)
{
die("<center><form method=post><br>
<input type=password name=pass size=20 placeholder='Nh&#7853;p M&#7853;t Kh&#7849;u'>
<input type=submit value='&#272;&#259;ng Nh&#7853;p'></form></center>");}}
?>
<html><head><style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}
.button { background-color: #3fff00; border: none; color: #000000;
text-decoration: none; font-size: 30px; margin: 2px; cursor: pointer;}
table, th, td, hr {border: 1px solid #dc00f7;}
.button2 {background-color: #ff0000;}
@-webkit-keyframes my {0% { color: #000000; } 100% { color: #ff0000;  } 100% { color: #ff0000;  } }
@-moz-keyframes my { 0% { color: #000000;  } 100% { color: #ff0000;  }100% { color: #ff0000;  } }
@-o-keyframes my { 0% { color: #000000; } 100% { color: #ff0000; } 100% { color: #ff0000;  } }
@keyframes my { 0% { color: #000000;  } 100% { color: #ff0000;  }100% { color: #ff0000;  } } 
.chunhay {-webkit-animation: my 700ms infinite;-moz-animation: my 700ms infinite; -o-animation: my 700ms infinite; animation: my 700ms infinite;}
</style><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script></head>
<body><center><h1>Web Server App Blynk By: V&#361; Tuy&#7875;n</h1>
 <table><tbody><tr>
<th>T&#234;n Project</th>
<th>T&#234;n Module</th>
<th>Ki&#7875;u K&#7871;t N&#7889;i</th>
<th>Tr&#7841;ng Th&#225;i Module</th></tr>
<tr><td><center><p id="name"></p></center></td>
<td><center><p id="boardType"></p></center></td>
<td><center><p id="connectionType"></p></center></td>
<td><center><b><p id="ketnoimang"></p></b></center></td></tr>
</tbody></table><br/><table><tbody><tr>
<td><button onclick="reload()">HOME</button></td>
<td><input type="button" value="B&#7853;t T&#7845;t C&#7843;" onclick="batall()"></td>
<td><input type="button" value="T&#7855;t T&#7845;t C&#7843;" onclick="tatall()"></td>
<form method="POST" aciton=""><td><input type="submit" name="Marion001-Dep-Trai" value="&#272;&#259;ng Xu&#7845;t"></td></form></tr></tbody></table>
<center><p id="trangthainut"></p><p id="checktoken"></p></center><table><tbody><tr>
<th>Pin Blynk</th>
<th title='Pin Type'>Ki&#7875;u Pin</th>
<th title='Type'>D&#7841;ng Pin</th>
<th title='Tên Thiết Bị'>T&#234;n Thi&#7871;t B&#7883;</th>
<th title='Value'>Tr&#7841;ng Th&#225;i</th>
<th title='Bật, Tắt Thiết Bị'>H&#224;nh &#272;&#7897;ng</th></tr><tr>
<th><center><p id="pin"></p></center></th>
<td><center><p id="pinType"></center></td>
<td><center><p id="type"></center></td>
<td><center><p id="label"></center></td>
<td><center><p id="trangthai"><p id="demo1"></p></center></td>
<td><form method="POST" action=""><center><p id="hanhdong"></center></form></td>
</form></td> </tbody></table>
<script type="text/javascript">
var token = "49fe7704c5294f5cb46d4b604205dd3c";
$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/project',
  async: false,
  beforeSend: function (xhr) {
    if (xhr && xhr.overrideMimeType) {
      xhr.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data) {
 document.getElementById("name").innerHTML = data.name;
var devices = data.devices[0];
  document.getElementById("connectionType").innerHTML = devices.connectionType;
  document.getElementById("boardType").innerHTML = devices.boardType;
 var widget = data.widgets;
$.each(widget,function(thietbi){
var widgets  = widget[thietbi];
	var ttj = (widgets.pinType === "VIRTUAL") ? "V" : "D";
	var tt1 = (widgets.value == 1) ? "<font color=red id='tuy"+ttj+widgets.pin+"'>&#272;ang B&#7853;t</font>" : "<font color=green id='tuy"+ttj+widgets.pin+"'>&#272;ang T&#7855;t</font>";
	document.getElementById("pin").innerHTML += "<br/>"+ttj+widgets.pin+"<br/><hr/>";
	 document.getElementById("pinType").innerHTML += "<br/>"+widgets.pinType+"<br/><hr/>";
	 document.getElementById("type").innerHTML += "<br/>"+widgets.type+"<br/><hr/>";
	 document.getElementById("label").innerHTML += "<br/>"+widgets.label+"<br/><hr/>";
 document.getElementById("trangthai").innerHTML += "<br/>"+tt1+"<br/><hr/>";
	document.getElementById("hanhdong").innerHTML += "<input type='button' value='B&#7853;t' id='"+ttj+widgets.pin+"' name='"+ttj+widgets.pin+"' placeholder='"+widgets.label+"' onclick='BatThietBi(this)' style='height:40px; width:40px; color:green'> <input type='button' value='T&#7855;t' id='"+ttj+widgets.pin+"' name='"+ttj+widgets.pin+"' onclick='TatThietBi(this)' style='height:40px; width:40px; color:red'><hr/>";
	});
  },
  error: function(error){
   document.getElementById("checktoken").innerHTML = "<h1 class=chunhay>L&#7895;i Token Kh&#244;ng H&#7907;p L&#7879;,<br/>Vui L&#242;ng Ki&#7875;m Tra L&#7841;i</h1>";
  }
});
$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/isHardwareConnected',
  async: false,
  beforeSend: function (xhr1) {
    if (xhr1 && xhr1.overrideMimeType) {
      xhr1.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data1) {
  var replacemang = (data1 === true) ? "<font color=green><b>&#272;ang K&#7871;t N&#7889;i internet</b></font>" : "<p class=chunhay>M&#7845;t K&#7871;t N&#7889;i internetM</p>";
  document.getElementById("ketnoimang").innerHTML = replacemang;
  }
});
$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/isHardwareConnected',
  async: false,
  beforeSend: function (xhr1) {
    if (xhr1 && xhr1.overrideMimeType) {
      xhr1.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data1) {
  var replacemang = (data1 === true) ? "<font color=green><b>&#272;ang K&#7871;t N&#7889;i internet</b></font>" : "<p class=chunhay>M&#7845;t K&#7871;t N&#7889;i internet</p>";
  document.getElementById("ketnoimang").innerHTML = replacemang;
  }
});
//setInterval('loadmang()', 10000); // hàm này chạy auto load 10 giây
/*
function loadmang(){
	
	$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/isHardwareConnected',
  async: false,
  beforeSend: function (xhr1) {
    if (xhr1 && xhr1.overrideMimeType) {
      xhr1.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data1) {
  var replacemang = (data1 === true) ? "<b style='color:green'>&#272;ang K&#7871;t N&#7889;i internet</b>" : "<p class=chunhay>M&#7845;t K&#7871;t N&#7889;i internet</p>";
  document.getElementById("ketnoimang").innerHTML = replacemang;
  }
});	
}
*/
function BatThietBi(tuyenn) {
var bat = document.getElementById(tuyenn.id).name;
var tenthb = document.getElementById(tuyenn.id).placeholder;
$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/update/'+bat+'?value=1',
  async: false,
  beforeSend: function (xhr1) {
    if (xhr1 && xhr1.overrideMimeType) {
      xhr1.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data1) {
 document.getElementById("trangthainut").innerHTML = "&#272;&#227; B&#7853;t: <b><font color=red>"+tenthb+"</font></b>";
document.getElementById("tuy"+bat+"").innerHTML = "<font color=red>&#272;ang B&#7853;t</font>";
}
});
}
function TatThietBi(tuyen) {
var tat = document.getElementById(tuyen.id).name;
var tenthb = document.getElementById(tuyen.id).placeholder;
$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/update/'+tat+'?value=0',
  async: false,
  beforeSend: function (xhr1) {
    if (xhr1 && xhr1.overrideMimeType) {
      xhr1.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data1) {
 document.getElementById("trangthainut").innerHTML = "&#272;&#227; T&#7855;t: <b><font color=green>"+tenthb+"</font></b>";
document.getElementById("tuy"+tat+"").innerHTML = "<font color=green>&#272;ang T&#7855;t</font>";}});}
function batall(){
$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/project',
  async: false,
  beforeSend: function (xhr) {
    if (xhr && xhr.overrideMimeType) {
      xhr.overrideMimeType('application/json;charset=utf-8');
    }	
  },
  dataType: 'json',
  success: function (data) {
  var widget = data.widgets;
$.each(widget,function(batalll){
	var widgets  = widget[batalll];
	var ttj = (widgets.pinType === "VIRTUAL") ? "V" : "D";
	var thietbi = ttj+widgets.pin;
	$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/update/'+thietbi+'?value=1',
  async: false,
  beforeSend: function (xhr1) {
    if (xhr1 && xhr1.overrideMimeType) {
      xhr1.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data1) {
 document.getElementById("trangthainut").innerHTML = "&#272;&#227; B&#7853;t: <font color=red><b>T&#7845;t C&#7843; Thi&#7871;t B&#7883;<b></font>";
document.getElementById("tuy"+thietbi+"").innerHTML = "<font color=red>&#272;ang B&#7853;t</font>";}});});}});}
function tatall(){
$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/project',
  async: false,
  beforeSend: function (xhr) {
    if (xhr && xhr.overrideMimeType) {
      xhr.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data) {
  var widget = data.widgets;
$.each(widget,function(batalll){
	var widgets  = widget[batalll];
	var ttj = (widgets.pinType === "VIRTUAL") ? "V" : "D";
	var thietbi = ttj+widgets.pin;
	$.ajax({
  type: 'GET',
  url: 'http://blynk-cloud.com/'+token+'/update/'+thietbi+'?value=0',
  async: false,
  beforeSend: function (xhr1) {
    if (xhr1 && xhr1.overrideMimeType) {
      xhr1.overrideMimeType('application/json;charset=utf-8');
    }
  },
  dataType: 'json',
  success: function (data1) {
 document.getElementById("trangthainut").innerHTML = "&#272;&#227; T&#7855;t: <font color=green><b>T&#7845;t C&#7843; Thi&#7871;t B&#7883;<b></font>";
 document.getElementById("tuy"+thietbi+"").innerHTML = "<font color=green>&#272;ang T&#7855;t</font>";}});});}});}
function reload(){
location.reload();
}
</script><br/>Contac: anhtuyenvipcr5@gmail.com - <a href='https://www.facebook.com/100008756118319' target='_bank'>Facebook</a> - Code By: V&#361; Tuy&#7875;n</center>
</body>
</html>