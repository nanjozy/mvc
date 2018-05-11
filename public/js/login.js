var check = [false, false];
$(function () {
        $("#username").blur(function () {
            checkUser();
        });
        $("#password").blur(function () {
            checkPass();
        });
    }
)

function cCheckT() {
    var re = true;
    for (var i = 0; i < check.length; i++) {
        if (check[i] == false) {
            re = false;
        }
    }
    return re;
}

function checkUser() {
    var username = $("#username").val();
    if (!/^[a-zA-Z][a-zA-Z0-9]{2,8}$/.test(username)) {
        $("#userAlert").html("请输入正确的用户名！");
        $("#userAlert").removeClass("green");
        check[0] = false;
        $("#btn").attr("disabled", true);
    }
    else {
        $("#userAlert").html("*");
        $("#userAlert").addClass("green");
        check[0] = true;
        if (cCheckT()) {
            $("#btn").attr("disabled", false);
        }
    }
}

function checkPass() {
    var password = $("#password").val();
    if (!/^[a-zA-Z0-9]{4,16}$/.test(password)) {
        $("#passAlert").html("请输入正确的密码");
        $("#passAlert").removeClass("green");
        check[1] = false;
        $("#btn").attr("disabled", true);
    }
    else {
        $("#passAlert").html("*");
        $("#passAlert").addClass("green");
        check[1] = true;
        if (cCheckT()) {
            $("#btn").attr("disabled", false);
        }
    }
}

