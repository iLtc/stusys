var jsInited = false;
function jsInit(){
    if(jsInited) return;

    var controller = $("#controller").val();
    var action = $("#action").val();
    var fun = controller+"_"+action;
    console.log(fun);

    try {
        eval(fun+"()");
    } catch(e) {
        console.log(e.message);
    }

    jsInited = true;

    console.log('jsInit finish');
}

function accountUnique(element){
    $.ajax('/System-Account-unique.html', {
        type: 'POST',
        async: false,
        data: {name: element.name, value: element.value},
        success: function(data){
            if(data.status == true) result = true;
            else result =  {'error': data.info};
        },
        error: function(){result = {'error': '未知错误'};}
    });
    return result;
}

function Sign_register(){
    $('#regform').validator({
        showOk: "",
        stopOnError: false,
        timely: true,
        rules:{
            unique: function(element){
                return accountUnique(element);
            },
            stutype: function(element){
                if(element.value == 0) return '请选择';
                else return true;
            },
            isaddress: function(element){
                return true;
            },
            address: function(){
                if($("#stutype").val()>10 && $("#isaddress").is(':checked')) return true;
                else return false;
            }
        },
        fields: {
            'phone': {
                rule: 'required, integer, length[11], mobile, unique',
                msg: {
                    length: '位数不足'
                },
                tip: '用于登陆和接收通知'
            },
            'email': {
                rule: 'required, email, unique',
                tip: '用于登陆和接收回执'
            },
            'password': 'required',
            'repassword': {
                rule: 'required, match[password]',
                msg: {
                    match: '两次输入不一致'
                }
            },
            'name': 'required',
            'sex': 'checked',
            'sid': {
                rule: 'required, integer, length[9~13], unique',
                msg: {
                    length: '位数不足'
                },
                tip: '用于登陆和识别'
            },
            'year': {
                rule: 'required, integer, length[4], range[2000~2099]',
                mag: {
                    length: '请填写4位年份',
                    range: '年份不正确'
                }
            },
            'major': 'required',
            'stutype': 'stutype',
            'isaddress': 'isaddress',
            'address': 'required(address)',
            'code': {
                rule: 'required, length[4]',
                tip: '点击图片可以刷新验证码'
            }
        },

        valid: function(form){
            var me = this;

            // 提交表单之前，hold住表单，防止重复提交
            me.holdSubmit();

            submitForm($(form),
                function(data) {
                    window.location.href = data.url;
                },
                function(data) {
                    $("#reg-img").click();
                    me.holdSubmit(false);
                }
            );
        }
    });

    $("#stutype").change(function(){
        var value = $(this).val();
        if(value<5){
            $("#isaddressdiv").css('display', 'none');
        }else{
            $("#isaddressdiv").css('display', 'block');
        }
    });
    $("#isaddress").click(function(){
        if($("#stutype").val()>10){
            if($(this).is(':checked')){
                $("#addressdiv").css('display', 'block');
            }else{
                $("#addressdiv").css('display', 'none');
            }
        }
    });

    $("#loginform").on('submit', function(){
        if($("#username").val() == ''){
            msgonly('error', '请填写用户名');
            return false;
        }
        if($("#loginpassword").val() == ''){
            msgonly('error', '请填写密码');
            return false;
        }
        if($("#login-code").val() == ''){
            msgonly('error', '请填写验证码');
            return false;
        }

        submitForm($("#loginform"),
            function(data) {
                window.location.href = data.url;
            },
            function(data) {
                $("#login-img").click();
            }
        );
        return false;
    });

    codeImg();
}

function Sign_forget(){
    codeImg();

    $('form').submit(function(){
        if($('#name').val() == '' || $('#sid').val() == '' || $('#target').val() == '' || $('#code').val() == ''){
            msgonly('error', '请完整填写表单');
            return false;
        }
        submitForm($(this), '', function(data){
            if(data.info == '验证码不正确') $("#code-img").click();
            else redirect(data.url);
        });

        return false;
    });
}

function Apply_form(){
    var form_name = $("#apply_form_name").val();
    var func = form_name+'_script';

    try {
        eval(func+"()");
    } catch(e) {
        console.log(e.message);
    }

    $(".show-uploader-btn").each(function(){
        var name = $(this).data('name');

        uploaderInit(name);
    });

	$(".datepicker").datepicker({
		todayBtn: "linked",
		language: "zh-CN",
		autoclose: true
	}).on('changeDate', function(e){
		//var target = $("#" + e.currentTarget.id.split("_")[0]);
		//target.val((new Date(e.date)).getTime()/1000).trigger("validate");
		$("#" + e.currentTarget.id).trigger("validate");
	});
}

