<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Cat;
use think\facade\Request;

/**
 * 书籍管理
 */
class Book extends Controller
{
  /**
   * 添加页
   * @return [type] [description]
   */
  public function index()
  {
    // 获取分类列表
    $model = new Cat();
    $cat = $model->getAll();
    if (!$cat) {
      $cat = ['0'=>['cat_id'=>'0','cat_name'=>'默认分类']];
    }
    $this->assign('cat',$cat);
    return $this->fetch();
  }
  /**
   * 添加
   */
  public function add()
  {
    $book_name = Request::post('book_name');
    $author = Request::post('author');
    $info = Request::post('info');
    $status = Request::post('status');
    $cat = Request::post('cat');
    $img = request()->file('img');

    // 非空验证
    if (!$book_name || !$author || !$info || !$img) {
      $this->error('字段不能为空！','admin/book/index');
    }
    $model = new Cat();
    // 判断是否上传同一书籍
    $res = $model -> checkBook($book_name, $author);
    if (!$res) {
      $this->error('请勿重复上架书籍！！','admin/book/index');
    }
    // 图片上传
    $img = $img->move('../uploads');
    if ($img) {
      $img = $img->getSaveName();
    }
    $model = new \app\admin\model\Book();
    $result = $model->add($book_name, $author, $info, $status, $cat, $img);
    if (!$result) {
      $this->error('添加失败！','admin/book/index');
    }
    $this->success('添加成功！','admin/book/index');
  }
}
