<?php

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;


class Banner extends Controller{

	//添加
	public function banner_add(){
		return view();
	}

	//执行添加
	public function doadd(){
		// 获取表单上传文件
		// var_dump(input('post.'));
		$addtime=date("Y-m-d H:i:s",time());
		
		$data=['pic'=>input('post.pic'),'dump'=>input('post.link'),'descr'=>input('desc'),'state'=>input('post.state'),'addtime'=>$addtime];
		// var_dump($data);
		$m=Db::table('banner')->insert($data);
		return $m;
	}


	//banner图片上传
	public function bannerupload(){
		$file=request()->file('file');
		// var_dump($file);
		// die;
		$info=$file->move(ROOT_PATH.'public'.DS.'static'.DS.'uploads'.DS.'banner');
		if($info){

			//图片名不返回
			//$pic=$info->getFilename();

			//获取文件夹名
			return $str=$info->getSaveName();

		}else{
			echo $file->getError();
		}	 
	}

	//状态关闭
	public function bannerstop($id){
		$m=db('banner')->where('id',$id)->update(['state'=>'2']);
		return $m;
		// return $id;
	}
	//状态开启
	public function bannerstart($id){
		$m=db('banner')->where('id',$id)->update(['state'=>'1']);
		return $m;
		// return $id;
	}

	//删除
	public function banner_del($id){
		$list=Db::table('banner')->where('id',$id)->find();
		// var_dump($list);
		// var_dump($list['pic']);
	
		$m=Db::table('banner')->where('id',$id)->delete();

		if ($m>0) {
			if (is_file("static/uploads/banner/{$list['pic']}")) {
	            unlink("static/uploads/banner/{$list['pic']}");
	        }
		}
		// var_dump($m);
		return $m;
	}

	//修改
	public function banner_edit($id){
		$list=Db::table('banner')->where('id',$id)->find();
		$this->assign('list',$list);
		return $this->fetch();
	}

	//执行修改
	public function doedit(){
		//数据库原来未修改前的信息
		$list=Db::table('banner')->where('id',input('post.id'))->find();
		

		//数据库要执行修改的新信息
		$data=['id'=>input('post.id'),'pic'=>input('post.pic'),'dump'=>input('post.link'),'descr'=>input('desc'),'state'=>input('post.state')];
		
		if (empty($data['dump'])) {
			return 2;//连接不能为空
			die;
		}elseif(empty($data['descr'])){
			return 3;//描述不能为空
			die;
		}	
		$m=Db::table('banner')->update($data);
		if($m>0 && $list['pic']!==$data['pic']){
			if (is_file("static/uploads/banner/{$list['pic']}")) {
	            unlink("static/uploads/banner/{$list['pic']}");
	        }
		}

	
		return $m;
	
	}

	//查看所有banner
	public function banner_list(){
		$list=db('banner')->order('id desc')->paginate(2);
		$this->assign("list",$list);
		$count=$list->total();
		$this->assign("count",$count);
		return view();

	}
}