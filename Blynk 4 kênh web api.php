<?php
@error_reporting(0);
@session_start();
@ini_set('output_buffering',0);
@ini_set('display_errors', 0);
@set_time_limit(0);
//config
$token = "49fe7704c5294f5cb46d4b604205dd3c"; //Mã token của app Blynk 
$password = "chiyeuminhem"; // mật khẩu đăng nhập web
//end config
echo '<!DOCTYPE html><html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"><title>Web Server App Blynk By: Vũ Tuyển</title>
<link rel="icon" href="data:,">
<style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}
.button { background-color: #3fff00; border: none; color: #000000;
text-decoration: none; font-size: 30px; margin: 2px; cursor: pointer;}
table, th, td {border: 1px solid #dc00f7;}
.button2 {background-color: #ff0000;}

@-webkit-keyframes my {0% { color: #000000; } 100% { color: #ff0000;  } 100% { color: #ff0000;  } }
@-moz-keyframes my { 0% { color: #000000;  } 100% { color: #ff0000;  }100% { color: #ff0000;  } }
@-o-keyframes my { 0% { color: #000000; } 100% { color: #ff0000; } 100% { color: #ff0000;  } }
@keyframes my { 0% { color: #000000;  } 100% { color: #ff0000;  }100% { color: #ff0000;  } } 
.chunhay {-webkit-animation: my 700ms infinite;-moz-animation: my 700ms infinite; -o-animation: my 700ms infinite; animation: my 700ms infinite;}


</style>
</head><body><center><h1>Web Server App Blynk By: Vũ Tuyển</h1>';
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
die("<form method=post><br>
<input type=password name=pass size=20 placeholder='Nh&#7853;p M&#7853;t Kh&#7849;u'>
<input type=submit value='&#272;&#259;ng Nh&#7853;p'></form></center>");}}
//login thành công
echo "<table><tr><td><a href='$self'><input type='button' value='HOME'></input></a></td> <td><form method='POST' aciton=''><input type='submit' name='Marion001-Dep-Trai' value='&#272;&#259;ng Xu&#7845;t'></form></td></tr></table>";
echo 'Điều Khiển App Blynk Qua Trình Duyệt'; 
//Xuất thông tin server
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://blynk-cloud.com/$token/project");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
curl_close($ch);
$character = json_decode($response);
$checktoken = ("$response" == "Invalid token.") ? "<b><font color=red size=10><hr>Lỗi, Mã Token Không Hợp Lệ</font></font>" : "";
echo $checktoken; //kiểm tra token hợp lệ hay k
//////chech mạng module
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, "http://blynk-cloud.com/$token/isHardwareConnected");
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch1, CURLOPT_HEADER, FALSE);
$status = curl_exec($ch1);
curl_close($ch1);
$checknet = json_decode($status);
$mangstatus = ("$checknet" == "1") ? "<center><b><font color=green>Đang kết nối internet</font></b></center>" : "<center><font color=red class=chunhay><b>Mất kết nối Internet</b></font></center>";
//echo $character;
echo "<br/><table><tbody><tr>
<th>Tên Project</th>
<th>Tên Module</th>
<th>Kiểu Kết Nối</th>
<th>Trạng Thái Module</th>
</tr>";
foreach ($character->devices as $devices) {
	echo "<tr>";
    echo "<td><center>"."$devices->name"."</center></td>";
    echo "<td><center>"."$devices->boardType"."</center></td>";
    echo "<td><center>"."$devices->connectionType"."</center></td>";
    echo "<td><center>"."$mangstatus"."</center></td>";
	echo "</tr></tbody></table>";
}
if(isset($_POST['batthietbi'])){
$port = @$_POST['ThietBi'];
$url = "http://blynk-cloud.com/$token/update/$port?value=1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$url");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
curl_close($ch);
header("Location: $self");
}
if(isset($_POST['tatthietbi'])){
$port = @$_POST['ThietBi'];
$url = "http://blynk-cloud.com/$token/update/$port?value=0";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$url");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
curl_close($ch);
header("Location: $self");
}
//Thông tin chức năng app blynk + hành động
echo "<hr><table><tr>
<th>Pin Blynk</th>
<th title='Pin Type'>Kiểu Pin</th>
<th title='Type'>Dạng Pin</th>
<th title='Tên Thiết Bị'>Tên Thiết Bị</th>
<th title='Value'>Trạng Thái</th>
<th title='Bật, Tắt Thiết Bị'>Hành Động</th></tr>";
foreach ($character->widgets as $widgets) {
$wgpin= ("$widgets->pinType" === "VIRTUAL") ? "V" : "D";
$trangthai= ("$widgets->value" === "1") ? "<font color=red>Đang Bật</font>" : "<font color=green>Đang Tắt</font>";
echo "<tr>";
echo "<td><center>$wgpin$widgets->pin</center></td>
<td><center>$widgets->pinType</center></td>
<td><center>$widgets->type</center></td>
<td><center>$widgets->label</center></td>
<td><center>$trangthai</center></td>
<td><center><form method='POST' action=''>
<input type='hidden'  name='ThietBi' value='$wgpin$widgets->pin'>
<input type='submit' value='Bật' name='batthietbi' style='height:40px; width:40px; color:green'>
<input type='submit' value='Tắt' name='tatthietbi' style='height:40px; width:40px; color:red'>
</form></center></td>";
}
echo "</tr></table><br/>Contac: anhtuyenvipcr5@gmail.com - <a href='https://www.facebook.com/100008756118319' target='_bank'>Facebook</a> - Code By: Vũ Tuyển</center></tbody></table>
</body></html>";

?>