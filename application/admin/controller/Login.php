<?php

namespace app\admin\controller;

use think\Controller;
use think\URL;
use app\admin\model\Adminuser;

/**
 * 登陆模块
 */
class Login extends Controller
{
  /**
   * 登陆页面
   */
  public function index()
  {
    return $this->fetch();
  }
/**
 * 登陆验证
 */
  public function login()
  {
    $model = new Adminuser();
    $username = isset($_POST['username'])?$_POST['username']:"";
    $password = isset($_POST['password'])?$_POST['password']:"";
    $result = $model->checkAdmin($username,$password);
    if (!$result) {
      $this->error('用户名或密码错误！','admin/login/index');
    }
    $this->success('登陆成功！','admin/book/index');
  }
}
