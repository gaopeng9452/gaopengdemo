<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        $list=db('banner')->where('state',1)->select();//查询banner数据
       
        $count=db('goods')->where('state',1)->count();
        if ($count>=9) {
            $goods=db('goods')->where('state',1)->limit(9)->select();
        }else{
            $goods=db('goods')->where('state',1)->select();
        }

        if ($count>=4) {
            $regoods=db('goods')->where('state',1)->limit(4)->order("id desc")->select();
        }else{
            $regoods=db('goods')->where('state',1)->order("id desc")->select();
        }

        foreach ($regoods as $key => $value) {
            $regoods[$key]['images']=explode(",",$value['picname']);
        }

        foreach ($goods as $key => $v) {
            $images[$key]=$v;
            $images[$key]['images']=explode(",",$v['picname']);
        }

        $this->assign("list",$list);
        $this->assign('goods',$goods);
        $this->assign("images",$images);
        $this->assign("regoods",$regoods);
        $this->assign("count",$count);

        return $this->fetch();
    }  

    public function goods(){
    	//搜索
    	$gets=input("get.");//获取搜索框提交的所有值
    	$goodsname=input("get.goodsname");
    	// $this->assign("goods_name",$goods_name);

    	$add=db('goods')->where('good','like',"%$goodsname%")->where("state","1")->select();
    	return view('shangcheng',['goods'=>$add]);
    }

     public function shangcheng(){ 
        
        //分类==============================================================
        $gid=input('get.id');

        //根目录下子类
        if ($gid>0) {
            $gidlist=Db::table('type')->where('pid',$gid)->select();
            $this->assign('gidlist',$gidlist);
        }

        //根目录
        $list=Db::table('type')->where('pid',0)->select();
       
        $wherelist=array();
        foreach ($list as $key => $v) {
            $arr=Db::table('type')->where('pid',$v['id'])->select();
            $wherelist[$v['id']]=$arr;
        }
    	//分类==============================================================

    	
        $name=input('get.good');
        // if(count($name)>1){
        // 	 $goods=db('goods')->where("state","1")->select();
        // }else{
        // 	$goods=db('goods')->where('good','like',"%$name%")->where("state",1)->select();
        // }
        $where="";
        $gid2="";
        $pricewhere="";

        //商品的类型
        if(input('get.id2')!==null){
            $gid2=input('get.id2');
            $where['typeid']=['EQ',"{$gid2}"];
        }

        if(input('get.price')!==null){
            switch (input('get.price')) {
                case '10':
                    // $pricewhere=" price between 0 and 1000 ";
                    // $urllist[]="goods={$_GET['price']}";
                     $pricewhere['price']=['between',"0,1000"]; 
                    break;
                case '20':
                    // $pricewhere=" price between 1000 and 2000 ";
                    // $urllist[]="goods={$_GET['price']}";
                     $pricewhere['price']=['between',"1000,2000"]; 
                    break;
                case '30':
                    // $pricewhere=" price between 2000 and 3000 ";
                    // $urllist[]="goods={$_GET['price']}";
                     $pricewhere['price']=['between',"2000,3000"]; 
                    break;
                case '50':
                    // $pricewhere=" price between 3000 and 5000 ";
                    // $urllist[]="goods={$_GET['price']}";
                     $pricewhere['price']=['between',"3000,5000"]; 
                    break;
                case '51':
                    // $pricewhere=" price>5000 ";
                    // $urllist[]="goods={$_GET['price']}";
                    $pricewhere['price']=['>',"5000"]; 
                    break;
            }
        }
         
        $num=6;
        $pageParam=array();
        $pageParam['query']['state'] = 1;
        $pageParam['query']['good'] = $name;
        $pageParam['query']['price'] = input('get.price');
        if(input('get.id2')!==null){
            $pageParam['query']['typeid'] = input('get.id2');

        }

       

        $goods=Db::table('goods')->where([
        		'state'=>1,
        		'good'  =>  ['like',"%{$name}%"]
        	])->where($where)->where($pricewhere)->paginate($num,false,$pageParam);

        $list2=Db::table('goods')->select();
        foreach ($list2 as $key => $v) {
            $images[]=$v;
            $images[$key]['images']=explode(",",$v['picname']);
        }
        
        $this->assign("images",$images);

       return view("",['wherelist'=>$wherelist,'list'=>$list,'goods'=>$goods,'images'=>$images]);

    }

    public function addshopcar(){
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

}
