"use strict";

var $table = $("#table_list"); // "table" accordingly
var electiveSubjectGroupCounter = 1;

$(function () {
    // $("#sortable-row").sortable({
    //     placeholder: "ui-state-highlight"
    // });
    function checkList(listName, newItem, id) {
        var dupl = false;
        $("#" + listName + " > div").each(function () {
            if ($(this)[0] !== newItem[0]) {
                if ($(this).find("li").attr('id') == newItem.find("li").attr('id')) {
                    dupl = true;
                }
            }
        });
        return dupl;
    }
    $('#table_list_exam_questions').on('check.bs.table', function (e, row) {
        var questions = $(this).bootstrapTable('getSelections');
        let li = ''
        $.each(questions, function (index, value) {
            if (value.question_type) {
                li = $('<div class="list-group"><input type="hidden" name="assign_questions[' + value.question_id + '][question_id]" value="' + value.question_id + '"><li id="q' + value.question_id + '"class="list-group-item d-flex justify-content-between align-items-center ui-state-default list-group-item-secondary m-2">' + value.question_id + ". " + value.question + ' <span class="text-right row"><input type="number" class="list-group-item col-md-6" name="assign_questions[' + value.question_id + '][marks]" style="width: 10rem"><a class="btn btn-danger btn-sm remove-row ml-2" data-id="' + value.question_id + '"><i class="fa fa-times" aria-hidden="true"></i></a></span></li></div>');
            } else {
                li = $('<div class="list-group"><input type="hidden" name="assign_questions[' + value.question_id + '][question_id]" value="' + value.question_id + '"><li id="q' + value.question_id + '"class="list-group-item d-flex justify-content-between align-items-center ui-state-default list-group-item-secondary m-2">' + value.question_id + ". " + '<span class="text-center">' + value.question + '</span> <span class="text-right row"><input type="number" class="list-group-item col-md-6" name="assign_questions[' + value.question_id + '][marks]" style="width: 10rem"><a class="btn btn-danger btn-sm remove-row ml-2" data-id="' + value.question_id + '"><i class="fa fa-times" aria-hidden="true"></i></a></span></li></div>');
            }
            var pasteItem = checkList("sortable-row", li, row.question_id);
            if (!pasteItem) {
                $("#sortable-row").append(li);
            }
        });
        createCkeditor();
    })
    $('#table_list_exam_questions').on('uncheck.bs.table', function (e, row) {
        $("#sortable-row > div").each(function () {
            $(this).find('#q' + row.question_id).remove();
        });
    })
    $table.bootstrapTable('destroy').bootstrapTable({
        exportTypes: ['csv', 'excel', 'pdf', 'txt', 'json'],
    });

    $("#toolbar")
        .find("select")
        .change(function () {
            $table.bootstrapTable("refreshOptions", {
                exportDataType: $(this).val()
            });
        });

    //File Upload Custom Component
    $('.file-upload-browse').on('click', function () {
        var file = $(this).parent().parent().parent().find('.file-upload-default');
        file.trigger('click');
    });
    $('.file-upload-default').on('change', function () {

        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
    tinymce.init({
        height: "400",
        selector: '#tinymce_message',
        menubar: 'file edit view formate tools',
        toolbar: [
            'styleselect fontselect fontsizeselect',
            'undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify',
            'bullist numlist | outdent indent | blockquote autolink | lists |  code'
        ],
        plugins: 'autolink link image lists code'
    });

    $('.modal').on('hidden.bs.modal', function () {
        //Reset input file on modal close
        $('.file-upload-default').val('');
        $('.file-upload-info').val('');
    })
    /*simplemde editor*/
    if ($("#simpleMde").length) {
        var simplemde = new SimpleMDE({
            element: $("#simpleMde")[0],
            hideIcons: ["guide", "fullscreen", "image", "side-by-side"],
        });
    }

    //Color Picker Custom Component
    if ($(".color-picker").length) {
        $('.color-picker').asColorPicker();
    }

    //Added this for Dynamic No Future Date Picker input Initialization
    $('body').on('focus', ".datepicker-popup-no-future", function () {
        if (!$(this).hasClass('hasDatepicker')) {
            var today = new Date();
            var maxDate = new Date();
            maxDate.setDate(today.getDate());
            $(this).datepicker({
                enableOnReadonly: false,
                todayHighlight: true,
                format: "dd-mm-yyyy",
                endDate: maxDate,
            });
        }
    });


    //Added this for Dynamic Date Picker input Initialization
    $('body').on('focus', ".datepicker-popup", function () {
        // Check if the element has the `hasDatepicker` class
        if (!$(this).hasClass('hasDatepicker')) {
            $(this).datepicker({
                enableOnReadonly: false,
                todayHighlight: true,
                format: "dd-mm-yyyy",
            });
        }
    });

    //Time Picker
    if ($("#timepicker-example").length) {
        $('#timepicker-example').datetimepicker({
            format: 'LT'
        });
    }
    //Select
    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }
    // form reapeater
    $('.repeater').repeater({
        // (Optional)
        // "defaultValues" sets the values of added items.  The keys of
        // defaultValues refer to the value of the input's name attribute.
        // If a default value is not specified for an input, then it will
        // have its value cleared.
        defaultValues: {
            'text-input': 'foo'
        },
        // (Optional)
        // "show" is called just after an item is added.  The item is hidden
        // at this point.  If a show callback is not given the item will
        // have $(this).show() called on it.
        show: function () {
            $(this).slideDown();
        },
        // (Optional)
        // "hide" is called when a user clicks on a data-repeater-delete
        // element.  The item is still visible.  "hide" is passed a function
        // as its first argument which will properly remove the item.
        // "hide" allows for a confirmation step, to send a delete request
        // to the server, etc.  If a hide callback is not given the item
        // will be deleted.
        hide: function (deleteElement) {
            // if (confirm('Are you sure you want to delete this element?')) {
            //     $(this).slideUp(deleteElement);
            // }
            if ($(this).find('input:first').val() != '') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't to delete this element?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/school/timetable/" + $(this).find('input:first').val(),
                            type: "DELETE",
                            success: function (response) {
                                if (response['error'] == false) {
                                    showSuccessToast(response['message']);
                                    $(this).slideUp(deleteElement);
                                } else {
                                    showErrorToast(response['message']);
                                }
                            }
                        });
                    }
                })
            } else {
                $(this).slideUp(deleteElement);
            }
        },
        // (Optional)
        // Removes the delete button from the first list item,
        // defaults to false.
        isFirstItemUndeletable: true
    })
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

});
//Setup CSRF Token default in AJAX Request
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#create-form,.create-form').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        formElement[0].reset();
        $('#table_list').bootstrapTable('refresh');
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$('#edit-form,.editform').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let data = new FormData(this);
    data.append("_method", "PUT");
    let url = $(this).attr('action') + "/" + data.get('edit_id');

    function successCallback(response) {
        $('#table_list').bootstrapTable('refresh');
        setTimeout(function () {
            $('#editModal').modal('hide');
        }, 1000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('.editformclasses').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let data = new FormData(this);
    data.append("_method", "PUT");
    let url = $(this).attr('action') + "/" + data.get('id');

    function successCallback(response) {
        $('#table_list').bootstrapTable('refresh');
        setTimeout(function () {
            $('#editModal').modal('hide');
        }, 1000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$(document).on('click', '.delete-form', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = $(this).attr('href');
            let data = null;

            function successCallback(response) {
                $('#table_list').bootstrapTable('refresh');
                showSuccessToast(response.message);
            }

            function errorCallback(response) {
                showErrorToast(response.message);
            }

            ajaxRequest('DELETE', url, data, null, successCallback, errorCallback);
        }
    })
})
$('.edit-class-teacher-form').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let data = new FormData(this);
    let url = $(this).attr('action');

    function successCallback(response) {
        $('#table_list').bootstrapTable('refresh');

        //Reset input file field
        $('.file-upload-default').val('');
        $('.file-upload-info').val('');
        setTimeout(function () {
            window.location.reload();
        }, 1000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$('.add-new-core-subject').on('click', function (e) {
    e.preventDefault();
    let core_subject = cloneNewCoreSubjectTemplate();
    $(this).parent().parent().siblings('.edit-extra-core-subjects').append(core_subject);
});

$(document).on('click', '.remove-core-subject', function (e) {
    e.preventDefault();
    let $this = $(this);
    if ($(this).data('id')) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $this.data('id');
                let url = baseUrl + '/class/subject/' + id;

                function successCallback() {
                    $('#table_list').bootstrapTable('refresh');
                    $this.parent().parent().remove();
                }

                function errorCallback(response) {
                    showErrorToast(response.message);
                }

                ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
            }
        })
    } else {
        $(this).parent().parent().remove();
    }
});

$(document).on('click', '.add-new-elective-subject', function (e) {
    e.preventDefault();
    let subject_list = cloneNewElectiveSubject($(this));
    //Removed Class subject id because its new elective subject
    subject_list.find('.edit-elective-subject-class-id').remove();
    subject_list.find('.remove-elective-subject').removeAttr('data-id');
    let total_selectable_subject = $(this).parent().next().children().children('input')
    let max = $(this).siblings('.elective-subject-div').length;
    $(total_selectable_subject).rules("add", {
        max: max,
    });
    $(subject_list).insertBefore($(this));
});

