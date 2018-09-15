<?php

namespace app\home\controller;

use think\Controller;
use think\facade\Request;
use app\home\model\Book;
use app\home\model\Score;
use app\home\model\Cat;
/**
 * 首页控制器
 */
class Index extends Controller
{
  /**
   * 首页
   */
  public function Index()
  {
    // 获取排序顺序
    $order = Request::route('order');
    // 获取查询条件
    $where = Request::get('where');

    $model = new Book();
    $book = $model->getAll($order,$where);
    $this->assign([
        'book' => $book,
        'order' => $order
        ]);
    return $this->fetch();
  }
  /**
   * score页
   * @return  [渲染]
   */
  public function view()
  {
    // 通过路由变量获取book_id
    $book_id = Request::route('book_id');
    $this->assign('book_id', $book_id);
    return $this->fetch();
  }
  /**
   * 打分
   * @return integer [结果]
   */
  public function score()
  {
    $score = Request::post('score');
    $book_id = Request::post('book_id');
    // 判断是否有必需参数
    if (!$score || !$book_id) {
      return 0;
    }

    $model = new Score();
    $res = $model->add($book_id, $score);
    if (!$res) {
      return 0;
    }
    return 1;
  }
  /**
   * 分类top10
   * @return [type] [description]
   */
  public function cat()
  {
    $model = new Cat();
    $cat = $model->getAll();
    $this->assign('cat',$cat);
    
    return $this->fetch();
  }
}