function Apply_history(){
    $(".btn-cancel").click(function(){
        if(confirm('您确定要撤销此申请吗？')){
            var url = $(this).attr('href');
            msgandpro('info', '撤销中，请稍后……');
            $.get(url, function(data){
                if(data.status){
                    msgandpro('success', '撤销成功！');
                    reload();
                }else{
                    msgandpro('error', '错误：'+data.info);
                }
            })
        }
        return false;
    });
}

function Public_detail(){
    getApplyLog($("#log"));
}

function Account_index(){
    $(".remove-auth").click(function(){
        if(confirm('您确定要解除绑定吗？')){
            var url = $(this).attr('href');
            msgandpro('info', '解除中，请稍后……');
            $.get(url, function(){
                msgandpro('success', '解除成功！');
                reload();
            })
        }
        return false;
    });
}

function Account_edit(){
    $('form').validator({
        showOk: "",
        stopOnError: false,
        timely: true,
        rules:{
            unique: function(element){
                return accountUnique(element);
            },
            stutype: function(element){
                if(element.value == 0) return '请选择';
                else return true;
            },
            isaddress: function(element){
                return true;
            },
            address: function(){
                if($("#stutype").val()>10 && $("#isaddress").is(':checked')) return true;
                else return false;
            }
        },
        fields: {
            'password': 'required',
            'phone': {
                rule: 'required, integer, length[11], mobile, unique',
                msg: {
                    length: '位数不足'
                },
                tip: '用于登陆和接收通知'
            },
            'email': {
                rule: 'required, email, unique',
                tip: '用于登陆和接收回执'
            },
            'major': 'required',
            'stutype': 'stutype',
            'isaddress': 'isaddress',
            'address': 'required(address)'
        },

        valid: function(form){
            var me = this;

            submitForm($(form),
                function(data){
                    window.location.href = data.url;
                },
                function() {
                    $("#reg-img").click();
                }
            );
        }
    });

    $("#stutype").change(function(){
        var value = $(this).val();
        if(value<5){
            $("#isaddressdiv").css('display', 'none');
        }else{
            $("#isaddressdiv").css('display', 'block');
        }
    });
    $("#isaddress").click(function(){
        if($("#stutype").val()>10){
            if($(this).is(':checked')){
                $("#addressdiv").css('display', 'block');
            }else{
                $("#addressdiv").css('display', 'none');
            }
        }
    });
}

function Account_password(){
    $('form').submit(function(){
        if($('#oldpassword').val() == '' || $('#password').val() == '' || $('#repassword').val() == ''){
            msgonly('error', '请完整填写表单');
            return false;
        }
        submitForm($(this), function(data){
            window.location.href = data.url;
        });

        return false;
    });
}

function Account_send(){
    codeImg();

    $('form').submit(function(){
        if($('#code').val() == ''){
            msgonly('error', '请填写验证码');
            return false;
        }

        submitForm($('form'), '', function(data){
            $("#code-img").click();
        });
        return false;
    });
}

function Account_verify(){
    codeImg();

    $('form').submit(function(){
        if($('#verify').val() == ''){
            msgonly('error', '请填写校验码');
            return false;
        }

        submitForm($('form'));
        return false;
    });
}

