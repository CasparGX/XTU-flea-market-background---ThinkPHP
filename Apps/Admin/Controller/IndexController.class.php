<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\GoodsModel;
class IndexController extends Controller {

    public $path;

    public function index(){
    	//$goods = D("Goods");
        //$this->show($goods->addGoods("1","1","1",1,"1",1,"12",1,1,1,1));
        $goods = M("Goods");
        $goodsCount = $goods->count();
        $this->assign('goodsCount',"<p>123</p>");
    	$this->display();
    }





}