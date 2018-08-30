<?php

namespace app\admin\controller;
use think\Controller;

class Member extends Controller{

	public function member_add(){
		return view();
	}

	public function member_doadd(){
		$data=['username'=>input('post.username'),'password'=>input('post.pass'),'name'=>input('post.name'),'sex'=>input('post.sex'),'phone'=>input('post.phone'),'addtime'=>time(),'email'=>input('post.email'),'address'=>input('post.address'),'pic'=>input('post.pic')];
		$m=db("users")->insert($data);
		return $m;
	}

	//头像上传
	public function memberupload(){
		$file=request()->file('file');
		// var_dump($file);
		// die;
		$info=$file->move(ROOT_PATH.'public'.DS.'static'.DS.'uploads'.DS.'member');
		if($info){

			//图片名不返回
			//$pic=$info->getFilename();

			//获取文件夹名
			return $str=$info->getSaveName();

		}else{
			echo $file->getError();
		}	 
	}
	
	public function member_search(){
		$name=input("name");
		$m=db("users")->where('name','like',"%$name%")->order('id','desc')->paginate(5);
		$count=db('users')->where('name','like',"%$name%")->count();
		$sex=array('m'=>"男",'w'=>"女");
		return view("member_list",['m'=>$m,'count'=>$count,'sex'=>$sex]);
	}

	public function member_del(){
		$m=db('users')->where('state',1)->order('id','desc')->paginate(5);
		$count=db('users')->count();
		$sex=array('m'=>"男",'w'=>"女");
		return view("",['m'=>$m,'sex'=>$sex,'count'=>$count]);
		return view();
	}

	public function member_edit(){
		return view();
	}

	public function member_kiss(){
		return view();
	}

	public function member_level(){
		return view();
	}

	public function member_list(){
		$m=db('users')->order('id','desc')->paginate(5);
		$count=db('users')->count();
		$sex=array('m'=>"男",'w'=>"女");
		return view("",['m'=>$m,'sex'=>$sex,'count'=>$count]);
	}
	public function member_stop($id){
		$m=db('users')->where("id",$id)->setField('state','2');
		return $m;
	}
	public function member_start($id){
		$m=db('users')->where("id",$id)->setField('state','1');
		return $m;
	}

	public function member_password(){
		return view();
	}

	public function member_show($id){
		$m=db("users")->where("id",$id)->select();
		$sex=array('m'=>"男",'w'=>"女");
		return view("",['m'=>$m,'sex'=>$sex]);

	}

	public function member_view(){
		return view();
	}

	public function level_add(){
		return view();
	}
	public function level_edit(){
		return view();
	}

	public function kiss_add(){
		return view();
	}

	public function kiss_edit(){
		return view();
	}
	
	public function members_password(){
		return view();
	}
	
}