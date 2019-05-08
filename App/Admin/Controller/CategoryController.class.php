<?php

namespace Admin\Controller;

use Common\Controller\BaseController;

/**
 * 文章栏目管理
 */
class CategoryController extends BaseController {

    /**
     * 栏目列表
     */
    public function categoryList() {
        $commonStatus = C('COMMON_STATUS');
        $category = M('Category');

        $parentCateData = $category->field('id,pid,name')->where('status=1')->order("sort ASC")->select();
        $allCateData = $category->field('c.*,c2.name AS pname')
                ->alias('c')
                ->join('LEFT JOIN __CATEGORY__ AS c2 ON c.pid=c2.id')
                ->order('c.sort ASC')
                ->select();

        $this->assign('commonStatus', $commonStatus);
        $this->assign('parentCateData', $parentCateData);
        $this->assign('allCateData', $allCateData);
        $this->display();
    }

    /**
     * 添加栏目
     */
    public function addCategory() {
        if (IS_POST) {
            $name = I('post.name', '');
            $category = M('Category');

            if (empty($name)) {
                ajaxReturn('栏目名称不能为空', 300);
            }

            $data = $category->create();

            if ($data) {
                $ret = $category->add($data);

                if ($ret) {
                    ajaxReturn('添加栏目成功', 200);
                } else {
                    ajaxReturn('添加栏目失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $this->display();
        }
    }

    /**
     * 修改栏目
     */
    public function updCategory() {
        if (IS_POST) {
            $name = I('post.name', '');
            $cateId = I('post.cateId', 0);
            $category = M('Category');

            if (empty($name)) {
                ajaxReturn('栏目名称不能为空', 300);
            }

            if (empty($cateId)) {
                ajaxReturn('栏目ID不能为空', 300);
            }

            $data = $category->create();

            if ($data) {
                $ret = $category->where("id={$cateId}")->save($data);

                if ($ret) {
                    ajaxReturn('修改栏目成功', 200);
                } else {
                    ajaxReturn('修改栏目失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $this->display();
        }
    }

    /**
     * 删除栏目
     */
    public function delCategory() {
        $cateId = I('post.cateId', 0);

        if (empty($cateId)) {
            ajaxReturn('栏目ID不能为空', 300);
        }

        $ret = M('Category')->where("id={$cateId}")->delete();
        if ($ret) {
            ajaxReturn('删除栏目成功', 200);
        } else {
            ajaxReturn('删除栏目失败', 300);
        }
    }

    /**
     * 上传栏目图片
     */
    public function uploadPic() {
        $info = uploadOne($_FILES['file'], array('savePath' => 'pic/'));
        if (!$info) {
            ajaxReturn('上传失败', 300);
        } else {
            $filePath = C('UPLOAD_CONFIG.rootPath') . $info['savepath'] . $info['savename'];
            $filePath = ltrim($filePath, '.');
            ajaxReturn('上传成功', 200, array('filename' => $filePath));
        }
    }

}
