<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Zhuanchangxq extends Controller
{
    public function zhuanchangxq()
    {
    	$goods=db('goods')->where('state',1)->select();
    	$banner=db('banner')->where('state',1)->select();
    	$this->assign('goods',$goods);
    	$this->assign('banner',$banner);
        return $this->fetch();
    }
}
