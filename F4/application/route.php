<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    'home'=>'index/index/index',
    'zhuanchang'=>'index/zhuanchang/zhuanchang',
    'shopindex'=>'index/shangcheng/shopindex',//商城主页面
    'shangcheng'=>'index/index/shangcheng',
    'yishujia'=>'index/yishujia/yishujia',
    'zhuce'=>'index/zhuce/zhuce',
    'denglu'=>'index/denglu/denglu',//登陆页面
    'zhuanchangxq'=>'index/zhuanchangxq/zhuanchangxq',
    'yishujiaxq'=>'index/yishujiaxq/yishujiaxq',//艺术家详情
    'shangpinxq'=>'index/shangpinxq/shangpinxq',//商品详情
    'jiesuan'=>'index/jiesuan/jiesuan',//结算页面
    'fukuan'=>'index/fukuan/fukuan',//付款页面
    'gerenxinxi'=>'index/gerenxinxi/gerenxinxi',//个人信息
    'wddingdan'=>'index/wddingdan/wddingdan',//我的订单
    'sqshouhou'=>'index/sqshouhou/sqshouhou',//申请售后
    'pjshaidan'=>'index/pjshaidan/pjshaidan',//评价晒单
    'pjshaidanpj'=>'index/pjshaidanpj/pjshaidanpj',//评价晒单的评价商品
    'shopcar'=>'index/shopcar/shopping',//购物车
    'letter'=>'index/letter/znx',//收件
    'write'=>'index/letter/xiexin',//写信
     'myquestion'=>'index/myquestion/zixun',//我的咨询
    'exitrecode'=>'index/exitrecode/lljl',//退货记录
    'shippingaddress'=>'index/gerenxinxi/shippingaddress',//收货地址
    'shippingaddress1'=>'index/gerenxinxi/shippingaddress1',
    'addressdel'=>'index/gerenxinxi/address_del',//删除地址    
    'address'=>'index/gerenxinxi/address',//增加地址
    'set'=>'index/gerenxinxi/set',//设置默认地址
    'editaddress'=>'index/gerenxinxi/editaddress',//修改地址
    'favorite'=>'index/favorite/favorite',//我的收藏
    'interest'=>'index/interest/interest',//我的关注
    'changepassword'=>'index/gerenxinxi/changepassword',//修改密码
    'remainingsum'=>'index/remainingsum/remainingsum',//账户余额
    'recharge'=>'index/recharge/recharge',//在线充值
    'drawings'=>'index/drawings/drawings',//我要提现
    'register'=>'index/zhuce/register',//注册执行
    'logon'=>'index/denglu/logon',//登录执行
    'unlogon'=>'index/denglu/unlogon',//执行退出
    'doregister'=>'index/zhuce/doregister',//注册执行(判断表单提交的所有数据和数据库的users添加)
    'edit'=>'index/gerenxinxi/edit',//个人信息(显示)
    'update'=>'index/gerenxinxi/update',//个人信息(可修改)
    'photo'=>'index/gerenxinxi/photo',//头像(可修改)
    'addphoto'=>'index/gerenxinxi/addphoto',//头像(可修改)
    'password'=>'index/gerenxinxi/password',//修改密码
    'bigprice2'=>'index/shopcar/bigprice2',//商品详情里的数量+ -
    'addshopcar2'=>'index/shopcar/addshopcar2',//商品详情里加入购物车
    'addshopcar'=>'index/index/addshopcar',//商城列表里加入购物车
    'quitaddress'=>'index/jiesuan/quitaddress',//生成订单中省级联动
    'quitaddress1'=>'index/jiesuan/quitaddress1',//生成订单中添加地址




];
