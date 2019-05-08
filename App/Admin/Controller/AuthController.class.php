<?php

namespace Admin\Controller;

use Common\Controller\BaseController;

/**
 * 权限管理
 */
class AuthController extends BaseController {

    /**
     * 添加权限
     */
    public function addRule() {
        if (IS_POST) {
            $name = I('post.name', '');
            $title = I('post.title', '');
            $pid = I('post.pid', 0);
            $rules = M('Rules');

            if (!empty($name)) {
                $existName = $rules->where("name='{$name}'")->find();
                if (!empty($existName)) {
                    ajaxReturn('已存在权限标识', 300);
                }
            }
            if (empty($title)) {
                ajaxReturn('权限中文名不能为空', 300);
            }

            $data = $rules->create();

            if ($data) {
                if (!empty($pid)) {
                    $parent = $rules->field('path')->where("id={$pid}")->find();
                    $data['path'] = $parent['path'] . ',' . $pid;
                } else {
                    $data['path'] = '0';
                }

                $ret = $rules->add($data);
                if ($ret) {
                    ajaxReturn('添加权限成功', 200);
                } else {
                    ajaxReturn('添加权限失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $commonStatus = C('COMMON_STATUS');
            $ruleType = C('RULE_TYPE');
            $rules = M('Rules');

            $parentRuleData = $rules->field('id,pid,name,title')->where("status=1")->order("sort ASC")->select();

            $this->assign('commonStatus', $commonStatus);
            $this->assign('ruleType', $ruleType);
            $this->assign('parentRuleData', $parentRuleData);
            $this->display();
        }
    }

    /**
     * 权限列表
     */
    public function ruleList() {
        $commonStatus = C('COMMON_STATUS');
        $ruleType = C('RULE_TYPE');
        $rules = M('Rules');

        $parentRuleData = $rules->field('id,pid,name,title')->where('status=1')->order("sort ASC")->select();
        $allRuleData = $rules->field('r.*,r2.title AS ptitle')
                ->alias('r')
                ->join('LEFT JOIN __RULES__ AS r2 ON r.pid=r2.id')
                ->order('r.sort ASC')
                ->select();

        $this->assign('commonStatus', $commonStatus);
        $this->assign('ruleType', $ruleType);
        $this->assign('parentRuleData', $parentRuleData);
        $this->assign('allRuleData', $allRuleData);
        $this->display();
    }

    /**
     * 更新权限
     */
    public function updRule() {
        $name = I('post.name', '');
        $title = I('post.title', '');
        $pid = I('post.pid', 0);
        $ruleId = I('post.ruleId', 0);
        $rules = M('Rules');

        if (empty($ruleId)) {
            ajaxReturn('权限ID不能为空', 300);
        }
        $ruleInfo = $rules->where("id={$ruleId}")->find();
        if (empty($ruleInfo)) {
            ajaxReturn('没有找到该权限', 300);
        }
        if (!empty($name)) {
            $existName = $rules->where("name='{$name}' AND id!={$ruleId}")->find();
            if (!empty($existName)) {
                ajaxReturn('已存在权限标识', 300);
            }
        }
        if (empty($title)) {
            ajaxReturn('权限中文名不能为空', 300);
        }

        $data = $rules->create();
        if ($data) {
            if (!empty($pid)) {
                $parent = $rules->field('path')->where("id={$pid}")->find();
                $data['path'] = $parent['path'] . ',' . $pid;
            } else {
                $data['path'] = '0';
            }

            $ret = $rules->where("id={$ruleId}")->save($data);
            if ($ret) {
                if ($ruleInfo['pid'] != $pid) {
                    $this->reGenChildPath($ruleId);
                }

                ajaxReturn('修改权限成功', 200);
            } else {
                ajaxReturn('修改权限失败', 300);
            }
        } else {
            ajaxReturn('创建数据对象失败', 300);
        }
    }

    /**
     * 删除权限
     */
    public function delRule() {
        $ruleId = I('post.ruleId', 0);

        if (empty($ruleId)) {
            ajaxReturn('权限ID不能为空', 300);
        }

        $ret = M('Rules')->where("id={$ruleId}")->delete();
        if ($ret) {
            ajaxReturn('删除权限成功', 200);
        } else {
            ajaxReturn('删除权限失败', 300);
        }
    }

    /**
     * 重新生成孩子路径
     */
    public function reGenChildPath($pid) {
        $rules = M('Rules');
        $childs = $rules->where("pid={$pid}")->select();
        if (empty($childs)) {
            return;
        }
        $parent = $rules->where("id={$pid}")->find();
        foreach ($childs as $child) {
            $rules->where("id={$child['id']}")->save(array('path' => $parent['path'] . ',' . $parent['id']));
            $this->reGenChildPath($child['id']);
        }
    }

    /**
     * 添加用户组
     */
    public function addUserGroup() {
        if (IS_POST) {
            $name = I('post.name', '');
            $userGroup = M('UserGroup');

            if (empty($name)) {
                ajaxReturn('用户组名不能为空', 300);
            }
            $existName = $userGroup->where("name='$name'")->find();
            if (!empty($existName)) {
                ajaxReturn('该用户组名已存在', 300);
            }

            $data = $userGroup->create();
            if ($data) {
                $ret = $userGroup->add($data);

                if ($ret) {
                    ajaxReturn('添加用户组成功', 200, '', '', '', 'Admin/Auth/userGroupList');
                } else {
                    ajaxReturn('添加用户组失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $commonStatus = C('COMMON_STATUS');
            $rules = M('Rules');

            $ruleData = $rules->field('id,pid,name,title')->where("status=1")->order("sort ASC")->select();

            $this->assign('commonStatus', $commonStatus);
            $this->assign('ruleData', $ruleData);
            $this->display();
        }
    }

    /**
     * 用户组列表
     */
    public function userGroupList() {
        $pageSize = I('post.pageSize', C('PAGE_SIZE'));
        $pageCurrent = I('post.pageCurrent', 1);
        $orderField = I('post.orderField', 'id');
        $orderDirection = I('post.orderDirection', 'DESC');

        $name = I('post.name', '');

        //参数数组
        $params = array();
        //构造WHERE条件
        $where = '1=1 ';
        if (!empty($name)) {
            $params['name'] = $name;
            $where .= "AND `name` LIKE '%{$name}%' ";
        }

        $userGroup = M('UserGroup');
        //数据总数
        $total = $userGroup->where($where)->count();

        //数据列表
        $list = $userGroup->where($where)
                ->order("{$orderField} {$orderDirection}")
                ->page("{$pageCurrent},{$pageSize}")
                ->select();

        if (!empty($list)) {
            $commonStatus = C('COMMON_STATUS');
            foreach ($list as &$item) {
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
     * 删除用户组
     */
    public function delUserGroup() {
        $ids = I('get.ids', '');

        if (empty($ids)) {
            ajaxReturn('请选择删除项', 300);
        }

        $ret = M('UserGroup')->where("FIND_IN_SET(id,'{$ids}')")->delete();
        if ($ret) {
            ajaxReturn('删除成功', 200, '', '', '', 'Admin/Auth/userGroupList');
        } else {
            ajaxReturn('删除失败', 300);
        }
    }

    /**
     * 修改用户组
     */
    public function updUserGroup() {
        if (IS_POST) {
            $userGroupId = I('post.userGroupId', '');
            $name = I('post.name', '');
            $userGroup = M('UserGroup');

            if (empty($userGroupId)) {
                ajaxReturn('用户组ID不能为空', 300);
            }
            if (empty($name)) {
                ajaxReturn('用户组名不能为空', 300);
            }
            $existName = $userGroup->where("name='$name' AND id!={$userGroupId}")->find();
            if (!empty($existName)) {
                ajaxReturn('该用户组名已存在', 300);
            }

            $data = $userGroup->create();
            if ($data) {
                $ret = $userGroup->where("id={$userGroupId}")->save($data);

                if ($ret) {
                    ajaxReturn('修改用户组成功', 200, '', '', '', 'Admin/Auth/userGroupList');
                } else {
                    ajaxReturn('修改用户组失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $userGroupId = I('get.userGroupId', '');

            if (empty($userGroupId)) {
                ajaxReturn('用户组ID不能为空', 300);
            }
            $userGroupInfo = M('UserGroup')->where("id={$userGroupId}")->find();
            if (empty($userGroupInfo)) {
                ajaxReturn('没有找到该用户组信息', 300);
            }

            $userGropuRuleArr = explode(',', $userGroupInfo['rules']);
            $commonStatus = C('COMMON_STATUS');
            $ruleData = M('Rules')->field('id,pid,name,title')->where("status=1")->order("sort ASC")->select();

            $this->assign('userGroupInfo', $userGroupInfo);
            $this->assign('userGropuRuleArr', $userGropuRuleArr);
            $this->assign('commonStatus', $commonStatus);
            $this->assign('ruleData', $ruleData);
            $this->display();
        }
    }

}
