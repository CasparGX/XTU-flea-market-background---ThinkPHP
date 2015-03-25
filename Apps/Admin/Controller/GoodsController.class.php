<?php
namespace Admin\Controller;
//use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Model\GoodsModel;
class GoodsController extends CommonController {

	/**
	 * 构造函数,完成通用操作
	 */
	/*protected function _initialize()
    {
    	//支持跨域ajax操作的头信息.测试时跨域操作用,正式发布时应关闭;
		header("Access-Control-Allow-Origin:*");
    }*/

	/**
	 * 后台首页
	 */
	public function index() {
		$goods = M("Goods");
		$goodsSelect = $goods->select();
		$countGoods = count($goodsSelect);
		for($i=0;$i<$countGoods;$i++){
			parse_str($goodsSelect[$i]["picname"],$picThumbArray[$i]);
		}
		$this->assign('picThumb', $picThumbArray);
		$this->assign('goodsSelect', $goodsSelect);
		$this->display();
	}

	/*  图片上传部分  */
    private function createDir($path){

        if (!file_exists($path)){

            $this -> createDir(dirname($path));
            mkdir($path,0777,true);
            $result = chmod($dir,$mode);

        }

    }

    //banner图上传
    public function uploadBanner(){

        if(empty($_FILES)){
            $this->error('请选择需要上传的文件');
        } else {
        	//1,引入模块包
            //import('@.Org.Net.UploadFile');
            //2,实例化对象，调用对象的方法
            $file = new \Think\UploadFile();
            //3,上传的话需要做一些设置
            //默认情况下是-1，代表不限制文件的大小
            $file ->maxSize = '1000000';
            //allowExts 设置上传文件的扩展名
            $file ->allowExts = array('jpg','gif','png','jpeg');
            //允许上传文件的类型
            $file ->allowTypes = array('image/png','image/jpg','image/pjpeg','image/gif','image/jpeg');
            //对上传文件进行缩略图处理
	        $file->thumb = true;
	        //缩略图的最大的宽度
	        $file->thumbMaxWidth = '945';
	        //缩略图的最大的高度
	        $file->thumbMaxHeight = '100';
	        //缩略图的文件后缀
	        $file->thumbSuffix = "jpg";
            // 指定缩略图文件名
            $file->thumbFile = "banner";
            //如果上传的图片和原图一样，是否删除原图
            $file->thumbRemoveOrigin = false;
            // 上传文件保存路径
            $file->savePath = "./Public/uploadfile/banner/";
            // 存在同名是否覆盖
            $file->uploadReplace = true;
            if($file->upload()){
                $info = $file->getUploadFileInfo();
                 return $info;

            }else{
                $this->ajaxReturn(returnMsg(0,$file->getErrorMsg()),'json');
            }
        }
    }

    private function upload(){
        $sellerId = session("uid");
        $title = strtotime(date("Y-m-d H:i:s", time()));
        $this->path = "./Public/uploadfile/".$sellerId."/".$title."/";
        $this -> createDir($this->path);
        //1,引入模块包
        //import('@.Org.Net.UploadFile');
        //2,实例化对象，调用对象的方法
        $file = new \Think\UploadFile();
        //3,上传的话需要做一些设置
        //默认情况下是-1，代表不限制文件的大小
        $file ->maxSize = '1000000';
        //allowExts 设置上传文件的扩展名
        $file ->allowExts = array('jpg','gif','png','jpeg');
        //允许上传文件的类型
        $file ->allowTypes = array('image/png','image/jpg','image/pjpeg','image/gif','image/jpeg');
        //对上传文件进行缩略图处理
        $file->thumb = true;
        //缩略图的最大的宽度
        $file->thumbMaxWidth = '200,60';
        //缩略图的最大的高度
        $file->thumbMaxHeight = '200,60';
        //缩略图的前缀
        $file->thumbPrefix = 's_,m_';
         // 缩略图保存路径
         $file->thumbPath= $this->path;
         //如果上传的图片和原图一样，是否删除原图
         $file->thumbRemoveOrigin = false;
         // 上传文件保存路径
         $file->savePath = $this->path;
         // 存在同名是否覆盖
         $file->uploadReplace = true;
         $this->path = "/Public/uploadfile/".$sellerId."/".$title."/";
         if($file->upload()){
             $info = $file->getUploadFileInfo();
             return $info;

         }else{
             //$this->ajaxReturn(returnMsg(0,$file->getErrorMsg()),'json');
         	$this->error($file->getErrorMsg());
         }
    }

