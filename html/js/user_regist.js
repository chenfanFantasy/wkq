$(function () {
        $("#d_show_friend_link").css("display", "none");
        $("#imge,#change").click(function () {
            document.getElementById("imge").src = "ValidateCode.aspx?" + Math.random();
        });

        //          $("#ckagreen").click(function () {
        //              if ($(this).attr("checked") == 'undefined') {
        //                  $(this).attr("checked", true);
        //              }
        //              else {
        //                  $(this).removeAttr("checked");
        //              }
        //          });
        $("#ckagreen").click(function () {
            if ($(this).attr("checked") == 'checked') {
                $(this).attr("checked", true);
            }
            else {
                $(this).attr("checked", false);
            }
        });
    })
    function IsEmail(strText) {
        var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        return reg.test(strText);

    }
    function Register() {
        var msg = "";
        var regPwd = /^[0-9a-zA-Z_]{6,16}$/;
        if ($("#txtLoginName").val().length == 0) {
            msg = "登录名称不能为空！";
        }
        else if ($("#txtLoginName").val().length < 2) {
            msg = "登录名长度不能小于2个字符！";
        }
        else if ($("#txtRealyName").val().length == 0) {
            msg = "真实姓名不能为空！";
        }
        else if ($("#txtPassword").val().length == 0) {
            msg = "密码不能为空！";
        } else if ($("#txtPassword").val().length < 6 || $("#txtPassword").val().length > 16) {
            msg = "密码位数必须介于6-16位！";
        } else if (!regPwd.test($("#txtPassword").val())) {
            msg = "密码只允许包含数字、字母与下划线！";
        }
        else if ($("#txtPassword").val() != $("#txtRePassword").val()) {
            msg = "两次输入密码不一致！";
        }
        else if ($("#txtPayPwd").val().length == 0) {
            msg = "威客圈安全密码不能为空！";
        }
        else if ($("#txtPayPwd").val().length < 6 || $("#txtPayPwd").val().length > 16) {
            msg = "威客圈安全密码位数必须介于6-16位！";
        } else if (!regPwd.test($("#txtPayPwd").val())) {
            msg = "威客圈安全密码只允许包含数字、字母与下划线！";
        }
        else if ($("#txtPayPwd").val() != $("#txtRePayPwd").val()) {
            msg = "两次输入威客圈安全密码不一致！";
        }
        else if ($("#txtPayPwd").val() == $("#txtPassword").val()) {
            msg = "登录密码和威客圈安全密码不能一样！";
        }
        else if ($("#txtQQ").val().length == 0) {
            msg = "QQ号码不能为空！";
        }
        else if (!IsEmail($("#txtEmail").val())) {
            msg = "邮箱格式错误！";
        }



        //        if ($("#ckagreen").attr("checked") != "checked") {
        //            msg = "请确认已阅读型尚用户注册协议！";
        //        }
        if (msg != '') {
            alert(msg);
            return false;
        }

        return true;
    }