$(document).on('click', '.remove-elective-subject', function (e) {
    e.preventDefault();
    let $this = $(this);
    let total_selectable_subject = $(this).parent().parent().next().children().children('input');
    if ($(this).data('id')) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $this.data('id');
                let url = baseUrl + '/class/subject/' + id;

                function successCallback() {
                    let max = $this.parent().siblings('.elective-subject-div').length - 1;
                    $(total_selectable_subject).rules("add", {
                        max: max,
                    });
                    $('#table_list').bootstrapTable('refresh');
                    $this.parent().prev('span').remove();
                    $this.parent().remove();
                }

                ajaxRequest('DELETE', url, null, null, successCallback);
            }
        })
    } else {
        let max = $(this).parent().siblings('.elective-subject-div').length - 1;
        $(total_selectable_subject).rules("add", {
            max: max,
        });
        $(this).parent().prev('span').remove();
        $(this).parent().remove();
    }
});

$(document).on('click', '.add-elective-subject-group', function (e) {
    e.preventDefault();
    let html = cloneNewElectiveSubjectGroup();
    html.appendTo('#edit-extra-elective-subject-group');
});

$(document).on('click', '.remove-elective-subject-group', function (e) {
    e.preventDefault();
    let $this = $(this);
    if ($(this).data('id')) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $this.data('id');
                let url = baseUrl + '/class/subject-group/' + id;

                function successCallback() {
                    $('#table_list').bootstrapTable('refresh');
                    $this.parent().parent().remove();
                }

                function errorCallback(response) {
                    showErrorToast(response.message);
                }

                ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
            }
        })
    } else {
        $(this).parent().parent().remove();
    }

});

$('#show-guardian-details').on('change', function () {
    if ($(this).is(':checked')) {
        $('#guardian_div').show();
        $('#guardian_div input,#guardian_div select').attr('disabled', false);
        $('#father_display_and_hidden').hide();
    } else {
        $('#guardian_div').hide();
        //Added this to prevent data submission while elective subject option is Off.
        $('#guardian_div input,#guardian_div select').attr('disabled', true);
        $('#father_display_and_hidden').show();
    }
})

$('#show-edit-guardian-details').on('change', function () {
    if ($(this).is(':checked')) {
        $('#edit_guardian_div').show();
        $('#edit_guardian_div input,#edit_guardian_div select').attr('disabled', false);
    } else {
        $('#edit_guardian_div').hide();
        //Added this to prevent data submission while elective subject option is Off.
        $('#edit_guardian_div input,#edit_guardian_div select').attr('disabled', true);
    }
})

$(document).on('change', '.file_type', function () {
    var type = $(this).val();
    var parent = $(this).parent();
    if (type == "file_upload") {
        parent.siblings('#file_name_div').show();
        parent.siblings('#file_thumbnail_div').hide();
        parent.siblings('#file_div').show();
        parent.siblings('#file_link_div').hide();
    } else if (type == "video_upload") {
        parent.siblings('#file_name_div').show();
        parent.siblings('#file_thumbnail_div').show();
        parent.siblings('#file_div').show();
        parent.siblings('#file_link_div').hide();
    } else if (type == "youtube_link") {
        parent.siblings('#file_name_div').show();
        parent.siblings('#file_thumbnail_div').show();
        parent.siblings('#file_div').hide();
        parent.siblings('#file_link_div').show();
    } else if (type == "other_link") {
        parent.siblings('#file_name_div').show();
        parent.siblings('#file_thumbnail_div').show();
        parent.siblings('#file_div').hide();
        parent.siblings('#file_link_div').show();
    } else {
        parent.siblings('#file_name_div').hide();
        parent.siblings('#file_thumbnail_div').hide();
        parent.siblings('#file_div').hide();
        parent.siblings('#file_link_div').hide();
    }
})


$(document).on('click', '.add-lesson-file', function (e) {
    e.preventDefault();
    let html = $('.file_type_div:last').clone();
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find(':input').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    html.find('.add-lesson-file i').addClass('fa-times').removeClass('fa-plus');
    html.find('.add-lesson-file').addClass('btn-inverse-danger remove-lesson-file').removeClass('btn-inverse-success add-lesson-file');
    $(this).parent().parent().siblings('.extra-files').append(html);
    // Trigger change only after the html is appended to DOM
    html.find('.file_type').val('').trigger('change');
    html.find('input').val('');
});

$(document).on('click', '.edit-lesson-file', function (e) {
    e.preventDefault();
    let html = $('.file_type_div:last').clone();
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find(':input').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    html.find('.add-lesson-file i').addClass('fa-times').removeClass('fa-plus');
    html.find('.add-lesson-file').addClass('btn-inverse-danger remove-lesson-file').removeClass('btn-inverse-success add-lesson-file');
    $(this).parent().parent().siblings('.edit-extra-files').append(html);
    // Trigger change only after the html is appended to DOM
    html.find('.file_type').val('').trigger('change');
    html.find('input').val('');
});

$(document).on('click', '.remove-lesson-file', function (e) {
    e.preventDefault();
    var $this = $(this);
    // If button has Data ID then Call ajax function to delete file
    if ($(this).data('id')) {
       var route_url= $('#route_name_id').val();
       route_url = route_url.replace("/0", "");

        var file_id = $(this).data('id');


        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = route_url + '/' + file_id;
                let data = null;

                function successCallback(response) {
                    $this.parent().parent().remove();
                    $('#table_list').bootstrapTable('refresh');
                    showSuccessToast(response.message);
                }

                function errorCallback(response) {
                    showErrorToast(response.message);
                }


                ajaxRequest('DELETE', url, data, null, successCallback, errorCallback);
            }
        })
    } else {
        // If button don't have any Data Id then simply remove that row from DOM
        $(this).parent().parent().remove();
    }
});

$('#topic_class_section_id').on('change', function () {
    let html = "<option value=''>--Select Lesson--</option>";
    $('#topic_lesson_id').html(html);
    $('#topic_subect_id').trigger('change');
})

$('#topic_subject_id').on('change', function () {
    let url = baseUrl + '/search-lesson';
    let data = {
        'subject_id': $(this).val(),
        'class_section_id': $('#topic_class_section_id').val()
    };

    function successCallback(response) {
        let html = ""
        if (response.data.length > 0) {
            html += "<option>--Select Lesson--</option>"
            response.data.forEach(function (data) {
                html += "<option value='" + data.id + "'>" + data.name + "</option>";
            })
        } else {
            html = "<option value=''>No Data Found</option>";
        }
        $('#topic_lesson_id').html(html);
    }

    ajaxRequest('GET', url, data, null, successCallback, null, null, true);
})

$('#resubmission_allowed').on('change', function () {
    if ($(this).is(':checked')) {
        $(this).val(1);
        $('#extra_days_for_resubmission_div').show();
    } else {
        $(this).val(0);
        $('#extra_days_for_resubmission_div').hide();
    }
})

$('#edit_resubmission_allowed').on('change', function () {
    if ($(this).is(':checked')) {
        $(this).val(1);
        $('#edit_extra_days_for_resubmission_div').show();
    } else {
        $(this).val(0);
        $('#edit_extra_days_for_resubmission_div').hide();
    }
})

$('#edit_topic_class_section_id').on('change', function () {
    let html = "<option value=''>--Select Lesson--</option>";
    $('#topic_lesson_id').html(html);
    $('#topic_subect_id').trigger('change');
})

$('#edit_topic_subject_id').on('change', function () {
    let url = baseUrl + '/search-lesson';
    let data = {
        'subject_id': $(this).val(),
        'class_section_id': $('#edit_topic_class_section_id').val()
    };

    function successCallback(response) {
        let html = ""
        if (response.data.length > 0) {
            response.data.forEach(function (data) {
                html += "<option value='" + data.id + "'>" + data.name + "</option>";
            })
        } else {
            html = "<option value=''>No Data Found</option>";
        }
        $('#edit_topic_lesson_id').html(html);
    }

    ajaxRequest('GET', url, data, null, successCallback, null, null, true);
})

$(document).on('click', '.remove-assignment-file', function (e) {
    e.preventDefault();
    var $this = $(this);
    var file_id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = baseUrl + '/file/delete/' + file_id;
            let data = null;

            function successCallback(response) {
                $this.parent().remove();
                $('#table_list').bootstrapTable('refresh');
                showSuccessToast(response.message);
            }

            function errorCallback(response) {
                showErrorToast(response.message);
            }

            ajaxRequest('DELETE', url, data, null, successCallback, errorCallback);
        }
    })
});

$(document).on('click', '.add-exam-timetable', function (e) {
    e.preventDefault();
    let html = $('.exam_timetable:last').clone();
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find('.form-control').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    html.find('.add-exam-timetable i').addClass('fa-times').removeClass('fa-plus');
    html.find('.add-exam-timetable').addClass('btn-inverse-danger remove-exam-timetable').removeClass('btn-inverse-success add-exam-timetable');
    $(this).parent().parent().siblings('.extra-timetable').append(html);
    html.find('.form-control').val('');
});

