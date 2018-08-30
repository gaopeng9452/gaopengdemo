<?php
namespace app\index\validate;
use think\validate;

class User extends validate{
	protected $rule = [
       'username|用户名'  =>  'require|max:12|min:6',
       'email|邮箱' =>  'require|email|max:50',
       'name|姓名'=>'require|max:30',
       // 'code|邮编'=>'require|max:6|min:6|number',//这里是邮编不是验证码
       'password|密码'=>'require|max:15|min:6'

	];

	protected $msg = [
	   'username.require' => '用户名不能为空',
	   'username.max'     => '用户名最多不能超过12个字符',
	   'username.min'   => '用户名不能少于6个字符',
	   'email.require'  => '邮箱不能为空',
	   'email'        => '邮箱格式错误',
	   'email.max'        => '输入过长,请输入正确的邮箱',
	   'name.require'=>'姓名不能为空',
	   'name.max'=>'输入过长,请输入正确的姓名',
	   'code.require'=>'邮政编码不能为空',
	   'code.max'=>'邮编长度不对',
	   'code.min'=>'邮编长度不对',
	   'code.number'=>'请输入正确的邮编',
	   'pass.require'=>'密码不能为空',
	   'pass.max'=>'密码长度不能大于15',
	   'pass.min'=>'密码长度不能小于6',
	];


}