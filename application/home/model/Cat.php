<?php

namespace app\home\model;

use think\Model;
use think\Db;
use app\home\model\Book;

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
    // 获取分类下打分前十
    foreach ($data as $k => $v) {
      $data[$k]['book'] = $this->getTen($v['cat_id']);
    }
    return $data;
  }
  /**
   * 获取评分前十
   * @param  integer $cat_id [分类ID]
   * @return array         [前十书籍]
   */
  public function getTen($cat_id)
  {
    $data = Db::name('book')
        ->where('cat_id', '=', "{$cat_id}")
        ->select();
    $book = new Book();
    foreach ($data as $k => $v) {
      // 获取均分
      $data[$k]['score'] = $book->avg($v['book_id']);
    }
    // 判断是否有记录
    if (!$data) {
      return ' ';
    }
    // 倒序排序
    array_multisort(array_column($data, 'score'), SORT_DESC, $data);
    // 判断取出数据是否大于10
    if (count($data)>10) {
      // 保留前十
      array_splice($data, 10);
    }
    return $data;
  }
}
