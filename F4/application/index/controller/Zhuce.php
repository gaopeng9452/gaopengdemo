<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use app\index\validate\User;

class Zhuce extends Controller{
 
    //注册主页面
    public function zhuce()
    {
        return $this->fetch();
    }

    //手机验证
    public function telcode(){
        $phone=input('post.phone');
    	$telcode=rand(pow(10,(6-1)), pow(10,6)-1);
        Session::set('telcode',$telcode);
        // echo $telcode."<br>";
        // echo $phone."<br>";
        // echo Session::get('telcode')."<br>";
    	


        $host = "https://fesms.market.alicloudapi.com";//api访问链接
         $path = "/sms/";//API访问后缀
         $method = "GET";
         $appcode = "34fc6ac47a09468dbde31be2d3e0b152";//替换成自己的阿里云appcode
         $headers = array();
         array_push($headers, "Authorization:APPCODE " . $appcode);
         $querys = "code={$telcode}&phone={$phone}&skin=1";  //参数写在这里, 自定义skin编号请找客服申请
         $bodys = "";
         $url = $host . $path . "?" . $querys;//url拼接

         $curl = curl_init();
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($curl, CURLOPT_FAILONERROR, false);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($curl, CURLOPT_HEADER, false);
         if (1 == strpos("$".$host, "https://"))
         {
             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
             curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
         }
         echo(curl_exec($curl));
    	
   	}

    //注册协议    
    public function zcxy(){
        return $this->fetch();
    }

    //判断执行注册
    public function doregister(){
    
        $addtime=time();
        $list=input('post.');
        $data=[
            'username'=>$list['username'],
            'name'=>$list['name'],
            'password'=>$list['password'],
            'email'=>$list['email'],
            'phone'=>$list['phone'],
        ];

        $validate = new User();
        $result   = $validate->check($data);
        if(!$result){
            //返回错误信息
            return $validate->getError();
        }else{
            //判断账号是否已在数据库存在(是否重复)
            $a=Db::table('users')->where('username',$list['username'])->find();
            if ($a>0) {
                return "账户名已存在";
            }else{
                 //判断手机验证码
                if ($list['telcode']==Session::get('telcode')) {
                    //判断两次密码是否一样
                    if ($list['password']==$list['repassword']) {
                         //判断验证码
                        if ($list['yzm']==$_SESSION['session_code']) {
                            $m=Db::table('users')->insert([
                                'username'=>$list['username'],
                                'password'=>md5($list['password']),
                                'name'=>$list['name'],
                                'sex'=>$list['sex'],
                                'phone'=>$list['phone'],
                                'email'=>$list['email'],
                                'addtime'=>$addtime,
                            ]);
                            return $m;
                        }else{
                            return "验证码不对";
                        }
                        
                    }else{
                        return "两次密码不一致";
                    }
                }else{
                    return "手机验证有误";
                   
                }
                
            }
            
        }

    }
}
