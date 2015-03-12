<?php
return array(
	//'配置项'=>'配置值'

	// 数据库配置
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'ershou', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '123456', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'tp_', // 数据库表前缀
	'DB_CHARSET'=> 'utf8', // 字符集

	//定义商品类型
	'goodsType' => array(
					0 => "全部商品",
					1 => "图书教材",
					2 => "数码产品",
					3 => "代步工具",
					4 => "运动器材",
					5 => "衣物衣帽",
					6 => "家用电器",
					7 => "租赁",
					8 => "其他"
		)
);