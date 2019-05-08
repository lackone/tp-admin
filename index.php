<?php

// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) die('require PHP > 5.3.0 !');

// 开启调试模式
define('APP_DEBUG', true);

// 定义应用目录
define('APP_PATH', './App/');

// 定义缓存目录
define('RUNTIME_PATH', './Runtime/');

// 定义模板文件默认目录
define("TMPL_PATH", './Tpl/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
