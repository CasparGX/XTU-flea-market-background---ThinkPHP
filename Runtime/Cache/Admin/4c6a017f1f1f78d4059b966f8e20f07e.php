<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>湘大二手后台管理</title>
	<link rel="stylesheet" href="/ershou/Public/css/bootstrap.css">
	<link rel="stylesheet" href="/ershou/Public/css/base.css">
	<link rel="stylesheet" href="/ershou/Public/css/index.css">
	<link rel="stylesheet" href="/ershou/Public/css/styles.css">
	<link rel="stylesheet" href="/ershou/Public/css/houtai.css">
	<!--[if lt IE 9]>
		<script src="./js/css3-mediaqueries.js"></script>
	<![endif]-->
	<script src="/ershou/Public/js/jquery-2.1.3.min.js"></script>
	<script src="/ershou/Public/js/jQueryColor.js"></script>
	<!-- 这个插件是瀑布流主插件函数必须 -->
	<script src="/ershou/Public/js/jquery.masonry.min.js"></script>
	<!-- 这个插件只是为了扩展jquery的animate函数动态效果可有可无 -->
	<script src="/ershou/Public/js/jQeasing.js"></script>
	<script src="/ershou/Public/js/loading.js"></script>
	<script src="/ershou/Public/js/returnTop.js"></script>
	<script src="/ershou/Public/js/bootstrap.js"></script>
</head>
<body>
	<header class="container-fluid">
	<div class="row">
		<nav class="navbar-default">
		<div class="container">
			<div class="row">
				<h1>湘大二手街</h1>
				<ul>
					<li><a href="">用户管理</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">商品管理<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php $goods = C('goodsType'); ?>
							<?php if(is_array($goods)): foreach($goods as $k=>$good): ?><li><a href=""><?php echo ($good); ?></a></li><?php endforeach; endif; ?>
							<!-- <li><a href="">全部产品</a></li>
							<li><a href="">图书教材</a></li>
							<li><a href="">数码产品</a></li>
							<li><a href="">代步工具</a></li>
							<li><a href="">运动器材</a></li>
							<li><a href="">衣物鞋帽</a></li>
							<li><a href="">家用电器</a></li>
							<li><a href="">租赁</a></li>
							<li><a href="">其他</a></li> -->
						</ul>
					</li>
					<li><a href="">后台管理</a></li>
				</ul>
			</div>
		</div>
		</nav>
	</div>
	</header>
	<section class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 houtai-content">
			<div class="trade">
				<div class="trade-content" id="hot">
					<!-- 瀑布流样式开始 -->
					<div class="waterfull clearfloat" id="waterfull">
					<ul>
						<?php if(is_array($goodsSelect)): foreach($goodsSelect as $k=>$vo): ?><li class="item">
								<span style="background-color:#f82;float:left;position:absolute;z-index:1;" onclick="deleteGoods(<?php echo ($vo["id"]); ?>,'<?php echo ($vo["picsrc"]); ?>',this);">删除</span>
								<a href="####" class="a-img">
									<img src="/ershou<?php echo ($vo["picsrc"]); ?>s_<?php echo ($picThumb[$k][0]); ?>" alt="">
								</a>
								<h2 class="li-title" title=""><a href=""><?php echo (msubstr($vo["title"],0,10,'utf-8',true)); ?></a></h2>
								<div class="qianm clearfloat">
									<span class="sp1"><?php echo ($vo["seller"]); ?></span>
									<!-- <span class="sp2"><a href="">(学号认证)</a></span> -->
									<span class="sp3">￥<?php echo ($vo["price"]); ?></span>
								</div>
							</li><?php endforeach; endif; ?>
					</ul>
					</div>
					<!-- loading按钮自己通过样式调整 -->
					<div id="imloading">
						小二正在玩命加载。。。
					</div>
					<div class="retureTop">
						<a href="javascript:;" id="btn" title="回到顶部"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
	<footer class="container-fluid">
	<div class="row">
		<div class="copyright">
			<div class="col-md-12">Copyright©2014-2015湘潭大学三翼工作室 Powered by 翼工坊</div>
			<div class="col-md-12">
				<a href="">意见反馈</a>
				<a href="">加入我们</a>
				<a href="">管理登陆</a>
			</div>
		</div>
	</div>
	</footer>
	<script type="text/javascript">
		function deleteGoods($id, $picsrc, obj) {
			$.ajax({
				url: "<?php echo U('Admin/Goods/delete/',"","","");?>",
				type: "post",
				data: "id="+$id+"&picsrc="+$picsrc,
				dataType: "json",
				success:function(data){
					if(data.result=="error") {
						alert("删除失败:"+data.msg);
					}
					else if(data.result=="success"){
						$(obj).parents('li')[0].remove();
					}
					else {
						alert("删除失败,请联系管理员");
					}
				}//success
			});//$.ajax()
		}
	</script>
</body>
</html>