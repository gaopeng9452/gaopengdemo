<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Shangpinxq extends Controller
{
    public function shangpinxq(){
    	$goodid=input('get.id');
    	$goodlist=Db::table('goods')->where('id',$goodid)->find();
    	$a=$goodlist['picname'];
		$imgname=explode(",",$a);

		$typeid=$goodlist['typeid'];
		$typegood=Db::table('goods')->where('typeid',$typeid)->select();
		foreach ($typegood as $key => $v) {
            $typeimg[$key]=$v;
            $typeimg[$key]['images']=explode(",",$v['picname']);
        }
       	
       	
       	$endnum=3;
       	$count=Db::table('goods')->where('typeid',$typeid)->count();
       	if ($count<$endnum) {
       		$endnum=$count;
       	}else{
       		$endnum=3;
       	}
      
       	$endnum=(string)$endnum;
    
       	$fornum=0;
    	$comment=db('comment')->select();
        $this->assign("com",$comment);
        $user=db('users')->select();
        $this->assign("user",$user);
        return view("shangpinxq",['goodlist'=>$goodlist,'imgname'=>$imgname,'typegood'=>$typegood,'typeimg'=>$typeimg,'fornum'=>$fornum,'endnum'=>$endnum]);
    }
}
