<?php
namespace Admin\Controller;
//use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Model\UserModel;

class UserController extends CommonController {

	/**
	 * 构造函数,完成通用操作
	 */
	protected function _initialize()
    {
    	//支持跨域ajax操作的头信息.测试时跨域操作用,正式发布时应关闭;
		header("Access-Control-Allow-Origin:*");
    }

	public function index() {
		$this->display();
	}

	/**
	 * 登陆
	 */
	public function login() {
		$email = I('post.username');
		$password = I('post.password');
		//如果没填写邮箱和密码,就验证是否有session,
		$user = D("User");
		if($email==""&&$password=="") {
			if(session('uid')&&session('userEmail')){
				$id = session('uid');
				$email = session('userEmail');
				$result = $user->where(array('id'=>$id,'email'=>$email))->find();
				unset($result['password']);//删除查询出来的数组中password项
				unset($result['power']);
				$result = returnMsg(1,$result);
				$this->ajaxReturn($result,"json");
			}
			else{
				$result = returnMsg(0,"未登陆");
				$this->ajaxReturn($result,"json");
			}
		}
		$result = $user->login($email, $password);
		if($result=="登陆成功") {
			$result = $user->where(array('email'=>$email))->find();

			cookie('User',$email);
			session('uid',$result['id']);
			session('userEmail',$email);

			unset($result['password']);//删除查询出来的数组中password项
			unset($result['power']);
			$result = returnMsg(1,$result);
			$this->ajaxReturn($result,"json");
		}
		else {
			$this->ajaxReturn($result,"json");
		}
	}

	/**
	 * 登出
	 */
	public function logout() {
		cookie('User',null);
		session('uid',null);
		session('userEmail',null);
		$result = returnMsg(1,"退出成功");
		$this->ajaxReturn($result,"json");
	}

    /**
     * 注册账号
     */
    public function register() {
    	$nickname = I('post.nickname');
    	$email = I('post.email');
    	$password = I('post.password');
    	$qq = I('post.qq');
    	$phone = I('post.phone');
    	if($email==""||$password=="") {
			$result = returnMsg(0,"邮箱和密码必须填写");
			$this->ajaxReturn($result,"json");
		}
		$user = D("user");
		$result = $user->addUser($nickname, $email, $password, $qq, $phone);
		$this->ajaxReturn($result,"json");
    }

    /**
     * 注册公益组织账号
     */
    public function register2() {
    	$nickname = I('post.nickname');
    	$email = I('post.email');
    	$password = I('post.password');
    	$qq = I('post.qq');
    	$phone = I('post.phone');
    	if($email==""||$password=="") {
			$result = returnMsg(0,"邮箱和密码必须填写");
			$this->ajaxReturn($result,"json");
		}
		$user = D("user");
		$result = $user->addSuperUser($nickname, $email, $password, $qq, $phone);
		$this->ajaxReturn($result,"json");
    }

    /**
     * 修改用户信息
     */
    public function changeInfo() {
    	$id = I('uid');
    	$nickname = I('nickname');
    	$qq = I('qq');
    	$phone = I('phone');
    	if($id=="") {
    		$result = returnMsg(0,"无指定用户");
    	}
    	$user = D("User");
    	$user->changeInfo($id, $nickname ,$qq, $phone);
    }

    /**
     * 修改账户密码
     */
    public function changePassword() {
    	if(I('post.uid'))
    		$id = I('post.uid');
    	else
    		$id = session('uid');

    	$oldPwd = I('post.oldPwd');
    	$newPwd = I('post.oldPwd');

    	if($oldPwd=="" || $newPwd=="") {
    		$result = returnMsg(0,"密码填写不完整");
    		$this->ajaxReturn($result,"json");
    	}

    	$user = D('User');
    	$user->changPassword($id, $oldPwd, $newPwd);
    }

}
?>