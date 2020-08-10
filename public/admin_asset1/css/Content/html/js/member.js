//Đăng ký
$(document).ready(function () {
    $("#formRegister").validate({
        rules: {
            iptResName: {
                required: true
            },
            iptResMobile: {
                required: true,
                number: true,
                minlength: 10
            },
            iptResEmail: {
                required: true,
                email: true
            },
            iptResPass: {
                required: true,
                minlength: 6,
            },
            iptResCofPass: {
                required: true,
                minlength: 6,
            },

        },
        messages: {
            iptResName: {
                required: "Nhập Tên Của Bạn !",
            },
            iptResEmail: {
                required: "Email không được để trống",
                email: "Email không đúng định dạng",

            },
            iptResMobile: {
                required: "Số điện thoại không được để trống",
                number: "Số điện thoại không đúng định dạng",
                minlength: "Số điện thoại phải có ít nhất 10 chữ số"
            },
            iptResPass: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Độ dài mật khẩu từ 6 ký tự",
            },
            iptResCofPass: {
                required: "Vui lòng nhập lại mật khẩu",
                minlength: "Độ dài mật khẩu từ 6 ký tự",
            },
        },
        submitHandler: function () {
            doSendReg("#formRegister");
        },
    });
    $("#formRegisterMember").validate({
        rules: {
            iptResName: {
                required: true
            },
            iptResMobile: {
                required: true,
                number: true,
                minlength: 10
            },
            iptResEmail: {
                required: true,
                email: true
            },
            iptResPass: {
                required: true,
                minlength: 6,
            },
            iptResCofPass: {
                required: true,
                minlength: 6,
            },

        },
        messages: {
            iptResName: {
                required: "Nhập Tên Của Bạn !",
            },
            iptResEmail: {
                required: "Email không được để trống",
                email: "Email không đúng định dạng",

            },
            iptResMobile: {
                required: "Số điện thoại không được để trống",
                number: "Số điện thoại không đúng định dạng",
                minlength: "Số điện thoại phải có ít nhất 10 chữ số"
            },
            iptResPass: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Độ dài mật khẩu từ 6 ký tự",
            },
            iptResCofPass: {
                required: "Vui lòng nhập lại mật khẩu",
                minlength: "Độ dài mật khẩu từ 6 ký tự",
            },
        },
        submitHandler: function () {
            console.log('12121')
        },
    });

    function doSendReg(form) {
        var d = $(form).serialize();
        var url = $(form).attr("action");
        $("#res-acc").unbind("click").text("Đang gửi...");
        var pass1 = $("#iptResPass").val();
        var pass2 = $("#iptResCofPass").val();
        if (pass1 == pass2) {
            // $.post(url, d, function (msg) {
            //     if (msg.errorcode == "1") {
            //         swal("Thành công!", "Chúc mừng bạn đã đăng ký thành công!", "success");
            //         setInterval(function () {
            //             window.location.href = "/";
            //         }, 3000);
            //     } else {
            //         swal(msg.errormessage, "error");
            //         $("#res-acc").text("Đăng ký");
            //     }
            // }, "json");
            axios({
                method : $(form).attr('method'),
                url : url,
                data : d
            })
            .then((response)=>{
                // $('#errorsForm').removeClass('alert-danger');
                // $('#errorsForm').addClass('alert-success');
                // $('#errorsForm').html('Đăng ký thành công.')
                // $('#errorsForm').show();
                swal("Thành công!", "Chúc mừng bạn đã đăng ký thành công!", "success");
            })
            .catch((error)=>{
                console.log(error.response)
                $('#errorsForm').removeClass('alert-success');
                $('#errorsForm').addClass('alert-danger');
                
                var err = error.response.data.errors;
                
                var result = "";
                $.each(err, function (index, value) { 
                     result+=(value + '<br>')
                });
                $('#errorsForm').show();
                $('#errorsForm').html(result)
            })
        } else {
            swal("Mật khẩu không trùng khớp!", "error");
            $("#res-acc").text("Register");
        }
    }
    function doSendRegMember(form) {
        var d = $(form).serialize();
        var url = $(form).attr("action");
        $("#res-member").unbind("click").text("Đang gửi...");
        var pass1 = $("#iptResPass1").val();
        var pass2 = $("#iptResCofPass1").val();
        if (pass1 == pass2) {
            // $.post(url, d, function (msg) {
            //     if (msg.errorcode == "1") {
            //         swal("Thành công!", "Chúc mừng bạn đã đăng ký thành công!", "success");
            //         setInterval(function () {
            //             window.location.href = "/";
            //         }, 3000);
            //     } else {
            //         swal(msg.errormessage, "error");
            //         $("#res-member").text("Đăng ký");
            //     }
            // }, "json");
        } else {
            swal("Mật khẩu không trùng khớp!", "error");
            $("#res-member").text("Register");
        }
    }
});
//End Đăng ký
//Đăng nhập
$(document).ready(function () {
    function doSendLogin(form) {
        debugger
        var d = $(form).serialize();
        var url = $(form).attr("action");
        $(".btn-login").unbind("click").text("Đang gửi...");
        $.post(url, d, function (data) {
            if (data.errorcode == 1) {
                debugger
                swal("Thành công!", "Chúc mừng bạn đã đăng nhập thành công!", "success");
                setInterval(function () {
                    debugger
                    window.location.href = "/";
                }, 2000);

            } else {
                swal("Không thành công!", data.errormessage, "error");
                $(".btn-login").unbind("click").text("Đăng nhập");
            }
        }, "json");
    }    

    $("#formLogin").validate({
        rules: {
            iptLoginUser: {
                required: true,
                email: true
            },
            iptLoginPass: {
                required: true,
                minlength: 6,
            }
        },
        messages: {
            iptLoginUser: {
                required: "Nhập Email  của bạn !",
                email: "Email không đúng định dạng !"
            },
            iptLoginPass: {
                required: "Nhập password của bạn",
                minlength: "Password tối thiểu 6 ký tự",
            },
        },
        submitHandler: function () {
            doSendLogin("#formLogin");
        },
    });

    $("#formLoginMember").validate({
        rules: {
            iptLoginUser1: {
                required: true,
                email: true
            },
            iptLoginPass1: {
                required: true,
                minlength: 6,
            }
        },
        messages: {
            iptLoginUser1: {
                required: "Nhập Email  của bạn !",
                email: "Email không đúng định dạng !"
            },
            iptLoginPass1: {
                required: "Nhập password của bạn",
                minlength: "Password tối thiểu 6 ký tự",
            },
        },
        submitHandler: function () {
            doSendLogin("#formLoginMember");
        },
    });    

    $(".log-out-acc").click(function (e) {
        e.preventDefault();//
        var url = $(this).attr('href');
        swal({
            title: "Đăng xuất?",
            text: "Bạn có chắc chắn muốn đăng xuất?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#57a133",
            confirmButtonText: "OK",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                    },
                    dataType: "json",
                    success: function (response) {
                        swal("Thành công!", "Bạn đã đăng xuất thành công!", "success");
                        setInterval(function () {
                            window.location.href = $('#trangchu').text();
                        }, 2000);
                        console.log(response)
                    },
                })
                
                
            } else {
            }
        });
    });
    function LogOut() {
        
    }
    // Quên mật khẩu
        $("#form-forgot-pass").validate({
            rules: {
                forgotPassEmail: {
                    required: true,
                    email: true
                }
            },
            messages: {
                forgotPassEmail: {
                    required: "Nhập Email  của bạn !",
                    email: "Email không đúng định dạng !"
                }
            },
            submitHandler: function () {
                doSendForgotPass();
            },
        });
    function doSendForgotPass() {
        $form = $("#form-forgot-pass");
        $btnSend = $("#btn-send-forgot-pass");
        $btnSend.unbind("click").text("Đang gửi...");
        var d = $form.serialize();
        var url = $form.attr("action");
        $.post(url, d, function (data) {
            if (data.errorcode != 0) {
                swal("Thành công!", "Chúng tôi đã gửi mail cho bạn, kiểm tra lại mail bạn vừa nhập để lấy mật khẩu mới!", "success");
                $("[data-remodal-id=forgot-password]").remodal().close();
            }
            else {
                swal("Không thành công!", "Email này không hợp lệ hoặc không có trong hệ thống!", "error");
                setInterval(function () {
                    window.location.reload();
                }, 3000);
            }
        }, "json");
    }
    
    $("#frmforgoPass").validate({
        rules: {
            forgotPassEmail: {
                required: true,
                email: true
            }
        },
        messages: {
            forgotPassEmail: {
                required: "Nhập Email  của bạn !",
                email: "Email không đúng định dạng !"
            }
        },
        submitHandler: function () {
            $form = $("#frmforgoPass");
            $btnSend = $("#btn-send-forgot-pass-temp");
            $btnSend.unbind("click").text("Đang gửi...");
            var d = $form.serialize();
            var url = $form.attr("action");
            $.post(url, d, function (data) {
                if (data.errorcode != 0) {
                    swal("Thành công!", "Chúng tôi đã gửi mail cho bạn, kiểm tra lại mail bạn vừa nhập để lấy mật khẩu mới!", "success");
                    $("[data-remodal-id=forgot-password-temp]").remodal().close();
                }
                else {
                    swal("Không thành công!", "Email này không hợp lệ hoặc không có trong hệ thống!", "error");
                    setInterval(function () {
                        $btnSend.bind("click").text("Gửi đi");
                    }, 3000);
                }
            }, "json");
        },
    });
    //End Mật khẩu
});
//End Đăng nhập
//Thông tin tài khoản

