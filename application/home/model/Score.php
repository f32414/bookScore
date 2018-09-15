<?php

namespace app\home\model;

use think\Model;
use think\Db;

/**
 * Score模型
 */
class Score extends Model
{
  /**
   * 添加Score数据
   * @param string $book_id [书籍ID]
   * @param integer $score  [分数]
   * @return bool  [是否成功添加数据]
   */
  public function add($book_id, $score){
    $data = [
      'book_id' => $book_id,
      'score' => $score,
      'create_time' => time(),
    ];
    $result = Db::name('score')->insert($data);
    if (!$result) {
      return FALSE;
    }
    return TRUE;
  }
}
