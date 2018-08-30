<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Yishujia extends Controller
{
    public function yishujia()
    {
        return $this->fetch();
    }
}
