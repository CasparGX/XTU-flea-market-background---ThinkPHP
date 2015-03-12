<?php
/**
 * 用户模型
 * @author CasparGX
 * @field int 		id ID
 * @field text 		nickname 昵称
 * @field varchar(32)	password 密码 (md5加密)
 * @field bigint	qq QQ
 * @field bigint 	phone 手机号
 * @field bigint 	power 权限
 *
 * @function returnMsg() 公共函数 Common/Common/function.php
 */
namespace Admin\Model;
use Think\Model;
class UserModel extends Model {

	/**
	 * 新增用户
	 * 普通用户权限,发布商品默认后显示
	 * @param nickname 昵称
	 * @param password 密码
	 * @param qq
	 * @param phone 手机号
	 */
	public function addUser($nickname=NULL, $email, $password, $qq=NULL, $phone=NULL) {
		$result = $this->where(array('email'=>$email))->find();
		if ($result==NULL) {
			$data = array(
					'nickname' => $nickname,
					'email' => $email,
					'password' => md5($password),
					'qq' => $qq,
					'phone' => $phone,
					'power' => 3
				);
			$lastInsID = $this->add($data);
			if($lastInsID) {
				unset($data['password']);
				unset($data['power']);
				$data['id'] = $lastInsID;
				return returnMsg(1,$data);
			}
			else
				return returnMsg(0,"服务器忙,创建用户失败");
		}
		else if ($result==false)
			return returnMsg(0,'服务器忙,查询数据失败');
		else
			return returnMsg(0,'该邮箱已使用');

	}

	/**
	 * 新增特殊用户
	 * 发布物品优先显示,power<3;
	 */
	public function addSuperUser($nickname, $email, $password, $qq, $phone) {
		$result = $this->where(array('email'=>$email))->find();
		if ($result==NULL) {
			$data = array(
					'nickname' => $nickname,
					'email' => $email,
					'password' => md5($password),
					'qq' => $qq,
					'phone' => $phone,
					'power' => 2
				);
			$lastInsID = $this->add($data);
			if($lastInsID) {
				unset($data['password']);
				unset($data['power']);
				$data['id'] = $lastInsID;
				return returnMsg(1,$data);
			}
			else
				return returnMsg(0,"服务器忙,创建用户失败");
		}
		else if ($result==false)
			return returnMsg(0,'服务器忙,查询数据失败');
		else
			return returnMsg(0,'该邮箱已使用');
	}

	/**
	 * 登陆函数
	 */
	public function login($username, $password) {
		//判断账号密码是否填写完整
		if ($username==""||$password=="") {
			return returnMsg(0,"账号密码不完整");
		}//if
		else {
			//验证账号是否存在,密码是否正确
			$userData = $this->where(array('email'=>$username))->getField('password');
			if($userData==NULL) {
				return returnMsg(0,"账号不存在");
			}
			else {
				//验证密码是否正确
				$password = md5($password);
				if($userData==$password) {
					return "登陆成功";
				}
				else {
					return returnMsg(0,"密码错误");
				}
			}//else
		}//else
	}//function login()

	/**
	 * 修改信息
	 */
	public function changeInfo($id, $nickname, $qq, $phone) {
		/*if($phone=="") {
			return returnMsg(0,"手机号必须填写");
		}*/
		$data = array(
				'nickname' => $nickname,
				'qq' => $qq,
				'phone' => $phone
			);
		$lastInsID = $this->where(array('id'=>$id))->save($data);
		if ($lastInsID == false)
			return returnMsg(0,'信息修改失败!');
		else
			return returnMsg(1,'user ID: '.$lastInsID);
	}//function change()

	/**
	 * 修改账户密码
	 */
	public function changPassword($id ,$oldPwd, $newPwd) {

    	$result = $this->where(array('id'=>$id,'password'=>$oldPwd))->find();
		if($result) {
			$data['password'] = $newPwd;
			$result = $this->where(array('id'=>$id))->save($data);
			if($result) {
				return returnMsg(1,"密码修改成功");
			} else {
				return returnMsg(0,"服务器忙,密码修改失败");
			}
		} else {
			return returnMsg(0,"原始密码错误");
		}
	}

}


?>