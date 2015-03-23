<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>湘大二手后台管理</title>
	<link rel="stylesheet" href="/ershou/Public/css/bootstrap.css">
	<link rel="stylesheet" href="/ershou/Public/css/bootstrap-table.min.css">
	<script src="/ershou/Public/js/jquery-2.1.3.min.js"></script>
	<script src="/ershou/Public/js/bootstrap.js"></script>
	<script src="/ershou/Public/js/bootstrap-table.js"></script>

	<style>
		*{margin: 0 auto;padding: 0;}
		.content{max-width:1000px;margin:0 auto;padding:20px;}

		.rightKeyMenu{width:50px;height:auto;border:1px solid #666; display:none; position: absolute; z-index: 999; background:#fff; }
		.rightKeyMenu ul{list-style:none; margin:0;}
		.rightKeyMenu ul li{text-align:center;padding:2px;}
		.rightKeyMenu ul li:hover{background-color: #999;}
	</style>

</head>
<body>
	<div class="rightKeyMenu">
		<ul>
			<li>修改</li>
			<li>下架</li>
			<li>删除</li>
		</ul>
	</div>

	<div class="head">
	</div>

	<div class="content">
				<table id="table"
			           data-toggle="table"
			           data-show-columns="true"
			           data-search="true"
			           data-show-refresh="true"
			           data-show-toggle="true"
			           data-pagination="true"
			           data-height="500"
			           data-id-field="ID">
			        <thead>
			        <tr>
			            <th data-field="id" >ID</th>
			            <th data-field="title">标题</th>
			            <th data-field="price">价格</th>

			            <th data-field="type">分类</th>

			            <th data-field="seller">卖家</th>

			            <th data-field="phone">联系方式</th>

			            <th data-field="qq">QQ</th>

			            <th data-field="last_time">下架时间</th>
			        </tr>
			        </thead>
			    </table>
	</div>

	<div class="foot">

	</div>

	<script type="text/javascript">
		$('#table').bootstrapTable({
		  //url: '/ershou/Public/data/data1.json'
		  url: 'http://localhost/ershou/index.php/Admin/Goods/query'
		}).on('load-success.bs.table', function (e, data) {
                $('#table tbody tr').mousedown(function(e){
                	var flag=0;
					if(e.which==3) {
						$(".rightKeyMenu").offset({top:e.pageY, left:e.pageX});
						$(".rightKeyMenu").css({display:'block'});
						flag=1;
						console.log(e.pageX);
					} else if ((e.which==1 || e.which==2)) {
						$(".rightKeyMenu").css({display:'none'});
						flag=0;
					}
				});
            });

		$(document).bind('contextmenu',function(e){
			return false;
		 });


		$(window).load(function(){
			$('#table tbody tr').mousedown(function(e){
				if(e.which==3) {
					console.log(this);
				}
			});
		});

		$(function(){



		});

	</script>
</body>
</html>