$(document).on('click', '.edit-exam-timetable', function (e) {
    e.preventDefault();
    let html = $('.exam_timetable:last').clone();
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find('.form-control').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    html.find('.add-exam-timetable i').addClass('fa-times').removeClass('fa-plus');
    html.find('.add-exam-timetable').addClass('btn-inverse-danger remove-exam-timetable').removeClass('btn-inverse-success add-exam-timetable');
    $(this).parent().parent().siblings('.edit-extra-timetable').append(html);
    html.find('.form-control').val('');
});

$(document).on('click', '.remove-exam-timetable', function (e) {
    e.preventDefault();
    let $this = $(this);
    // If button has Data ID then Call ajax function to delete file
    if ($(this).data('id')) {
        let timetable_id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = baseUrl + '/exams/delete-timetable/' + timetable_id;

                function successCallback(response) {
                    $this.parent().parent().remove();
                    $('#table_list').bootstrapTable('refresh');
                    showSuccessToast(response.message);
                }

                function errorCallback(response) {
                    showErrorToast(response.message);
                }

                ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
            }
        })
    } else {
        // If button don't have any Data Id then simply remove that row from DOM
        $(this).parent().parent().remove();
    }
});


$('#exam_id').on('change', function () {

    let class_id = $('#class_id').val();
    let exam_id = $(this).val();

    let url = baseUrl + '/exams/get-subjects/' + class_id + '/' + exam_id;
    $('#subject_id option').hide();

    function successCallback(response) {
        let html = ''
        html = '<option>No Subjects</option>';
        if (response.data) {
            html = '<option value="">Select Subject</option>';
            $.each(response.data, function (key, data) {
                html += '<option value=' + data.subject.id + '>' + data.subject.name + ' - ' + data.subject.type + '</option>';
            });
        } else {
            html = '<option>No Subjects Found</option>';
        }
        $('#subject_id').html(html);
    }

    ajaxRequest('GET', url, null, null, successCallback, null);
});

$('#class_id').on('change', function () {

    // let exam_id = $('#exam_id').val();
    let class_id = $(this).val();

    let url = baseUrl + '/exams/get-exams/' + class_id;
    $('#exam_id option').hide();
    $('#subject_id option').hide();


    function successCallback(response) {
        let html = ''
        html = '<option>No Exams</option>';
        if (response.data) {
            html = '<option value="">Select Exam</option>';
            $.each(response.data, function (key, data) {
                html += '<option value=' + data.id + '>' + data.name +  '</option>';
            });
        } else {
            html = '<option>No Exams Found</option>';
        }
        $('#exam_id').html(html);
    }

    ajaxRequest('GET', url, null, null, successCallback, null);
});

$('#filter_class_id').on('change', function () {

    let class_id = $(this).val();

    let url = baseUrl + '/exams/get-publish-exam/' + class_id;

    $('#filter_exam_id option').hide();


    function successCallback(response) {
        let html = ''
        html = '<option>No Exams</option>';

        if (response.data) {
            html = '<option value="">Select Exam</option>';
            $.each(response.data, function (key, data) {
                html += '<option value=' + data.exam.id + '>' + data.exam.name +  '</option>';
            });
        } else {
            html = '<option>No Exams Found</option>';
        }
        $('#filter_exam_id').html(html);
    }

    ajaxRequest('GET', url, null, null, successCallback, null);
});
//Father Search
parentSearch($(".father-search"), baseUrl + "/parent/search", { 'type': 'father' }, 'Search for Father Email', parentSearchSelect2DesignTemplate, function (repo) {
    if (!repo.text) {
        //Remove dynamic jquery validation
        $(".father-search").rules("remove", "email");
        $(".father_image").rules("remove", "required");
        $('#father_first_name').val(repo.first_name).attr('readonly', true);
        $('#father_last_name').val(repo.last_name).attr('readonly', true);
        $('#father_mobile').val(repo.mobile).attr('readonly', true);
        $('#father_occupation').val(repo.occupation).attr('readonly', true);
        $('#father_dob').val(repo.dob).attr('readonly', true);
        $('#father-image-tag').attr('src', repo.image);
    } else {
        //Add dynamic jquery validation
        $(".father-search").rules("add", {
            email: true,
        });

        $(".father_image").rules("add", {
            required: true,
        });
        $('#father_first_name').val('').attr('readonly', false);
        $('#father_last_name').val('').attr('readonly', false);
        $('#father_mobile').val('').attr('readonly', false);
        $('#father_occupation').val('').attr('readonly', false);
        $('#father_dob').val('').attr('readonly', false);
        $('#father-image-tag').attr('src', '');
    }
    return repo.email || repo.text;
});
parentSearch($(".mother-search"), baseUrl + "/parent/search", { 'type': 'mother' }, 'Search for Mother Email', parentSearchSelect2DesignTemplate, function (repo) {
    if (!repo.text) {
        //Remove dynamic jquery validation
        $(".mother-search").rules("remove", "email");
        $(".mother_image").rules("remove", "required");
        $('#mother_first_name').val(repo.first_name).attr('readonly', true);
        $('#mother_last_name').val(repo.last_name).attr('readonly', true);
        $('#mother_mobile').val(repo.mobile).attr('readonly', true);
        $('#mother_occupation').val(repo.occupation).attr('readonly', true);
        $('#mother_dob').val(repo.dob).attr('readonly', true);
        $('#mother-image-tag').attr('src', repo.image);
    } else {
        //Add dynamic jquery validation
        $(".mother-search").rules("add", {
            email: true,
        });
        $(".mother_image").rules("add", {
            required: true,
        });
        $('#mother_first_name').val('').attr('readonly', false);
        $('#mother_last_name').val('').attr('readonly', false);
        $('#mother_mobile').val('').attr('readonly', false);
        $('#mother_occupation').val('').attr('readonly', false);
        $('#mother_dob').val('').attr('readonly', false);
        $('#mother-image-tag').attr('src', '');
    }
    return repo.email || repo.text;
});
//Father Search
parentSearch($(".guardian-search"), baseUrl + "/parent/search", null, 'Search for Guardian Email', parentSearchSelect2DesignTemplate, function (repo) {
    if (!repo.text) {
        //Remove dynamic jquery validation
        $(".guardian-search").rules("remove", "email");
        $(".guardian_image").rules("remove", "required");
        $('#guardian_first_name').val(repo.first_name).attr('readonly', true);
        $('#guardian_last_name').val(repo.last_name).attr('readonly', true);
        $('#guardian_mobile').val(repo.mobile).attr('readonly', true);
        $('#guardian_occupation').val(repo.occupation).attr('readonly', true);
        if (repo.gender == 'Male') {
            $('#guardian_female').removeAttr('checked');
            $('#guardian_male').attr('checked', 'true');
        } else {
            $('#guardian_male').removeAttr('checked');
            $('#guardian_female').attr('checked', 'true');
        }
        $('#guardian_dob').val(repo.dob).attr('readonly', true);
        $('#guardian-image-tag').attr('src', repo.image).attr('readonly', true);
    } else {
        //Add dynamic jquery validation
        $(".guardian-search").rules("add", {
            email: true,
        });

        $(".guardian_image").rules("add", {
            required: true,
        });
        $('#guardian_first_name').val('').attr('readonly', false);
        $('#guardian_last_name').val('').attr('readonly', false);
        $('#guardian_mobile').val('').attr('readonly', false);
        $('#guardian_occupation').val('').attr('readonly', false);
        $('#guardian_dob').val('').attr('readonly', false);
        $('#guardian-image-tag').attr('src', '').attr('readonly', false);
    }
    return repo.email || repo.text;
});

parentSearch($(".edit-father-search"), baseUrl + "/parent/search", { 'type': 'father' }, 'Search for Father Email', parentSearchSelect2DesignTemplate, function (repo) {
    if (!repo.text) {
        //Remove dynamic jquery validation
        $(".edit-father-search").rules("remove", "email");
        $(".father_image").rules("remove", "required");
        $('#edit_father_first_name').val(repo.first_name).attr('readonly', true);
        $('#edit_father_last_name').val(repo.last_name).attr('readonly', true);
        $('#edit_father_mobile').val(repo.mobile).attr('readonly', true);
        $('#edit_father_occupation').val(repo.occupation).attr('readonly', true);
        $('#edit_father_dob').val(repo.dob).attr('readonly', true);
        $('#edit-father-image-tag').attr('src', repo.image);
        // } else if (repo.text !== "Search for Father Email") {
    } else {

        //Add dynamic jquery validation
        $(".edit-father-search").rules("add", {
            email: true,
        });

        $(".father_image").rules("add", {
            required: true,
        });
        $('#edit_father_first_name').val('').attr('readonly', false);
        $('#edit_father_last_name').val('').attr('readonly', false);
        $('#edit_father_mobile').val('').attr('readonly', false);
        $('#edit_father_occupation').val('').attr('readonly', false);
        $('#edit_father_dob').val('').attr('readonly', false);
        $('#edit-father-image-tag').attr('src', '');
    }
    // }
    return repo.email || repo.text;
});

