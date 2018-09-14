<?php

namespace app\admin\model;

use think\Model;
use think\Db;

/**
 * 书籍模型
 */
class Book extends Model
{
  /**
   * 添加书籍
   * @param string $book_name [书名]
   * @param string $author    [作者]
   * @param string $info      [简介]
   * @param string $status    [状态]
   * @param string $cat       [分类]
   * @param string $img       [封面]
   */
  public function add($book_name, $author, $info, $status, $cat, $img)
  {
    $data = [
      'book_name' => $book_name,
      'author' => $author,
      'info' => $info,
      'img' => $img,
      'create_time' => time(),
      'status' => $status,
      'cat_id' => $cat
    ];
    $result = Db::name('book')->insert($data);
    if (!$result) {
      return FALSE;
    }
    return TRUE;
  }
}