    /**
     * 被外部调用的函数,新增商品的入口
     */
    public function insert(){
        if(empty($_FILES)){
            $this->error('请选择需要上传的文件');
        }else{

            $goodsType = C("goodsType");
            //获取post参数值
            $title = I('post.title');
            $type = I('post.type');
            $price = I('post.price');
            $describe = I('post.describe');
            $bargain = I('post.bargain');
            $trading = I('post.trading');
            $seller = I('post.seller');
            $sellerID = session('uid');
            $qq = I('post.qq');
            $phone = I('post.phone');
            $interval = I('post.interval');

            if($title=="" || $type=="" || $price=="" || $describe=="" || $bargain=="" || $trading=="" || $seller=="" || ($qq=="" && $phone=="")) {
            	//$result = returnMsg(0,"信息填写不完整");
            	//$this->ajaxReturn($result,"json");
                $this->error("信息填写不完整");
            }

            if( $type < 1 || $type > count($goodsType) - 1 ) {
                //$result = returnMsg(0,"商品类型录入错误,请联系管理员");
                //$this->ajaxReturn($result,"json");
                $this->error("商品类型录入错误,请联系管理员");
            }
            $type = $goodsType[$type];

            $data = $this -> upload();
            $picName = "";
            if(isset($data)){
                $countData = count($data);
                //如果上传文件的信息不为空，我们就将这些信息保存到数据库中
                for($i=1;$i<=$countData;$i++){
                    $picName = $picName.$i."=".$data[$i-1]['savename'];
                    if($i<$countData)
                        $picName = $picName."&";
                    //echo $picName;
                }

                $goods = D("Goods");
                $insId = $goods->addGoods($this->path,$picName,$title,$type,$price,$describe,$bargain,$trading,$seller,$sellerID,$qq,$phone,$interval);
                if($insId) {
                	//$result = returnMsg(1,"商品添加成功");
                	//$this->ajaxReturn($result,"json");
                	$this->success("商品添加成功","http://www.chengjiuaixin.com");
                } else {
                	//$result = returnMsg(0,"商品添加失败");
                	//$this->ajaxReturn($result,"json");
                	$this->error("商品添加失败");
                }
            }else{
            	//$result = returnMsg(0,'信息录入失败,请联系管理员');
            	//$this->ajaxReturn($result,"json");
                $this->error('信息录入失败,请联系管理员');
            }

        }

    }
    /**
     * 测试用insert
     */
    public function testInsert(){
        if(empty($_FILES)){
            $this->error('请选择需要上传的文件');
        }else{

            //测试post数据
            $title = "野生程序员一只,低价贱卖";
            $type = "人口贩卖";
            $price = 6666;
            $describe = "上好的野生程序员,低价贱卖了,大家行行好收了吧...";
            $bargain = 1;
            $trading = "面议";
            $seller = "萌萌哒单身狗";
            $sellerID = 12138;
            $qq = 630248976;
            $phone = 15675264864;
            $data = $this -> upload();
            $picName = "";
            $interval = 30;
            if(isset($data)){
                $countData = count($data);
                //如果上传文件的信息不为空，我们就将这些信息保存到数据库中
                for($i=0;$i<$countData;$i++){
                    $picName = $picName.$i."=".$data[$i]['savename'];
                    if($i<$countData-1)
                        $picName = $picName."&";
                    //echo $picName;
                }

                $goods = D("Goods");
                $insId = $goods->addGoods($this->path,$picName,$title,$type,$price,$describe,$bargain,$trading,$seller,$sellerID,$qq,$phone);
                $this->show(dump($data).$insId);
            }else{
                $this->error('信息录入失败,请联系管理员');
            }

        }

    }
    /**图片上传部分结束**/

