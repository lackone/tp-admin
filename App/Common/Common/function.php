<?php

/**
 * ajax返回数据
 * @param type $message 消息
 * @param type $statusCode 状态码(200:成功,300:失败,301:超时)
 * @param type $data 数据
 * @param type $forward 跳转url
 * @param type $forwardConfirm 跳转url提示信息
 * @param type $tabid 刷新navtab
 * @param type $dialogid 刷新dialog
 * @param type $closeCurrent 是否关闭当前窗口
 */
function ajaxReturn($message, $statusCode = 200, $data = array(), $forward = '', $forwardConfirm = '', $tabid = '', $dialogid = '', $closeCurrent = false) {
    $ret = array(
        'message' => $message,
        'statusCode' => $statusCode,
        'data' => $data,
        'forward' => $forward,
        'forwardConfirm' => $forwardConfirm,
        'tabid' => $tabid,
        'dialogid' => $dialogid,
        'closeCurrent' => $closeCurrent,
    );
    echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * 生成树型数据
 * @param type $items 数组数据
 * @param type $id ID字段名
 * @param type $pid 父级ID字段名
 * @param type $son 子类数组下标名
 */
function genTree($items, $id = 'id', $pid = 'pid', $son = 'child') {
    $tree = array();
    $tmpMap = array();

    foreach ($items as $item) {
        $tmpMap[$item[$id]] = $item;
    }

    foreach ($items as $item) {
        if (isset($tmpMap[$item[$pid]])) {
            $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
        } else {
            $tree[] = &$tmpMap[$item[$id]];
        }
    }
    unset($tmpMap);
    return $tree;
}

/**
 * 上传多个文件上传
 * @param type $config 配置数组
 */
function upload($config = array()) {
    if (empty($config)) {
        $config = C('UPLOAD_CONFIG');
    } else {
        $config = array_merge(C('UPLOAD_CONFIG'), $config);
    }

    $up = new \Think\Upload($config);
    $info = $up->upload();
    return $info;
}

/**
 * 上传单个文件
 * @param type $file 上传文件
 * @param type $config 配置数组
 */
function uploadOne($file, $config = array()) {
    if (empty($config)) {
        $config = C('UPLOAD_CONFIG');
    } else {
        $config = array_merge(C('UPLOAD_CONFIG'), $config);
    }

    $up = new \Think\Upload($config);
    $info = $up->uploadOne($file);
    return $info;
}

/**
 * 验证码
 */
function showVerify($id = '', $config = array()) {
    if (empty($config)) {
        $config = C('VERIFY_CONFIG');
    }
    $verify = new \Think\Verify($config);
    $verify->entry($id);
}

/**
 * 检测验证码
 */
function checkVerify($code, $id = '') {
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 权限验证
 */
function checkRule($rule) {
    if (empty(session('userInfo.id'))) {
        return false;
    }

    $myAuth = new \Common\Lib\MyAuth();

    return $myAuth->check($rule, session('userInfo.id'));
}
