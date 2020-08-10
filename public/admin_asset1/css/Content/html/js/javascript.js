String.prototype.getParamFromUrl = String.prototype.getParamFromUrl || function (name) {
    var temp = "[\?&#]" + name + "=([^&#]*)";
    var regex = new RegExp(temp);
    var results = regex.exec(this);
    if (!results)
        return "";
    else
        return results[1];
};
$(document).ready(function () {
    var $menu = $("#mainMenu").clone();
    $menu.attr("id", "mainMenuMobile");
    $menu.mmenu({
        dragOpen: {
            open: true
        },
        searchfield: {
            add: true,
            placeholder: "Tìm kiếm các mục...",
            noResults: "Không có mục nào!"
        },
        extensions: ["theme-dark"],
        extensions: ["effect-zoom-menu", "effect-zoom-panels"],
        extensions: ["border-full"],
        extensions: ["pageshadow"]
    });
    var API = $("#mainMenuMobile").data("mmenu");
    $("#button-toggle-menu").click(function (e) {
        API.open();
    });
});


//slyder-home
$(document).ready(function () {
    var owl = $(".slyder-home");
    owl.owlCarousel({
        navigation: true,
        singleItem: true,
        autoPlay: 8000,
        transitionStyle: "fade"
    });
    $("#transitionType").change(function () {
        var newValue = $(this).val();
        owl.data("owlCarousel3").transitionTypes(newValue);
        owl.trigger("owl.next");
    });
});


// serach
$(document).ready(function () {
    if ($('.leng-item').length) {
        $('.leng-item .on-serach').on('click', function () {
            if ($('.leng-item').hasClass('show-sea')) {
                $('.leng-item').removeClass('show-sea');
            } else {
                $('.leng-item').addClass('show-sea');
            }
        });
    }
});


$(window).scroll(function () {
    if ($(this).scrollTop() > 10) {
        $(".header").addClass("headerxd");

    } else {
        $(".header").removeClass("headerxd");

    }
});


var totalSlide = 4;
if ($(window).width() < 990) {
    totalSlide = 3;
}
if ($(window).width() < 500) {
    totalSlide = 1;
}

$(document).on('ready', function () {

    $(".slyder-content").slick({
        slidesToShow: totalSlide,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });
});



$(document).ready(function () {
    var owl = $(".show-mem"),
        status = $("#owlStatus");
    owl.owlCarousel({
        navigation: true,
        afterAction: afterAction,
        items: 3, //10 items above 1000px browser width
        itemsDesktop: [1000, 3], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 2], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
    });
    function updateResult(pos, value) {
        status.find(pos).find(".result").text(value);
    }
    function afterAction() {
        updateResult(".owlItems", this.owl.owlItems.length);
        updateResult(".currentItem", this.owl.currentItem);
        updateResult(".prevItem", this.prevItem);
        updateResult(".visibleItems", this.owl.visibleItems);
        updateResult(".dragDirection", this.owl.dragDirection);
    }
});



$(document).ready(function () {
    if ($(window).width() > 767) {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $("body").addClass("body-set");

            } else {
                $("body").removeClass("body-set");

            }
        });
    }
    else {
    }
});


$(function () {
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;
        var links = this.el.find('.carte');
        links.on('click', { el: this.el, multiple: this.multiple }, this.dropdown)
    }
    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el;
        $this = $(this),
        $next = $this.next();
        $next.slideToggle();
        $this.parent().toggleClass('open');
        if (!e.data.multiple) {
            $el.find('.open-carte').not($next).slideUp().parent().removeClass('open');
        };
    }
    var accordion = new Accordion($('.accordion'), false);
});
function getSelectedValue(id) {
    return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function (e) {
    var $clicked = $(e.target);
    if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});

