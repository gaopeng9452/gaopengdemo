<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Sqshouhou extends Controller
{
    public function sqshouhou()
    {
        $id=input('id');
    	$order=db("order")->select();
    	$this->assign("order",$order);
    	$good=db("goods")->select();
    	$this->assign("good",$good);
    	// $com=db("comment")->select();
    	// $this->assign("com",$com);
        $this->assign('id',$id);
        return $this->fetch();
    }
    public function comment(){
        halt($_POST['goodsid']);
    }

}
