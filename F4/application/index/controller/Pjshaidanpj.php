<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Pjshaidanpj extends Controller
{
    public function pjshaidanpj()
    {
        return $this->fetch();
    }
}
