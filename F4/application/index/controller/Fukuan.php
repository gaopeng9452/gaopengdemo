<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
class Fukuan extends Controller
{
    public function fukuan(){
        $bigprice=input('bigprice');
        $this->assign('bigprice',$bigprice);

    	$uid=Session::get('indexuser.id');//uid
    	$shop=db('shopcar')->where('userid',$uid)->select();
    	foreach ($shop as $k) {
    		//gid
    		$gid=$k['goodid'];
    		//time
    		$time=time();
    		//订单号
    		$order=date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    		//address
    		$add=db('address')->where('pid',Session::get('indexuser.id'))->where('state',1)->select();
    		$address=$add['0']['address1'];
    		//money
    		$money=$k['price']*$k['num'];
           
    		//picname
    		$good=db('goods')->where('id',$k['goodid'])->select();
    		$picname=$good[0]['picname'];
    		//tity
    		$tity=$k['num'];
    		$data=['uid'=>$uid,'gid'=>$gid,'time'=>$time,'order'=>$order,'address'=>$address,'money'=>$money,'picname'=>$picname,'tity'=>$tity];
    		$m=db('order')->insert($data);
            //相对应减少库存
            $now=$good[0]['store']-$k['num'];
            db('goods')->where('id',$k['goodid'])->update(['store'=>$now]);
            db('goods')->where('id',$k['goodid'])->update(['sonum'=> $good[0]['sonum']+$k['num']]);
             if($m>0){

                db('shopcar')->where('userid',$uid)->delete();
                session("indexuser.shopgoodsnum","0");

            }
    		
    	}
      
           
        return $this->fetch();
    }
}
