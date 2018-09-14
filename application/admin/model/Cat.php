<?php

namespace app\admin\model;

use think\Model;
use think\Db;

/**
 * 分类模型
 */
class Cat extends Model
{
  public function getAll()
  {
    $data = Db::name('cat')->select();
    if (!$data) {
      return FALSE;
    }
    return $data;
  }
  public function checkBook($book_name, $author)
  {
    $data = Db::table('book')->where('author', '=', $author)->find();
    if (!$data && $data['book_name'] != $book_name) {
      return TRUE;
    }
    return FALSE;
  }
}
