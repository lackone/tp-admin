<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>通用后台框架</title>
        <meta name="Keywords" content=""/>
        <meta name="Description" content=""/> 
        <!-- bootstrap - css -->
        <link href="/Public/bjui/themes/css/bootstrap.css" rel="stylesheet">
        <!-- core - css -->
        <link href="/Public/bjui/themes/css/style.css" rel="stylesheet">
        <link href="/Public/bjui/themes/blue/core.css" id="bjui-link-theme" rel="stylesheet">
        <!-- plug - css -->
        <link href="/Public/bjui/plugins/kindeditor_4.1.10/themes/default/default.css" rel="stylesheet">
        <link href="/Public/bjui/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="/Public/bjui/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
        <link href="/Public/bjui/plugins/bootstrapSelect/bootstrap-select.css" rel="stylesheet">
        <link href="/Public/bjui/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
        <!--[if lte IE 7]>
        <link href="/Public/bjui/themes/css/ie7.css" rel="stylesheet">
        <![endif]-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lte IE 9]>
            <script src="/Public/bjui/other/html5shiv.min.js"></script>
            <script src="/Public/bjui/other/respond.min.js"></script>
        <![endif]-->
        <!-- jquery -->
        <script src="/Public/bjui/js/jquery-1.7.2.min.js"></script>
        <script src="/Public/bjui/js/jquery.cookie.js"></script>
        <!--[if lte IE 9]>
        <script src="/Public/bjui/other/jquery.iframe-transport.js"></script>    
        <![endif]-->
        <!-- BJUI.all 分模块压缩版 -->
        <script src="/Public/bjui/js/bjui-all.js"></script>
        <!-- 以下是B-JUI的分模块未压缩版，建议开发调试阶段使用下面的版本 -->
        <!--
        <script src="/Public/bjui/js/bjui-core.js"></script>
        <script src="/Public/bjui/js/bjui-regional.zh-CN.js"></script>
        <script src="/Public/bjui/js/bjui-frag.js"></script>
        <script src="/Public/bjui/js/bjui-extends.js"></script>
        <script src="/Public/bjui/js/bjui-basedrag.js"></script>
        <script src="/Public/bjui/js/bjui-slidebar.js"></script>
        <script src="/Public/bjui/js/bjui-contextmenu.js"></script>
        <script src="/Public/bjui/js/bjui-navtab.js"></script>
        <script src="/Public/bjui/js/bjui-dialog.js"></script>
        <script src="/Public/bjui/js/bjui-taskbar.js"></script>
        <script src="/Public/bjui/js/bjui-ajax.js"></script>
        <script src="/Public/bjui/js/bjui-alertmsg.js"></script>
        <script src="/Public/bjui/js/bjui-pagination.js"></script>
        <script src="/Public/bjui/js/bjui-util.date.js"></script>
        <script src="/Public/bjui/js/bjui-datepicker.js"></script>
        <script src="/Public/bjui/js/bjui-ajaxtab.js"></script>
        <script src="/Public/bjui/js/bjui-datagrid.js"></script>
        <script src="/Public/bjui/js/bjui-tablefixed.js"></script>
        <script src="/Public/bjui/js/bjui-tabledit.js"></script>
        <script src="/Public/bjui/js/bjui-spinner.js"></script>
        <script src="/Public/bjui/js/bjui-lookup.js"></script>
        <script src="/Public/bjui/js/bjui-tags.js"></script>
        <script src="/Public/bjui/js/bjui-upload.js"></script>
        <script src="/Public/bjui/js/bjui-theme.js"></script>
        <script src="/Public/bjui/js/bjui-initui.js"></script>
        <script src="/Public/bjui/js/bjui-plugins.js"></script>
        -->
        <!-- plugins -->
        <!-- swfupload for uploadify && kindeditor -->
        <script src="/Public/bjui/plugins/swfupload/swfupload.js"></script>
        <!-- kindeditor -->
        <script src="/Public/bjui/plugins/kindeditor_4.1.10/kindeditor-all.min.js"></script>
        <script src="/Public/bjui/plugins/kindeditor_4.1.10/lang/zh_CN.js"></script>
        <!-- colorpicker -->
        <script src="/Public/bjui/plugins/colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <!-- ztree -->
        <script src="/Public/bjui/plugins/ztree/jquery.ztree.all-3.5.js"></script>
        <!-- nice validate -->
        <script src="/Public/bjui/plugins/niceValidator/jquery.validator.js"></script>
        <script src="/Public/bjui/plugins/niceValidator/jquery.validator.themes.js"></script>
        <!-- bootstrap plugins -->
        <script src="/Public/bjui/plugins/bootstrap.min.js"></script>
        <script src="/Public/bjui/plugins/bootstrapSelect/bootstrap-select.min.js"></script>
        <script src="/Public/bjui/plugins/bootstrapSelect/defaults-zh_CN.min.js"></script>
        <!-- icheck -->
        <script src="/Public/bjui/plugins/icheck/icheck.min.js"></script>
        <!-- dragsort -->
        <script src="/Public/bjui/plugins/dragsort/jquery.dragsort-0.5.1.min.js"></script>
        <!-- HighCharts -->
        <script src="/Public/bjui/plugins/highcharts/highcharts.js"></script>
        <script src="/Public/bjui/plugins/highcharts/highcharts-3d.js"></script>
        <script src="/Public/bjui/plugins/highcharts/themes/gray.js"></script>
        <!-- ECharts -->
        <script src="/Public/bjui/plugins/echarts/echarts.js"></script>
        <!-- other plugins -->
        <script src="/Public/bjui/plugins/other/jquery.autosize.js"></script>
        <link href="/Public/bjui/plugins/uploadify/css/uploadify.css" rel="stylesheet">
        <script src="/Public/bjui/plugins/uploadify/scripts/jquery.uploadify.min.js"></script>
        <script src="/Public/bjui/plugins/download/jquery.fileDownload.js"></script>
        <!-- init -->
        <script type="text/javascript">
            $(function () {
                BJUI.init({
                    JSPATH: '/Public/bjui/', //[可选]框架路径
                    PLUGINPATH: '/Public/bjui/plugins/', //[可选]插件路径
                    loginInfo: {url: 'login_timeout.html', title: '登录', width: 400, height: 200}, // 会话超时后弹出登录对话框
                    statusCode: {ok: 200, error: 300, timeout: 301}, //[可选]
                    ajaxTimeout: 50000, //[可选]全局Ajax请求超时时间(毫秒)
                    pageInfo: {total: 'total', pageCurrent: 'pageCurrent', pageSize: 'pageSize', orderField: 'orderField', orderDirection: 'orderDirection'}, //[可选]分页参数
                    alertMsg: {displayPosition: 'topcenter', displayMode: 'slide', alertTimeout: 3000}, //[可选]信息提示的显示位置，显隐方式，及[info/correct]方式时自动关闭延时(毫秒)
                    keys: {statusCode: 'statusCode', message: 'message'}, //[可选]
                    ui: {
                        windowWidth: 0, //框架可视宽度，0=100%宽，> 600为则居中显示
                        showSlidebar: true, //[可选]左侧导航栏锁定/隐藏
                        clientPaging: true, //[可选]是否在客户端响应分页及排序参数
                        overwriteHomeTab: false //[可选]当打开一个未定义id的navtab时，是否可以覆盖主navtab(我的主页)
                    },
                    debug: true, // [可选]调试模式 [true|false，默认false]
                    theme: 'sky' // 若有Cookie['bjui_theme'],优先选择Cookie['bjui_theme']。皮肤[五种皮肤:default, orange, purple, blue, red, green]
                });

                // main - menu
                $('#bjui-accordionmenu').collapse().on('hidden.bs.collapse', function (e) {
                    $(this).find('> .panel > .panel-heading').each(function () {
                        var $heading = $(this), $a = $heading.find('> h4 > a');

                        if ($a.hasClass('collapsed')) {
                            $heading.removeClass('active');
                        }
                    });
                }).on('shown.bs.collapse', function (e) {
                    $(this).find('> .panel > .panel-heading').each(function () {
                        var $heading = $(this), $a = $heading.find('> h4 > a');

                        if (!$a.hasClass('collapsed')) {
                            $heading.addClass('active');
                        }
                    });
                });

                $(document).on('click', 'ul.menu-items > li > a', function (e) {
                    var $a = $(this), $li = $a.parent(), options = $a.data('options').toObj();
                    var onClose = function () {
                        $li.removeClass('active');
                    };
                    var onSwitch = function () {
                        $('#bjui-accordionmenu').find('ul.menu-items > li').removeClass('switch');
                        $li.addClass('switch');
                    };

                    $li.addClass('active');
                    if (options) {
                        options.url = $a.attr('href')
                        options.onClose = onClose;
                        options.onSwitch = onSwitch;
                        if (!options.title) {
                            options.title = $a.text();
                        }
                        if (!options.target) {
                            $a.navtab(options);
                        } else {
                            $a.dialog(options);
                        }
                    }

                    e.preventDefault();
                });

                //时钟
                var today = new Date(), time = today.getTime();
                $('#bjui-date').html(today.formatDate('yyyy/MM/dd'));
                setInterval(function () {
                    today = new Date(today.setSeconds(today.getSeconds() + 1));
                    $('#bjui-clock').html(today.formatDate('HH:mm:ss'));
                }, 1000);
            });

            //菜单-事件
            function MainMenuClick(event, treeId, treeNode) {
                event.preventDefault();

                if (treeNode.isParent) {
                    var zTree = $.fn.zTree.getZTreeObj(treeId);

                    zTree.expandNode(treeNode, !treeNode.open, false, true, true);
                    return;
                }

                if (treeNode.target && treeNode.target == 'dialog') {
                    $(event.target).dialog({id: treeNode.tabid, url: treeNode.url, title: treeNode.name});
                } else {
                    $(event.target).navtab({id: treeNode.tabid, url: treeNode.url, title: treeNode.name, fresh: treeNode.fresh, external: treeNode.external});
                }
            }
        </script>
    </head>
    <body>
        <!--[if lte IE 7]>
            <div id="errorie"><div>您还在使用老掉牙的IE，正常使用系统前请升级您的浏览器到 IE8以上版本 <a target="_blank" href="http://windows.microsoft.com/zh-cn/internet-explorer/ie-8-worldwide-languages">点击升级</a>&nbsp;&nbsp;强烈建议您更改换浏览器：<a href="http://down.tech.sina.com.cn/content/40975.html" target="_blank">谷歌 Chrome</a></div></div>
        <![endif]-->
        <div id="bjui-window">
            <header id="bjui-header">
                <div class="bjui-navbar-header">
                    <button type="button" class="bjui-navbar-toggle btn-default" data-toggle="collapse" data-target="#bjui-navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="bjui-navbar-logo" href="#"><img src="/Public/images/logo.png"></a>
                </div>
                <nav id="bjui-navbar-collapse">
                    <ul class="bjui-navbar-right">
                        <li class="datetime"><div><span id="bjui-date"></span> <span id="bjui-clock"></span></div></li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">我的账户 <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php if(checkRule('Admin/User/changePwd')): ?><li><a href="<?php echo U('Admin/User/changePwd');?>" data-toggle="dialog" data-id="changePwd" data-mask="true" data-width="400" data-height="260">&nbsp;<span class="glyphicon glyphicon-lock"></span> 修改密码&nbsp;</a></li><?php endif; ?>
                                <li><a href="#">&nbsp;<span class="glyphicon glyphicon-user"></span> 我的资料</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo U('Admin/Index/logout');?>" class="red">&nbsp;<span class="glyphicon glyphicon-off"></span> 注销登陆</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle theme blue" data-toggle="dropdown" title="切换皮肤"><i class="fa fa-tree"></i></a>
                            <ul class="dropdown-menu" role="menu" id="bjui-themes">
                                <li><a href="javascript:;" class="theme_default" data-toggle="theme" data-theme="default">&nbsp;<i class="fa fa-tree"></i> 黑白分明&nbsp;&nbsp;</a></li>
                                <li><a href="javascript:;" class="theme_orange" data-toggle="theme" data-theme="orange">&nbsp;<i class="fa fa-tree"></i> 橘子红了</a></li>
                                <li><a href="javascript:;" class="theme_purple" data-toggle="theme" data-theme="purple">&nbsp;<i class="fa fa-tree"></i> 紫罗兰</a></li>
                                <li class="active"><a href="javascript:;" class="theme_blue" data-toggle="theme" data-theme="blue">&nbsp;<i class="fa fa-tree"></i> 天空蓝</a></li>
                                <li><a href="javascript:;" class="theme_green" data-toggle="theme" data-theme="green">&nbsp;<i class="fa fa-tree"></i> 绿草如茵</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <div id="bjui-hnav">
                    <button type="button" class="btn-default bjui-hnav-more-left" title="导航菜单左移"><i class="fa fa-angle-double-left"></i></button>
                    <div id="bjui-hnav-navbar-box">
                        <ul id="bjui-hnav-navbar">
                            <?php if(!empty($ruleList)): if(is_array($ruleList)): foreach($ruleList as $topK=>$top): ?><li <?php if($topK == 0): ?>class="active"<?php endif; ?>><a href="javascript:void;" data-toggle="slidebar"><?php echo ($top["title"]); ?></a>
                                        <?php if(!empty($top['child'])): ?><div class="items hide" data-noinit="true">
                                                <?php if(is_array($top['child'])): foreach($top['child'] as $midK=>$mid): ?><ul id="nav-mid-<?php echo ($mid["id"]); ?>" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-expand-all="true" data-faicon="check-square-o" data-tit="<?php echo ($mid["title"]); ?>">
                                                        <?php if(!empty($mid['child'])): if(is_array($mid['child'])): foreach($mid['child'] as $botK=>$bot): if(empty($bot['child'])): ?><li data-id="<?php echo ($bot["id"]); ?>" data-pid="<?php echo ($bot["pid"]); ?>" data-url="<?php echo ($bot["url"]); ?>" data-tabid="<?php echo ($bot["name"]); ?>" data-faicon="caret-right"><?php echo ($bot["title"]); ?></li>
                                                                    <?php else: ?>
                                                                    <li data-id="<?php echo ($bot["id"]); ?>" data-pid="<?php echo ($bot["pid"]); ?>" data-faicon="folder-open-o" data-faicon-close="folder-o"><?php echo ($bot["title"]); ?></li>
                                                                    <?php if(is_array($bot['child'])): foreach($bot['child'] as $tbotK=>$tbot): ?><li data-id="<?php echo ($tbot["id"]); ?>" data-pid="<?php echo ($tbot["pid"]); ?>" data-url="<?php echo ($tbot["url"]); ?>" data-tabid="<?php echo ($tbot["name"]); ?>" data-faicon="caret-right"><?php echo ($tbot["title"]); ?></li><?php endforeach; endif; endif; endforeach; endif; endif; ?>
                                                    </ul><?php endforeach; endif; ?>
                                            </div><?php endif; ?>
                                    </li><?php endforeach; endif; endif; ?>
                        </ul>
                    </div>
                    <button type="button" class="btn-default bjui-hnav-more-right" title="导航菜单右移"><i class="fa fa-angle-double-right"></i></button>
                </div>
            </header>
            <div id="bjui-container">
                <div id="bjui-leftside">
                    <div id="bjui-sidebar-s">
                        <div class="collapse"></div>
                    </div>
                    <div id="bjui-sidebar">
                        <div class="toggleCollapse"><h2><i class="fa fa-bars"></i> 导航栏 <i class="fa fa-bars"></i></h2><a href="javascript:;" class="lock"><i class="fa fa-lock"></i></a></div>
                        <div class="panel-group panel-main" data-toggle="accordion" id="bjui-accordionmenu" data-heightbox="#bjui-sidebar" data-offsety="26">
                        </div>
                    </div>
                </div>
                <div id="bjui-navtab" class="tabsPage">
                    <div class="tabsPageHeader">
                        <div class="tabsPageHeaderContent">
                            <ul class="navtab-tab nav nav-tabs">
                                <li data-url="<?php echo U('Admin/Index/welcome');?>"><a href="javascript:;"><span><i class="fa fa-home"></i> #maintab#</span></a></li>
                            </ul>
                        </div>
                        <div class="tabsLeft"><i class="fa fa-angle-double-left"></i></div>
                        <div class="tabsRight"><i class="fa fa-angle-double-right"></i></div>
                        <div class="tabsMore"><i class="fa fa-angle-double-down"></i></div>
                    </div>
                    <ul class="tabsMoreList">
                        <li><a href="javascript:;">#maintab#</a></li>
                    </ul>
                    <div class="navtab-panel tabsPageContent">
                        <div class="navtabPage unitBox">
                            <div class="bjui-pageContent" style="background:#FFF;">
                                Loading...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer id="bjui-footer">Copyright &copy; 2015 - 2018</footer>
        </div>
    </body>
</html>