//Đổi mật khẩu
$(document).ready(function () {
    var urlChangePass = "/Ajax/Member/ChangePass";
    $("#formChangePassword").validate({
        rules: {
            passwordform2: {
                required: true
            },
            passwordnewsform2: {
                required: true
            },
            repasswordnewsform2: {
                required: true
            }
        },
        messages: {
            passwordform2: {
                required: "Bạn chưa nhập mật khẩu cũ!",
            },
            passwordnewsform2: {
                required: "Bạn chưa nhập mật khẩu mới!",
            },
            repasswordnewsform2: {
                required: "Bạn chưa nhập mật lại khẩu mới!",
            }
        },
        submitHandler: function () {
            if ($("#repasswordnewsform2").val() == $("#passwordnewsform2").val()) {
                $.get(urlChangePass, $("#formChangePassword").serialize(), function (msg) {
                    if (msg.Erros == true) {
                        swal("Không thành công!", msg.Message, "error");
                        setInterval(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        swal("Thành công!", "Chúc mừng bạn đã cập nhập mật khẩu thành công!", "success");
                        setInterval(function () {
                            window.location.href = "/thong-tin-tai-khoan";
                        }, 2000);

                    }
                });
            } else {
                swal("Không thành công!", "Nhập lại mật khẩu không đúng!", "error");
            }
        },
    });
});
//End Thông tin tài khoả
$(document).ready(function () {
    var urlChangeMail = "/Ajax/Member/ChangeMail";
    $("#formChangeEmail").validate({
        rules: {
            reemailform3: {
                required: true
            },
        },
        messages: {
            reemailform3: {
                required: "Bạn chưa nhập email mới!",
            },
        },
        submitHandler: function () {
            $.get(urlChangeMail, $("#formChangeEmail").serialize(), function (msg) {
                if (msg.Erros == true) {
                    swal("Không thành công!", msg.Message, "error");
                } else {
                    swal("Thành công!", "Chúc mừng bạn đã cập nhập email thành công!", "success");
                    setInterval(function () {
                        window.location.href = "/thong-tin-tai-khoan";
                    }, 2000);
                }
            });
        },
    });
});
//Đổi mail


//Select District theo City
$(document).ready(function () {
    var urlLoad = '/Ajax/Member/ListDistrict';
    $("#citypayment").change(function () {

        $.ajax({
            type: "POST",
            url: urlLoad,
            data: { cityID: parseInt($(this).val()) },
            dataType: "text",
            success: function (data) {
                $("#districtpayment").html(data);
            }
        });
    });
});
$(document).ready(function () {
    $('#BirthdayMember').datepicker({
        'format': 'dd/mm/yyyy',
        'autoclose': true,
        endDate: '+1d',
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#ImageAvatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload").on('change', function () {
        readURL(this);
    });
    $("#fileupload").change(function () {
        var url = $(this).val();
        $("#UrlAvatar").text(url);
    });
});
var config_description = {
    height: 200
};
var config_content = {
    toolbar: 'Full',
    height: 250
};
function LoadCKEDITOR(instanceName, fullEditor) {
    if (fullEditor)
        CKEDITOR.replace(instanceName, config_content);
    else
        CKEDITOR.replace(instanceName, config_description);
}
function LoadCKEDITORStand(instanceName) {
    CKEDITOR.replace(instanceName, config_stand);
}
function updateEditor() {
    for (var name in CKEDITOR.instances)
        CKEDITOR.instances[name].updateElement();
}
function createCKFider(instance, imageWidth) {
    $("#" + instance + "Button").click(function () {
        var finder = new CKFinder();
        finder.selectActionFunction = function (fileUrl) {
            var htmlRespoint = "<input type=\"hidden\" name=\"" + instance + "\" value=\"" + fileUrl + "\" />";
            htmlRespoint += "<img src=\"" + fileUrl + "\" style=\"border:1px solid #ccc; width:" + imageWidth + "px; margin-top:2px;\" />";
            $("#" + instance + "Values").html(htmlRespoint);
        };
        finder.popup();
    });
}