function loadPitch(month, timeZone, year, fieldId, dateSearch) {
    var url = "/Ajax/Content/ChooisePitch?month=" + parseInt(month) + "&timeZone=" + parseInt(timeZone) + "&year=" + parseInt(year) + "&fieldId=" + parseInt(fieldId) + "&dateSearch=" + dateSearch;
    $.ajax({
        type: "POST",
        url: url,
        dataType: "text",
        success: function (data) {
            $("#list-month-pitch").append(data);
            cacuTotalPrice();
        }
    });
}

function loadMonth() {
    var arrMonth = new Array();
    $(".current-month").find("li.active>a.delay").each(function () {
        arrMonth.push($(this).attr("rel"));
    });
    $(".next-month").find("li.active>a.delay").each(function () {
        arrMonth.push($(this).attr("rel"));
    });
    $("#ChooiseMonth").val(arrMonth.toString());
}

//$(document).ready(function () {
//    window.csrf_token = $("meta[name=csrf-token]").attr("content"), $(window).load(function () {
//        $("body").addClass("loaded");
//    });
//});

$(document).ready(function () {
    $('#mainMenu li a').each(function () {
        if (this.href.trim() == window.location)
            $(this).parent('li').addClass('active');
    });
    $('.subMenu li a').each(function () {
        if (this.href.trim() == window.location) {
            $(this).parents('#mainMenu li').addClass('active');
        }
    });
});

function resetChooise() {
    $("#TotalMoney").val("0 VNĐ");
    $("#TotalPriceChooise").text("0 VNĐ");
    $("#TotalChooise").text("0");
    $("#TotalDeposit").text("0 VNĐ");
    $("#TotalPriceDeposit").text("0 VNĐ");
    $("#list-month-pitch").find("input[type=checkbox]").prop("checked", false);
}
$(function () {
    $("body").on("click", ".calendar-month a.delay", function (e) {
        e.preventDefault();
        arrChecked = new Array();
        var month = $(this).attr("data-month");
        var year = $(this).attr("data-year");
        var parentClass = $(this).parent("li").attr("class");
        if (parentClass.indexOf("active") >= 0) {
            $(this).parent("li").attr("class", "");
            $("#list-month-pitch").find("tr#" + month + "" + year).remove();
            loadMonth();
        } else {
            $(this).parent("li").addClass("active");
            var timeZone = $("#TimeZone").val();
            $("#list-month-pitch").find("li").show();
            $(".mutliSelect").find("input:checkbox").prop("checked", false);
            resetChooise();
            $(".multiSel").html('');
            $(".hida").show();
            loadPitch(month, timeZone, year, fieldId);
            loadMonth();
        }
        $("#choiseAll").prop("checked", false);
    });
    $("body").on("click", ".dayInMonth", function () {
        cacuTotalPrice();
    });
    $(".btnSubmit").click(function () {
        // var arrMonth = new Array();
        // $("#list-month-pitch").find("input[type=checkbox]:checked").each(function () {
        //     arrMonth.push($(this).val());
        // });
        // if (arrMonth.length <= 0) {
        //     alert("Chưa chọn buổi đặt sân.");
        //     return;
        // }
        if ($("#frmBook").valid()) {
            $("#monthChooise").val(arrMonth.toString());
            $("#paymentType").val($(this).attr("data-type"));
            $("#timeZoneId").val($("#TimeZone").val());
            $("#voucherCode").val($("#kmSan").val());
            $("#frmBook").submit();
        }
    });
    $("#frmBook").validate({
        rules: {
            FullName: {
                required: true
            },
            Phone: {
                required: true
            },
            Address: {
                required: true
            },
            Email: {
                required: true,
                email: true
            }, 
            Time:{
                required: true,
            },
        },
        messages: {
            FullName: {
                required: "*",
            },
            Phone: {
                required: "*",
            },
            Address: {
                required: "*",
            },
            Email: {
                required: "*",
                email: "*"
            },
            Time: {
                required: "*",
            },
        }, submitHandler: function () {
            var url = $("#frmBook").attr("action");
            $.post(url, $("#frmBook").serialize(), function (msg) {
                if (msg.Erros == true) {
                    swal({
                        title: "Thông báo",
                        text: msg.Message,
                        type: "warning",
                        showLoaderOnConfirm: true,
                        timer: 2000,
                        animation: false
                    },
                        function () {
                            window.location.reload();
                        });
                } else {
                    swal({
                        title: "Thông báo",
                        text: msg.Message,
                        type: "success",
                        showLoaderOnConfirm: true,
                        timer: 2000,
                        animation: false
                    });
                }
            });
        }
    });
    //thêm trạng thái sân


    // $("#TimeZone").change(function () {
    //     var timeZone = $(this).val();
    //     $("#list-month-pitch").html('');
    //     $(".multiSel").html('');
    //     $(".hida").show();
    //     $(".mutliSelect").find("input:checkbox").prop("checked", false);
    //     $("#list-month-pitch").find("input[type=checkbox]").prop("checked", false);
    //     $("#TotalMoney").val('0');
    //     $(".current-month").find("li.active>a.delay").each(function () {
    //         var month = $(this).attr("data-month");
    //         var year = $(this).attr("data-year");
    //         loadPitch(month, timeZone, year, fieldId);
    //     });
    //     $(".next-month").find("li.active>a.delay").each(function () {
    //         var month = $(this).attr("data-month");
    //         var year = $(this).attr("data-year");
    //         loadPitch(month, timeZone, year, fieldId);
    //     });
    //     $("#choiseAll").prop("checked", false);
    // });
    // $("body").on('click', ".dropdown dt a", function (e) {
    //     e.preventDefault();
    //     $(".dropdown dd ul").slideToggle('fast');
    // });

    // $("body").on('click', ".dropdown dd ul li a", function (e) {
    //     e.preventDefault();
    //     $(".dropdown dd ul").hide();
    // });
    // var arrChecked = new Array();
    // $('body').on('click', '.mutliSelect input[type="checkbox"]', function () {
    //     var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
    //       title = $(this).val() + ",";
    //     var emlRel = $(this).attr("rel");
    //     var emlChecked = '';
    //     if ($(this).is(':checked')) {
    //         var html = '<span title="' + title + '">' + title + '</span>';
    //         $('.multiSel').append(html);
    //         $(".hida").hide();
    //         //chọn
    //         arrChecked.push(emlRel);
    //         emlChecked = arrChecked.toString();
    //         loadMonthInWeek(emlChecked);
    //     } else {
    //         $('span[title="' + title + '"]').remove();
    //         var ret = $(".hida");
    //         $('.dropdown dt a').append(ret);
    //         //bỏ chọn
    //         var index = arrChecked.indexOf(emlRel);
    //         arrChecked.splice(index, 1);
    //         emlChecked = arrChecked.toString();
    //         loadUncheckMonthInWeek(emlRel);
    //     }
    //     $("#choiseAll").prop("checked", false);
    //     resetChooise();
    // });
});

