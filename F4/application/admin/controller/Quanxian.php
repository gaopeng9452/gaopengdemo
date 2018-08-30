<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use \auth\Auth;
use think\Db;

session_start();

class Quanxian extends Controller{

	public function __construct(){
		if(empty(session('adminuser'))){
			$this->redirect('admin/login/login');
		}

		
		// $auth=new Auth();
		// $mod=request()->module();
		// $con=request()->controller();
		// $act=request()->action();
		// $str=$mod."/".$con.'/'.$act;
		// if (!$auth->check($str,session("adminuser"))) {
		// 	$this->redirect('admin/login/login');
		// }

	}

}





?>