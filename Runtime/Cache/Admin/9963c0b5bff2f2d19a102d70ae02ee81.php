<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form id="j_pwschange_form" action="<?php echo U('Admin/User/changePwd');?>" data-toggle="validate" method="post">
        <div class="form-group">
            <label for="old_password" class="control-label x85">旧密码：</label>
            <input type="password" data-rule="required" name="old_password" id="old_password" value="" placeholder="旧密码" size="20">
        </div>
        <div class="form-group" style="margin: 20px 0 20px; ">
            <label for="new_password" class="control-label x85">新密码：</label>
            <input type="password" data-rule="required" name="new_password" id="new_password" value="" placeholder="新密码" size="20">
        </div>
        <div class="form-group">
            <label for="new_password2" class="control-label x85">确认密码：</label>
            <input type="password" data-rule="required" name="new_password2" id="new_password2" value="" placeholder="确认新密码" size="20">
        </div>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close">取消</button></li>
        <li><button type="submit" class="btn-default">保存</button></li>
    </ul>
</div>