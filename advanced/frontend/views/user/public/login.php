<?php $this->beginPage(); ?>  
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SCT-后台系统</title>
<link href="assets/style/authority/login_css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="assets/scripts/jquery/jquery-1.7.1.js"></script>
</head>
<body>
	<div id="login_center">
		<div id="login_area">
			<div id="login_box">
				<div id="login_form">
						<div id="login_tip">
							<span id="login_err" class="sty_txt2"></span>
						</div>
					<?php $form=ActiveForm::begin([
						'action'=>Url::toRoute('login')
					])?>
						<div>
							 用户名：<input type="text" name="username" class="username" placeholder="请输入正确的用户名" onfocus="this.placeholder=''" id="name">
						</div>
						<div>
							密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type="password" name="password"  placeholder="请输入正确的密码" onfocus="this.placeholder=''" class="pwd" id="pwd">
						</div>
						<div id="btn_area">
							<input type="submit" class="login_btn" id="login_sub"  value="登  录">
							<input type="reset" class="login_btn" id="login_ret" value="重 置">
						</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/scripts/jquery/jq.js"></script>
	<script>
		function  length(str) {
			return	str.replace(/(^\s*)|(\s*$)/g, "").length;
		}
		function CheckStr(str){
			var regx=/['"#$%&\^*》>,."<《？，。！@#￥%……’”：/；]/;
			rs=regx.exec(str);
			if(rs!=null)
			{
				return false;
			}
			else
			{
				return true ;
			}
		}
		$(document).on("click",'#name',function () {
			$("#login_err").text("");
		})
		var ok1=false;
		$(document).on("blur","#name",function () {

			var name = $("#name").val();
			if(length(name)==0)
			{
				$("#login_err").text("用户名不能为空");
				return false;

			}
			else
			{
				if(CheckStr(name)==true)
				{
					ok1=true;
				}
				else
				{
					$("#login_err").text("用户名存在特殊字符");
				}
			}
		})
		//验证密码
		$(document).on("click",'#pwd',function () {
			$("#u_pwd").text("");
		})
		var ok2=false;
		$(document).on("blur","#pwd",function () {
			var name = $("#pwd").val();
			if(length(name)==0)
			{
				$("#login_err").text("密码不能为空");
				return false;
			}
			else
			{
				if(CheckStr(name)==true)
				{
					ok2=true;
				}
				else
				{
					$("#login_err").text("密码存在特殊字符");
				}
			}
		})
		$(document).on("click","#login_sub",function () {
			if(ok1==true&&ok2==true)
			{
				$("form").submit();
			}
			else
			{
				return false;
			}
		})
	</script>
<div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
</body>
</html>