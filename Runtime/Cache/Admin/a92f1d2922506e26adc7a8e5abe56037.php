<?php if (!defined('THINK_PATH')) exit();?><html>
<body>
<form action="<?php echo U('Admin/User/register',"","","");?>" method="post">
	nickname:<input type="text" name="nickname" /><br/>
	email:<input type="text" name="email" /><br/>
	password:<input type="password" name="password" /><br/>
	qq:<input type="text" name="qq" /><br/>
	phone:<input type="text" name="phone"/><br/>
	<button type="submit">submit</button>
	<button type="button" id="button1">ajax submit</button>
</form>

<!-- <form action="<?php echo U('Admin/User/login',"","","");?>" method="post"> -->
	email:<input type="text" name="username" id="username" /><br/>
	password<input type="text" name="password" id="login_pwd"/><br/>
	<button type="submit">submit</button>
	<button type="button" id="button2">ajax submit</button>
<!-- </form> -->
	<script src="/ershou/Public/js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript">
	$('#button2').click(function(){
		$.ajax({
			url:'http://118.251.194.230/ershou/index.php/Admin/User/login/',
			//url:'http://flea.sky31.com/index.php/Admin/User/login',
			//url:'User/login',
			type: 'post',
			data: {'username':$('#username').val(),'password':$('#login_pwd').val()},
			dataType: 'json',
			success: function(data) {
				console.log(data);
				console.log($.cookie("User"));
			}
		});
	});
	</script>
</body>
</html>