<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    function avatarUploadSuccess(file, data) {
        var data = $.parseJSON(data);
        $(this).bjuiajax("ajaxDone", data);
        if (data["statusCode"] == 200) {
            $.CurrentNavtab.find("#avatar").val(data["data"]["filename"]);
            $.CurrentNavtab.find("#avatarImg").html("<img src='" + data["data"]["filename"] + "' width='100' />");
        }
    }
</script>
<div class="bjui-pageContent">
    <form action="<?php echo U('Admin/User/updUser');?>" data-toggle="validate" data-alertmsg="false">
        <input type="hidden" name="userId" value="<?php echo ($userInfo["id"]); ?>">
        <table class="table table-condensed table-hover" width="100%">
            <tbody>
                <tr>
                    <td>
                        <label for="name" class="control-label x85">用户名：</label>
                        <input type="text" name="name" id="name" value="<?php echo ($userInfo["name"]); ?>" data-rule="required" size="20">
                        <span>(*用于登陆)</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="name" class="control-label x85">用户角色：</label>
                        <?php if(!empty($userGroup)): if(is_array($userGroup)): foreach($userGroup as $k=>$vo): ?><input type="checkbox" name="group_id[]" data-toggle="icheck" value="<?php echo ($vo["id"]); ?>" data-label="<?php echo ($vo["name"]); ?>" <?php if(in_array($vo['id'],$userGroupIdArr)): ?>checked="checked"<?php endif; ?>>
                                &nbsp;&nbsp;<?php endforeach; endif; endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="nick_name" class="control-label x85">用户昵称：</label>
                        <input type="text" name="nick_name" id="nick_name" value="<?php echo ($userInfo["nick_name"]); ?>" data-rule="required" size="20">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="avatar" class="control-label x85">用户头像：</label>
                        <div style="display:inline-block;vertical-align:middle;">
                            <div id="j_custom_pic_up" data-toggle="upload" data-uploader="<?php echo U('Admin/User/uploadAvatar');?>" 
                                 data-file-size-limit="2097152"
                                 data-file-type-exts="*.jpg;*.jpeg;*.png;*.gif;*.mpg"
                                 data-multi="false"
                                 data-on-upload-success="avatarUploadSuccess"
                                 data-icon="cloud-upload">
                            </div>
                            <input type="hidden" name="avatar" value="<?php echo ($userInfo["avatar"]); ?>" id="avatar">
                            <span id="avatarImg">
                                <?php if(!empty($userInfo["avatar"])): ?><img src="<?php echo ($userInfo["avatar"]); ?>" width="100" /><?php endif; ?>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email" class="control-label x85">用户邮箱：</label>
                        <input type="text" name="email" id="two_password" value="<?php echo ($userInfo["email"]); ?>" data-rule="email" size="20">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="phone" class="control-label x85">手机号：</label>
                        <input type="text" name="phone" id="phone" value="<?php echo ($userInfo["phone"]); ?>" data-rule="mobile" size="20">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="sex" class="control-label x85">性别：</label>
                        <?php if(!empty($userSex)): if(is_array($userSex)): foreach($userSex as $k=>$vo): ?><input type="radio" name="sex" data-toggle="icheck" value="<?php echo ($k); ?>" data-label="<?php echo ($vo); ?>" <?php if($k == $userInfo['sex']): ?>checked="checked"<?php endif; ?>>
                                &nbsp;&nbsp;<?php endforeach; endif; endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="status" class="control-label x85">用户状态：</label>
                        <?php if(!empty($commonStatus)): if(is_array($commonStatus)): foreach($commonStatus as $k=>$vo): ?><input type="radio" name="status" data-toggle="icheck" value="<?php echo ($k); ?>" data-label="<?php echo ($vo); ?>" <?php if($k == $userInfo['status']): ?>checked="checked"<?php endif; ?>>
                                &nbsp;&nbsp;<?php endforeach; endif; endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="sort" class="control-label x85">用户排序：</label>
                        <input type="text" name="sort" id="sort" value="<?php echo ($userInfo["sort"]); ?>" size="20">
                        <span>(*值越小越前)</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">更新</button></li>
    </ul>
</div>