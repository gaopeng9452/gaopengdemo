<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Wddingdan extends Controller
{
    public function wddingdan()
    {
    	// $order=db("order")->select();
    	// $this->assign("order",$order);
    	$user=db("address")->select();
    	$this->assign("user",$user);
    	$good=db("goods")->select();
    	$this->assign("good",$good);
     //    $com=db("comment")->select();
     //    $this->assign("com",$com);
        $link=db('order')->select();
        $this->assign("link",$link);
        $com=db('comment')->select();
        $this->assign("com",$com);
        return $this->fetch();
    }
    public function yes(){
        $m=db("order")->where('id',input("id"))->update(['state'=>3]);
        return $m;
    }
    public function no(){
        $m=db("order")->where('id',input("id"))->update(['state'=>4]);
        return $m;
    }
    public function del(){
        $q=db("order")->where("id",input("id"))->delete();
    }
}