function loadMonthInWeek(emlChecked) {
    $("#list-month-pitch").find('li').each(function () {
        if (emlChecked.indexOf($(this).attr("class")) >= 0) {
            $(this).fadeIn();
        } else {
            $(this).fadeOut();
        }
    });
}
function loadUncheckMonthInWeek(emlChecked) {
    $("#list-month-pitch").find('li').each(function () {
        if (emlChecked.indexOf($(this).attr("class")) >= 0) {
            $(this).fadeOut();
        }
    });
}
function ValidateYear(currentYear, year) {
    if (parseInt(year) == parseInt(currentYear)) {
        $(".fa-caret-left").hide();
        $(".fa-caret-right").show();
    }
    if (parseInt(year) > parseInt(currentYear)) {
        $(".fa-caret-left").show();
        $(".fa-caret-right").hide();
    }
}
function formatPrice(str) {
    var parts = (str + "").split("."),
        main = parts[0],
        len = main.length,
        output = "",
        i = len - 1;

    while (i >= 0) {
        output = main.charAt(i) + output;
        if ((len - i) % 3 === 0 && i > 0) {
            output = "." + output;
        }
        --i;
    }
    if (parts.length > 1) {
        output += "." + parts[1];
    }
    return output;
}
function ChangeRandom() {
    $("#imageRandom").attr("src", "/showCaptchaImage?width=90&height=26&t=" + new Date().getMilliseconds());
}

