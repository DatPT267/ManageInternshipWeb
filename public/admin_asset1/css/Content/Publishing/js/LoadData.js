
function getValueFormMutilSelect(form) {
    var arrParam = '';
    var idMselect;

    $(form).find("input,textarea,hidden,select").not("input[type='checkbox'], input[type='radio']:checked, input[name='selectItem'], .ms-search input, .mutil").each(function () {
        idMselect = $(this).attr("name");
        if ($(this).val() != '' && $(this).val() != 'Từ khóa tìm kiếm')
            arrParam += "&" + idMselect + "=" + $(this).val();
    });
    $("[data-id='SearchIn'].multiSelectSearch").each(function () {
        idMselect = $(this).attr("data-id");
        if (getValueMutilSelect(idMselect) != '')
            arrParam += "&" + idMselect + "=" + getValueMutilSelect(idMselect);
    });
    if (arrParam != '')
        arrParam = arrParam.substring(1);
    return arrParam;
}

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([#&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('#') !== -1 ? "&" : "#";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}

$(function () {
    $(".formatPrice").change(function () {
        debugger;
        var valNow = $(this);
        var amount = Number(valNow.val()).toLocaleString('en', { maximumSignificantDigits: 21 });
        if ($(this).parent().find('.lbFormatPrice').length != 0) {
            var removeThis = $(this).parent().find('.lbFormatPrice');
            removeThis.remove();
        }

        valNow.parent().append("<lable class='lbFormatPrice' style='color:#ed1f24'>" + amount + "</label>");
    });
    //$(".hiddenView").click(function (e) {
    //    e.preventDefault();
    //    var arrRowId = $(this).attr("ref");
    //    var actionTitle = $(this).attr("actionTitle");
    //    var rowTitle = $(this).attr("title");
    //    if (actionTitle == '') {
    //        actionTitle = 'Ẩn';
    //    }
    //    confirmAlert(actionTitle, "Hide", urlAlertAction, arrRowId, rowTitle);
    //});

    //$(".showView").click(function (e) {
    //    e.preventDefault();
    //    var arrRowId = $(this).attr("ref");
    //    var actionTitle = $(this).attr("actionTitle");
    //    var rowTitle = $(this).attr("title");
    //    if (actionTitle == '') {
    //        actionTitle = 'Hiển thị';
    //    }
    //    confirmAlert(actionTitle, "Show", urlAlertAction, arrRowId, rowTitle);
    //});

    //$(".deleteView").click(function (e) {
    //    e.preventDefault();
    //    var arrRowId = $(this).attr("ref");
    //    var actionTitle = $(this).attr("actionTitle");
    //    var rowTitle = $(this).attr("title");
    //    if (actionTitle == '') {
    //        actionTitle = 'Xóa';
    //    }
    //    confirmAlert(actionTitle, "Delete", urlAlertAction, arrRowId, rowTitle);
    //});

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


function doActionForm(formId, modal) {
    var form = formId.serialize();
    var url = formId.attr("action");
    $.post(url, form, function (res) {
        if (!res.Erros) {
            if (modal != '') {
                $(modal).fadeOut();
            }
            swal({
                title: "Thông báo",
                text: res.Message,
                type: "success",
                showConfirmButton: true,
                animation: false
            },
            function () {
                window.location.reload();
            });
        } else {
            swal({
                title: "Thông báo",
                text: res.Message,
                type: "error",
                showConfirmButton: true,
                animation: false
            });
        }
    }, "json");
}

function previewFiles() {

    var preview = document.querySelector('#preview');
    var files = document.querySelector('input[type=file]').files;

    function readAndPreview(file) {
        // Make sure `file.name` matches our extensions criteria
        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                $("#preview").empty();
                var image = new Image();
                image.height = 100;
                image.title = file.name;
                image.src = this.result;
                preview.appendChild(image);
            }, false);

            reader.readAsDataURL(file);
        }

    }

    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}
function confirmAlert(actionString, action, urlPost, arrRowId, rowTitle) {
    if (!arrRowId) {
        swal({
            title: "Thông báo",
            text: "Bạn chưa chọn bản ghi nào.",
            type: "error",
            showConfirmButton: true,
            animation: false
        });
        return;
    }
    var confirmModal =
        $('<div class="modal fade in" style="display:none">' +
            '<div class="modal-dialog modal-lg">' +
                '<div class="modal-content">' +
                    '<div class="modal-body">' +
                        '<p>Bạn có chắc chắn muốn ' + actionString + ':<br/></p>' +
                        '<p>' + rowTitle + '</p>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                        '<a href="#" id="okButton" class="btn btn-primary" data-dismiss="modal">Tiếp tục</a>' +
                        '<a href="#" id="cancelButton" class="btn btn-danger">Hủy</a>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>');
    confirmModal.find('#okButton').click(function (e) {
        e.preventDefault();
        $.post(encodeURI(urlPost), { "ActionView": action, "itemId": "" + arrRowId + "" }, function (data) {
            if (data.Erros) {
                swal({
                    title: "Thông báo",
                    text: data.Message,
                    type: "error",
                    showConfirmButton: true,
                    animation: false
                });
            }
            else {
                swal({
                    title: "Thông báo",
                    text: data.Message,
                    type: "success",
                    showConfirmButton: true,
                    animation: false
                }, function () {
                    window.location.reload();
                });
            }
        });
        setTimeout(function () {
            confirmModal.remove();
        }, 500);
        confirmModal.modal('hide');
    });
    confirmModal.find('#cancelButton').click(function (e) {
        e.preventDefault();
        setTimeout(function () {
            confirmModal.remove();
        }, 500);
        confirmModal.modal('hide');
    });
    confirmModal.modal('show');
};

function GridActionView() {
    $(".hiddenView").click(function (e) {
        e.preventDefault();
        var arrRowId = $(this).attr("ref");
        var actionTitle = $(this).attr("actionTitle");
        var rowTitle = $(this).attr("title");
        if (actionTitle == '') {
            actionTitle = 'Ẩn';
        }
        confirmAlert(actionTitle, "Hide", urlAlertAction, arrRowId, rowTitle);
    });

    $(".showView").click(function (e) {
        e.preventDefault();
        var arrRowId = $(this).attr("ref");
        var actionTitle = $(this).attr("actionTitle");
        var rowTitle = $(this).attr("title");
        if (actionTitle == '') {
            actionTitle = 'Hiển thị';
        }
        confirmAlert(actionTitle, "Show", urlAlertAction, arrRowId, rowTitle);
    });

    $(".deleteView").click(function (e) {
        e.preventDefault();
        var arrRowId = $(this).attr("ref");
        var actionTitle = $(this).attr("actionTitle");
        var rowTitle = $(this).attr("title");
        if (actionTitle == undefined) {
            actionTitle = 'Xóa';
        }
        confirmAlert(actionTitle, "Delete", urlAlertAction, arrRowId, rowTitle);
    });
    $(".classAddEdit").click(function (e) {
        e.preventDefault();
        var itemId = $(this).attr("ref");
        $.ajax({
            url: urlFromAddEdit,
            dataType: "text",
            data: 'itemId=' + itemId,
            success: function (data) {
                $("#ViewContent").html(data);
                $("#myModal").fadeIn();
            }
        });
    });
};
function NewsGoldTime() {
    $("#NewsGoldTimeForm")
        .validate({
            rules: {
                Title: {
                    required: true
                },
                GroupFieldIDs: {
                    required: true
                },
                ContactInfo: {
                    required: true
                },
                FromDate: {
                    required: true
                },
                ToDate: {
                    required: true
                },
                Description: {
                    required: true
                },

            },
            messages: {
                Title: {
                    required: "Tiêu đề bắt buộc nhập."
                },
                GroupFieldIDs: {
                    required: "Chọn sân bắt buộc nhập."
                },
                ContactInfo: {
                    required: "Liên hệ bắt buộc nhập."
                },
                FromDate: {
                    required: "Ngày đăng bắt buộc nhập."
                },
                ToDate: {
                    required: "Ngày kết thúc bắt buộc nhập."
                },
                Description: {
                    required: "Mô tả bắt buộc nhập."
                },

            },
            submitHandler: function () { //onSubmit
                doActionForm($("#NewsGoldTimeForm"), '#myModal');
                return false;
            }
        });
    $(".closePopup").click(function () {
        $("#myModal").fadeOut();
    });
}

function Competitor() {
    $("#submit").click(function () {
        if ($("#CompetitorForm").valid()) {
            $("#CompetitorForm").submit();
        }
       
    });
    $("#CompetitorForm")
        .validate({
            rules: {
                TeamName: {
                    required: true
                },
                ContactInfo: {
                    required: true
                },
                TeamLevel: {
                    required: true
                },
                HasField: {
                    required: true
                },
                GroupFielName: {
                    required: true
                },
                date: {
                    required: true
                },
                time: {
                    required: true
                },
                Description: {
                    required: true
                },

            },
            messages: {
                TeamName: {
                    required: "Tên đội bắt buộc nhập."
                },
                ContactInfo: {
                    required: "Liên hệ bắt buộc nhập."
                },
                TeamLevel: {
                    required: "Trình độ bắt buộc nhập."
                },
                HasField: {
                    required: "Tình trạng bắt buộc nhập."
                },
                GroupFielName: {
                    required: "Chọn Sân bắt buộc nhập."
                },
                //LocationIDs: {
                //    required: "Quận/Huyện bắt buộc nhập."
                //},
                date: {
                    required: "Ngày bắt buộc nhập."
                },
                time: {
                    required: "Giờ bắt buộc nhập."
                },
                Description: {
                    required: "Mô tả bắt buộc nhập."
                },

            },
            submitHandler: function () { //onSubmit
                //doActionForm($("#CompetitorForm"), '#myModal');
                $("#CompetitorForm").ajaxSubmit({
                    success: function (data) {
                        if (data.Erros) {
                            swal({
                                title: "Thông báo",
                                text: data.Message,
                                type: "error",
                                showConfirmButton: true,
                                animation: false
                            });
                        } else {
                            swal({
                                    title: "Thông báo",
                                    text: data.Message,
                                    type: "success",
                                    showConfirmButton: true,
                                    animation: false
                                },
                                function() {
                                    window.location.reload();
                                });
                        }
                    }
                });
                return false;
            }
        });
    $(".closePopup").click(function () {
        $("#myModal").fadeOut();
    });
}