	/**
	 * 删除商品函数
	 */
	public function delete() {
		$id = I('post.gid');
		$picsrc = I('post.picsrc');
		//echo $id."...".$picsrc;
		//如果传递的值为空则返回失败
		if($id==""||$picsrc=="") {
			$result = returnMsg(0,"失败delete1");
			$this->ajaxReturn($result,"json");
		}
		else {
			$goods = D("Goods");
			$result = $goods->where(array('id'=>$id,'picsrc'=>$picsrc))->find();
			if($result==false||$result==NULL) {
				$result = returnMsg(0,"失败delete2:".$result);
				$this->ajaxReturn($result,"json");
			}
			else {
				delDirAndFile(".".$picsrc);
				$result = $goods->deleteGoods($id);
				$this->ajaxReturn($result,"json");
			}
		}

	}

	/**
	 * 查询商品函数
	 */
	public function query() {
		$id = I('get.gid');
		$type = I('get.type');
		//判断分类信息是否正确
		$goodsType = C('goodsType');
		if($type<0||$type>count($goodsType)-1) {
			$result = returnMsg(0,"所查询的分类不存在");
			$this->ajaxReturn($result,"json");
		}
		else if($type==0)
			$type = "";
		else
			$type = $goodsType[$type];
		$title = I('get.title');
		$limitID = I('get.limitID');
		$validity = I('get.validity');
		$goods = D('Goods');
		//echo $validity;die();
		$result = $goods->queryGoods($id, $type, $title, $limitID, $validity);
		if($id!=null) {
			$countGoods = 1;
			parse_str($result["picname"],$result["picname"]);
		} else {
			$countGoods = count($result);
			for($i=0;$i<$countGoods;$i++){
				parse_str($result[$i]["picname"],$result[$i]["picname"]);
				//$result[$i]["picname"] = json_encode($result[$i]["picname"]);
			}
		}

		$this->ajaxReturn($result,"json");
	}

	public function testArray() {
		$array = array(
				0=>[0=>1,1=>1,2=>("123")],
				1=>["321"],
				2=>(array(
									0=>"012",
									1=>"345"
									))
			);
		$this->ajaxReturn($array,"json");
	}

	/**
	 * 下架商品
	 */
	public function soldOut() {
		$id = I('get.gid');
		if($id=="") {
			$result = returnMsg(0,"商品不存在");
			$this->ajaxReturn();
		}

		$goods = D("Goods");
		$result = $goods->soldOut($id);
		$this->ajaxReturn($result,"json");
	}

	/**
	 * 编辑/修改 商品信息
	 */
	public function edit() {
		$goods = D("Goods");
		$goodsType = C("goodsType");
        //获取post参数值
        $id = I("get.gid");
        $title = I('post.title');
        $type = I('post.type');
        $price = I('post.price');
        $describe = I('post.describe');
        //$bargain = I('post.bargain');
        $trading = I('post.trading');
        $seller = I('post.seller');
        $sellerID = session('uid');
        $qq = I('post.qq');
        $phone = I('post.phone');
        $interval = I('post.interval');

        if($title=="" || $type=="" || $price=="" || $describe=="" || /*$bargain=="" ||*/ $trading=="" || $seller=="" || $sellerID=="" || ($qq=="" && $phone=="")) {
        	$result = returnMsg(0,"信息填写不完整");
        	$this->ajaxReturn($result,"json");
        }

        if( $type < 1 || $type > count($goodsType) - 1 ) {
            $result = returnMsg(0,"商品类型录入错误,请联系管理员");
            $this->ajaxReturn($result,"json");
        }
        $type = $goodsType[$type];

        $goods = D("Goods");
        $insId = $goods->edit($id,$title,$type,$price,$describe,/*$bargain,*/$trading,$qq,$phone,$interval);
        if($insId) {
        	$result = returnMsg(1,"商品修改成功");
        	$this->ajaxReturn($result,"json");
        } else {
        	$result = returnMsg(0,"商品修改失败");
        	$this->ajaxReturn($result,"json");
        }

	}

}
?>
