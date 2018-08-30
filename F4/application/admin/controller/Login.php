<?php
namespace app\admin\controller;
session_start();
use think\Controller;
use think\Db;


class Login extends controller{

	
	public function login(){
		return view();
	}	
	
	public function dologin(){
		$a=input('post.');
		// echo "<pre>";
		// var_dump($a);die;
		if (!empty($a['username'])){
			$arr=Db::table('rule')->where('username',$a['username'])->select();
			if ($arr) {
				if($arr[0]['state']==1){
					if (!empty($a['pass'])) {
						if(md5($a['pass'])==$arr[0]['pass']){
							if(!empty($a['code'])){

								if ($a['code']==$_SESSION['session_code']) {
									session('adminuser',$arr[0]);
									if(!empty(session('adminuser'))){
										return 66;
									}
								}else{
									return 3;//验证码有误
									die;
								}
							}else{
								return 6;//验证码为空;
								die;
							}
							
						}else{
							return 2;//密码有误
							die;
						}
					}else{
						return 5;//密码为空;
						die;
					}
				}else{
					return 7;//此账号已被冻结,不可登陆
				}
									
			}else{
				return 1;//账号有误
				die;
			}
		}else{
			return 4;//账号为空
			die;
		}
		


	   }
		// var_dump($arr);
		

}