parentSearch($(".edit-mother-search"), baseUrl + "/parent/search", { 'type': 'mother' }, 'Search for Mother Email', parentSearchSelect2DesignTemplate, function (repo) {
    if (!repo.text) {
        //Remove dynamic jquery validation
        $(".edit-mother-search").rules("remove", "email");
        $(".mother_image").rules("remove", "required");
        $('#edit_mother_first_name').val(repo.first_name).attr('readonly', true);
        $('#edit_mother_last_name').val(repo.last_name).attr('readonly', true);
        $('#edit_mother_mobile').val(repo.mobile).attr('readonly', true);
        $('#edit_mother_occupation').val(repo.occupation).attr('readonly', true);
        $('#edit_mother_dob').val(repo.dob).attr('readonly', true);
        $('#edit-mother-image-tag').attr('src', repo.image);
    } else {
        //Add dynamic jquery validation
        $(".edit-mother-search").rules("add", {
            email: true,
        });
        $(".mother_image").rules("add", {
            required: true,
        });
        $('#edit_mother_first_name').val('').attr('readonly', false);
        $('#edit_mother_last_name').val('').attr('readonly', false);
        $('#edit_mother_mobile').val('').attr('readonly', false);
        $('#edit_mother_occupation').val('').attr('readonly', false);
        $('#edit_mother_dob').val('').attr('readonly', false);
        $('#edit-mother-image-tag').attr('src', '');
    }
    return repo.email || repo.text;
});

parentSearch($(".edit-guardian-search"), baseUrl + "/parent/search", null, 'Search for Guardian Email', parentSearchSelect2DesignTemplate, function (repo) {
    if (!repo.text) {
        //Remove dynamic jquery validation
        $(".edit-guardian-search").rules("remove", "email");
        $(".guardian_image").rules("remove", "required");
        $('#edit_guardian_first_name').val(repo.first_name).attr('readonly', true);
        $('#edit_guardian_last_name').val(repo.last_name).attr('readonly', true);
        if (repo.gender == 'Male') {
            $('#edit_guardian_female').removeAttr('checked');
            $('#edit_guardian_male').attr('checked', 'true');
        } else {
            $('#edit_guardian_male').removeAttr('checked');
            $('#edit_guardian_female').attr('checked', 'true');
        }
        $('#edit_guardian_mobile').val(repo.mobile).attr('readonly', true);
        $('#edit_guardian_occupation').val(repo.occupation).attr('readonly', true);
        $('#edit_guardian_dob').val(repo.dob).attr('readonly', true);
        $('#edit-guardian-image-tag').attr('src', repo.image).attr('readonly', true);
    } else {
        //Add dynamic jquery validation
        $(".edit-guardian-search").rules("add", {
            email: true,
        });
        $(".guardian_image").rules("add", {
            required: true,
        });
        $('#edit_guardian_first_name').val('').attr('readonly', false);
        $('#edit_guardian_last_name').val('').attr('readonly', false);
        $('#edit_guardian_mobile').val('').attr('readonly', false);
        $('#edit_guardian_occupation').val('').attr('readonly', false);
        $('#edit_guardian_dob').val('').attr('readonly', false);
        $('#edit-guardian-image-tag').attr('src', '').attr('readonly', false);
    }
    return repo.email || repo.text;
});
$(document).on('submit', '.setting-form', function (e) {
    e.preventDefault();
    var data = new FormData(this);
    var message = data.get('setting_message');
    let submitButtonElement = $(this).find(':submit');
    var type = $('#type').val();
    var url = $(this).attr('action');
    let submitButtonText = submitButtonElement.val();
    $.ajax({
        type: "POST",
        url: url,
        data: { message: message, type: type },
        beforeSend: function () {

            submitButtonElement.val('Please Wait...').attr('disabled', true);
        },
        success: function (response) {

            if (response.error == false) {
                showSuccessToast(response.message);
                submitButtonElement.val(submitButtonText).attr('disabled', false);
            } else {

                showErrorToast(response.message);
            }
        }

    });
});

$('.general-setting').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        setTimeout(function () {
            location.reload();
        }, 3000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
});

$('#s_section_id').on('change', function () {
    if ($(this).val() !== "") {
        $('#timetable-div').removeClass('d-none');
    } else {
        $('#timetable-div').addClass('d-none');
    }
});



$('.class_section_id').on('change', function () {
    // let class_id = $(this).find(':selected').data('class');
    let class_section_id = $(this).val();
    let url = baseUrl + '/subject-by-class-section';
    let data = { class_section_id: class_section_id };

    function successCallback(response) {
        if (response.length > 0) {
            let html = '';
            html += '<option>--Select Subject--</option>';
            $.each(response, function (key, value) {
                html += '<option value="' + value.subject_id + '">' + value.subject.name + ' - ' + value.subject.type + '</option>'
            });
            $('.subject_id').html(html);
        } else {
            $('.subject_id').html("<option value=''>--No data Found--</option>>");
        }
    }

    ajaxRequest('GET', url, data, null, successCallback, null, null, true)
})

$('#edit_class_section_id').on('change', function (e, subject_id) {
    // let class_id = $(this).find(':selected').data('class');
    let class_section_id = $(this).val();
    let url = baseUrl + '/subject-by-class-section';
    let data = { class_section_id: class_section_id };

    function successCallback(response) {
        if (response.length > 0) {
            let html = '';
            $.each(response, function (key, value) {
                html += '<option value="' + value.subject_id + '">' + value.subject.name + ' - ' + value.subject.type + '</option>'
            });
            $('#edit_subject_id').html(html);
            if (subject_id) {
                $('#edit_subject_id').val(subject_id);
            }
        } else {
            $('#edit_subject_id').html("<option value=''>--No data Found--</option>>");
        }
    }

    ajaxRequest('GET', url, data, null, successCallback, null, null, true)
})

$(document).on('change', '.timetable_start_time', function () {
    let $this = $(this);
    let end_time = $(this).parent().siblings().children('.timetable_end_time');
    $(end_time).rules("add", {
        timeGreaterThan: $this,
    });
})

$('#system-update').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        setTimeout(function () {
            window.location.reload();
        }, 1000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$("#create-form-bulk-data").submit(function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback(response) {
        formElement[0].reset();
    }
    function errorCallback(response) {
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback, errorCallback);
});


// get classes on Drop down exam changes


// get Subjects on Drop down classes changes



// add more subject in create exam timetable


// remove more subject in create exam timetable
$(document).on('click', '.remove-exam-timetable-content', function (e) {
    e.preventDefault();
    $(this).parent().parent().parent().remove();
});

$(".exam_class_filter").find("select").change(function () {
    $table.bootstrapTable("refreshOptions", {
        exportDataType: $(this).val()
    });
});

$("#edit_class_id").on('change', function () {
    let data = $(this).find(':selected').data("medium");
    let url = baseUrl + "/class-subject-list/" + data
    $.ajax({
        type: "GET",
        url: url,
        success: function (response) {
            let html = ""
            if (response.data.length > 0) {
                response.data.forEach(function (data) {
                    html += "<option value='" + data.id + "'>" + data.name + "</option>";
                })
            } else {
                html = "<option value=''>No Data Found</option>";
            }
            $('.core-subject-id').html(html);
            $('.elective-subject-name').html(html)
        }
    });
});

// According to Conditions Show the Button of Adding new row
function checkAddNewRowBtn() {
    if ($('.grade_content').find('.ending_range').length) {
        let chk_max = $(this).val();
        if (chk_max < 100 && chk_max != '') {
            $('.add-grade-content').prop('disabled', false);
        } else {
            $('.add-grade-content').prop('disabled', true);
        }
        $('.ending_range:last').keyup(function (e) {
            let chk_max = $(this).val();
            if (chk_max < 100 && chk_max != '') {
                $('.add-grade-content').prop('disabled', false);
            } else {
                $('.add-grade-content').prop('disabled', true);
            }
        });

    } else {
        $('.add-grade-content').prop('disabled', false);
    }
}

checkAddNewRowBtn();

