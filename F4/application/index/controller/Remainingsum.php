<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Remainingsum extends Controller
{
    public function remainingsum()
    {
        return $this->fetch();
    }
}