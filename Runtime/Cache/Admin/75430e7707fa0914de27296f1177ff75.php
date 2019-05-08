<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    function userGroupRuleTreeNodeClick(event, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj(treeId);
        zTree.checkNode(treeNode, !treeNode.checked, true, true);
        event.preventDefault();
    }
    
    function userGroupRuleTreeNodeCheck(event, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj(treeId);
        var nodes = zTree.getCheckedNodes(true);
        var form = $.CurrentNavtab.find("#addUserGroupForm");
        var ids = "";
        for (var ix = 0; ix < nodes.length; ix++) {
            ids += ','+ nodes[ix]["id"];
        }
        if (ids.length > 0) {
            ids = ids.substr(1);
        }
        form.find("input[name='rules']").val(ids);
    }
</script>
<style>
    #addUserGroupForm table td.x85 {width:85px;text-align:right;}
</style>
<div class="bjui-pageContent">
    <form id="addUserGroupForm" action="<?php echo U('Admin/Auth/addUserGroup');?>" data-toggle="validate" data-alertmsg="false">
        <table class="table table-condensed table-hover" width="100%">
            <tbody>
                <tr>
                    <td class="x85">
                        <label for="name">用户组名：</label>
                    </td>
                    <td>
                        <input type="text" name="name" id="name" value="" data-rule="required" size="20">
                    </td>
                </tr>
                <tr>
                    <td class="x85">
                        <label for="rules">权限：</label>
                    </td>
                    <td>
                        <input type="hidden" name="rules" value="">
                        <ul id="userGroupRuleTree" class="ztree" data-toggle="ztree" data-options="{expandAll:true,checkEnable:true,chkStyle:'checkbox',radioType:'all',onClick:userGroupRuleTreeNodeClick,onCheck:userGroupRuleTreeNodeCheck}">
                            <?php if(!empty($ruleData)): if(is_array($ruleData)): foreach($ruleData as $k=>$vo): ?><li data-id="<?php echo ($vo["id"]); ?>" data-pid="<?php echo ($vo["pid"]); ?>"><?php echo ($vo["title"]); ?></li><?php endforeach; endif; endif; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="x85">
                        <label for="status">状态：</label>
                    </td>
                    <td>
                        <?php if(!empty($commonStatus)): if(is_array($commonStatus)): foreach($commonStatus as $k=>$vo): ?><input type="radio" name="status" data-toggle="icheck" value="<?php echo ($k); ?>" data-label="<?php echo ($vo); ?>" <?php if($k == 1): ?>checked="checked"<?php endif; ?>>
                                &nbsp;&nbsp;<?php endforeach; endif; endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="x85">
                        <label for="sort">权限排序：</label>
                    </td>
                    <td>
                        <input type="text" name="sort" id="sort" value="0" size="20">
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
        <li><button type="submit" class="btn-default" data-icon="save">添加</button></li>
    </ul>
</div>