// create grade ajax
$('#create-grades').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        window.location.reload();
        checkAddNewRowBtn(); // calling the function of adding new row btn
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('.remove-grades').hide();
$('.grade_content:last').find('.remove-grades').show();
let value = parseInt($('.grade_content:last').find('.ending_range').val());
if (value >= 100) {
    $('.add-grade-content').prop('disabled', true);
} else {
    $('.add-grade-content').prop('disabled', false);
}
//adding new row for grade
$(document).on('click', '.add-grade-content', function (e) {
    e.preventDefault();
    let value = parseFloat($('.grade_content:last').find('.ending_range').val());
    if (value) {
        value = value + 1;
    } else {
        value = 0;
    }
    let html = $('.grade_content:last').clone();
    $('.grade_content:last').find('.remove-grades').hide();
    html.find('.error').remove();
    html.find('.temp_starting_range').removeClass('temp_starting_range').addClass('starting_range');
    html.find('.temp_ending_range').removeClass('temp_ending_range').addClass('ending_range');
    html.find('.temp_grade').removeClass('temp_grade').addClass('grade');
    html.css('display', 'block');
    html.find('.has-danger').removeClass('has-danger');
    html.find('.hidden').remove();
    html.find(".remove-grades").removeAttr('data-id');
    // This function will replace the last index value and increment in the multidimensional name attribute
    $(this).parent().siblings('.extra-grade-content').append(html);
    $('.add-grade-content').prop('disabled', true);
    html.find('.starting_range').val('')
    html.find('.ending_range').val('');
    html.find('.grade').val('');
    html.find('input').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    let increment_stating_range = html.find('.starting_range').val(value);
    increment_stating_range.attr('min', value);
    let min_attr = parseInt(increment_stating_range.attr("min"));
    increment_stating_range.keyup(function () {
        if ($(this).val()) {
            if ($(this).val() < min_attr) {
                $('.add-grade-content').prop('disabled', true);
            }
        } else {
            $('.add-grade-content').prop('disabled', true);
        }
    });

    let ending_range = html.find('.ending_range');
    ending_range.attr('max', 100);
    ending_range.keyup(function () {
        if ($(this).val()) {
            if ($(this).val() <= min_attr) {
                $('.add-grade-content').prop('disabled', true);
            } else {
                if ($(this).val() < 100) {
                    $('.add-grade-content').prop('disabled', false);
                } else {
                    $('.add-grade-content').prop('disabled', true);
                }
            }
        } else {
            $('.add-grade-content').prop('disabled', true);
        }
    });
});
// remove more grade in create grade
$(document).on('click', '.remove-grades', function (e) {
    e.preventDefault();
    let $this = $(this);
    if ($(this).data('id')) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $this.data('id');
                let url = baseUrl + '/destroy-grades/' + id;

                function successCallback() {
                    $this.parent().parent().remove();
                    window.location.reload();
                    checkAddNewRowBtn();
                }

                ajaxRequest('DELETE', url, null, null, successCallback);

            }
        })
    } else {
        $(this).parent().parent().parent().remove();
        $('.grade_content:last').find('.remove-grades').show();
        let last_ending_val = $('.grade_content:last').find('.ending_range').val();
        if (last_ending_val >= 100 && last_ending_val == '') {
            $('.add-grade-content').prop('disabled', true);
        } else {
            $('.add-grade-content').prop('disabled', false);
        }
        $('.ending_range:last').keyup(function (e) {
            let chk_max = $(this).val();
            if (chk_max < 100 && chk_max != '') {
                $('.add-grade-content').prop('disabled', false);
            } else {
                $('.add-grade-content').prop('disabled', true);
            }
        });
    }
});

$('.assign_subject_teacher').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        formElement[0].reset();
        $('.select2-selection__rendered').html('');
        $('#table_list').bootstrapTable('refresh');
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('.class_submit_button').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        formElement[0].reset();
        // $('.select2-selection__rendered').html('');
        $('#table_list').bootstrapTable('refresh');
    }

    formAjaxRequest('PUT', url, data, formElement, submitButtonElement, successCallback);
});

$('#admin-profile-update').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);


    function successCallback() {
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$('.create_exam_timetable_form').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);


    function successCallback() {
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('.add-new-timetable-data').click(function (e) {
    e.preventDefault();
    let html;
    if (!$('.edit-timetable-container:last').is(':empty')) {
        html = $('.edit-timetable-container').find('.edit_exam_timetable:last').clone();
    } else {
        html = $('.edit_exam_timetable_tamplate').clone();
    }
    html.css('display', 'block');
    html.find('.error').remove();
    html.removeClass('edit_exam_timetable_tamplate').addClass('edit_exam_timetable');
    html.find('.has-danger').removeClass('has-danger');
    html.find('.remove-edit-exam-timetable-content').removeAttr('data-timetable_id');
    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find('.form-control').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    $(this).parent().siblings('.edit-timetable-container').append(html);
    html.find('.form-control').val('');

});

$('.edit-form-timetable').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);


    function successCallback() {
        $('#editModal').modal('hide');
        $('#table_list').bootstrapTable('refresh');
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('.verify_email').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);


    function successCallback() {
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
});
$('.subject_id').on('change', function () {
    // let class_id = $(this).find(':selected').data('class');
    let class_section_id = $('.class_section_id').val();
    let subject_id = $(this).val();
    let url = baseUrl + '/teacher-by-class-subject';
    let data = {
        class_section_id: class_section_id,
        subject_id: subject_id
    };


    function successCallback(response) {
        if (response.length > 0) {
            let html = '';
            $.each(response, function (key, value) {
                html += '<option value="' + value.id + '">' + value.user.first_name + ' ' + value.user.last_name + '</option>'
            });
            $('#teacher_id').html(html);
        } else {
            $('#teacher_id').html("<option value=''>--No data Found--</option>>");
        }
    }

    ajaxRequest('GET', url, data, null, successCallback, null, null, true)
})
$('#edit_subject_id').on('change', function () {

    let edit_id = $('#id').val();
    let class_section_id = $('#edit_class_section_id').val();
    let subject_id = $(this).val();
    let url = baseUrl + '/teacher-by-class-subject';
    let data = {
        edit_id: edit_id,
        class_section_id: class_section_id,
        subject_id: subject_id
    };
    function successCallback(response) {
        if (response.length > 0) {
            let html = '';
            $.each(response, function (key, value) {
                html += '<option value="' + value.id + '">' + value.user.first_name + ' ' + value.user.last_name + '</option>'
            });
            $('#edit_teacher_id').html(html);
        } else {
            $('#edit_teacher_id').html("<option value=''>--No data Found--</option>>");
        }
    }

    ajaxRequest('GET', url, data, null, successCallback, null, null, true)
})
$('.add-new-fees-type').on('click', function (e) {
    e.preventDefault();
    let html = ''
    if ($('.edit-extra-fees-types').find('.template_fees_type:last').html()) {
        html = $('.edit-extra-fees-types').find('.template_fees_type:last').clone();
        html.find('.form-control').each(function (key, element) {
            this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
                return '[' + (parseInt(p1, 10) + 1) + ']';
            });
            this.id = this.id.replace(/\_(\d+)/, function (str, p1) {
                return '_' + (parseInt(p1, 10) + 1);
            });
            $(element).attr('disabled', false);
        })
    } else {
        html = $('.template_fees_type').clone().show();
    }
    html.find('select').siblings('.error').remove();
    html.find('.add-fees-type i').addClass('fa-times').removeClass('fa-plus');
    html.find('.add-fees-type').addClass('btn-inverse-danger remove-fees-type').removeClass('btn-inverse-success add-fees-type');
    $('.edit-extra-fees-types').append(html);
});

