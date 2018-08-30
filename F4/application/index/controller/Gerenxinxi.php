<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Gerenxinxi extends Controller
{
    // 获取个人信息
    public function gerenxinxi()
    {
    	// $abc=input('username');
    	$abc=session('indexuser');//获取登陆的所有数据
        // dump($abc);
    	$list=db('users')->where('username',$abc['username'])->find();//对比数据
        // dump($list);
    	$this->assign("list",$list);

        return $this->fetch();
    }
    //修改信息
    public function update(){
    	$stu=db("users")->where('id',input('id'))->update([
	    		'name'=>input('name'),
	    		'sex'=>input('sex'),
	    		'phone'=>input('phone'),
	    		'email'=>input('email'),
	    		'address'=>input('address')
    		]);
    	// var_dump($stu);
    	// var_dump(input('post.'));
    	if($stu>0){
			return "修改成功!";
		}else{
            return "修改失败!";
        }
		// $this->assing("stu",$stu);
    }
    //修改头像
    public function photo(){
        $file=request()->file('file');
      
        $info=$file->move(ROOT_PATH.'public'.DS.'static'.DS.'uploads'.DS.'member');
        if($info){

            //图片名不返回
            //$pic=$info->getFilename();

            //获取文件夹名
            return $info->getSaveName();

        }else{
            return  $file->getError();
        }    
    }
  public function addphoto(){
        // 获取表单上传文件

        $data=input('post.');

        //表单提交的图片名字
        $picname=$data['pic'];

        $list=db('users')->where('id',$data['id'])->find();//对比数据
        
        $m=Db::table('users')->update($data);
        if ($m>0) {
            if (is_file("static/uploads/member/{$list['pic']}")) {
                unlink("static/uploads/member/{$list['pic']}");
            }
        }
        return $m;
    }
    public function password(){
        
        if(md5(input('old'))==input('oldpass')){
            if(input('new')==input('new2')){
                if(strlen(input('new'))>=6){
                  $m=db('users')->where("id",input("id"))->update([
                     'password'=>md5(input('new')),
                    ]);
                    if($m>0){
                         Session("indexuser",null);
                        return 1;
                       
                    }//修改成功
                }else{
                    return 3;//限制密码长度
                }
            }else{
                return 2;//新密码两次不一致
            }
        }else{
            return 4;//原密码错误
        }
        return view("changepassword");
    }
    public function changepassword()
    {
        return view();
        
    }
    public function shippingaddress(){
        $select=db('address')->where('pid',Session::get('indexuser.id'))->select();
        // dump($select);
        return $this->fetch("",['select'=>$select]);
    }
    public function shippingaddress1(){
        $upid=input('upid');
        $m=db('district')->where('upid',$upid)->select();
        // var_dump($m);
      return $m;
    }
    public function address(){
        
        $data=['pid'=>input('pid'),'username'=>input('username'),'address1'=>input('alladdress'),'postcode'=>input('postcode'),'phone'=>input('phone')];
        
             $m=db('address')->insert($data);
             return 1; 
    }
    public function address_del(){
        $id=input('post.id');
        $m=db('address')->where('id',$id)->delete();
        return $m;
    }
    //设置默认地址
    public function set(){
        $id=input('post.id');
          db('address')->where('state',1)->where('pid',Session::get('indexuser.id'))->update(['state'=>2]);   
        $m=db('address')->where('id',$id)->update(['state'=>1]);       
        return $m;
    }
    //编辑地址
    public function editaddress(){
         $select=db('address')->where('pid',Session::get('indexuser.id'))->select();
         $id=$_GET['id'];
         $m=db('address')->where('id',$id)->select();
    
        return $this->fetch("",['select'=>$select,'m'=>$m]);

    }
    public function edit(){
        $id=input('id');
        $data=['username'=>input('username'),'phone'=>input('phone'),'address1'=>input('alladdress'),'postcode'=>input('postcode')];
        $m=db('address')->where('id',$id)->update($data);
        return $m;
    }


}
