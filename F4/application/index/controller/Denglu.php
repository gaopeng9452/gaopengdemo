<?php
namespace app\index\controller;


use think\Controller;
use think\Db;
class Denglu extends Controller
{
    public function denglu()
    {
        return $this->fetch();
    }
    public function logon(){
    	$a=input('post.');

		if (!empty($a['username'])){
			$arr=Db::table('users')->where('username',$a['username'])->select();
			// print_r($arr);
			// die();
			if ($arr){
				if ($arr[0]['state']==1) {
					if (!empty($a['password'])){
						if(md5($a['password'])==$arr[0]['password']){
							session('indexuser',$arr[0]);
							
							
							$count=Db::table('shopcar')->where(["userid"=>session('indexuser.id')])->count();
							
							session("indexuser.shopgoodsnum",$count);
							return 1;//全部正确		
							
						}else{
							return 2;//密码有误	
						}
					}else{
						return 3;//密码为空;
					
					}
					
				}else{
					return 6;//账号没有登陆权限
				}
				
						
			}else{
				return 4;//账号有误
			}
		}else{
			return 5;//账号为空
			
		}
    }
    public function unlogon(){
    	session('indexuser',null);
    	$this->redirect('/home');
        // header("location:index.html");
    }
 
}