$('#fees-class-create-form').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        setTimeout(function () {
            $('#editModal').modal('hide');
        }, 1000)
        $('#table_list').bootstrapTable('refresh');
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
});
$(document).on('click', '.remove-fees-type', function (e) {
    e.preventDefault();
    // let $this = $(this);
    if ($(this).data('id')) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).data('id');
                let url = baseUrl + '/class/fees-type/' + id;

                function successCallback(response) {
                    showSuccessToast(response['message']);
                    setTimeout(function () {
                        $('#editModal').modal('hide');
                    }, 1000)
                    $('#table_list').bootstrapTable('refresh');
                    $(this).parent().parent().remove();
                }
                function errorCallback(response) {
                    showErrorToast(response['message']);
                }

                ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
            }
        })
    } else {
        $(this).parent().parent().remove();
    }
});
$('.mode').on('change', function (e) {
    e.preventDefault();
    let mode_val = $(this).val();
    if (mode_val == 1) {
        $('.cheque_no_container').show(200);
    } else {
        $('.cheque_no_container').hide(200);
    }
});
$('.pay_student_fees_offline').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);


    function successCallback() {
        $('#editModal').modal('hide');
        $('.cheque_no_container').hide();
        formElement[0].reset();
        $('#table_list').bootstrapTable('refresh');
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('.edit_mode').on('change', function (e) {
    e.preventDefault();
    let mode_val = $(this).val();
    if (mode_val == 1) {
        $('.edit_cheque_no_container').show(200);
    } else {
        $('.edit_cheque_no_container').hide(200);
    }
});
$(document).on('click', '.remove-paid-choiceable-fees', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let amount = $(this).data("amount");
            // let url = $(this).attr('href');
            let id = $(this).data("id");
            let url = baseUrl + '/fees/paid/remove-choiceable-fees/' + id;
            let data = null;

            function successCallback(response) {
                $('#table_list').bootstrapTable('refresh');
                setTimeout(function () {
                    $('#editFeesPaidModal').modal('hide');
                }, 1000)
                showSuccessToast(response.message);
            }

            function errorCallback(response) {
                showErrorToast(response.message);
            }

            ajaxRequest('DELETE', url, data, null, successCallback, errorCallback);
        }
    })
})
$('#create-fees-config-form').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('#edit-fees-paid-form').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let data = new FormData(this);
    data.append("_method", "PUT");
    let url = $(this).attr('action') + "/" + data.get('edit_id');

    function successCallback(response) {
        $('#table_list').bootstrapTable('refresh');
        setTimeout(function () {
            $('#editFeesPaidModal').modal('hide');
        }, 1000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('#class_timetable_class_section').on('change', function (e) {
    $('.list_buttons').show(200);
    var class_section_id = $(this).val();
    // var class_id = $(this).find(':selected').attr('data-class');
    // var section_id = $(this).find(':selected').attr('data-section');
    $('.set_timetable').html('');
    $.ajax({
        url: baseUrl + '/gettimetablebyclass',
        type: "GET",
        data: { class_section_id: class_section_id },
        success: function (response) {
            var html = '';
            if (response['days'].length) {
                $('.warning_no_data').hide(300);
                for (let i = 0; i < response['days'].length; i++) {
                    html += '<div class="col-lg-4 col-xl-4 col-xxl-2 col-md-4 col-sm-12 col-12 project-grid">';
                    html += '<div class="project-grid-inner">';
                    html += '<div class="wrapper bg-light">';
                    html += '<h5 class="card-header header-sm bg-secondary">' + response['days'][i]['day_name'].charAt(0).toUpperCase() + response['days'][i]['day_name'].slice(1) + '</h5>';
                    for (let j = 0; j < response['timetable'].length; j++) {
                        if (response['days'][i]['day'] == response['timetable'][j]['day']) {
                            html += '<p class="timetable-body p-3">'
                                + response['timetable'][j]['subject_teacher']['subject']['name'] + ' - ' + response['timetable'][j]['subject_teacher']['subject']['type']
                                + '<br>' + response['timetable'][j]['subject_teacher']['teacher']['user']['first_name'] + ' ' + response['timetable'][j]['subject_teacher']['teacher']['user']['last_name']
                                + '<br>start time: ' + response['timetable'][j]['start_time'] + '<br>end time: '
                                + response['timetable'][j]['end_time'] + '</p><hr>';

                        }
                    }
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    $('.set_timetable').html(html);
                }
            } else {
                $('.warning_no_data').show(300);
                $('.table_content').hide();
            }
        }
    })
});

$('#teacher_timetable_class_section').on('change', function (e) {
    var class_section_id = $(this).val();
    var class_id = $(this).find(':selected').attr('data-class');
    var section_id = $(this).find(':selected').attr('data-section');
    $('.set_timetable').html('');
    $.ajax({
        url: baseUrl + "/get-timetable-by-subject-teacher-class",
        type: "GET",
        data: { class_section_id: class_section_id, class_id: class_id },
        success: function (response) {
            if (response['days'].length) {
                $('.warning_no_data').hide(300);
                var html = '';
                let counter = 0
                for (let i = 0; i < response['days'].length; i++) {
                    html += '<div class="col-lg-4 col-xl-4 col-xxl-2 col-md-4 col-sm-12 col-12 project-grid">';
                    html += '<div class="project-grid-inner">';
                    html += '<div class="wrapper bg-light">';
                    html += '<h5 class="card-header header-sm bg-secondary">' + response['days'][i]['day_name'].charAt(0).toUpperCase() + response['days'][i]['day_name'].slice(1) + '</h5>';
                    for (let j = 0; j < response['timetable'].length; j++) {
                        if (response['days'][i]['day'] == response['timetable'][j]['day']) {
                            html += '<p class="timetable-body p-3">'
                                + response['timetable'][j]['class_section']['class']['name'] + ' - ' + response['timetable'][j]['class_section']['section']['name']
                                + '<br>' + response['timetable'][j]['subject_teacher']['subject']['name'] + ' - ' + response['timetable'][j]['subject_teacher']['subject']['type']
                                + '<br>start time: ' + response['timetable'][j]['start_time'] + '<br>end time: '
                                + response['timetable'][j]['end_time'] + '</p><hr>';

                        }
                    }
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    $('.set_timetable').html(html);
                }
            } else {
                $('.warning_no_data').show(300);
            }
        }
    })
});

$('#teacher_timetable_teacher_id').on('change', function (e) {
    var teacher_id = $(this).val();
    $('.set_timetable').html('');
    $.ajax({
        url: baseUrl + "/gettimetablebyteacher",
        type: "GET",
        data: {
            teacher_id: teacher_id
        },
        success: function (response) {
            var html = '';
            let counter = 0;
            for (let n = 0; n < response['days'].length; n++) {
                for (let i = 0; i < response['days'][n].length; i++) {
                    counter += 1;
                    html += '<div class="col-lg-4 col-xl-4 col-xxl-2 col-md-4 col-sm-12 col-12 project-grid">';
                    html += '<div class="project-grid-inner">';
                    html += '<div class="wrapper bg-light">';
                    html += '<h5 class="card-header header-sm bg-secondary">' + response['days'][n][i]['day_name'].charAt(0).toUpperCase() + response['days'][n][i]['day_name'].slice(1) + '</h5>';
                    for (let m = 0; m < response['timetable'].length; m++) {
                        if (response['timetable'][m] != '') {
                            for (let j = 0; j < response['timetable'][m].length; j++) {
                                if (response['days'][n][i]['day'] == response['timetable'][m][j]['day']) {
                                    html += '<p class="timetable-body p-3">' + response['timetable'][m][j]['class_section']['class']['name'] +
                                        ' - ' + response['timetable'][m][j]['class_section']['section']['name'] +
                                        '<br>' + response['timetable'][m][j]['subject_teacher']['subject']['name'] + '-' + response['timetable'][m][j]['subject_teacher']['subject']['type'] +
                                        '<br>start time: ' + response['timetable'][m][j]['start_time'] +
                                        '<br>end time: ' + response['timetable'][m][j]['end_time'] + '</p><hr>';
                                }
                            }
                        }
                    }
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    $('.set_timetable').html(html);
                }
            }
            if (counter != 0) {
                $('.warning_no_data').hide(300);
            } else {
                $('.warning_no_data').show(300);
            }
        }
    })
});
$('#razorpay_status').on('change', function (e) {
    e.preventDefault();
    if ($(this).val() == 1) {
        $('#stripe_status').val(0);
    } else {
        $('#stripe_status').val(1);
    }
});
$('#stripe_status').on('change', function (e) {
    e.preventDefault();
    if ($(this).val() == 1) {
        $('#razorpay_status').val(0);
    } else {
        $('#razorpay_status').val(1);
    }
});
$('#assign-roll-no-form').on('submit', function (e) {
    e.preventDefault();
    Swal.fire({
        title: lang_delete_title,
        text: lang_delete_warning,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: lang_yes_change_it
    }).then((result) => {
        if (result.isConfirmed) {
            let formElement = $(this);
            let submitButtonElement = $(this).find(':submit');
            let url = $(this).attr('action');
            let data = new FormData(this);

            function successCallback() {
                $('#table_list').bootstrapTable('refresh');
            }

            formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
        }
    })
})
$('.online-exam-class-section-id').on('change', function (e) {
    e.preventDefault();
    let url = baseUrl + '/get-subject-online-exam';
    let data = {
        'based_on': 1,
        'class_section_id': $(this).val()
    };

    function successCallback(response) {
        let html = ""
        if (response.data.length) {
            html += "<option value=''>-- " + lang_select_subject + " --</option>"
            response.data.forEach(function (data) {
                html += "<option value='" + data.id + "'>" + data.name + ' - ' + data.type + "</option>";
            })
        } else {
            html = "<option value=''>" + lang_no_data_found + "</option>";
        }
        $('.online-exam-subject-id').html(html);
    }

    ajaxRequest('GET', url, data, null, successCallback, null, null, true);
})
$('#add-new-option').on('click', function (e) {
    e.preventDefault();
    let html = $('.option-container').find('.form-group:last').clone();
    html.find('.add-question-option').val('');
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    $('.remove-option-content').css('display', 'none');
    html.addClass('quation-option-extra');

    // html.removeClass('col-md-6').addClass('col-md-5');
    // This function will increment in the label option number
    let inner_html = html.find('.option-number:last').html();
    html.find('.option-number:last').each(function (key, element) {
        inner_html = inner_html.replace(/(\d+)/, function (str, p1) {
            return (parseInt(p1, 10) + 1);
        });
    })
    html.find('.option-number:last').html(inner_html)

    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find(':input').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    html.find('.remove-option-content').html('<button class="btn btn-inverse-danger remove-option btn-sm mt-1" type="button"><i class="fa fa-times"></i></button>')
    $('.option-container').append(html)

    let select_answer_option = '<option value=' + inner_html + ' class="answer_option extra_answers_options">' + lang_option + ' ' + inner_html + '</option>'
    $('#answer_select').append(select_answer_option)
});
$(document).on('click', '.remove-option', function (e) {
    e.preventDefault();
    $(this).parent().parent().remove();
    $('.option-container').find('.form-group:last').find('.remove-option-content').css('display', 'block');
    $('#answer_select').find('.answer_option:last').remove();
})
$('#create-online-exam-questions-form').on('submit', function (e) {
    e.preventDefault();
    for (var equation_editor in CKEDITOR.instances) {
        CKEDITOR.instances[equation_editor].updateElement();
    }
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('.question_type').on('change', function (e) {
    $('.quation-option-extra').remove();
    $('#answer_select').val(null).trigger("change");
    if ($(this).val() == 1) {
        $('#simple-question').hide();
        $('#equation-question').show(500);
    } else {
        $('#simple-question').show(500);
        $('#equation-question').hide();
    }
})
$('#add-new-eqation-option').on('click', function (e) {
    e.preventDefault();
    let html = $('.equation-option-container').find('.quation-option-template:last').clone();
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    $('.remove-equation-option-content').css('display', 'none');

    // html.removeClass('col-md-6').addClass('col-md-5');
    // This function will increment in the label equation-option-number
    let inner_html = html.find('.equation-option-number:last').html();
    html.find('.equation-option-number:last').each(function (key, element) {
        inner_html = inner_html.replace(/(\d+)/, function (str, p1) {
            return (parseInt(p1, 10) + 1);
        });
    })

    // This function will replace the last index value and increment in the multidimensional name attribute
    let name;
    html.find(':input').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            name = '[' + (parseInt(p1, 10) + 1) + ']';
            return name;
        });
    })

    let option_html = '<div class="form-group col-md-6 equation-editor-options-extra quation-option-template"><label>' + lang_option + ' <span class="equation-option-number">' + inner_html + '</span> <span class="text-danger">*</span></label><textarea class="editor_options" name="eoption' + name + '" placeholder="' + lang_select_option + '"></textarea><div class="remove-equation-option-content"><button class="btn btn-inverse-danger remove-equation-option btn-sm mt-1" type="button"><i class="fa fa-times"></i></button></div></div>'
    $('.equation-option-container').append(option_html).ready(function () {
        createCkeditor();
    });
    let select_answer_option = '<option value=' + inner_html + ' class="answer_option extra_answers_options">' + lang_option + ' ' + inner_html + '</option>'
    $('#answer_select').append(select_answer_option)
});
$(document).on('click', '.remove-equation-option', function (e) {
    e.preventDefault();
    $(this).parent().parent().remove();
    $('.equation-option-container').find('.form-group:last').find('.remove-equation-option-content').css('display', 'block');
    $('#answer_select').find('.answer_option:last').remove();
})

