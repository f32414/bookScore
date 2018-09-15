<?php

namespace app\admin\model;

use think\Model;
use think\Db;

/**
 * 分类模型
 */
class Cat extends Model
{
  /**
   * 获取所有分类信息
   * @return bool|string  分类数据
   */
  public function getAll()
  {
    $data = Db::name('cat')->select();
    if (!$data) {
      return FALSE;
    }
    return $data;
  }
  /**
   * 检查是否有上传重复书籍
   * @param  string $book_name [书名]
   * @param  string $author    [作者]
   * @return bool            [是否重复上传]
   */
  public function checkBook($book_name, $author)
  {
    $data = Db::table('book')->where('author', '=', $author)->find();
    if (!$data || $data['book_name'] != $book_name) {
      return TRUE;
    }
    return FALSE;
  }
}
