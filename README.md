# tp-admin
基于ThinkPHP3.2 + B-JUI 的后台权限管理系统

# 如何使用

### 1、拷贝项目
<code>
git clone https://github.com/lackone/tp-admin.git
</code>

### 2、创建数据库, 并导入database.sql
将项目目录下的database.sql导入

### 3、配置数据库参数
在App\Common\Conf\db.php

<code>
return array(
    'DB_TYPE' => 'mysqli', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'auth', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'tb_', // 数据库表前缀
);
</code>

### 4、配置虚拟主机, 指向当前项目目录

### 5、通过 /admin 访问后台页面
用户名：admin
密码：123456


