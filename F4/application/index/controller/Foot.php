<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Foot extends Controller{
	
	//商城购买流程1
	public function scgmlc(){
        return $this->fetch();
    }

    //常见问题2
    public function cjwt(){
        return $this->fetch();
    }

	//账户充值3
	public function zhcz(){
	    return $this->fetch();
	}

	//账户提现4
	public function zhtx(){
	    return $this->fetch();
	}

	//支付方式5
	public function zffs(){
	    return $this->fetch();
	}

	//友情链接6
	public function friendlink(){
	    return $this->fetch();
	}

	//公司简介7
	public function gsjj(){
	    return $this->fetch();
	}

	//艺术家入住8
	public function ysjrzz(){
	    return $this->fetch();
	}

	//联系我们9
	public function contact(){
	    return $this->fetch();
	}

	//加入我们10
	public function jrwm(){
	    return $this->fetch();
	}

	//物流说明11
	public function wlsm(){
	    return $this->fetch();
	}

	//免责声明12
	public function mzsm(){
	    return $this->fetch();
	}
}
