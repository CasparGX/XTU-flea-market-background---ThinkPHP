<?php
/**
 * 商品模型
 * @author CasparGX
 * @field text 		picsrc 商品图片路径
 * @field text 		picname 商品图片名称
 * @field char(30) 	title 商品名称
 * @field char(10) 	type 商品类型
 * @field int(11) 	price 商品价格
 * @field text 		describe 商品描述
 * @field tinyint	bargain 是否支持讲价
 * @field char(10)	trading 交易方式
 * @filed text 		seller 卖家昵称
 * @field int(11)	sellerID 卖家ID
 * @field int(12)	qq qq
 * @field int(12)	phonr 手机号
 * @field int(11)	id 商品ID
 * @field date 		creat_time 创建时间
 * @field date   	last_time 修改时间
 * @field date   	end_time 下架时间
 */
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model {

	/**
	 * 新增商品
	 * @param char title 商品名称
	 * @param char type 商品类型
	 * ...
	 *
	 */
	public function addGoods($picsrc, $picname, $title, $type, $price, $describe, $bargain, $trading, $seller, $sellerID, $qq, $phone, $interval) {
		//时间间隔(天)
		//$interval = 30;
		//结束时间计算
		$end_time = date("Y-m-d h:i:s",mktime(0,0,0,date("m"),date("d")+$interval,date("Y")));
		//定义数据库字段参数值
		$data = array(
				'picsrc'=>$picsrc,
				'picname'=>$picname,
				'title'=>$title,
				'type'=>$type,
				'price'=>$price,
				'describe'=>$describe,
				'bargain'=>$bargain,
				'trading'=>$trading,
				'seller'=>$seller,
				'sellerID'=>$sellerID,
				'qq'=>$qq,
				'phone'=>$phone,
				'creat_time'=>date("Y-m-d h:i:s"),
				'last_time'=>date("Y-m-d h:i:s"),
				'end_time'=>$end_time
			);
		$lastInsID = $this->add($data);
		return $lastInsID;
	}

	/**
	 * 修改商品信息
	 *
	 */
	public function edit($id, $title, $type, $price, $describe, /*$bargain,*/ $trading, $qq, $phone, $interval) {
		$end_time = date("Y-m-d h:i:s",mktime(0,0,0,date("m"),date("d")+$interval,date("Y")));
		$data = array(
				'title'=>$title,
				'type'=>$type,
				'price'=>$price,
				'describe'=>$describe,
				/*'bargain'=>$bargain,*/
				'trading'=>$trading,
				'qq'=>$qq,
				'phone'=>$phone,
				'last_time'=>date("Y-m-d h:i:s"),
				'end_time'=>$end_time
			);
		//dump($data);die();
		$result = $this->where(array('id'=>$id))->save($data);
		return $result;
	}

	/**
	 * 删除商品,同时删除图片
	 */
	public function deleteGoods($id) {
		$result = $this->delete($id);
		//$result = 0;
		if($result==false)
			return returnMsg(0,"删除失败:".$result);//SQL出错
		else if($result==0)
			return returnMsg(0,"删除失败,没有此数据");//没有此数据
		else
			return returnMsg(1,"删除成功,记录ID:".$result);
	}

	/**
	 * 查询商品,分类查询,
	 * limit限制数量
	 * @param $id 商品id, 有id查询时默认忽略其他条件
	 * @param $type 分类
	 * @param $title 按标题查询
	 * @param $limitID 查询批次
	 * @param $validity 是否忽略下架商品,如果值为1,默认不查询已下架商品
	 */
	public function queryGoods($id, $type, $title, $limitID, $validity, $uid) {
		if($id!="") {
			$query = array('id'=>$id);
			$result = $this->where($query)->find();
			if($result)
				return $result;
			else if($result==NULL)
				return returnMsg(0,"您所查找的商品不存在");
			else
				return returnMsg(0,"服务器忙,查询失败:".$result);
		}
		else {

			if($type!="")
				$query['type'] = $type;

			if($title!="")
				$query['title'] = array('like', '%'.$title.'%');

			//limitID默认为0
			if($limitID=="")
				$limitID = 0;

			//validity默认为1
			if($validity=="")
				$validity = 1;

			if($validity==1)
				$query['end_time'] = array('egt', date("Y-m-d h:i:s"));

			if($uid!="")
				$query['sellerID'] = $uid;

			$limitInterval = 30;//limit间隔为30条记录
			$limitStart = $limitID*$limitInterval;//limit开始位置
			$limitEnd = ($limitID+1)*$limitInterval-1;//limit结束位置
			$result = $this->where($query)->limit($limitStart, $limitEnd)->select();
			if($result)
				return $result;
			else if($result==NULL)
				return returnMsg(0,"没有更多商品");
			else
				return returnMsg(0,"服务器忙,查询失败:".$result);
		}
	}//queryGoods();

	public function soldOut($id) {
		$data['end_time'] =  date("Y-m-d h:i:s");
		$result = $this->where(array('id'=>$id))->save($data);
		if($result)
			return returnMsg(1,"操作成功:".$result);
		else
			return returnMsg(0,"操作失败");
	}

}?>