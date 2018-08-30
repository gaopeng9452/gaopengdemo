<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class favorite extends Controller
{
    public function favorite()
    {
        return $this->fetch();
    }
}