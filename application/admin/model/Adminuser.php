<?php

namespace app\admin\model;

use think\Model;
use think\Db;

/**
 * 管理员模型
 */
class Adminuser extends Model
{
  public function checkAdmin($username, $password)
  {
    $data = Db::table('adminuser')->where('username', '=', $username)->find();
    if (!$data || $data['password'] != $password) {
      return FALSE;
    }
    return $data['id'];
  }
}
