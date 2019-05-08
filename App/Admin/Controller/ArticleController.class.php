<?php

namespace Admin\Controller;

use Common\Controller\BaseController;

/**
 * 文章管理
 */
class ArticleController extends BaseController {

    /**
     * 文章列表
     */
    public function articleList() {
        $pageSize = I('post.pageSize', C('PAGE_SIZE'));
        $pageCurrent = I('post.pageCurrent', 1);
        $orderField = I('post.orderField', 'id');
        $orderDirection = I('post.orderDirection', 'DESC');

        $title = I('post.title', '');

        //参数数组
        $params = array();
        //构造WHERE条件
        $where = '1=1 ';
        if (!empty($title)) {
            $params['title'] = $title;
            $where .= "AND a.`title` LIKE '%{$title}%' ";
        }

        $article = M('Article');
        //数据总数
        $total = $article->alias('a')
                ->join('LEFT JOIN __CATEGORY__ AS c ON a.cate_id=c.id')
                ->where($where)
                ->count();

        //数据列表
        $list = $article->field('a.*,c.name as cate_name')
                ->alias('a')
                ->join('LEFT JOIN __CATEGORY__ AS c ON a.cate_id=c.id')
                ->where($where)
                ->order("{$orderField} {$orderDirection}")
                ->page("{$pageCurrent},{$pageSize}")
                ->select();

        if (!empty($list)) {
            $commonStatus = C('COMMON_STATUS');
            foreach ($list as &$item) {
                $item['add_time'] = !empty($item['add_time']) ? date('Y-m-d H:i:s', intval($item['add_time'])) : '';
                $item['upd_time'] = !empty($item['upd_time']) ? date('Y-m-d H:i:s', intval($item['upd_time'])) : '';
                $item['status_name'] = array_key_exists($item['status'], $commonStatus) ? $commonStatus[$item['status']] : '';
            }
        }

        $this->assign('pageSize', $pageSize);
        $this->assign('pageCurrent', $pageCurrent);
        $this->assign('orderField', $orderField);
        $this->assign('orderDirection', $orderDirection);
        $this->assign('total', $total);
        $this->assign('list', $list);
        $this->assign('params', $params);
        $this->display();
    }

    /**
     * 添加文章
     */
    public function addArticle() {
        if (IS_POST) {
            $title = I('post.title', '');
            $article = M('Article');

            if (empty($title)) {
                ajaxReturn('文章标题不能为空', 300);
            }

            $data = $article->create();
            if ($data) {
                $data['add_time'] = time();
                $data['upd_time'] = time();
                $ret = $article->add($data);

                if ($ret) {
                    ajaxReturn('添加文章成功', 200, '', '', '', 'Admin/Article/articleList');
                } else {
                    ajaxReturn('添加文章失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $commonStatus = C('COMMON_STATUS');
            $cateData = M('Category')->field('id,pid,name')->where('status=1')->order("sort ASC")->select();

            $this->assign('commonStatus', $commonStatus);
            $this->assign('cateData', $cateData);
            $this->display();
        }
    }

    /**
     * 修改文章
     */
    public function updArticle() {
        if (IS_POST) {
            $title = I('post.title', '');
            $artId = I('post.artId', 0);
            $article = M('Article');

            if (empty($title)) {
                ajaxReturn('文章标题不能为空', 300);
            }

            if (empty($artId)) {
                ajaxReturn('文章ID不能为空', 300);
            }

            $data = $article->create();

            if ($data) {
                $data['upd_time'] = time();

                $ret = $article->where("id={$artId}")->save($data);
                if ($ret) {
                    ajaxReturn('修改文章成功', 200, '', '', '', 'Admin/Article/articleList');
                } else {
                    ajaxReturn('修改文章失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $artId = I('get.artId', 0);

            if (empty($artId)) {
                ajaxReturn('文章ID不能为空', 300);
            }

            $artInfo = M('Article')->where("id={$artId}")->find();
            if (empty($artInfo)) {
                ajaxReturn('没有找到该文章信息', 300);
            }

            $commonStatus = C('COMMON_STATUS');
            $cateData = M('Category')->field('id,pid,name')->where('status=1')->order("sort ASC")->select();

            $this->assign('commonStatus', $commonStatus);
            $this->assign('cateData', $cateData);
            $this->assign('artInfo', $artInfo);
            $this->display();
        }
    }

    /**
     * 删除文章
     */
    public function delArticle() {
        $ids = I('get.ids', '');

        if (empty($ids)) {
            ajaxReturn('请选择删除项', 300);
        }

        $ret = M('Article')->where("FIND_IN_SET(id,'{$ids}')")->delete();
        if ($ret) {
            ajaxReturn('删除成功', 200, '', '', '', 'Admin/Article/articleList');
        } else {
            ajaxReturn('删除失败', 300);
        }
    }

    /**
     * 上传缩略图
     */
    public function uploadThumb() {
        $info = uploadOne($_FILES['file'], array('savePath' => 'thumb/'));
        if (!$info) {
            ajaxReturn('上传失败', 300);
        } else {
            $filePath = C('UPLOAD_CONFIG.rootPath') . $info['savepath'] . $info['savename'];
            $filePath = ltrim($filePath, '.');
            ajaxReturn('上传成功', 200, array('filename' => $filePath));
        }
    }

}
