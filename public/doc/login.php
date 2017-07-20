<!Doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>API - 云宿</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta content="width=device-width,minimum-scale=0.1,maximum-scale=8.0,user-scalable=yes" name="viewport" />
<link rel="stylesheet" href="style/api.css" type="text/css" media="screen" />
<style type="text/css">
html,body{background:#8DABB9;}
.loginwrap{width:360px;height:260px;margin:100px auto;background:#fff;border-radius:8px;}
.loginbox{padding:10px;}
.loginbox h3{margin:0;padding:5px;text-align:center;}
.loginbox p{margin:20px 0 20px 30px;}
.loginbox p input{width:260px;height:35px;border:1px solid #7D9DAC;padding:0 10px;}
.loginbox p.btns{}
.loginbox p.btns input{width:280px;}
</style>
<script type="text/javascript" src="jsapi/moocore145.js"></script>
<script type="text/javascript" src="jsapi/moomore145.js"></script>
<script type="text/javascript">
function chkSubmit(frm){
	if(frm.username.value.length==0){
		alert("username");
		frm.username.focus();
		return false;
	}
	if(frm.password.value.length==0){
		alert("password");
		frm.username.focus();
		return false;
	}
	return true;
}
window.onload = function(){
	document.loginForm.username.focus();
	
}
</script>
</head>
<body>
<div class="loginwrap">
	<div class="loginbox">
		<form name="loginForm" action="login.jsp" method="post" onsubmit="return chkSubmit(this)">
			<h3>Login</h3>
			<p><input type="text" name="username"></p>
			<p><input type="password" name="password"></p>
			<p class="btns"><input type="submit" name="loginBtn" value="Login"></p>
		</form>
	</div>
</div>
</body>
</html>