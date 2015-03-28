Admin接口信息:{
	示例地址:flea.sky31.com/index.php/Admin/控制名/操作名/
	操作接口列表:{
		控制名:Goods;
		Goods操作名:{
			uploadBanner:{
				上传banner图	post/get
				需要管理权限才能上传,只能添加一张图片.
				标准大小:945*100;
			}

			insert:{
				新增商品	需要post提交参数
				title:	发布商品的标题
				type:	商品类型,整数型,1~8,如果有变动查看 flea.sky31.com/Apps/Common/Conf/Config.php 里的商品类型定义
				price:	商品价格,整数型
				describe:	商品描述
				bargain:	是否支持讲价
				trading:	交易方式
				seller:		卖家昵称
				qq:		卖家qq
				phone:	卖家联系方式
				interval:	上架天数
			}

			delete:{
				删除商品	post
				gid:	商品ID
				picsrc:	商品图片地址,为获取到的商品信息的picsrc参数
			}

			query:{
				查询商品	get
				gid:	商品ID,如果有ID这个值,默认忽略其他查询条件
				type:	商品类型,整数型,具体参阅Goods/insert方法中的说明,但是这里可以接受0,表示查询全部商品,如果不填,默认为0
				title:	商品标题,可以模糊查找
				limitID:	分页,默认每次获取30条记录,默认为0,当为0时,获取0-29条记录, 为1时,获取30-59条记录,以此类推
				validity: 	是否忽略下架商品,如果值为1,默认不查询已下架商品,默认为不查询
				uid:	用户ID
			}

			soldOut:{
				下架商品	get
				gid:	商品ID
			}

			edit:{
				修改商品信息	post
				title:	商品标题
				type:	商品类型
				price:	商品价格
				describe:	商品描述
				bargain:	是否支持讲价
				trading:	交易方式
				seller:		卖家昵称
				qq:		卖家qq
				phone:	卖家联系方式
				interval:	上架天数
			}
		}

		控制名:User;
		User操作名:{
			login:{
				登陆	post
				username:	登陆Email账号
				password:	登陆密码
			}

			logout:{
				退出	无参数,直接调用
			}

			register:{
				注册账号	post
				nickname:	昵称
				email:		邮箱,用作登陆账号
				password:	密码
				qq:			QQ号
				phone:		手机号
			}

			register2:{
				注册公益组织账号,参数与register一样,但是需要管理权限账号才能调用
			}

			changeInfo:{
				修改用户信息	post/get都可以
				uid:	用户ID
				nickname:	昵称
				qq:		QQ号
				phone:	手机号
			}

			changePassword:{
				修改账户密码	post
				uid:	用户ID, 如果填写,则是管理员权限才能修改,默认不填写
				oldPwd:	原始密码
				newPwd:	新密码
			}
		}
	}
}