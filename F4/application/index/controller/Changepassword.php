<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Changepassword extends Controller
{
    public function changepassword()
    {
        return $this->fetch();
    }
}