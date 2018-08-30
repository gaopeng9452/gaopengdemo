<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Type extends Controller{
	//查看页面
	public function type_list(){
		$typelist=Db::table('type')->order('concat(path,id)')->select();
		$this->assign('typelist',$typelist);
		$num=50;
		// ==================================================================================
		$fenlei=input('get.fenlei');
		$name=input('get.name');
		$pageParam=array();
		$pageParam['query']['name'] = $name;
		$pageParam['query']['id'] = $fenlei;

		if (!empty($fenlei) && empty($name)) {
			$list=db("type")->where('id',$fenlei)->order('concat(path,id)') ->paginate($num,false,$pageParam);
		}
		if (empty($fenlei) && !empty($name)) {
			$list=db("type")->where("name","like","%{$name}%")->order('concat(path,id)')->paginate($num,false,$pageParam);
		}
		if (!empty($fenlei) && !empty($name)) {
			$list=db("type")->where("name","like","%{$name}%")->where("id","=","{$fenlei}")->order('concat(path,id)')->paginate($num,false,$pageParam);
		}
		if (empty($fenlei) && empty($name)) {
			$list=Db::table('type')->order('concat(path,id)')->paginate($num,false);
		}
		//=============================================================================================

		$this->assign("list",$list);

		$count=$list->total();
		$this->assign("count",$count);
		
		$nbsp="&nbsp;&nbsp;&nbsp;";
		$this->assign("nbsp",$nbsp);

		return $this->fetch();	
	}

	//添加
	public function type_add($id){

		// 初始化父类信息
	    $pname="根类别";//定义输出的父类名
	    $pid=0;//定义父类的pid
	    $path="0,";//定义父类的path

	    //判断是否是添加子类
        //查询要添加子类的父类所有信息
      	$m=Db::table("type")->where('id',$id) ->find();
        if($m){
            //重新定义输出的父类名称
            $pname=$m['name'];
            //重新定义子类的父id
            $pid=$m['id'];
            //重新定义子类的path
            $path=$m['path'].$pid.",";
        }
		
		$this->assign("pname",$pname);
		$this->assign("pid",$pid);
		$this->assign("path",$path);
		return view();
	}
	//执行添加
	public function typedoadd(){
		$list=input("post.");
		$arr=Db::table('type')->where('name',$list['name'])->find();
		if ($arr>0) {
			return 2;
			die;
		}
		$m=Db::table("type")->insert($list);
		return $m;
	}
	
	//修改
	public function type_edit($id){
		$m=Db::table("type")->where('id',$id) ->find();
		$pname="跟分类";
		if ($m['pid']!=0) {
		    $parr=Db::table("type")->where('id',$m['pid']) ->find();
		    $pname=$parr['name'];
		}

		$this->assign("pname",$pname);
		$this->assign("name",$m['name']);
		$this->assign("id",$m['id']);
		return view();
	}
	//执行修改
	public function type_doedit(){
		$info=input('post.');
		$arr=Db::table('type')->where('name',$info['name'])->find();
		if ($arr>0) {
			return 2;
			die;
		}
		$m=Db::table('type')->update($info);
		return $m;

	}

	//删除
	public function type_del($id){
		
		$arr1=Db::table("type")->where('pid',$id) ->count();
		// var_dump($arr1);

		$arr2=Db::table("goods")->where('typeid',$id) ->count();
		

		if ($arr1>0) {
			return 2;//此分类下有子类 不可以删除
			die;
		}

		if ($arr2>0) {
			return 3;//此分类下有商品 不可以删除
			die;
		}

		$m=Db::table('type')->where('id',$id)->delete();
		if ($m>0) {
			return 1;//删除成功
		}else{
			return 0;//删除失败
		}
	}

	//状态停用
	public function type_stop(){
		$m=db('type')->where('id',input('post.id'))->update(['state'=>'2']);
		return $m;
	}

	//状态开启
	public function type_start(){
		$m=db('type')->where('id',input('post.id'))->update(['state'=>'1']);
		return $m;
	}

}