<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
class Jiesuan extends Controller
{
    public function jiesuan()
    { 
    	$address=db('address')->where("pid",Session::get('indexuser.id'))->select();
    	// $shop=db('shopcar,goods')->where('shopcar.userid',Session::get('indexuser.id'))->where('shopcar.goodid','goods.id')->field('shopcar.goodid,shopcar.userid,goods.picname')->select();//多表联查到 订单中的 uid gid picname
    	
    	$shop=db('shopcar')->select();
    	$goods=db('goods')->select();
        $bigprice="";
    	// dump($goods);
    	// db('order')->insert();
    	$this->assign('address',$address);
    	$this->assign('goods',$goods);
    	$this->assign('shop',$shop);
        $this->assign('bigprice',$bigprice);
        return $this->fetch();
    }
    //修改默认地址
    public function editaddress(){
        $id=input('post.id');
          db('address')->where('state',1)->where('pid',Session::get('indexuser.id'))->update(['state'=>2]);   
        $m=db('address')->where('id',$id)->update(['state'=>1]);       
        return $m;
    }
    //省级联动
     public function quitaddress(){
        $upid=input('upid');
        $m=db('district')->where('upid',$upid)->select();
        // var_dump($m);
      return $m;
    }
     public function quitaddress1(){
        
        $data=['pid'=>input('pid'),'username'=>input('username'),'address1'=>input('alladdress'),'postcode'=>input('postcode'),'phone'=>input('phone')];
        
             $m=db('address')->insert($data);
             return 1; 
    }

}
