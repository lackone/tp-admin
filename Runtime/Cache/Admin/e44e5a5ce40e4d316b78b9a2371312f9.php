<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    function parentCateTreeNodeClick(event, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj(treeId);
        zTree.checkNode(treeNode, !treeNode.checked, true, true);
        event.preventDefault();
    }
    
    function parentCateTreeNodeCheck(event, treeId, treeNode) {
        var form = $.CurrentNavtab.find("#categoryForm");
        form.find("input[name='parentCateName']").val(treeNode["name"]);
        form.find("input[name='pid']").val(treeNode["id"]);
    }

    function cateListTreeNodeClick(event, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj(treeId);
        var form = $.CurrentNavtab.find("#categoryForm");

        form.find("input[name='name']").val(treeNode["name"]);
        form.find("input[name='parentCateName']").val(treeNode["pname"]);
        form.find("input[name='pid']").val(treeNode["pid"]);
        if(treeNode["pic"]) {
            form.find("#pic").val(treeNode["pic"]);
            form.find("#picImg").html("<img src='" + treeNode["pic"] + "' width='100' />");
        }
        form.find("input[name='sort']").val(treeNode["sort"]);
        form.find("input[name='cateId']").val(treeNode["id"]);


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

    $.CurrentNavtab.find("#addCategoryBtn").on("click", function () {
        var form =  $.CurrentNavtab.find("#categoryForm");
        form.attr("action", "<?php echo U('Admin/Category/addCategory');?>");
        form.bjuiajax("ajaxForm", {
            callback: function (data) {
                $(this).bjuiajax('ajaxDone', data).navtab('refresh');
            }
        });
    });
    
    $.CurrentNavtab.find("#updCategoryBtn").on("click", function () {
        var form =  $.CurrentNavtab.find("#categoryForm");
        form.attr("action", "<?php echo U('Admin/Category/updCategory');?>");
        form.bjuiajax("ajaxForm", {
            callback: function (data) {
                $(this).bjuiajax('ajaxDone', data).navtab('refresh');
            }
        });
    });
    
    $.CurrentNavtab.find("#delCategoryBtn").on("click", function () {
        var form =  $.CurrentNavtab.find("#ruleForm");
        form.attr("action", "<?php echo U('Admin/Category/delCategory');?>");
        form.bjuiajax("ajaxForm", {
            callback: function (data) {
                $(this).bjuiajax('ajaxDone', data).navtab('refresh');
            }
        });
    });
    
    function picUploadSuccess(file, data) {
        var data = $.parseJSON(data);
        $(this).bjuiajax("ajaxDone", data);
        if (data["statusCode"] == 200) {
            $.CurrentNavtab.find("#pic").val(data["data"]["filename"]);
            $.CurrentNavtab.find("#picImg").html("<img src='" + data["data"]["filename"] + "' width='100' />");
        }
    }
</script>
<div class="bjui-pageContent">
    <div class="col-md-4 col-sm-12">
        <div style="overflow:auto;">
            <ul id="cateListTree" class="ztree" data-toggle="ztree" data-options="{expandAll:true,onClick:cateListTreeNodeClick,setting:{view:{fontCss:setFontCss}}}">
                <?php if(!empty($allCateData)): if(is_array($allCateData)): foreach($allCateData as $k=>$vo): ?><li data-id="<?php echo ($vo["id"]); ?>" data-pid="<?php echo ($vo["pid"]); ?>" data-pname="<?php echo ($vo["pname"]); ?>" data-pic="<?php echo ($vo["pic"]); ?>" data-status="<?php echo ($vo["status"]); ?>" data-sort="<?php echo ($vo["sort"]); ?>"><?php echo ($vo["name"]); ?></li><?php endforeach; endif; endif; ?>
            </ul>
        </div>
    </div>
    <div class="col-md-8 col-sm-12">
        <div id="categoryInfo">
            <form id="categoryForm">
                <div class="form-group">
                    <label for="name" class="control-label x85">栏目名称：</label>
                    <input type="text" name="name" id="name" value="" data-rule="required" size="20">
                </div>
                <div class="form-group">
                    <label for="pid" class="control-label x85">父级栏目：</label>
                    <input type="text" name="parentCateName" data-toggle="selectztree" value="" size="20" data-tree="#parentCateTree" readonly>
                    <input type="hidden" name="pid" value="">
                    <ul id="parentCateTree" class="ztree hide" data-toggle="ztree" data-options="{expandAll:true,checkEnable:true,chkStyle:'radio',radioType:'all',onClick:parentCateTreeNodeClick,onCheck:parentCateTreeNodeCheck}">
                        <?php if(!empty($parentCateData)): if(is_array($parentCateData)): foreach($parentCateData as $k=>$vo): ?><li data-id="<?php echo ($vo["id"]); ?>" data-pid="<?php echo ($vo["pid"]); ?>"><?php echo ($vo["name"]); ?></li><?php endforeach; endif; endif; ?>
                    </ul>
                    <span>(*如果不选,默认顶级)</span>
                </div>
                <div class="form-group">
                    <label for="type" class="control-label x85">栏目图片：</label>
                    <div style="display:inline-block;vertical-align:middle;">
                        <div data-toggle="upload" data-uploader="<?php echo U('Admin/Category/uploadPic');?>" 
                             data-file-size-limit="2097152"
                             data-file-type-exts="*.jpg;*.jpeg;*.png;*.gif;*.mpg"
                             data-multi="false"
                             data-on-upload-success="picUploadSuccess"
                             data-icon="cloud-upload">
                        </div>
                        <input type="hidden" name="pic" value="" id="pic">
                        <span id="picImg"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="control-label x85">栏目状态：</label>
                    <?php if(!empty($commonStatus)): if(is_array($commonStatus)): foreach($commonStatus as $k=>$vo): ?><input type="radio" name="status" data-toggle="icheck" value="<?php echo ($k); ?>" data-label="<?php echo ($vo); ?>" <?php if($k == 1): ?>checked="checked"<?php endif; ?>>
                            &nbsp;&nbsp;<?php endforeach; endif; endif; ?>
                </div>
                <div class="form-group">
                    <label for="sort" class="control-label x85">栏目排序：</label>
                    <input type="text" name="sort" id="sort" value="0" size="20">
                    <span>(*值越小越前)</span>
                </div>
                <div class="form-group">
                    <label class="control-label x85"></label>
                    <?php if(checkRule('Admin/Category/addCategory')): ?><input type="button" class="btn btn-green" id="addCategoryBtn" value="添加栏目"><?php endif; ?>
                    <?php if(checkRule('Admin/Category/updCategory')): ?><input type="button" class="btn btn-green" id="updCategoryBtn" value="更新栏目"><?php endif; ?>
                    <?php if(checkRule('Admin/Category/delCategory')): ?><input type="button" class="btn btn-red" id="delCategoryBtn" value="删除栏目"><?php endif; ?>
                    <input type="hidden" name="cateId" value="">
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