$('.edit-question-type').on('change', function (e) {
    if ($(this).val() == 1) {
        $('#edit-simple-question-content').hide();
        $('#edit-equation-question-content').show(500);
    } else {
        $('#edit-simple-question-content').show(500);
        $('#edit-equation-question-content').hide();
    }
})
$(document).on('click', '.add-new-edit-option', function (e) {
    e.preventDefault();
    let html = $('.edit_option_container').find('.form-group:last').clone();
    html.find('.add-edit-question-option').val('');
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    html.find('.edit_option_id').val('')
    let hide_button = {}
    hide_button = $('.remove-edit-option-content:last').find('.remove-edit-option')
    if (hide_button.data('id')) {
        $('.remove-edit-option-content:last').css('display', 'block');
    } else {
        $('.remove-edit-option-content:last').css('display', 'none');
    }

    // This function will increment in the label option number
    let inner_html = html.find('.edit-option-number:last').html();
    html.find('.edit-option-number:last').each(function (key, element) {
        inner_html = inner_html.replace(/(\d+)/, function (str, p1) {
            return (parseInt(p1, 10) + 1);
        });
    })
    html.find('.edit-option-number:last').html(inner_html)

    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find(':input').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    html.find('.remove-edit-option-content').html('<button class="btn btn-inverse-danger remove-edit-option btn-sm mt-1" type="button"><i class="fa fa-times"></i></button>')
    $('.edit_option_container').append(html)

    let select_answer_option = '<option value="new' + $.trim(inner_html) + '" class="edit_answer_option">' + lang_option + ' ' + inner_html + '</option>'
    $('.edit_answer_select').append(select_answer_option)
});
$(document).on('click', '.remove-edit-option', function (e) {
    e.preventDefault();
    if ($(this).data('id')) {
        Swal.fire({
            title: lang_delete_title,
            text: lang_delete_warning,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: lang_yes_delete
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).data('id');
                let url = baseUrl + '/online-exam-question/remove-option/' + id;

                function successCallback(response) {
                    $('#editModal').modal('hide');
                    setTimeout(function () {
                        $('#table_list_questions').bootstrapTable('refresh');
                    }, 500)
                    showSuccessToast(response.message);
                }

                function errorCallback(response) {
                    showErrorToast(response.message);
                }
                ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
            }
        })
    } else {
        $(this).parent().parent().remove();
        $('.edit_answer_select').find('.edit_answer_option:last').remove()
        $('.edit_option_container').find('.form-group:last').find('.remove-edit-option-content').css('display', 'block');
        $('.edit_eoption_container').find('.form-group:last').find('.remove-edit-option-content').css('display', 'block');
    }
});
$(document).on('click', '.remove-answers', function (e) {
    e.preventDefault();
    Swal.fire({
        title: lang_delete_title,
        text: lang_delete_warning,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: lang_yes_delete
    }).then((result) => {
        if (result.isConfirmed) {
            let id = $(this).data('id');
            let url = baseUrl + '/online-exam-question/remove-answer/' + id;

            function successCallback(response) {
                $('#editModal').modal('hide');
                setTimeout(function () {
                    $('#table_list_questions').bootstrapTable('refresh');
                }, 500)
                showSuccessToast(response.message);
            }
            function errorCallback(response) {
                showErrorToast(response.message);
            }

            ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
        }
    })
});
$('#add-new-question-online-exam').on('submit', function (e) {
    e.preventDefault();
    for (var equation_editor in CKEDITOR.instances) {
        CKEDITOR.instances[equation_editor].updateElement();
    }
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback(response) {
        // Get the CKEditor instance
        var editors = Object.values(CKEDITOR.instances);


        // Loop through each instance
        editors.filter(editor => editor.element.hasClass('editor_question')).forEach(editor => {
            editor.setData(''); // clear the text
            editor.resetDirty(); // reset the points to save the changes
        });

        editors.filter(editor => editor.element.hasClass('editor_options')).forEach(editor => {
            editor.setData(''); // clear the text
            editor.resetDirty(); // reset the points to save the changes
        });


        // remove the extra options of ckeditors
        $(document).find('.equation-editor-options-extra').remove();
        $(document).find('.extra_answers_options').remove();

        $('.add-new-question-container').hide(200)
        $('.add-new-question-button').show(300).ready(function () {
            $('.add-new-question-button').html(lang_add_new_question);
        })
        formElement[0].reset();
        $('#simple-question').show();
        $('#equation-question').hide();

        $('#answer_select').val(null).trigger("change");
        $('.quation-option-extra').remove();
        $('#table_list_exam_questions').bootstrapTable('refresh');
        function checkList(listName, newItem) {
            var dupl = false;
            $("#" + listName + " > div").each(function () {
                if ($(this)[0] !== newItem[0]) {
                    if ($(this).html() == newItem.html()) {
                        dupl = true;
                    }
                }
            });
            return !dupl;
        }
        let li = ''
        if (response.data.question_type == 1) {
            li = $('<div class="list-group"><input type="hidden" name="assign_questions[' + response.data.question_id + '][question_id]" value="' + response.data.question_id + '"><li id="q' + response.data.question_id + '"class="list-group-item d-flex justify-content-between align-items-center ui-state-default list-group-item-secondary m-2">' + response.data.question_id + ". " + response.data.question + ' <span class="text-right row"><input type="number" class="list-group-item col-md-6" name="assign_questions[' + response.data.question_id + '][marks]" style="width: 10rem"><a class="btn btn-danger btn-sm remove-row ml-2" data-id="' + response.data.question_id + '"><i class="fa fa-times" aria-hidden="true"></i></a></span></li></div>');
        } else {
            li = $('<div class="list-group"><input type="hidden" name="assign_questions[' + response.data.question_id + '][question_id]" value="' + response.data.question_id + '"><li id="q' + response.data.question_id + '"class="list-group-item d-flex justify-content-between align-items-center ui-state-default list-group-item-secondary m-2">' + response.data.question_id + ". " + '<span class="text-center">' + response.data.question + '</span> <span class="text-right row"><input type="number" class="list-group-item col-md-6" name="assign_questions[' + response.data.question_id + '][marks]" style="width: 10rem"><a class="btn btn-danger btn-sm remove-row ml-2" data-id="' + response.data.question + '"><i class="fa fa-times" aria-hidden="true"></i></a></span></li></div>');
        }
        var pasteItem = checkList("sortable-row", li);
        if (pasteItem) {
            $("#sortable-row").append(li);
        }
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
});
$('.add-new-question-button').on('click', function (e) {
    e.preventDefault();
    $('#answer_select').val(null).trigger("change");
    $('.add-new-question-container').show(300);
    $(this).hide();
    $(this).html('');
})
$('.remove-add-new-question').on('click', function (e) {
    e.preventDefault();
    $('.add-new-question-container').hide(300);
    $('.add-new-question-button').show(300).ready(function () {
        $('.add-new-question-button').html(lang_add_new_question);
    });
})
$(document).on('click', '.remove-row', function (e) {
    let id = $(this).data('id');
    let edit_id = $(this).data('edit_id');
    let $this = $(this);
    if (edit_id) {
        Swal.fire({
            title: lang_delete_title,
            text: lang_delete_warning,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: lang_yes_delete
        }).then((result) => {
            if (result.isConfirmed) {
                let url = baseUrl + '/online-exam/remove-choiced-question/' + edit_id;

                function successCallback(response) {
                    showSuccessToast(response.message);
                    $this.parent().parent().parent().remove();
                    $('#table_list_exam_questions').bootstrapTable('refresh');
                }
                function errorCallback(response) {
                    showErrorToast(response.message);
                }

                ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
            }
        })
    } else {
        $(this).parent().parent().parent().remove();
        $('#table_list_exam_questions').bootstrapTable('uncheckBy', { field: 'question_id', values: [id] })
    }
})
$('#store-assign-questions-form').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        window.location.reload();
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$('#edit-question-form').on('submit', function (e) {
    e.preventDefault();
    for (var equation_editor in CKEDITOR.instances) {
        CKEDITOR.instances[equation_editor].updateElement();
    }
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let data = new FormData(this);
    data.append("_method", "PUT");
    let url = $(this).attr('action') + "/" + data.get('edit_id');

    function successCallback(response) {
        $('#table_list_questions').bootstrapTable('refresh');
        setTimeout(function () {
            $('#editModal').modal('hide');
        }, 1000)
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$(document).on('click', '.delete-question-form', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = $(this).attr('href');
            let data = null;

            function successCallback(response) {
                $('#table_list_questions').bootstrapTable('refresh');
                showSuccessToast(response.message);
            }

            function errorCallback(response) {
                showErrorToast(response.message);
            }

            ajaxRequest('DELETE', url, data, null, successCallback, errorCallback);
        }
    })
})
$('#table_list_questions').on('load-success.bs.table', function () {
    createCkeditor();
});
$('#table_list_exam_questions').on('load-success.bs.table', function () {
    createCkeditor();
});
$(document).on('click', '.add-new-edit-eoption', function (e) {
    e.preventDefault();

    // destroy the editors for no cloning the last ckeditor
    for (var equation_editor in CKEDITOR.instances) {
        CKEDITOR.instances[equation_editor].destroy();
    }
    let html = $('.edit_eoption_container').find('.form-group:last').clone();
    html.find('.editor_options').val('');
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    html.find('.edit_eoption_id').val('')
    let hide_button = {}
    hide_button = $('.remove-edit-option-content:last').find('.remove-edit-option')
    if (hide_button.data('id')) {
        $('.remove-edit-option-content:last').css('display', 'block');
    } else {
        $('.remove-edit-option-content:last').css('display', 'none');
    }

    // This function will increment in the label option number
    let inner_html = html.find('.edit-eoption-number:last').html();
    html.find('.edit-eoption-number:last').each(function (key, element) {
        inner_html = inner_html.replace(/(\d+)/, function (str, p1) {
            return (parseInt(p1, 10) + 1);
        });
    })
    html.find('.edit-eoption-number:last').html(inner_html)

    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find(':input').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    html.find('.remove-edit-option-content').html('<button class="btn btn-inverse-danger remove-edit-option btn-sm mt-1" type="button"><i class="fa fa-times"></i></button>')
    $('.edit_eoption_container').append(html).ready(function () {
        createCkeditor();
    })

    let select_answer_option = '<option value="new' + $.trim(inner_html) + '" class="edit_answer_option">' + lang_option + ' ' + inner_html + '</option>'
    $('.edit_answer_select').append(select_answer_option)
});
$('.online_exam_based_on').on('change', function (e) {
    if ($(this).val() == 1) {
        $('.class_container').hide(200);
        $('.class_section_container').show(500);
        $('.online-exam-class-section-id').val('');
        $('.online-exam-subject-id').val('');
    } else {
        $('.online-exam-class-id').val('');
        $('.online-exam-subject-id').val('');
        $('.class_section_container').hide(200);
        $('.class_container').show(500);
    }
})
$('.online-exam-class-id').on('change', function (e) {
    e.preventDefault();
    let url = baseUrl + '/get-subject-online-exam';
    let data = {
        'based_on': 0,
        'class_id': $(this).val()
    };

    function successCallback(response) {
        let html = ""
        if (response.data.length) {
            html += "<option value=''>-- " + lang_select_subject + " --</option>"
            response.data.forEach(function (data) {
                html += "<option value='" + data.id + "'>" + data.name + ' - ' + data.type + "</option>";
            })
        } else {
            html = "<option value=''>" + lang_no_data_found + "</option>";
        }
        $('.online-exam-subject-id').html(html);
    }

    ajaxRequest('GET', url, data, null, successCallback, null, null, true);
})
$('input[type="file"]').on('change', function (e) {
    $(this).closest('form').valid();
})

