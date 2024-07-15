"use strict";

function errorPlacement(label, element) {
    label.addClass('mt-2 text-danger');
    if (element.is(":radio") || element.is(":checkbox")) {
        label.insertAfter(element.parent().parent().parent());
    }
    else if (element.is(":file")) {
        label.insertAfter(element.siblings('div'));
    }
    else if (element.hasClass('color-picker')) {
        label.insertAfter(element.parent());
    } else {
        label.insertAfter(element);
    }
}

function highlight(element, errorClass) {
    if ($(element).hasClass('color-picker')) {
        $(element).parent().parent().addClass('has-danger')
    } else {
        $(element).parent().addClass('has-danger')
    }

    $(element).addClass('form-control-danger')
}

$(".medium-create-form").validate({
    rules: {
        'name': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".medium-edit-form").validate({
    rules: {
        'username': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".section-create-form").validate({
    rules: {
        'username': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".section-edit-form").validate({
    rules: {
        'username': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".class-create-form").validate({
    rules: {
        'name': "required",
        'medium_id': "required",
        'section_id[]': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});
$(".id-card-setting").validate({
    rules: {
        // 'country' : 'required',
        'header_color' : 'required',
        'footer_color' : 'required',
        'header_text_color' : 'required',
        'layout_type' : 'required',
        'profile_image_style' : 'required',
        'card_width' : 'required',
        'card_height' : 'required',
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});
$(".class-edit-form").validate({
    rules: {
        'name': "required",
        'medium_id': "required",
        'section_id[]': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".subject-create-form").validate({
    rules: {
        'medium_id': "required",
        'name': "required",
        'bg_color': "required",
        image: {
            required: true,
            extension: "png|jpg|jpeg|svg"
        },
        'type': "required",
    },
    success: function(label, element) {
        if ($(element).attr("name") == "bg_color"){
            $(element).parent().parent().removeClass('has-danger')
        }else{
            $(element).parent().removeClass('has-danger')
            $(element).removeClass('form-control-danger')
        }
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});
$(".assign-class-subject-form").validate({
    rules: {
        'class_id': "required",
        'core_subject_id[0]': "required",
        // 'elective_subject_id[0][0]': "required",
        'total_selectable_subjects[]': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$("#formdata").validate({
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    },
});
$("#editdata").validate({
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    },
});

$(".assign-class-teacher-form").validate({
    rules: {
        'class_section_id': "required",
        'teacher_id': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".edit-class-teacher-form").validate({
    rules: {
        'class_section_id': "required",
        'teacher_id': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".student-registration-form").validate({
    rules: {
        'first_name': "required",
        'last_name': "required",
        'mobile': "number",
        // 'image': "required",
        'dob': "required",
        'class_section_id': "required",
        'category_id': "required",
        'admission_no': "required",
        'roll_number': "required",
        // 'caste': "required",
        // 'religion': "required",
        'admission_date': "required",
        'blood_group': "required",
        'height': "required",
        'weight': "required",
        'current_address': "required",
        'permanent_address': "required",
        'father_first_name': "required",
        'father_last_name': "required",
        'father_email': {
            "email": true,
            "required": true,
        },
        'father_mobile': {
            "number": true,
            "required": true,
        },
        'father_occupation': "required",
        'father_dob': "required",

        'mother_email': {
            "required": true,
            "email": true,
        },
        'mother_first_name': "required",
        'mother_last_name': "required",
        'mother_mobile': {
            "number": true,
            "required": true,
        },
        'mother_occupation': "required",
        'mother_dob': "required",

        'guardian_email': {
            "required": true,
            "email": true,
        },
        'guardian_first_name': "required",
        'guardian_last_name': "required",
        'guardian_mobile': {
            "number": true,
            "required": true,
        },
        'guardian_occupation': "required",
        'guardian_dob': "required",

    },
    success: function(label, element) {
        // add the success class to the input field
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".edit-student-registration-form").validate({
    rules: {
        'first_name': "required",
        'last_name': "required",
        'dob': "required",
        'class_section_id': "required",
        'category_id': "required",
        'admission_no': "required",
        'roll_number': "required",
        // 'caste': "required",
        // 'religion': "required",
        'admission_date': "required",
        // 'blood_group': "required",
        // 'height': "required",
        // 'weight': "required",
        // 'address': "required",

        'father_email': "required",
        'father_first_name': "required",
        'father_last_name': "required",
        'father_mobile': {
            "number": true,
            "required": true,
        },
        'father_occupation': "required",
        'father_dob': "required",
        // 'father_image': "required",

        'mother_email': "required",
        'mother_first_name': "required",
        'mother_last_name': "required",
        'mother_mobile': {
            "number": true,
            "required": true,
        },
        'mother_occupation': "required",
        'mother_dob': "required",
        // 'mother_image': "required",

        'guardian_email': "required",
        'guardian_first_name': "required",
        'guardian_last_name': "required",
        'guardian_mobile': {
            "number": true,
            "required": true,
        },
        'guardian_occupation': "required",
        'guardian_dob': "required",
        // 'guardian_image': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".add-lesson-form").validate({
    rules: {
        'class_section_id': "required",
        'subject_id': "required",
        'name': "required",
        'description': "required",
        'file[0][name]': "required",
        'file[0][thumbnail]': "required",
        'file[0][file]': "required",
        'file[0][link]': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

//Added this Event here because this form has dynamic input fields.
// $('.add-lesson-form').on('submit', function () {
//     var file = $('[name^="file"]');
//     file.filter('input').each(function (key, data) {
//         $(this).rules("add", {
//             required: true,
//         });
//     });
//     file.filter('input[name$="[name]"]').each(function (key, data) {
//         $(this).rules("add", {
//             required: true,
//         });
//     });
// })

$(".edit-lesson-form").validate({
    rules: {
        'class_section_id': "required",
        'subject_id': "required",
        'name': "required",
        'description': "required",
        'edit_file[0][name]': "required",
        'edit_file[0][link]': "required",
        'file[0][name]': "required",
        'file[0][thumbnail]': "required",
        'file[0][file]': "required",
        'file[0][link]': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".add-topic-form").validate({
    rules: {
        'class_section_id': "required",
        'subject_id': "required",
        'lesson_id': "required",
        'name': "required",
        'description': "required",
        'file[0][name]': "required",
        'file[0][thumbnail]': "required",
        'file[0][file]': "required",
        'file[0][link]': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".edit-topic-form").validate({
    rules: {
        'class_section_id': "required",
        'subect_id': "required",
        'name': "required",
        'description': "required",
        'edit_file[0][name]': "required",
        'edit_file[0][link]': "required",
        'file[0][name]': "required",
        'file[0][thumbnail]': "required",
        'file[0][file]': "required",
        'file[0][link]': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".add-exam-form").validate({
    rules: {
        'class_id': "required",
        'name': "required",
        'timetable[0][subject_id]': "required",
        'timetable[0][total_marks]': "required",
        'timetable[0][passing_marks]': "required",
        'timetable[0][start_time]': "required",
        'timetable[0][end_time]': "required",
        'timetable[0][date]': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".add-assignment-form").validate({
    rules: {
        'class_section_id': "required",
        'subject_id': "required",
        'name': "required",
        'due_date': "required",
        'extra_days_for_resubmission': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

$(".edit-assignment-form").validate({
    rules: {
        'class_section_id': "required",
        'subject_id': "required",
        'name': "required",
        'due_date': "required",
        'extra_days_for_resubmission': "required",
    },
    success: function(label, element) {
        $(element).parent().removeClass('has-danger')
        $(element).removeClass('form-control-danger')
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});

//End Time Custom Validation
$.validator.addMethod("timeGreaterThan", function (value, element, params) {
    let startTime = $(params).val();
    let endTime = $(element).val();
    return endTime > startTime;
}, "End time should be greater than Start time.");

$(".subject-edit-form").validate({
    rules: {
        'medium_id': "required",
        'name': "required",
        'bg_color': "required",
        image: {
            extension: "png|jpg|jpeg|svg",
        },
        'type': "required",
    },
    success: function(label, element) {
        if ($(element).attr("name") == "bg_color"){
            $(element).parent().parent().removeClass('has-danger')
        }else{
            $(element).parent().removeClass('has-danger')
            $(element).removeClass('form-control-danger')
        }
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});
$('.form-validation').validate({
    success: function(label, element) {
        if ($(element).attr("name") == "bg_color"){
            $(element).parent().parent().removeClass('has-danger')
        }else{
            $(element).parent().removeClass('has-danger')
            $(element).removeClass('form-control-danger')
        }
    },
    errorPlacement: function (label, element) {
        errorPlacement(label, element);
    },
    highlight: function (element, errorClass) {
        highlight(element, errorClass);
    }
});