function init_form_messageCompose() {
    var frm_post = $("#frm-messageCompose");
    var url = frm_post.attr("action");
    $("#btn-frm-messageCompose").click(function () {
        frm_post.submit();
    });
    frm_post.validate({
        rules: {
            sendTo: {
                required: true
            },
            subject: {
                required: true
            },
            message: {
                required: true
            }
        },
        messages: {
            sendTo: {
                required: "Tới bắt buộc nhập!"
            },
            subject: {
                required: "Tiêu đề bắt buộc nhập!",
            },
            message: {
                required: "Nội dung bắt buộc nhập!",
            },
        },
        submitHandler: function () {
            $.post(url, frm_post.serialize(), function (data) {
                if (data.ErrorCode == 1) {
                    swal({
                        title: "Thông báo",
                        text: data.Message,
                        type: "success",
                        showLoaderOnConfirm: true,
                        timer: 2000,
                        animation: false
                    },
                        function () {
                            window.location.reload();
                        });
                } else {
                    swal({
                        title: "Thông báo",
                        text: data.Message,
                        type: "warning",
                        showLoaderOnConfirm: true,
                        timer: 2000,
                        animation: false
                    },
                        function () { });
                }
            });
        }
    });
    $("#checkRef").click(function () {
        var userName = $("#sendTo").val();
        $.post("/ajax/Member/CheckUserName", { userName: userName }, function (data) {
            swal({
                title: "",
                text: data.errormessage,
                type: (data.errorcode > 0 ? "success" : "warning"),
                showLoaderOnConfirm: true,
                timer: 2000,
                animation: false
            }, function () {
                if (data.errorcode > 0) {
                }
            });
        });
    });
}
// gửi message History
function init_pdgd_history_message() {
    $(".show-message-box").click(function (e) {
        e.preventDefault();

        var json = $(this).attr('data');
        var data = JSON && JSON.parse(json) || $.parseJSON(json);

        $.post("/ajax/Member/GetFormMessageGdPdHistory", data, function (data) {
            $("#dialog-msg .modal-dialog").html(data);
            $('#dialog-msg').modal('show');
        });
        return false;
    });
}
// Message View Reply
function init_frm_MessageViewReply() {
    var frm_post = $("#frm-reply-message-view");
    $("#btn-frm-reply-message-view").click(function () {
        frm_post.submit();
    });
    frm_post.validate({
        rules: {
            message: {
                required: true
            },

        },
        messages: {
            message: {
                required: "Please input content !"
            },

        },
        submitHandler: function () {
            frm_post.ajaxSubmit({
                success: function (data) {

                    swal({
                        title: "",
                        text: data.Message,
                        type: (data.ErrorCode > 0 ? "success" : "warning"),
                        showLoaderOnConfirm: true,
                        timer: 2000
                    }, function () { window.location.reload(); });
                }
            });
        },
    });
}
$(function () {
    $("#view-detail").click(function (e) {
        e.preventDefault();
        var text = $(this).text();
        if (text == "Thu lại") {
            $("#more-content").fadeOut();
            $(this).text("Xem chi tiết");
        } else {
            $("#more-content").fadeIn();
            $(this).text("Thu lại");
        }

    });
    $("#btnCancelMore").click(function (e) {
        e.preventDefault();
        $("#more-content").fadeOut();
    });
    $("#choiseAll").click(function () {
        if ($(this).prop("checked")) {
            $("#list-month-pitch").find("input[type=checkbox]").each(function () {
                if ($(this).is(':visible')) {
                    if (!$(this).prop("checked")) {
                        $(this).prop("checked", true);
                    }
                }
            });
        } else {
            $("#list-month-pitch").find("input[type=checkbox]").each(function () {
                if ($(this).prop("checked")) {
                    $(this).prop("checked", false);
                }
            });
        }
        cacuTotalPrice();
    });
});

