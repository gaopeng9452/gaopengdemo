<?php
namespace app\admin\controller;
use think\Request;
use think\Controller;
use think\Db;
class Shop extends Controller{


	//商品图片上传
	public function pic(){
		
    	// 获取表单上传文件
	    $files = request()->file('images');
	    $pic=array();
	    foreach($files as $file){
	        // 移动到框架应用根目录/public/uploads/ 目录下
	       	$info=$file->move(ROOT_PATH.'public'.DS.'static'.DS.'uploads'.DS.'goods');

	        if($info){
	          	$pic[]=$info->getSaveName(); 
	        }else{
	            // 上传失败获取错误信息
	            return $file->getError();
	        }
	    }

        return $pic;

	}


	//添加商品
	public function cate_add(){
		$typelist=Db::table('type')->order('concat(path,id)')->select();
		$arr=array();
		
		$nbsp="&nbsp;&nbsp;&nbsp;";
		

		$a=array();
		foreach ($typelist as $key => $v) {
			$num[]=Db::table('type')->field("count(*) as num")->where('pid',$v['id'])->select();

		}
		foreach ($num as $k => $v) {
			foreach ($v as $key => $value) {
				$a[$k]=$value;
			}
		}
		$this->assign("num",$a);
		$this->assign('typelist',$typelist);
		$this->assign("nbsp",$nbsp);
		// dump($a);
		return view();
	}

	//商品执行添加
	public function cate_doadd(){
		$time=date("Y-m-d H:i:s",time());
		$a=Request::instance()->post();
		// var_dump($a);die;
		$a['addtime']=$time;
		$str=$a['picname'];
		$aa=rtrim($str,'"]');
		$b=ltrim($aa,'["');
		// var_dump($b);
		$m=db("goods")->insert([
			// 'typeid'=>$a['typeid'],
			'good'=>$a['good'],
			'descr'=>$a['descr'],
			'price'=>$a['price'],
			'picname'=>$b,
			'store'=>$a['store'],
			'addtime'=>$a['addtime'],
			'company'=>$a['company'],
			'typeid'=>$a['typeid']
		]);
	    return $m;
	}

	//商品首页展示
	public function cate_list(){
		$list=db('goods')->field('goods.*,type.name')->join('type','goods.typeid=type.id','left')->order('goods.id desc')->paginate(5);
		$count=$list->total();
		$this->assign("list",$list);
		$this->assign("count",$count);
		return view();
		// $list=db('goods')->join('type','goods.typeid=type.id','left')->order('id desc')->select();
		// dump($list);
	}


	public function category(){
		return view();
	}

	//修改商品(1)
	public function cate_edit($id){
	
		$list=Db::table('goods')->where('id',$id)->find();
		// var_dump($list);die();
		// var_dump($list);
		$typelist=Db::table('type')->order('concat(path,id)')->select();
		$arr=array();
		
		$nbsp="&nbsp;&nbsp;&nbsp;";
		

		$a=array();
		foreach ($typelist as $key => $v) {
			$num[]=Db::table('type')->field("count(*) as num")->where('pid',$v['id'])->select();
			
		}
		foreach ($num as $k => $v) {
			foreach ($v as $key => $value) {
				$a[$k]=$value;
			}
		}
		$this->assign("num",$a);
		$this->assign('typelist',$typelist);
		$this->assign("nbsp",$nbsp);

		$this->assign('list',$list);
		return $this->fetch();
	}
	//修改商品(2)
	public function cate_update(){
		$a=input("post.");
		$str=$a['picname'];
		$aa=rtrim($str,'"]');
		$b=ltrim($aa,'["');
		$a['picname']=$b;
		$m=db("goods")->update($a);
		return $m;
	}
	public function cate_del($id){
		$rule=db("goods")->where("id",$id)->delete();
		return $rule;
	}

	public function cate_stop($id){
       
        $m=db("goods")->where('id',$id)->update(['state'=>'2']);
        return $m;

    }
    //管理员 的启用  
    public function cate_start($id){
       
        $m=db("goods")->where('id',$id)->update(['state'=>'1']);
        return $m;

    }

		
	
}