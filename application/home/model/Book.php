<?php

namespace app\home\model;

use think\Model;
use think\Db;

/**
 * 书籍模型
 */
class Book extends Model
{
  /**
   *
   * @return bool|string  书籍数据
   */
  /**
   * 获取数据
   * @param  string $order [排序]
   * @param  string $where [查询条件]
   * @return array        [书籍书籍]
   */
  public function getAll($order = NULL, $where = NULL)
  {
    $data = Db::name('book')
        ->order('create_time desc')
        ->where('book_name', 'like', "%{$where}%")
        ->select();
    foreach ($data as $k => $v) {
      // 获取平均分
      $data[$k]['score'] = $this->avg($v['book_id']);
    }
    // 判断数据是否存在
    if (!$data) {
      return FALSE;
    }
    // 判断是否需要排序
    if (!$order) {
      return $data;
    }
    // 判断排序顺序
    if ($order == 'desc') {
      // 倒序
      /**
       * array_column(数组, 字段名) 根据索引获取数组列
       * array_multisort(数组, 顺序, 数组) 将第一个参数排序，第二个数组对应第一个数组进行排序
       * @var [type]
       */
      array_multisort(array_column($data, 'score'), SORT_DESC, $data);
    }else{
      // 正序
      array_multisort(array_column($data, 'score'), SORT_ASC, $data);
    }

    return $data;
  }
  /**
   * 求均分
   * @param  integer $book_id [书籍ID]
   * @return integer          [均分]
   */
  public function avg($book_id)
  {
    $score = Db::name('score')
        ->where('book_id','=', $book_id)
        ->column('score');
    // 是否有评分记录
    if (!$score) {
      return 0;
    }
    // 获取评分记录条数
    $num = count($score);
    // 打分数少于3直接求均值返回
    if ($num < 3) {
      $score = round(array_sum($score)) / $num;
      return $score;
    }
    // 去掉最高分和最低分求均值返回
    $max = max($score);
    $min = min($score);
    $score = round((array_sum($score) -$max -$min) / ($num - 2), 1);

    return $score;
  }

}
