var check = [false, false, false];
$(function () {
    $("#username").blur(function () {
        $("#alert").fadeOut();
        checkUser();
    });
    $("#password").blur(function () {
        $("#alert").fadeOut();
        checkPass();
    });
    $("#password2").blur(function () {
        $("#alert").fadeOut();
        checkPass2();
    });
    $("#btn").click(function () {
        $("#btn").attr("disabled", true);
        register();
    });
});

function cCheckT() {
    var re = true;
    for (var i = 0; i < check.length; i++) {
        if (check[i] == false) {
            re = false;
        }
    }
    return re;
}

function register() {
    if (cCheckT()) {
        var username = $("#username").val();
        var password = $("#password").val();
        var password2 = $("#password2").val();
        $.ajax({
            url: url_reg,
            type: 'post',
            dataType: 'json',
            data: {
                code: 1,
                username: username,
                password: password,
                password2: password2
            },
            success: function (res) {
                if (res.code == 0) {
                    $("#alert").html(res.msg);
                    $("#alert").fadeIn();
                    checkUser();
                    checkPass();
                    checkPass2();
                } else if (res.code == 1) {

                    $("#alert").html(res.msg);
                    $("#alert").fadeIn();
                    $("#username").val('');
                    $("#password").val('');
                    $("#password2").val('');
                }
            },
            error: function () {
                $("#alert").html('error');
                $("#alert").fadeIn();
                $("#btn").attr("disabled", false);
            }
        });
    }
}

function checkUser() {
    var uname = $("#username").val();
    if (!/^[a-zA-Z][a-zA-Z0-9]{4,8}$/.test(uname)) {
        check[0] = false;
        $("#userAlert").html("用户名格式错误!");
        $("#userAlert").removeClass("green");
        $("#btn").attr("disabled", true);
    }
    else {
        $.ajax({
            url: url_cr,
            type: 'post',
            dataType: 'json',
            data: {
                code: 0,
                name: uname
            },
            success: function (res) {
                if (res.code == -9) {
                    check[0] = false;
                    $("#userAlert").html('');
                    $("#userAlert").removeClass("green");
                    $("#btn").attr("disabled", true);
                } else if (res.code == -1) {
                    check[0] = false;
                    $("#userAlert").html(res.msg);
                    $("#userAlert").removeClass("green");
                    $("#btn").attr("disabled", true);
                } else if (res.code == 0) {
                    check[0] = false;
                    $("#userAlert").html(res.msg);
                    $("#userAlert").removeClass("green");
                    $("#btn").attr("disabled", true);
                }
                else if (res.code == 1) {
                    $("#userAlert").html(res.msg);
                    $("#userAlert").addClass("green");
                    check[0] = true;
                    if (cCheckT()) {
                        $("#btn").attr("disabled", false);
                    }
                }
            },
            error: function () {
                check[0] = false;
                $("#userAlert").html("");
                $("#userAlert").removeClass("green");
                $("#btn").attr("disabled", true);
            }
        });
    }
}

function checkPass() {
    var pass = $("#password").val();
    if (!/^[a-zA-Z0-9]{4,16}$/.test(pass)) {
        check[1] = false;
        $("#passAlert").html("密码格式错误");
        $("#passAlert").removeClass("green");
        $("#btn").attr("disabled", true);
    }
    else if (!/^.*(?=.*\d)(?=.*[a-zA-Z]).*$/.test(pass)) {
        check[1] = false;
        $("#passAlert").html("密码强度不够");
        $("#passAlert").removeClass("green");
        $("#btn").attr("disabled", true);
    } else {
        $.ajax({
            url: url_cr,
            type: 'post',
            dataType: 'json',
            data: {
                code: 1,
                pass: pass
            },
            success: function (res) {
                if (res.code == 0) {
                    check[1] = false;
                    $("#passAlert").html(res.msg);
                    $("#passAlert").removeClass("green");
                    $("#btn").attr("disabled", true);
                } else if (res.code == 1) {
                    check[1] = false;
                    $("#passAlert").html(res.msg);
                    $("#passAlert").removeClass("green");
                    $("#btn").attr("disabled", true);
                }
                else if (res.code == 2) {
                    $("#passAlert").html(res.msg);
                    $("#passAlert").addClass("green");
                    check[1] = true;
                    if (cCheckT()) {
                        $("#btn").attr("disabled", false);
                    }
                }
            },
            error: function () {
                check[1] = false;
                $("#passAlert").html("");
                $("#passAlert").removeClass("green");
                $("#btn").attr("disabled", true);
            }
        });
    }
}

function checkPass2() {
    var pass = $("#password").val();
    var pass2 = $("#password2").val();
    if (pass2 != pass) {
        $("#pass2Alert").html("两次密码不一致!");
        $("#pass2Alert").removeClass("green");
        check[2] = false;
        $("#btn").attr("disabled", true);
    } else {
        $.ajax({
            url: url_cr,
            type: 'post',
            dataType: 'json',
            data: {
                code: 2,
                pass: pass,
                pass2: pass2
            },
            success: function (res) {
                if (res.code == 0) {
                    check[2] = false;
                    $("#pass2Alert").html(res.msg);
                    $("#pass2Alert").removeClass("green");
                    $("#btn").attr("disabled", true);
                } else if (res.code == 1) {
                    $("#pass2Alert").html(res.msg);
                    $("#pass2Alert").addClass("green");
                    check[2] = true;
                    if (cCheckT()) {
                        $("#btn").attr("disabled", false);
                    }
                }
            },
            error: function () {
                check[1] = false;
                $("#pass2Alert").html("");
                $("#pass2Alert").removeClass("green");
                $("#btn").attr("disabled", true);
            }
        });
    }
}