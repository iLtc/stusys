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
    $(".navbar-nav").children().each(function(){
        $(this).removeClass('active');
    });

    $("#nav-"+controller).addClass('active');
}

function Apply_index(){
    var status = getQuery('status');
    if(status == null) status = 0;
    $("#status-"+status).addClass('active');

    var fromDate = $("#fromDate");
    var toDate = $("#toDate");
    fromDate.datepicker({
        defaultDate: "-1w",
        dateFormat:'yy-mm-dd',
        maxDate:'0d',
        numberOfMonths: 2,
        onClose: function( selectedDate ) {
            if(selectedDate != '') toDate.datepicker( "option", "minDate", selectedDate );
        }
    });
    toDate.datepicker({
        dateFormat:'yy-mm-dd',
        maxDate:'0d',
        numberOfMonths: 2,
        onClose: function( selectedDate ) {
            if(selectedDate != '') fromDate.datepicker( "option", "maxDate", selectedDate );
        }
    });

    $("#filter-form").submit(function(){
        var aid = $("#aid").val();
        var type = $("#type").val();
        var status = $("#status").val();
        var from = $("#fromDate").val();
        var to = $("#toDate").val();
        var stutype = $("#stutype").val();

        if((from == '' && to != '') || (from != '' && to == '')){
            msgonly('error', '日期范围请填写完整');
        }else{
            $("#filter").modal('hide');
            msghide();
            var url = '/Worker-Apply.html?type='+type+'&status='+status+'&stutype='+stutype;
            if(aid != '') url += '&aid='+aid;
            if(from != '') url += '&from='+from+'&to='+to;
            redirect(url);
        }

        return false;
    });


    $("td .btn-primary").click(function(){
        $(this).parent().parent().css('background-color', 'LightGrey');
    });
    $("td .btn-success").click(function(){
        $(this).parent().parent().css('background-color', 'LightGrey');
    });
}

function Apply_verify(){
    $("#refuse-form").css('display', 'none');
    getApplyLog($("#log"));

    /*$('input[type=submit]').click(function(){
        $('#type').val($(this).val());
    });*/

    $("#refuse-button").click(function(){
        $("#refuse-form").slideToggle();
    });

    $('form').submit(function(){
        submitForm($(this));

        return false;
    });
}

function Apply_editapply(){
    $('form').submit(function(){
        submitForm($(this));

        return false;
    });
}

function Apply_view(){
    $("#print-now").click(function(){
        msghide();
        $.get($(this).data('confirm'));
        window.print();
        return false;
    });

    $("#refresh-now").click(function(){
        $.get($(this).attr('href'), function(){
            msgonly('info', '重置成功');
            reload();
        })
        return false;
    });
}

function Apply_editview(){
    editorInit('#editor');

    $('form').submit(function(){
        editor.sync();
        submitForm($(this));

        return false;
    });
}

function Apply_editview2nd(){
    var editor = simditorInit($("#editor"));
    
    $('form').submit(function(){
        editor.sync();
        submitForm($(this));

        return false;
    });
}

function Apply_detail(){
    getApplyLog($("#log"));

    $('form').submit(function(){
        submitForm($(this), function(data){
            $("#change").modal('hide');
            redirect(data.url);
        });

        return false;
    });
}

function Student_index(){
    $("#search-form").submit(function(){
        var search = $("#keyword").val();

        if(search == ''){
            msgonly('error', '请填写关键字');
        }else{
            $("#search").modal('hide');
            msghide();
            var url = '/Worker-Student.html?search='+search;
            redirect(url);
        }

        return false;
    });
}

function Student_edit(){
    $('form').submit(function(){
        submitForm($(this));

        return false;
    });
}

function Student_detail(){
    var hash = window.location.hash;

    if(hash == '#send') $('#send').modal('show');

    $('form').submit(function(){
        submitForm($(this), function(){
            $("#send").modal('hide');
        });

        return false;
    });
}

function Account_password(){
    $('form').submit(function(){
        if($('#oldpassword').val() == '' || $('#password').val() == '' || $('#repassword').val() == ''){
            msgonly('error', '请完整填写表单');
            return false;
        }
        submitForm($(this));

        return false;
    });
}

