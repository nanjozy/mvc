var ws;

$(function () {
    $("#content").blur(function () {
        checkTe();
    });
})

function connWS() {
    try {
        ws = new WebSocket("ws://127.0.0.1:8282");//连接服务器
        ws.onopen = function (event) {
            $("#cdt").html("已经与服务器建立了连接<br/>当前连接状态：" + this.readyState);
        };
        ws.onmessage = function (event) {
            data = JSON.parse(event.data);
            console.log(data);
            switch (data.type) {
                case 'init':
                    switch (data.code) {
                        case 0:
                            $.ajax({
                                url: '<?=$url_bind?>',
                                type: 'post',
                                dataType: 'json',
                                data: {client_id: data.client_id},
                                success: function (res) {
                                },
                                error: function (res, res2) {
                                }
                            });
                    }
                    break;
                case 'message':
                    switch (data.code) {
                        case '0':
                            console.log(data.msg);
                            $("#msg").html($("#msg").html() + "<br/>" + data.msg);
                    }
            }

        };
        ws.onclose = function (event) {
            $("#cdt").html("已经与服务器断开连接<br/>当前连接状态：" + this.readyState);
        };
        ws.onerror = function (event) {
            $("#cdt").html("WebSocket异常！");
        };
    } catch (ex) {
        $("#cdt").html(ex.message);
    }
};

function checkTe() {
    if ($("#content").val()) {
        $("#btn").attr("disabled", false);
    } else {
        $("#btn").attr("disabled", true);
    }
}

function postMsg() {
    if ($("#content").val()) {
        $.ajax({
            url: '<?=url_postMsg?>',
            type: 'post',
            dataType: 'json',
            data: {
                type: 'message',
                code: 0,
                msg: $("#content").val()
            },
            success: function (res) {
                $("#content").val('');
            },
            error: function () {

            }
        });
    }
}

function sendMsg() {
    try {
        var content = $("#content").val();
        var msg = {
            "code": 1,
            "content": content
        };
        msg = JSON.stringify(msg);
        if (content) {
            ws.send(msg);
        }

    } catch (ex) {
        $("#cdtS").html(ex.message);
    }
};