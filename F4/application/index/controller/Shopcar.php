<?php

namespace app\index\controller;
use think\Controller;
use think\Db;


class Shopcar extends Controller{

	public function shopping(){
		$images=array();
		$glist=array();//当前登陆的用户购物车所有商品的信息


		if (!empty(session("indexuser"))) {

			$uid=session("indexuser.id");

			//当前登陆的用户购物车所有信息
			$list=Db::table('shopcar')->where('userid',$uid)->select();

			foreach ($list as $key => $value) {

				//当前登陆的用户购物车所有商品的信息
				$goodlist=Db::table('goods')->where('id',$value['goodid'])->select();

				foreach ($goodlist as $k => $v) {
					$glist[$v['id']]=$v;
            		$glist[$v['id']]['images']=explode(",",$v['picname']);
				}


			}

		}

		$userid=session("indexuser.id");

		$count2=db('shopcar,goods')->field('shopcar.*,goods.id')->where("shopcar.userid",$userid)->where('shopcar.goodid=goods.id')->count();
		$arr=db('shopcar,goods')->field('shopcar.*,goods.id')->where("shopcar.userid",$userid)->where('shopcar.goodid=goods.id')->select();

		$bigprice="";

		return view('',['list'=>$list,'glist'=>$glist,'count'=>$count2,'bigprice'=>$bigprice]);
	}

	//商品详情里加入购物车
	// public function addshopcar2(){
	// 	if (!empty(session("indexuser"))) {

	// 		$post=input('post.');
			
	// 		$list=Db::table('shopcar')->where("goodid",$post['goodid'])->find();
	// 		$goodlist=Db::table('goods')->where("id",$post['goodid'])->find();


	// 		$addtime=date("Y-m-d H:i:s",time());

	// 		$post['addtime']=$addtime;
	// 		$post['userid']=session("indexuser.id");


	// 		if ($list) {
	// 			if ($post['num']+$list['num']>$goodlist['store']) {
	// 				return 'c';//商品加购件数(含已加购件数)已超过库存
	// 			}else{
	// 				$m=Db::table('shopcar')->where("goodid",$post['goodid'])->update(['num' => $post['num']+$list['num']]);;
	// 			}
	// 		}else{
	// 			$m=Db::table('shopcar')->insert($post);
	// 			if ($m>0) {
 //                    session("indexuser.shopgoodsnum",$count+$m);
 //                }
	// 		}

	// 		return $m;

	// 	}
	// }

	 public function addshopcar2(){
        if (!empty(session("indexuser"))) {

            $userid=session("indexuser.id");

            //商城列表提交过来的
            $post=input('post.');

            //查询数据库购物车表里有没有提交过来的商品的信息
            $list=Db::table('shopcar')->where(["goodid"=>$post['goodid'],"userid"=>$userid])->find();

            //查询数据库商品表里提交过来的商品的全部信息
            $goodlist=Db::table('goods')->where("id",$post['goodid'])->find();

            //查询当前登陆的前台用户购物车表里的商品数量
            $count=Db::table('shopcar')->where(["userid"=>$userid])->count();

            session("indexuser.shopgoodsnum",$count);

            $addtime=date("Y-m-d H:i:s",time());

            $post['addtime']=$addtime;
            $post['userid']=session("indexuser.id");


            if ($list) {
                if ($post['num']+$list['num']>$goodlist['store']) {
                    return 9;//商品加购件数(含已加购件数)已超过库存
                }else{
                    $m=Db::table('shopcar')->where(["goodid"=>$post['goodid'],"userid"=>$userid])->update(['num' => $post['num']+$list['num']]);;
                }
            }else{
                $m=Db::table('shopcar')->insert($post);
                if ($m>0) {
                    session("indexuser.shopgoodsnum",$count+$m);
                }
            }

            return $m;

        }
        
    }


	//购物车列表里商品数量的加减
	public function shopnum(){
		if (!empty(session("indexuser"))) {

			$post=input('post.');
			
			
			$list=Db::table('shopcar')->where("id",$post['shopcarid'])->find();
			$goodlist=Db::table('goods')->where("id",$post['goodid'])->find();


			if ($post['jiajian']=="a") {
				
				
				if ($list['num']==$goodlist['store']) {
					return 9;//商品加购件数(含已加购件数)已超过库存
				}else{
					$m=Db::table('shopcar')->where("id",$post['shopcarid'])->update(['num' => $list['num']+1]);
				}
			}elseif($post['jiajian']=="m"){
				if ($list['num']<=1) {
					return 8;//商品件数最低为1
				}else{
					$m=Db::table('shopcar')->where("id",$post['shopcarid'])->update(['num' => $list['num']-1]);
				}
			}

			return $m;

		}
		

	}

	//购物车信息删除
	public function shopcardel(){
		if (!empty(session("indexuser"))) {
			$id=input('post.shopcarid');
			$m=Db::table("shopcar")->where('id',$id)->delete();
			if ($m>0) {
				$count=session("indexuser.shopgoodsnum");
				session("indexuser.shopgoodsnum",$count-1);
			}
			return $m;
		}
	}


}