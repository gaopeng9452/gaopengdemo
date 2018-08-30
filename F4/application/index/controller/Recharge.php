<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Recharge extends Controller
{
    public function recharge()
    {
        return $this->fetch();
    }
}