$('.fees_installment_toggle').on('change',function(e){
    e.preventDefault();
    if($(this).val() == 1){
        $('.fees_installment_content').show(200)
    }else{
        $('.fees_installment_content').hide(200)
    }
})


// add installment content
$(document).on('click', '.add-fee-installment-content', function (e) {
    e.preventDefault();
    let html = $('.fees_installment_content:last').clone();
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find('.form-control').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
        this.id = this.id.replace(/_(\d+)/, function (str, p1) {
            return '_' + (parseInt(p1, 10) + 1);
        });
    })
    html.find('.add-fee-installment-content i').addClass('fa-times').removeClass('fa-plus');
    html.find('.add-fee-installment-content').addClass('btn-inverse-danger remove-exam-timetable-content').removeClass('btn-inverse-success add-exam-timetable');
    $(this).parent().parent().parent().siblings('.extra-fee-installment-content').append(html);
    html.find('.form-control').val('');
});

// general form ajax with reload
$('#create-form-reload,.create-form-reload').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);

    function successCallback() {
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$('.add-extra-fee-installment-data').on('click', function (e) {
    e.preventDefault();
    let html = $('.installment-div').find('.edit-installment-container').find('.edit-installment-content:last').clone();
    html.find('.error').remove();
    html.find('.has-danger').removeClass('has-danger');
    // This function will replace the last index value and increment in the multidimensional name attribute
    html.find('.form-control').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
        this.id = this.id.replace(/_(\d+)/, function (str, p1) {
            return '_' + (parseInt(p1, 10) + 1);
        });
    })
    html.find('.add-edit-fee-installment-content i').addClass('fa-times').removeClass('fa-plus');
    html.find('.add-edit-fee-installment-content').addClass('btn-inverse-danger remove-edit-fee-installment-content').removeClass('btn-inverse-success add-edit-fee-installment-content');
    html.find('.remove-edit-fee-installment-content').removeAttr("data-id")
    $(this).parent().siblings('.edit-installment-container').append(html);
    html.find('.form-control').val('');
});
// remove more grade in create grade
$(document).on('click', '.remove-edit-fee-installment-content', function (e) {
    e.preventDefault();
    let $this = $(this);
    if ($(this).data('id')) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $this.data('id');
                let url = baseUrl + '/remove-installment-data/' + id;

                function successCallback(response) {
                    $('#table_list').bootstrapTable('refresh');
                    setTimeout(function () {
                        $('#editModal').modal('hide');
                    }, 500)
                    showSuccessToast(response.message);
                }

                function errorCallback(response) {
                    showErrorToast(response.message);
                }

                ajaxRequest('DELETE', url, null, null, successCallback,errorCallback);

            }
        })
    } else {
        $(this).parent().parent().parent().remove();
    }
});
$('.pay_optional_fees_offline').on('submit', function (e) {

    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);


    function successCallback() {
        $('#optionalModal').modal('hide');
        $('.cheque_no_container').hide();
        formElement[0].reset();
        $('#table_list').bootstrapTable('refresh');
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})

$(document).on('click', '.remove-optional-fees-paid', function (e) {
    e.preventDefault();
    let $this = $(this);
    if ($(this).data('id')) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $this.data('id');
                let url = baseUrl + '/fees/paid/remove-choiceable-fees/' + id;

                function successCallback() {
                    $('#table_list').bootstrapTable('refresh');
                    setTimeout(() => {
                        $('#optionalModal').modal('hide');
                    }, 500);

                }

                function errorCallback(response) {
                    showErrorToast(response.message);
                }

                ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
            }
        })
    } else {
        $(this).parent().parent().remove();
    }
});
$(document).on('click','.pay_in_installment' ,function(e){
    if ($(this).is(':checked')) {
        $('#installment_mode').val(1)
        $('.due_charges_whole_year').hide(200);
        $('.installment_rows').show(200);
        $('.compulsory_amount').html(Number(0).toFixed(2))

        let choice_amount = parseInt($('.compulsory_amount').html());
        // Check the Amount And Make PAY Button Clickable Or Not
        if(choice_amount > 1){
            $(document).find('.compulsory_fees_payment').prop('disabled', false);
        }else{
            $(document).find('.compulsory_fees_payment').prop('disabled', true);
        }
    }else{
        $(document).find('.compulsory_fees_payment').prop('disabled', false);
        $('#installment_mode').val(0)
        $('.installment_rows').hide(200);
        $('.due_charges_whole_year').show(200);
        $('.compulsory_amount').html($(this).data("base_amount"))
    }
})
$('.pay_compulsory_fees_offline').on('submit', function (e) {
    e.preventDefault();
    let formElement = $(this);
    let submitButtonElement = $(this).find(':submit');
    let url = $(this).attr('action');
    let data = new FormData(this);


    function successCallback() {
        $('#compulsoryModal').modal('hide');
        $('.cheque_no_container').hide();
        formElement[0].reset();
        $('#table_list').bootstrapTable('refresh');
    }

    formAjaxRequest('POST', url, data, formElement, submitButtonElement, successCallback);
})
$(document).on('click', '.remove-installment-fees-paid', function (e) {
    e.preventDefault();
    let $this = $(this);
    if ($(this).data('id')) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $this.data('id');
                let url = baseUrl + '/fees/paid/remove-installment-fees/' + id;

                function successCallback(response) {
                    showSuccessToast(response.message);
                    $('#table_list').bootstrapTable('refresh');
                    setTimeout(() => {
                        $('#compulsoryModal').modal('hide');
                    }, 500);

                }

                function errorCallback(response) {
                    showErrorToast(response.message);
                }

                ajaxRequest('DELETE', url, null, null, successCallback, errorCallback);
            }
        })
    }
});
