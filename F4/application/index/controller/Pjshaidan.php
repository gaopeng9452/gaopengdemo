<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Pjshaidan extends Controller
{
    public function pjshaidan()
    {
        return $this->fetch();
    }
}