function cacuTotalPrice() {
    var totalPrice = 0;
    var totalChecked = 0;

    $("#list-month-pitch").find("input[type=checkbox]:checked").each(function () {
        totalChecked += 1;
        var emlPrice = $(this).attr("data-price");
        if (emlPrice == "") {
            emlPrice = 0;
        }

        totalPrice += parseFloat(emlPrice);
        $("#TotalMoney").val(formatPrice(totalPrice) + " VNĐ");
        $("#TotalPriceChooise").text(formatPrice(totalPrice) + " VNĐ");
        $("#TotalChooise").text(totalChecked);
        $("#TotalDeposit").text(formatPrice(totalPrice * 50 / 100) + " VNĐ");
        $("#TotalPriceDeposit").text(formatPrice(totalPrice * 50 / 100) + " VNĐ");
        $("#TotalPriceInPitch").text(formatPrice(totalPrice - (parseFloat(totalPrice * 50 / 100))) + " VNĐ");
    });
    var kmMoney = $("#kmSanView").val();
    var kmType = $("#kmSanType").val();
    var totalPriceKm = 0;
    var totalDeposit = totalPrice;
    if (kmType == 2) {
        totalPriceKm = totalDeposit * kmMoney / 100;
        $("#TotalKm").text(formatPrice(totalPriceKm) + " VNĐ");
        $("#TotalPriceChooise").text(formatPrice(totalDeposit - totalPriceKm) + " VNĐ");
    } else if (kmType == 3) {
        $("#TotalKm").text(formatPrice(kmMoney) + " VNĐ");
        $("#TotalPriceChooise").text(formatPrice(totalDeposit - kmMoney) + " VNĐ");
    }
    if (totalChecked == 0) {
        $("#TotalMoney").val("0 VNĐ");
        $("#TotalPriceChooise").text("0 VNĐ");
        $("#TotalChooise").text(totalChecked);
        $("#TotalDeposit").text("0 VNĐ");
        $("#TotalPriceDeposit").text("0 VNĐ");
        $("#TotalPriceInPitch").text("0 VNĐ");
    }
}

$(function() {
    $(".kmSan")
        .keyup(function() {
            debugger;
            $("#msgErrorKm").text("");
            var val = $(this).val();
            var groupFieldId = $("#groupFieldId").val();
            if (val != '') {
                $.ajax({
                        method: "POST",
                        url: "/ajax/Content/CheckCampain",
                        data: { code: val, fieldId: groupFieldId }
                    })
                    .done(function(msg) {
                        if (msg.IsDeleted != '' && msg.IsDeleted == true) {
                            $("#msgErrorKm").text("(Mã khuyến mãi không tồn tại.)");
                        } else if (msg.Type == 2) {
                            $("#kmSanView").val(msg.ValueDiscount);
                            $("#kmSanType").val("2");
                            cacuTotalPrice();
                        } else if (msg.Type == 3) {
                            $("#kmSanView").val(msg.MoneyDiscount);
                            $("#kmSanType").val("3");
                            cacuTotalPrice();
                        }

                    });
            }
        });
});
function initAjaxLoad(urlListsLoad, container, callback) {
    //alert(container);
    $.address.unbind().externalChange(function (event) {
        var urlTransform = urlListsLoad;
        var urlHistory = event.value;
        if (urlHistory.length > 0) {
            urlHistory = urlHistory.substring(1, urlHistory.length);
            if (urlTransform.indexOf('?') > 0)
                urlTransform = urlTransform + '&' + urlHistory;
            else
                urlTransform = urlTransform + '?' + urlHistory;
        }
        //alert(urlTransform);
        $(container).html("Đang tải dữ liệu...");
        $.post(urlTransform, function (data) {
            //alert(data);
            $(container).html(data);
        }).complete(function () {
            if (callback && typeof (callback) === "function") {
                callback();
            }
        });
    });
};
