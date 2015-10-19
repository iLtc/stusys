var jsInited = false;
function jsInit(){
    if(jsInited) return;

    var controller = $("#controller").val();
    var action = $("#action").val();
    var fun = controller+"_"+action;
    console.log(fun);

    changeNav(controller);

    try {
        eval(fun+"()");
    } catch(e) {
        console.log(e.message);
    }

    jsInited = true;

    console.log('jsInit finish');
}

function changeNav(controller){
    $("#navs").children().each(function(){
        $(this).removeClass('active');
    });

    $("#nav-"+controller).addClass('active');
}

function Module_basic(){
    $("form").submit(function(){
        if(!$("#name").val() || !$("#title").val() || !$("#tip").val()){
            msgonly('error', "请完整填写表单");
            return false;
        }

        submitForm($("form"));

        return false;
    });
}

function Module_form(){
    $(".btn-danger").click(function(){
        var url = $(this).attr('href');

        if(confirm('您确定要删除吗?')){
            $.get(url, function(data){
                if(data.status){
                    msgandpro('success', '已删除');
                    reload();
                }else{
                    msgandpro('error', '错误：'+data.info);
                }
            })
        }

        return false;
    });
}

function Module_edit(){
    $("form").submit(function(){
        if(!$("#name").val() || !$("#title").val()){
            msgonly('error', "请完整填写表单");
            return false;
        }

        submitForm($("form"));

        return false;
    });
}

function Module_view(){
    $(".panel-body").css('display', 'none');
    $(".panel-footer").css('display', 'none');

    $(".panel-heading").click(function(){
        var tid = $(this).data('tid');

        $("#body-"+tid).toggle();
        $("#footer-"+tid).toggle();
    });

    var hash = window.location.hash;
    hash = hash.substr(1);
    if(hash != ''){
        $("#body-"+hash).toggle();
        $("#footer-"+hash).toggle();
    }
}

function Module_templet(){
    var type = getQuery('type');
    if(type == 'print'){
        editorInit('#content');
        $("kbd").click(function(){
            var insert = "<u>&nbsp;&nbsp;"+$(this).html()+"&nbsp;&nbsp;</u>";
            editor.insertHtml(insert);
        });
    }else{
        $("kbd").click(function(){
            msgonly('info', "请手动复制粘贴");
        });
    }

    $("form").submit(function(){
        if(type == 'print') editor.sync();
        submitForm($("form"));

        return false;
    });
}

function Output_show(){
    $("#print-btn").click(function(){
        window.frames["view"].print();
    });
    
    $("#refresh-btn").click(function(){
        window.frames["view"].location.reload(true);
    });
    
    $("#return-btn").click(function(){
        history.back();
    });
}

function File_index(){
    $(".panel-body").css('display', 'none');
    $(".list-group").css('display', 'none');
    $(".panel-heading").click(function(){
        var fcid = $(this).data("fcid");
        $("#body-"+fcid).toggle();
        $("#list-"+fcid).toggle();
    });

    $(".btn-delete").click(function(){
        if(confirm('您确定要删除吗？')){
            var url = $(this).attr('href');
            msgandpro('info', '删除中，请稍后……');
            $.get(url, function(data){
                if(data.status){
                    msgandpro('success', '删除成功！');
                    reload();
                }else{
                    msgandpro('error', '错误：'+data.info);
                }
            })
        }
        return false;
    });
}

function File_addClass(){
    $("form").submit(function(){
        if($("#name").val() == ''){
            msgonly('error', "请填写“分类名称”");
            return false;
        }

        submitForm($("form"));

        return false;
    });
}

function File_editClass(){
    $("form").submit(function(){
        if($("#name").val() == ''){
            msgonly('error', "请填写“分类名称”");
            return false;
        }

        submitForm($("form"));

        return false;
    });
}

function File_upload(){
    var uploader = $('#uploader');
    var submit_btn = $("#submit-btn");

    uploader.uploadify({
        'swf'      : 'Public/uploadify/uploadify.swf',
        'uploader' : 'Public-upload.html',
        'buttonText' : '选择文件...',
        'multi'    : false,
        'uploadLimit' : 1,
        'auto' : false,
        'removeCompleted' : false,
        'formData'     : {
            dir: 'file'
        },
        'onSelect' : function(file) {
            var name = $("#name");
            var file_name = (file.name).replace(file.type, '');
            if(name.val() == '') name.val(file_name);
            uploader.uploadify('disable', true);
            submit_btn.removeAttr('disabled');
        },
        'onCancel' : function(file) {
            uploader.uploadify('disable', false);
            submit_btn.attr('disabled', 'true');
        },
        'onUploadSuccess' : function(file, data, response) {
            $("#url").val(data);
            submitForm($("form"));
        },
        'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            if(errorString == 'Cancelled') return;
            alert('由于以下原因，“' + file.name + '”上传失败：' + errorMsg);
            submit_btn.removeAttr('disabled');
        }
    });

    $("form").submit(function(){
        if($("#name").val() == ''){
            msgonly('error', "请填写“文件名称”");
            return false;
        }

        submit_btn.attr('disabled', 'true');

        uploader.uploadify('upload');

        return false;
    });
}

function File_edit(){
    $("form").submit(function(){
        if($("#name").val() == ''){
            msgonly('error', "请填写“文件名称”");
            return false;
        }

        submitForm($("form"));

        return false;
    });
}

function Templet_index(){
    $(".panel-body").css('display', 'none');
    $(".panel-footer").css('display', 'none');

    $(".panel-heading").click(function(){
        var tid = $(this).data('tid');

        $("#body-"+tid).toggle();
        $("#footer-"+tid).toggle();
    });

    var hash = window.location.hash;
    hash = hash.substr(1);
    if(hash != ''){
        $("#body-"+hash).toggle();
        $("#footer-"+hash).toggle();
    }
}

function Templet_edit(){
    $('form').submit(function(){
        if($("#title").val() == ''){
            msgonly('error', '标题不能为空');
            return false;
        }
        if($("#content").val() == ''){
            msgonly('error', '内容不能为空');
            return false;
        }

        submitForm($('form'));
        return false;
    });
}

function Worker_edit(){
    $('form').submit(function(){
        if($("#name").val() == ''){
            msgonly('error', '"显示名称"不能为空');
            return false;
        }

        submitForm($('form'));
        return false;
    });
}

function Config_index(){
    $('form').submit(function(){
        submitForm($('form'));
        return false;
    });
}