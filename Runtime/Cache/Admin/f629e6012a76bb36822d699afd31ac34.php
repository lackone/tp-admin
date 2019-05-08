<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    function parentRuleTreeNodeClick(event, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj(treeId);
        zTree.checkNode(treeNode, !treeNode.checked, true, true);
        event.preventDefault();
    }
    
    function parentRuleTreeNodeCheck(event, treeId, treeNode) {
        var form = $.CurrentNavtab.find("#ruleForm");
        form.find("input[name='parentRuleName']").val(treeNode["name"]);
        form.find("input[name='pid']").val(treeNode["id"]);
    }

    function ruleListTreeNodeClick(event, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj(treeId);
        var form = $.CurrentNavtab.find("#ruleForm");

        form.find("input[name='title']").val(treeNode["name"]);
        form.find("input[name='name']").val(treeNode["url"]);
        form.find("input[name='parentRuleName']").val(treeNode["ptitle"]);
        form.find("input[name='pid']").val(treeNode["pid"]);
        form.find("input[name='sort']").val(treeNode["sort"]);
        form.find("input[name='ruleId']").val(treeNode["id"]);

        var type = form.find("input[name='type']");
        $.each(type, function () {
            $(this).iCheck("uncheck");

            if ($(this).val() == treeNode["type"]) {
                $(this).iCheck("check");
            }
        });

        var status = form.find("input[name='status']");
        $.each(status, function () {
            $(this).iCheck("uncheck");

            if ($(this).val() == treeNode["status"]) {
                $(this).iCheck("check");
            }
        });

        event.preventDefault();
    }

    function setFontCss(treeId, treeNode) {
        return treeNode["status"] == 0 ? {color: "red"} : {};
    }

    $.CurrentNavtab.find("#addRuleBtn").on("click", function () {
        var form =  $.CurrentNavtab.find("#ruleForm");
        form.attr("action", "<?php echo U('Admin/Auth/addRule');?>");
        form.bjuiajax("ajaxForm", {
            callback: function (data) {
                $(this).bjuiajax('ajaxDone', data).navtab('refresh');
            }
        });
    });
    
    $.CurrentNavtab.find("#updRuleBtn").on("click", function () {
        var form =  $.CurrentNavtab.find("#ruleForm");
        form.attr("action", "<?php echo U('Admin/Auth/updRule');?>");
        form.bjuiajax("ajaxForm", {
            callback: function (data) {
                $(this).bjuiajax('ajaxDone', data).navtab('refresh');
            }
        });
    });
    
    $.CurrentNavtab.find("#delRuleBtn").on("click", function () {
        var form =  $.CurrentNavtab.find("#ruleForm");
        form.attr("action", "<?php echo U('Admin/Auth/delRule');?>");
        form.bjuiajax("ajaxForm", {
            callback: function (data) {
                $(this).bjuiajax('ajaxDone', data).navtab('refresh');
            }
        });
    });
</script>
<div class="bjui-pageContent">
    <div class="col-md-4 col-sm-12">
        <div style="overflow:auto;">
            <ul id="ruleListTree" class="ztree" data-toggle="ztree" data-options="{expandAll:true,onClick:ruleListTreeNodeClick,setting:{view:{fontCss:setFontCss}}}">
                <?php if(!empty($allRuleData)): if(is_array($allRuleData)): foreach($allRuleData as $k=>$vo): ?><li data-id="<?php echo ($vo["id"]); ?>" data-pid="<?php echo ($vo["pid"]); ?>" data-ptitle="<?php echo ($vo["ptitle"]); ?>" data-url="<?php echo ($vo["name"]); ?>" data-type="<?php echo ($vo["type"]); ?>" data-status="<?php echo ($vo["status"]); ?>" data-sort="<?php echo ($vo["sort"]); ?>"><?php echo ($vo["title"]); ?></li><?php endforeach; endif; endif; ?>
            </ul>
        </div>
    </div>
    <div class="col-md-8 col-sm-12">
        <div id="ruleInfo">
            <form id="ruleForm">
                <div class="form-group">
                    <label for="title" class="control-label x85">权限中文名：</label>
                    <input type="text" name="title" id="title" value="" data-rule="required" size="20">
                </div>
                <div class="form-group">
                    <label for="name" class="control-label x85">权限标识：</label>
                    <input type="text" name="name" id="name" value="" data-rule="required" size="20">
                    <span>(*英文,模块/控制器/方法)</span>
                </div>
                <div class="form-group">
                    <label for="pid" class="control-label x85">父级权限：</label>
                    <input type="text" name="parentRuleName" data-toggle="selectztree" value="" size="20" data-tree="#parentRuleTree" readonly>
                    <input type="hidden" name="pid" value="">
                    <ul id="parentRuleTree" class="ztree hide" data-toggle="ztree" data-options="{expandAll:true,checkEnable:true,chkStyle:'radio',radioType:'all',onClick:parentRuleTreeNodeClick,onCheck:parentRuleTreeNodeCheck}">
                        <?php if(!empty($parentRuleData)): if(is_array($parentRuleData)): foreach($parentRuleData as $k=>$vo): ?><li data-id="<?php echo ($vo["id"]); ?>" data-pid="<?php echo ($vo["pid"]); ?>"><?php echo ($vo["title"]); ?></li><?php endforeach; endif; endif; ?>
                    </ul>
                    <span>(*如果不选,默认顶级)</span>
                </div>
                <div class="form-group">
                    <label for="type" class="control-label x85">权限类型：</label>
                    <?php if(!empty($ruleType)): if(is_array($ruleType)): foreach($ruleType as $k=>$vo): ?><input type="radio" name="type" data-toggle="icheck" value="<?php echo ($k); ?>" data-label="<?php echo ($vo); ?>" <?php if($k == 0): ?>checked="checked"<?php endif; ?>>
                            &nbsp;&nbsp;<?php endforeach; endif; endif; ?>
                </div>
                <div class="form-group">
                    <label for="status" class="control-label x85">权限状态：</label>
                    <?php if(!empty($commonStatus)): if(is_array($commonStatus)): foreach($commonStatus as $k=>$vo): ?><input type="radio" name="status" data-toggle="icheck" value="<?php echo ($k); ?>" data-label="<?php echo ($vo); ?>" <?php if($k == 1): ?>checked="checked"<?php endif; ?>>
                            &nbsp;&nbsp;<?php endforeach; endif; endif; ?>
                </div>
                <div class="form-group">
                    <label for="sort" class="control-label x85">权限排序：</label>
                    <input type="text" name="sort" id="sort" value="0" size="20">
                    <span>(*值越小越前)</span>
                </div>
                <div class="form-group">
                    <label class="control-label x85"></label>
                    <?php if(checkRule('Admin/Auth/addRule')): ?><input type="button" class="btn btn-green" id="addRuleBtn" value="添加权限"><?php endif; ?>
                    <?php if(checkRule('Admin/Auth/updRule')): ?><input type="button" class="btn btn-green" id="updRuleBtn" value="更新权限"><?php endif; ?>
                    <?php if(checkRule('Admin/Auth/delRule')): ?><input type="button" class="btn btn-red" id="delRuleBtn" value="删除权限"><?php endif; ?>
                    <input type="hidden" name="ruleId" value="">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
    </ul>
</div>