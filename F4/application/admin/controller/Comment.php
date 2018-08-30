<?php

namespace app\admin\controller;
use think\Controller;

class Comment extends Controller{
	public function comment_list(){
		$comment=db('comment')->select();
		// var_dump($comment);
		$this->assign("comment",$comment);
		$add=db('address')->select();
		// var_dump($add);
		$this->assign("add",$add);
		$good=db('goods')->select();
		// var_dump($good);
		$this->assign("good",$good);
		return $this->fetch();
	}
	public function comment_edit(){

		$comment=db('comment')->where('id',input('id'))->find();
		$this->assign("comment",$comment);
		$user=db('address')->where('pid',$comment['uid'])->find();
		$this->assign("user",$user);

		$good=db('goods')->select();
		$this->assign("good",$good);

		//查看回复
		$boss=db('comment')->find('id');
		$this->assign("boss",$boss);

		return $this->fetch();
	}
	public function comment_edits(){
		$ss=db('comment')->where('id',input('id'))->setField('boss',input('huifu'));
		return $ss;

	}
	public function feedback_list(){
		return view();
	}

	public function feedback_edit(){
		return view();
	}
}