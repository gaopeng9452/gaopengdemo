<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Admin extends Controller{


	public function admin_add(){
		return view();
	}


	public function admin_cate(){
		return view();
	}

	//管理员添加
	public function admin_doadd(){
		$time=date("Y-m-d H:i:s",time());
		$a=Request::instance()->post(); 

		$a['pass']=md5($a['pass']);

		unset($a['repass']);
		$a['addtime']=$time;
		$list=db('rule')->where('username',$a['username'])->find();
		if($list>0){
			return 2;//账号已存在
		}else{
			$m=db("rule")->insert($a);
	    	return $m;
		}
    	
	}

	//管理员修改查询
	public function admin_edit($id){
		 $rule=db("rule")->find($id);
    	 $this->assign("rule",$rule);
    	 return $this->fetch();
		return view();
	}
	//删除
	public function admin_del($id){
		$rule=db("rule")->where("id",$id)->delete();
		return $rule;
		

	}


	//管理员显示
	public function admin_list(){
		
		$username=input('get.username');
		$role=input('get.role');
		$pageParam=array();
		$pageParam['query']['role'] = $role;
		$pageParam['query']['username'] = $username;


		$num=5;

	
		if (!empty($role) && empty($username)) {
			$list=db("rule")->where('role',$role)->order('id','desc') ->paginate($num,false,$pageParam);
		}
		if (empty($role) && !empty($username)) {
			$list=db("rule")->where("username","like","%{$username}%")->order('id','desc') ->paginate($num,false,$pageParam);
		}
		if (!empty($role) && !empty($username)) {
			$list=db("rule")->where("username","like","%{$username}%")->where("role","=","{$role}")->paginate($num,false,$pageParam);
		}
		if (empty($role) && empty($username)) {
			$list=db("rule")->order('id','desc') ->paginate($num,false);
		}
	
		
		$this->assign("list",$list);
		$count=$list->total();
		$this->assign("count",$count);

		return view();
	}
	//修改
	public function admin_update()
    {
        //接收数组
        $s=input('post.');
        $i=db('rule')->find($s['id']);
        // echo "<pre>";
        // var_dump($s);die;
        if ($s==$i){
        	return 2;
        }else{
        	$m=db("rule")->update($s);
        	return $m;
        }


      
        
    }

    //修改密码
    public function admin_updatemima(){
    	$list=session('adminuser');
    	$info=input('post.');
    	$rule=db("rule")->where('id',$list['id'])->find();
    	
    	if ($rule['pass']==md5($info['oldpass'])) {
    		$m=db('rule')->where('id',$list['id'])->update(['pass' => md5($info['pass'])]);
    		if ($m>0) {
    			return 1;//修该成功
    		}else{
    			return 3;//修该失败
    		}
    	}else{

    		return 2;//原密码不对

    	}


    }

     //管理员 的禁用
    public function admin_stop($id){
       
        $m=db("rule")->where('id',$id)->update(['state'=>'2']);
        return $m;

    }
    //管理员 的启用  
    public function admin_start($id){
       
        $m=db("rule")->where('id',$id)->update(['state'=>'1']);
        return $m;

    }


	public function admin_role(){
		return view();
	}


	public function admin_rule(){
		return view();
	}


	public function role_add(){
		return view();
	}


	public function role_edit(){
		return view();
	}


	public function cate_edit(){
		return view();
	}

}