<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public $action;
	public $controller;

	protected function _initialize()
    {

		header("Access-Control-Allow-Origin:*");
        $this->action = ACTION_NAME;
        $this->controller = CONTROLLER_NAME;
        //echo $this->action.'/'.$this->controller;
        //echo session('uid').'/'.session('userEmail');
        if($this->controller=="Goods"||$this->controller=="goods")
        	$this->checkGoods();
        else if($this->controller=="User"||$this->controller=="user")
        	$this->checkUser();

    }

	protected function checkGoods() {
		//判断是否登陆
		if($this->action=="insert") {
			if($this->ifLogin()) {

			} else {
				$result = returnMsg(0,"请先登录");
				$this->ajaxReturn($result,"json");
			}//if else
		}

		//判断是否登陆,且商品是否属于该用户
		if($this->action=="soldOut" || $this->action=="delete" || $this->action=="edit") {
			if($this->ifLogin()==1) {

				if($this->ifBelongTo()) {

				} else {
					$result = returnMsg(0,"商品编号错误");
					$this->ajaxReturn($result,"json");
				}//if else

			} else {
				$result = returnMsg(0,"请先登录");
				$this->ajaxReturn($result,"json");
			}//if else

		}//if
	}

	protected function checkUser() {

		//检测账户是否登陆且是否为1权限
		if($this->action=="changeInfo" || $this->action=="register2" || $this->action=="changePassword") {

			if($this->ifLogin()) {

				if($this->action=="changePassword") {
					if(I('post.uid')) {
						if($this->checkPower()) {

						} else {
							$result = returnMsg(0,"权限不足,无法操作");
							$this->ajaxReturn($result,"json");
						}
					} else {}

				} else {
					if($this->checkPower()) {

					} else {
						$result = returnMsg(0,"权限不足,无法操作");
						$this->ajaxReturn($result,"json");
					}
				}//else

			} else {
				$result = returnMsg(0,"请先登录");
				$this->ajaxReturn($result,"json");
			}

		}//if
	}

	/**
	 * 判断用户是否登陆
	 */
	protected function ifLogin() {
		if(session('uid')&&session('userEmail'))
			return 1;
		else
			return 0;
	}

	/**
	 * 判断商品是否属于该用户
	 */
	protected function ifBelongTo() {
		$uid = session('uid');
		$gid = I('gid');
		if($gid=="") {
			$result = returnMsg(0,"商品不存在");
			$this->ajaxReturn($result,"json");
		}
		$goods = D("Goods");
		$result = $goods->where(array('id'=>$gid, 'sellerID'=>$uid))->find();
		if($result)
			return 1;
		else
			return 0;
	}

	/**
	 * 检查用户权限是否为admin (1)
	 */
	protected function checkPower() {
		$uid = session('uid');
		$user = D("User");
		$result = $user->where(array('id'=>$uid))->find();
		if($result==1) {
			return 1;
		}
		else {
			return 0;
		}
	}

}?>