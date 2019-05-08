<?php

return array(
    //是否显示调试面板
    'SHOW_PAGE_TRACE' => false,
    //url区分大小写
    'URL_CASE_INSENSITIVE' => false,
    //加载配置文件
    'LOAD_EXT_CONFIG' => 'db,dbParam',
    //自定义模板的字符串替换
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => __ROOT__ . '/Public',
        '__BJUI__' => __ROOT__ . '/Public/bjui',
        '__IMAGES__' => __ROOT__ . '/Public/images',
        '__JS__' => __ROOT__ . '/Public/js',
        '__CSS__' => __ROOT__ . '/Public/js',
    ),
    //允许访问模块列表
    'MODULE_ALLOW_LIST' => array('Home', 'Admin'),
    //URL伪静态后缀设置
    'URL_HTML_SUFFIX' => '',
    //默认AJAX数据返回格式
    'DEFAULT_AJAX_RETURN' => 'JSON',
    //URL访问模式
    'URL_MODEL' => 2,
    //默认主题
    'DEFAULT_THEME' => 'default',
    //权限表设置
    'AUTH_CONFIG' => array(
        'AUTH_USER' => 'users',
        'AUTH_RULE' => 'rules',
        'AUTH_GROUP_ACCESS' => 'user_group_access',
        'AUTH_GROUP' => 'user_group',
    ),
    //文件上传配置
    'UPLOAD_CONFIG' => array(
        'maxSize' => 2097152,
        'exts' => array('gif', 'jpg', 'jpeg', 'mpg', 'png'),
        'autoSub' => true,
        'subName' => array('date', 'Y-m-d'),
        'rootPath' => './Uploads/',
        'savePath' => '',
        'saveName' => 'time',
        'saveExt' => '',
        'replace' => false,
    ),
    //验证码配置
    'VERIFY_CONFIG' => array(
        'fontSize' => '18',
        'useCurve' => true,
        'useNoise' => false,
        'imageH' => 35,
        'imageW' => 120,
        'length' => 4,
        'fontttf' => '6.ttf',
    ),
    //默认分页显示数目
    'PAGE_SIZE' => 30,
);