function uploaderInit(name){
    var img_obj = $("#"+name+"_img");
    var upload_input = $("#"+name);
    var submit_btn = $('input[type=submit]');
    var line1 = $("#"+name+"_line1");
    var line2 =$("#"+name+"_line2");
    var error_txt = $("#"+name+"_error");

    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,silverlight,html4',    //上传模式,依次退化
        browse_button: name+'_btn',       //上传选择的点选按钮，**必需**
        uptoken_url: '/System-Upload-qiniu.html',
        //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
        //unique_names: false,
        domain: $('#qiniu-url').val(),
        //bucket 域名，下载资源时用到，**必需**
        container: name+'_queue',           //上传区域DOM ID，默认是browser_button的父元素，
        max_file_size: '3mb',           //最大文件体积限制
        filters: {
            mime_types : [
                { title : "图片文件", extensions : "jpg,gif,png,jpeg" }
            ]
        },
        flash_swf_url: '/Public/plupload/Moxie.swf',  //引入flash,相对路径
        silverlight_xap_url: '/Public/plupload/Moxie.xap',
        max_retries: 3,                   //上传失败最大重试次数
        dragdrop: true,                   //开启可拖曳上传
        drop_element: 'container',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                //分块上传时，每片的体积
        auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
        init: {
            'PostInit': function() {
                error_txt.html('');
            },
            'FilesAdded': function(up, files) {
                plupload.each(files, function(file) {
                    // 文件添加进队列后,处理相关的事情
                    line2.css('width', '15%');
                    line1.css('display', 'block');
                });
            },
            'BeforeUpload': function(up, file) {
                // 每个文件上传前,处理相关的事情
                submit_btn.attr('disabled', 'true');
            },
            'UploadProgress': function(up, file) {
                // 每个文件上传时,处理相关的事情
                line2.css('width', file.percent+'%');
            },
            'FileUploaded': function(up, file, info) {
                var domain = up.getOption('domain');
                var res = $.parseJSON(info);
                var file = domain + res.key;
                uploaderImg(img_obj, file);

                if(upload_input.val() == ''){
                    upload_input.val(file);
                }else{
                    upload_input.val(upload_input.val()+', '+file);
                }
            },
            'Error': function(up, err, errTip) {
                //上传出错时,处理相关的事情
                alert('由于以下原因，'+err.file.name+'上传失败：'+errTip);
            },
            'UploadComplete': function() {
                //队列文件处理完毕后,处理相关的事情
                submit_btn.removeAttr('disabled');
                line1.css('display', 'none');
            },
            'Key': function(up, file) {
				var uid = $("#uid").val();
                var tempArr = file.name.split(".");
                var ext;
                if (tempArr.length === 1 || (tempArr[0] === "" && tempArr.length === 2)) ext = "";
                else ext = tempArr.pop().toLowerCase();
                var name = ext ? file.id + '.' + ext : file.id;

                var date = new Date();
                var year = date.getFullYear();
                var month = date.getMonth() + 1;
                if(month < 10) month = '0' + month;

                return 'img/'+year+month+'/'+uid+'/'+name;
            }
        }
    });

    console.log(name + ' upload inited');
    /*uploader.uploadify({
        'swf'      : 'Public/uploadify/uploadify.swf',
        'uploader' : 'Public-upload.html',
        'buttonText' : '选择文件...',
        'fileSizeLimit' : '3MB',
        'fileTypeDesc' : '图片附件...',
        'fileTypeExts' : '*.gif; *.jpg; *.png; *.jpeg',
        //'auto'     : false,
        'removeCompleted' : false,
        'formData'     : {
            dir: 'img'
        },
        'onUploadStart' : function(file) {
            $("#uploader-finish-btn").attr('disabled', 'disabled');
            upload_info.html('上传中，请稍后……');
        },
        'onUploadSuccess' : function(file, data, response) {
            uploaderImg(img_obj, data);

            if(upload_input.val() == ''){
                upload_input.val(data);
            }else{
                upload_input.val(upload_input.val()+', '+data);
            }
        },
        'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            if(errorString == 'Cancelled') return;
            alert('由于以下原因，“' + file.name + '”上传失败：' + errorMsg);
        },
        'onQueueComplete' : function(queueData) {
            $("#uploader-finish-btn").removeAttr('disabled');
            upload_info.html('上传完成，请点击“完成”按钮返回');
        }
    });*/

/*$("#uploader-box").modal('show');

    $("#uploader-finish-btn").click(function(){
        if($(this).attr('disabled')) return false;

        $("#uploader-box").modal('hide');
    });

    $('#uploader-box').on('hide.bs.modal', function (e) {
        $(".uploadify-queue").remove();
        upload_input.trigger("validate");
        upload_info.html('请点击“选择文件”按钮选择文件');
    });*/
}

function uploaderImg(obj, url){
    obj.append("<a href='"+url+"' data-lightbox='upload'><img src='"+url+"!style1' class='img-polaroid'></a>");
}

function codeImg(){
    $(".code-img").click(function(){
        var img = $(this);
        img.attr('src', img.attr('src')+Math.random().toString().substr(2, 1));
        $("#"+img.data("for")).val('');
        $("#"+img.data("for")).focus();
    });
}