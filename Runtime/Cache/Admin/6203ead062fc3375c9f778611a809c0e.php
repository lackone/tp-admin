<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U('Admin/User/userList');?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo ($pageSize); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo ($pageCurrent); ?>">
        <input type="hidden" name="orderField" value="<?php echo ($orderField); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo ($orderDirection); ?>">
        <div class="bjui-searchBar">
            <label>用户名：</label><input type="text" name="name" value="<?php echo ($params["name"]); ?>" class="form-control" size="10">&nbsp;
            <label>用户昵称：</label><input type="text" name="nick_name" value="<?php echo ($params["nickName"]); ?>" class="form-control" size="10">&nbsp;
            <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;
            <a class="btn btn-orange" href="javascript:;" onclick="$(this).navtab('reloadForm', true);" data-icon="undo">清空查询</a>
        </div>
    </form>
    <div style="margin:10px 0;">
        <?php if(checkRule('Admin/User/addUser')): ?><a class="btn btn-green" href="<?php echo U('Admin/User/addUser');?>" data-toggle="navtab" data-id="Admin/User/addUser">添加用户</a><?php endif; ?>
        <?php if(checkRule('Admin/User/delUser')): ?><a class="btn btn-red" href="<?php echo U('Admin/User/delUser');?>" data-toggle="doajaxchecked" data-confirm-msg="确定要删除选中项吗？" data-idname="ids" data-group="ids">批量删除</a><?php endif; ?>
    </div>
</div>
<div class="bjui-pageContent tableContent">
    <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
                <th width="26"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
                <th data-order-field="id">ID</th>
                <th data-order-field="name">用户名</th>
                <th data-order-field="nick_name">用户昵称</th>
                <th data-order-field="email">用户邮箱</th>
                <th>手机号</th>
                <th>性别</th>
                <th data-order-field="reg_time">注册时间</th>
                <th>注册IP</th>
                <th data-order-field="last_login_time">最后登陆时间</th>
                <th>最后登陆IP</th>
                <th>用户状态</th>
                <th data-order-field="sort">用户排序</th>
                <th width="100">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($list)): if(is_array($list)): foreach($list as $k=>$vo): ?><tr data-id="<?php echo ($vo["id"]); ?>">
                    <td><input type="checkbox" name="ids" data-toggle="icheck" value="<?php echo ($vo["id"]); ?>"></td>
                    <td><?php echo ($vo["id"]); ?></td>
                    <td><?php echo ($vo["name"]); ?></td>
                    <td><?php echo ($vo["nick_name"]); ?></td>
                    <td><?php echo ($vo["email"]); ?></td>
                    <td><?php echo ($vo["phone"]); ?></td>
                    <td><?php echo ($vo["sex"]); ?></td>
                    <td><?php echo ($vo["reg_time"]); ?></td>
                    <td><?php echo ($vo["reg_ip"]); ?></td>
                    <td><?php echo ($vo["last_login_time"]); ?></td>
                    <td><?php echo ($vo["last_login_ip"]); ?></td>
                    <td><?php echo ($vo["status_name"]); ?></td>
                    <td><?php echo ($vo["sort"]); ?></td>
                    <td>
                        <?php if(checkRule('Admin/User/updUser')): ?><a href="<?php echo U('Admin/User/updUser', array('userId' => $vo['id']));?>" class="btn btn-green" data-toggle="navtab" data-id="Admin/User/updUser">编辑</a><?php endif; ?>
                        <?php if(checkRule('Admin/User/delUser')): ?><a href="<?php echo U('Admin/User/delUser', array('ids' => $vo['id']));?>" class="btn btn-red" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？">删</a><?php endif; ?>
                    </td>
                </tr><?php endforeach; endif; endif; ?>
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
    <div class="pages">
        <span>每页&nbsp;</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
                <option value="30" <?php if($pageSize == 30): ?>selected="selected"<?php endif; ?>>30</option>
                <option value="60" <?php if($pageSize == 60): ?>selected="selected"<?php endif; ?>>60</option>
                <option value="120" <?php if($pageSize == 120): ?>selected="selected"<?php endif; ?>>120</option>
                <option value="150" <?php if($pageSize == 150): ?>selected="selected"<?php endif; ?>>150</option>
            </select>
        </div>
        <span>&nbsp;条，共 <?php echo ($total); ?> 条</span>
    </div>
    <div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($total); ?>" data-page-size="<?php echo ($pageSize); ?>" data-page-current="<?php echo ($pageCurrent); ?>"></div>
</div>