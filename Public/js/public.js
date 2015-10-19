NProgress.configure({showSpinner: false});

Messenger.options = {
    extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
    theme: 'future'
};

$(document).pjax('a:not([data-skip-pjax])', '#container', {timeout: 7000});

var from = window.location.href;
var to = '';

$(document).on('pjax:start', function() {
    NProgress.start();

    jsInited = false;
});
$(document).on('pjax:end', function() {
    to = $("#self").val();
    NProgress.done();

    jsInit();

    _czc.push([ "_trackPageview", to, from]);
    from = window.location.href;
});
$(document).on('pjax:error', function() {
    _czc.push(["_trackEvent", 'page', 'loadError']);
    //msgonly('info', '页面载入出错，将再次尝试……');
});

$(document).ready(function(){
    jsInit();
});


var msg = '';
function msgandpro(type, message){
    if(type == 'info') NProgress.start();
    else NProgress.done();

    if(msg == ''){
        msg = Messenger().post({
            message: message,
            type: type
        });
    }else{
        msg.update({
            message: message,
            type: type
        });
    }
}
function msgonly(type, message){
    if(msg == ''){
        msg = Messenger().post({
            message: message,
            type: type
        });
    }else{
        msg.update({
            message: message,
            type: type
        });
    }
}
function msghide(){
    Messenger().hideAll();
}

function redirect(url){
    $.pjax({url: url, container: '#container'});
}

function reload(){
    $.pjax.reload('#container');
}

//是否存在指定函数
function isExitsFunction(funcName) {
    try {
        if (typeof(eval(funcName)) == "function") {
            return true;
        }
    } catch(e) {}
    return false;
}

function submitForm(form, success, error){
    msgandpro('info', '提交中，请稍后……');
    var btn = form.find('input[type=submit]');
    btn.attr('disabled', 'true');

    var url = form.attr('action');
    if(url == undefined) url = window.location.href;

    $.ajax({
        url: url,
        data: form.serialize(),
        type: "POST",
        success: function(data){
            console.log('post success', data);
            _czc.push(["_trackEvent", 'submitForm', 'success']);
            if(data.status == true){
                msgandpro('success', data.info);
                if(isExitsFunction(success)){
                    success(data);
                }else{
                    if(data.url){
                        redirect(data.url);
                    }else{
                        reload();
                    }
                }
            }else{
                msgandpro('error', data.info);
                if(isExitsFunction(error)){
                    error(data);
                    btn.removeAttr('disabled', 'true');
                }else{
                    if(data.url){
                        redirect(data.url);
                    }else{
                        btn.removeAttr('disabled', 'true');
                    }
                }
            }
        },
        error: function(jqXHR, textStatus){
            console.log('post error');
            _czc.push(["_trackEvent", 'submitForm', 'error']);
            msgandpro('error', "由于以下原因，提交失败："+textStatus);
            if(isExitsFunction(error)){
                error();
            }
            btn.removeAttr('disabled', 'true');
        }
    });
}

//获取操作历史
function getApplyLog(obj){
    var code = obj.data('code');
    $.get('/System-Log-apply.html?code='+code, function(data){
        obj.html(data);
    });
}

//获得地址栏中的参数
function getQuery(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  decodeURI(r[2]); return null;
}

function editorInit(editor){
    KindEditor.ready(function(K) {
        window.editor = K.create(editor,{
            items: ['source', '|', 'undo', 'redo', '|', 'cut', 'copy', 'paste', 'plainpaste', 'wordpaste', '|',
                'formatblock', 'fontname', 'fontsize', '|', 'bold',
                'italic', 'underline', 'lineheight', 'removeformat', '|',
                'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                'superscript', 'clearhtml', 'quickformat', 'selectall', '|',
                'image', 'insertfile', 'table', 'hr', 'pagebreak', 'link', 'unlink', '|', 'fullscreen'],
            uploadJson : 'Public-editor_upload.html',
            allowFileManager : false,
            height : '500px'
        });
    });
}

function setIframeHeight(iframe) {
	if (iframe) {
		var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
		if (iframeWin.document.body) {
			iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
		}
	}
}