<?php

namespace Admin\Controller;

use Common\Controller\BaseController;

/**
 * 用户管理
 */
class UserController extends BaseController {

    /**
     * 用户列表
     */
    public function userList() {
        $pageSize = I('post.pageSize', C('PAGE_SIZE'));
        $pageCurrent = I('post.pageCurrent', 1);
        $orderField = I('post.orderField', 'id');
        $orderDirection = I('post.orderDirection', 'DESC');

        $name = I('post.name', '');
        $nickName = I('post.nick_name', '');

        //参数数组
        $params = array();
        //构造WHERE条件
        $where = '1=1 ';
        if (!empty($name)) {
            $params['name'] = $name;
            $where .= "AND `name` LIKE '%{$name}%' ";
        }
        if (!empty($nickName)) {
            $params['nickName'] = $nickName;
            $where .= "AND `nick_name` LIKE '%{$nickName}%' ";
        }

        $users = M('Users');
        //数据总数
        $total = $users->where($where)->count();

        //数据列表
        $list = $users->where($where)
                ->order("{$orderField} {$orderDirection}")
                ->page("{$pageCurrent},{$pageSize}")
                ->select();

        if (!empty($list)) {
            $commonStatus = C('COMMON_STATUS');
            $userSex = C('USER_SEX');
            foreach ($list as &$item) {
                $item['reg_time'] = $item['reg_time'] ? date('Y-m-d H:i:s', intval($item['reg_time'])) : '';
                $item['last_login_time'] = $item['last_login_time'] ? date('Y-m-d H:i:s', intval($item['last_login_time'])) : '';

                $item['sex'] = array_key_exists($item['sex'], $userSex) ? $userSex[$item['sex']] : '';
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
     * 添加用户
     */
    public function addUser() {
        if (IS_POST) {
            $name = I('post.name', '');
            $nick_name = I('post.nick_name', '');
            $password = I('post.password', '');
            $two_password = I('post.two_password', '');
            $group_id = I('post.group_id', array());
            $users = M('Users');
            $userGroupAccess = M('UserGroupAccess');

            if (empty($name)) {
                ajaxReturn('用户名不能为空', 300);
            }
            $existName = $users->where("name='{$name}'")->find();
            if (!empty($existName)) {
                ajaxReturn('该用户名已经存在', 300);
            }
            if (empty($nick_name)) {
                ajaxReturn('用户昵称不能为空', 300);
            }
            if (empty($password)) {
                ajaxReturn('用户密码不能为空', 300);
            }
            if (empty($two_password)) {
                ajaxReturn('重复密码不能为空', 300);
            }
            if ($password != $two_password) {
                ajaxReturn('两次密码不一致', 300);
            }

            $data = $users->create();
            if ($data) {
                $data['password'] = md5($data['password']);
                $data['reg_time'] = time();
                $data['upd_time'] = time();
                $data['reg_ip'] = get_client_ip();

                $ret = $users->add($data);
                if ($ret) {
                    if (!empty($group_id)) {
                        foreach ($group_id as $gid) {
                            $userGroupAccess->add(array('user_id' => $ret, 'group_id' => $gid));
                        }
                    }

                    ajaxReturn('添加用户成功', 200, '', '', '', 'Admin/User/userList');
                } else {
                    ajaxReturn('添加用户失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $userSex = C('USER_SEX');
            $commonStatus = C('COMMON_STATUS');

            $userGroup = M('UserGroup')->where("status=1")->select();

            $this->assign('userSex', $userSex);
            $this->assign('commonStatus', $commonStatus);
            $this->assign('userGroup', $userGroup);
            $this->display();
        }
    }

    /**
     * 删除用户
     */
    public function delUser() {
        $ids = I('get.ids', '');

        if (empty($ids)) {
            ajaxReturn('请选择删除项', 300);
        }

        $ret = M('Users')->where("FIND_IN_SET(id,'{$ids}')")->delete();
        if ($ret) {
            ajaxReturn('删除成功', 200, '', '', '', 'Admin/User/userList');
        } else {
            ajaxReturn('删除失败', 300);
        }
    }

    /**
     * 修改用户
     */
    public function updUser() {
        if (IS_POST) {
            $userId = I('post.userId', '');
            $name = I('post.name', '');
            $nick_name = I('post.nick_name', '');
            $group_id = I('post.group_id', array());
            $users = M('Users');
            $userGroupAccess = M('UserGroupAccess');

            if(empty($userId)) {
                ajaxReturn('用户ID不能为空', 300);
            }
            $userInfo = $users->where("id={$userId}")->find();
            if (empty($userInfo)) {
                ajaxReturn('没有找到该用户信息', 300);
            }
            if (empty($name)) {
                ajaxReturn('用户名不能为空', 300);
            }
            $existName = $users->where("name='{$name}' AND id!={$userId}")->find();
            if (!empty($existName)) {
                ajaxReturn('该用户名已经存在', 300);
            }
            if (empty($nick_name)) {
                ajaxReturn('用户昵称不能为空', 300);
            }
            
            $data = $users->create();
            if ($data) {
                $data['upd_time'] = time();
                $ret = $users->where("id={$userId}")->save($data);
                if ($ret) {
                    $userGroupAccess->where("user_id={$userId}")->delete();
                    if (!empty($group_id)) {
                        foreach ($group_id as $gid) {
                            $userGroupAccess->add(array('user_id' => $userId, 'group_id' => $gid));
                        }
                    }

                    ajaxReturn('修改用户成功', 200, '', '', '', 'Admin/User/userList');
                } else {
                    ajaxReturn('修改用户失败', 300);
                }
            } else {
                ajaxReturn('创建数据对象失败', 300);
            }
        } else {
            $userId = I('get.userId', '');

            if (empty($userId)) {
                ajaxReturn('用户ID不能为空', 300);
            }

            $userInfo = M('Users')->where("id={$userId}")->find();
            if (empty($userInfo)) {
                ajaxReturn('没有找到该用户信息', 300);
            }

            $userSex = C('USER_SEX');
            $commonStatus = C('COMMON_STATUS');
            //获取用户组信息
            $userGroup = M('UserGroup')->where("status=1")->select();
            //获取用户所属组信息
            $userGroupIdArr = M('UserGroupAccess')->field('group_id')->where("user_id={$userId}")->select();
            if(!empty($userGroupIdArr)) {
                $tmp = array();
                foreach ($userGroupIdArr as $item) {
                    $tmp[] = $item['group_id'];
                }
                $userGroupIdArr = $tmp;
            }
            
            $this->assign('userSex', $userSex);
            $this->assign('commonStatus', $commonStatus);
            $this->assign('userGroup', $userGroup);
            $this->assign('userInfo', $userInfo);
            $this->assign('userGroupIdArr', $userGroupIdArr);
            $this->display();
        }
    }

    /**
     * 上传用户头像
     */
    public function uploadAvatar() {
        $info = uploadOne($_FILES['file'], array('savePath' => 'avatar/'));
        if (!$info) {
            ajaxReturn('上传失败', 300);
        } else {
            $filePath = C('UPLOAD_CONFIG.rootPath') . $info['savepath'] . $info['savename'];
            $filePath = ltrim($filePath, '.');
            ajaxReturn('上传成功', 200, array('filename' => $filePath));
        }
    }

    /**
     * 修改密码
     */
    public function changePwd() {
        if (IS_POST) {
            $old_password = I('post.old_password', '');
            $new_password = I('post.new_password', '');
            $new_password2 = I('post.new_password2', '');
            $users = M('Users');
            $userId = session('userInfo.id');

            if (empty($old_password)) {
                ajaxReturn('旧密码不能为空', 300);
            }
            $userInfo = $users->where("id={$userId}")->find();
            if (md5($old_password) != $userInfo['password']) {
                ajaxReturn('旧密码不正确', 300);
            }
            if (empty($new_password)) {
                ajaxReturn('新密码不能为空', 300);
            }
            if (empty($new_password2)) {
                ajaxReturn('确认新密码不能为空', 300);
            }
            if ($new_password != $new_password2) {
                ajaxReturn('新密码不一致', 300);
            }

            $ret = $users->where("id={$userId}")->save(array('password' => md5($new_password)));
            if ($ret) {
                ajaxReturn('修改密码成功', 200);
            } else {
                ajaxReturn('修改密码失败', 300);
            }
        } else {
            $this->display();
        }
    }

}
