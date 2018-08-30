<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Drawings extends Controller
{
    public function drawings()
    {
        return $this->fetch();
    }
}