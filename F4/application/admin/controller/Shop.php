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
		// var_dump($b);die();
		$c=str_replace('"','',$b);
		// var_dump($c);die();
		$m=db("goods")->insert([
			// 'typeid'=>$a['typeid'],
			'good'=>$a['good'],
			'descr'=>$a['descr'],
			'price'=>$a['price'],
			'picname'=>$c,
			'store'=>$a['store'],
			'addtime'=>$a['addtime'],
			'company'=>$a['company'],
			'typeid'=>$a['typeid']
		]);
	    return $m;
	}

	//商品首页展示
	public function cate_list(){
		$good=input("get.good");
		$pageParam=array();
		$pageParam['query']['good'] = $good;

		$num=6;
		$list=db('goods')->field('goods.*,type.name')->join('type','goods.typeid=type.id','left')->where('goods.good','like',"%$good%")->order('goods.id desc')->paginate($num,"",$pageParam);
		$count=$list->total();
		$images=array();
		// $images['id']['images']="";
		$list2=Db::table('goods')->select();
		foreach ($list2 as $key => $v) {
			$images[]=$v;
			$images[$key]['images']=explode(",",$v['picname']);
		}
		
		$this->assign("images",$images);
		$this->assign("list",$list);
		$this->assign("count",$count);
		return view();
		
	}


	public function category(){
		return view();
	}

	//修改商品(1)
	public function cate_edit($id){
	
		$list=Db::table('goods')->where('id',$id)->find();
		$a=$list['picname'];
		$b=explode(",",$a);
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
		$this->assign('b',$b);
		return $this->fetch();
	}
	//修改商品(2)
	public function cate_update(){

		$a=input("post.");
		$time=date("Y-m-d H:i:s",time());
		$a['edittime']=$time;
		//数据库里的东西
		$list=Db::table('goods')->where('id',$a['id'])->find();
		$aa=$list['picname'];
		$bb=explode(",",$aa);

		//表单提交过来的东西
		$str=$a['picname'];
		$a2=rtrim($str,'"]');
		$b=ltrim($a2,'["');
		$c=str_replace('"','',$b);
		$a['picname']=$c;

		
		//执行数据库修改
		$m=db("goods")->update($a);

		if ($m>0 && $list['picname']!==$a['picname']) {
		
			foreach ($bb as $key => $v) {
				if (is_file("static/uploads/goods/{$v}")) {
					unlink("static/uploads/goods/{$v}");
				}
			}
		}
		return $m;
	}
	public function cate_del($id){

		$list=Db::table('goods')->where('id',$id)->find();
		$a=$list['picname'];
		$b=explode(",",$a);

		$rule=db("goods")->where("id",$id)->delete();
		if ($rule>0) {
			foreach ($b as $key => $v) {
				if (is_file("static/uploads/goods/{$v}")) {
					unlink("static/uploads/goods/{$v}");
				}
			}
		}
		
		
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

    //商品信息查看
    public function goods_show($id){
 
    	$list=db('goods')->field('goods.*,type.name')->join('type','goods.typeid=type.id','left')->where("goods.id",$id)->find();

    	$a=$list['picname'];
		$imgname=explode(",",$a);
		
   
    	return view("goods_show",['list'=>$list,'imgname'=>$imgname]);

    }
	public function order_list(){
		//查看订单表
		$order=db('order')->select();
		$this->assign("order",$order);
		//查看地址表
		$add=db('address')->select();
		$this->assign("add",$add);
		//查看商品表
		$good=db('goods')->select();
		$this->assign("good",$good);
		return view();


	}
	public function order(){
		$m=db("order")->where('id',input("id"))->update(['state'=>2]);
		return $m;
	}

	
}