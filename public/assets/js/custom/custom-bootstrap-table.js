"use strict";
//Bootstrap actionEvents
window.lessonEvents = {
    'click .edit-data': function (e, value, row, index) {
        //Reset Values
        $('.edit-extra-files').html('')
        $('.edit_file_type_div').show();
        $('#edit_id').val(row.id);
        $('#edit_class_section_id').val(row.class_section_id).trigger('change');
        console.log(row);
        setTimeout(() => {
            $('#edit_trimester_id').val(row.trimester_id).trigger('change');

            $('#edit_subject_id').val(row.subject_id).trigger('change');
        }, 1000);



        $('#edit_name').val(row.name);
        $('#edit_description').val(row.description);
        if (row.file.length > 0) {
            $.each(row.file, function (key, data) {
                let html = '';
                if (key == 0) {
                    html = $('.edit_file_type_div');
                } else {
                    html = $('.edit_file_type_div:last').clone().show();
                    $('.edit-extra-files').append(html);
                }
                html.removeAttr('id');
                html.find('.error').remove();
                html.find('.has-danger').removeClass('has-danger');
                // This function will replace the last index value and increment in the multidimensional name attribute
                html.find(':input').each(function (key, element) {
                    this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
                        return '[' + (parseInt(p1, 10) + 1) + ']';
                    });
                })

                html.find('.edit-lesson-file i').addClass('fa-times').removeClass('fa-plus');
                html.find('.edit-lesson-file').addClass('btn-inverse-danger remove-lesson-file').removeClass('btn-inverse-success edit-lesson-file').attr('data-id', data.id);

                html.find('#edit_file_id').val(data.id);

                //1 = File Upload , 2 = Youtube Link , 3 = Uploaded Video , 4 = Other Link
                if (data.type == 1) {
                    // 1 = File Ulopad
                    html.find('#edit_file_type').val('file_upload').trigger('change');
                    html.find('#file_preview').attr('href', data.file_url).text(data.file_name);
                    //Used class name as a selector instead of id because of jquery dynamic field validation.
                    html.find('.file_name').val(data.file_name);
                } else if (data.type == 2) {
                    // 2 = Youtube Link
                    html.find('#edit_file_type').val('youtube_link').trigger('change');
                    html.find('#file_thumbnail_preview').attr('src', data.file_thumbnail);
                    html.find('.file_link').val(data.file_url);

                    html.find('.file_name').val(data.file_name);
                } else if (data.type == 3) {
                    // 3 = Uploaded Video
                    html.find('#edit_file_type').val('video_upload').trigger('change');
                    html.find('#file_thumbnail_preview').attr('src', data.file_thumbnail);
                    html.find('#file_preview').attr('src', data.file_url).text(data.file_name);

                    html.find('.file_name').val(data.file_name);
                } else if (data.type == 4) {
                    // 4 = Other Link
                    html.find('#edit_file_type').val('other_link').trigger('change');
                    html.find('#file_thumbnail_preview').attr('src', data.file_thumbnail);

                    html.find('.file_name').val(data.file_name);
                    html.find('.file_link').val(data.file_url);
                }
            })
        } else {
            $('.edit_file_type_div').hide();
        }
    }
};


window.topicEvents = {
    'click .edit-data': function (e, value, row, index) {
        //Reset Values
        $('.edit-extra-files').html('')
        $('.edit_file_type_div').show();
        $('#edit_id').val(row.id);
        $('#edit_topic_class_section_id').val(row.class_section_id).trigger('change');
        setTimeout(() => {
            $('#edit_topic_subject_id').val(row.subject_id).trigger('change');
            $('#edit_topic_lesson_id').val(row.lesson_id);
        }, 1000);
        $('#edit_name').val(row.name);
        $('#edit_description').val(row.description);

        if (row.file.length > 0) {
            $.each(row.file, function (key, data) {
                let html = '';
                if (key == 0) {
                    html = $('.edit_file_type_div');
                } else {
                    html = $('.edit_file_type_div:last').clone().show();
                    $('.edit-extra-files').append(html);
                }
                html.removeAttr('id');
                html.find('.error').remove();
                html.find('.has-danger').removeClass('has-danger');
                // This function will replace the last index value and increment in the multidimensional name attribute
                html.find(':input').each(function (key, element) {
                    this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
                        return '[' + (parseInt(p1, 10) + 1) + ']';
                    });
                })

                html.find('.edit-lesson-file i').addClass('fa-times').removeClass('fa-plus');
                html.find('.edit-lesson-file').addClass('btn-inverse-danger remove-lesson-file').removeClass('btn-inverse-success edit-lesson-file').attr('data-id', data.id);

                html.find('#edit_file_id').val(data.id);

                //1 = File Upload , 2 = Youtube Link , 3 = Uploaded Video , 4 = Other Link
                if (data.type == 1) {
                    // 1 = File Ulopad
                    html.find('#edit_file_type').val('file_upload').trigger('change');
                    html.find('#file_preview').attr('href', data.file_url).text(data.file_name);
                    //Used class name as a selector instead of id because of jquery dynamic field validation.
                    html.find('.file_name').val(data.file_name);
                } else if (data.type == 2) {
                    // 2 = Youtube Link
                    html.find('#edit_file_type').val('youtube_link').trigger('change');
                    html.find('#file_thumbnail_preview').attr('src', data.file_thumbnail);
                    html.find('.file_link').val(data.file_url);

                    html.find('.file_name').val(data.file_name);
                } else if (data.type == 3) {
                    // 3 = Uploaded Video
                    html.find('#edit_file_type').val('video_upload').trigger('change');
                    html.find('#file_thumbnail_preview').attr('src', data.file_thumbnail);
                    html.find('#file_preview').attr('src', data.file_url).text(data.file_name);

                    html.find('.file_name').val(data.file_name);
                } else if (data.type == 4) {
                    // 4 = Other Link
                    html.find('#edit_file_type').val('other_link').trigger('change');
                    html.find('#file_thumbnail_preview').attr('src', data.file_thumbnail);

                    html.find('.file_name').val(data.file_name);
                    html.find('.file_link').val(data.file_url);
                }
            })
        } else {
            $('.edit_file_type_div').hide();
        }
    }
};

window.examEvents = {
    'click .publish-exam-result': function (e, value, row, index) {
        e.preventDefault();
        // alert('working');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm!'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = baseUrl + '/exams/publish/' + row.id;

                function successCallback(response) {
                    showSuccessToast(response.message);
                    $('#table_list').bootstrapTable('refresh');
                }
                function errorCallback(response) {
                    showErrorToast(response.message);
                }

                ajaxRequest('POST', url, null, null, successCallback, errorCallback);
            }
        })
    },
    'click .edit-data': function (e, value, row, index) {
        //Reset to Old Values
        $('.edit-extra-timetable').html('');
        $('.edit_exam_timetable').show();
        $('#edit_id').val(row.id);
        $('.edit_class_id').val(row.class_id);
        $('#edit_name').val(row.name);
        $('#edit_description').val(row.description);
    }
};

window.assignmentEvents = {
    'click .edit-data': function (e, value, row, index) {
        //Reset to Old Values
        var html_file = '';
        $('#edit_id').val(row.id);
        $('#edit_class_section_id').val(row.class_section_id);
        $('#edit_subject_id').val(row.subject_id);
        $('#edit_name').val(row.name);
        $('#edit_instructions').val(row.instructions);

        var dt = new Date(row.due_date);
        var Fromdatetime = dt.getFullYear() + "-" + ("0" + (dt.getMonth() + 1)).slice(-2) + "-" + ("0" + dt.getDate()).slice(-2) + "T" + ("0" + dt.getHours()).slice(-2) + ":" + ("0" + dt.getMinutes()).slice(-2) + ":" + ("0" + dt.getSeconds()).slice(-2);
        $('#edit_due_date').val(Fromdatetime);
        $('#edit_points').val(row.points);
        if (row.resubmission) {
            $('#edit_resubmission_allowed').prop('checked', true).trigger('change');
            $('#edit_extra_days_for_resubmission').val(row.extra_days_for_resubmission);
        } else {
            $('#edit_resubmission_allowed').prop('checked', false).trigger('change');
            $('#edit_extra_days_for_resubmission').val('');
        }

        if (row.file) {
            $.each(row.file, function (key, data) {
                html_file += '<div class="file"><a target="_blank" href="' + data.file_url + '" class="m-1">' + data.file_name + '</a> <span class="fa fa-times text-danger remove-assignment-file" data-id=' + data.id + '></span><br><br></div>'
            })

            $('#old_files').html(html_file);
        }
    }
};

window.announcementEvents = {
    'click .editdata': function (e, value, row, index) {
        var html_file = '';
        $('#id').val(row.id);
        $('#title').val(row.title);
        $('#description').val(row.description);
        if (row.assign == "Subject") {
            $('#edit_set_data').val('class_section').trigger('change', [row.get_data]);
            $('#edit_class_section_id').val(row.assign_to['class_section_id']).trigger('change', [row.assign_to['subject_id']]);
            // $('#edit_get_data').val(row.assign_to['subject_id']);
        } else {
            $('#edit_set_data').val(row.assign).trigger('change', [row.get_data])
        }
        if (row.file) {
            $.each(row.file, function (key, data) {
                html_file += '<div class="file"><a target="_blank" href="' + data.file_url + '" class="m-1">' + data.file_name + '</a> <span class="fa fa-times text-danger remove-assignment-file" data-id=' + data.id + '></span><br><br></div>'
            })

            $('#old_files').html(html_file);
        }
    }
};
window.classSubjectEvents = {
    'click .edit-data': function (e, value, row, index) {
        // Hide Medium wise Subjects
        $('.core-subject-id').find('option').hide();
        $('.core-subject-id').find('option[data-medium-id="' + row.medium_id + '"]').show();

        $('.elective-subject-name').find('option').hide();
        $('.elective-subject-name').find('option[data-medium-id="' + row.medium_id + '"]').show();

        $('.edit-core-subject-id').find('option').hide();
        $('.edit-core-subject-id').find('option[data-medium-id="' + row.medium_id + '"]').show();

        $('.edit-elective-subject-name').find('option').hide();
        $('.edit-elective-subject-name').find('option[data-medium-id="' + row.medium_id + '"]').show();

        //Reset to Old Values
        $('.edit-extra-core-subjects').html("");
        $('#edit-extra-elective-subject-group').html("");

        $('#edit_id').val(row.id);
        $('#edit_class_id').val(row.id);
        //Change the Name array attribute for jquery validation
        // and remove the error label from the main html so that duplicate error will not be shown
        $.each(row.core_subjects, function (key, value) {
            let core_subject = cloneOldCoreSubjectTemplate();
            //Fill the Values
            core_subject.find('.remove-core-subject').attr('data-id', value.id);
            core_subject.find('.edit-class-subject-id').val(value.id);
            core_subject.find('select').find("option[value = '" + value.subject_id + "']").attr("selected", "selected");
            $('.edit-extra-core-subjects').append(core_subject);
        })

        if (row.elective_subject_groups.length > 0) {
            //First loop will be used for Subject Group
            $.each(row.elective_subject_groups, function (key, group) {
                let subjectGroup = cloneOldElectiveSubjectGroup();
                $('#edit-extra-elective-subject-group').append(subjectGroup);
                //Fill the values in cloned element
                subjectGroup.find('.edit-total-selectable-subject').val(group.total_selectable_subjects);
                subjectGroup.find('.remove-elective-subject-group').attr('data-id', group.id);

                //Second loop will be used for Subjects inside Groups
                subjectGroup.find('.edit-elective-subject-group-id').val(group.id);
                $.each(group.elective_subjects, function (key, elective_subject) {
                    if (key === 0) {
                        subjectGroup.find('.edit-elective-subject-name:first').val(elective_subject.subject.id)
                        subjectGroup.find('.edit-elective-subject-name:first').siblings('.edit-elective-subject-class-id').val(elective_subject.id)
                    } else if (key === 1) {
                        subjectGroup.find('.edit-elective-subject-name:eq(1)').val(elective_subject.subject.id)
                        subjectGroup.find('.edit-elective-subject-name:eq(1)').siblings('.edit-elective-subject-class-id').val(elective_subject.id)
                    } else {
                        let electiveSubjectButton = subjectGroup.find('.add-new-elective-subject');
                        let electiveSubject = cloneNewElectiveSubject(electiveSubjectButton);
                        electiveSubject.insertBefore(subjectGroup.find('.add-new-elective-subject'));
                        electiveSubject.find('.edit-elective-subject-name').val(elective_subject.subject.id);
                        electiveSubject.find('.edit-elective-subject-name').siblings('.edit-elective-subject-class-id').val(elective_subject.id)
                        electiveSubject.find('.edit-elective-subject-name').siblings('.remove-elective-subject').attr('data-id', elective_subject.id)
                    }
                })

            })
        }
    }
};

window.parentEvents = {
    'click .editdata': function (e, value, row, index) {
        $('#edit_id').val(row.id);
        $('#first_name').val(row.first_name);
        $('#last_name').val(row.last_name);
        $('input[name=gender][value=' + row.gender + '].edit').prop('checked', true);
        $('#email').val(row.email);
        $('#mobile').val(row.mobile);
        $('#occupation').val(row.occupation);
        $('#dob').val(row.dob);
        if (row.current_address) {
            $('#current_address_div').show();
            $('#current_address').val(row.current_address);
        } else {
            $('#current_address_div').hide();
        }
        if (row.permanent_address) {
            $('#permanent_address_div').show();
            $('#permanent_address').val(row.permanent_address);
        } else {
            $('#permanent_address_div').hide();
        }
    }
};

window.studentEvents = {
    'click .editdata': function (e, value, row, index) {
        $('#edit_id').val(row.user_id);
        $('#edit_first_name').val(row.first_name);
        $('#edit_last_name').val(row.last_name);
        $('#edit_mobile').val(row.mobile);
        $('#edit_dob').val(row.dob);
        $('#edit_class_section_id').val(row.class_section_id);
        $('#edit_category_id').val(row.category_id);
        $('#edit_admission_no').val(row.admission_no);
        $('#edit_roll_number').val(row.roll_number);
        $('#edit_caste').val(row.caste);
        $('#edit_religion').val(row.religion);
        $('#edit_admission_date').val(row.admission_date);
        $('#edit_blood_group').val(row.blood_group);
        $('#edit_height').val(row.height);
        $('#edit_weight').val(row.weight);
        $('#edit_current_address').val(row.current_address);
        $('#edit_permanent_address').val(row.permanent_address);
        $('#edit-student-image-tag').attr('src', row.image_link);
        if (row.gender == 'Male') {
            $('#edit_female').removeAttr('checked');
            $('#edit_male').attr('checked', 'true');
        } else {
            $('#edit_male').removeAttr('checked');
            $('#edit_female').attr('checked', 'true');
        }
        //Father Data
        $("#edit_father_email").select2("trigger", "select", {
            data: {
                id: row.father_id ? row.father_id : "",
                text: row.father_email ? row.father_email : "",
            }
        });
        //Adding delay to fill data so that select2 code and this code don't conflict each other
        setTimeout(function () {
            $('#edit_father_first_name').val(row.father_first_name).attr('readonly', true);
            $('#edit_father_last_name').val(row.father_last_name).attr('readonly', true);
            $('#edit_father_mobile').val(row.father_mobile).attr('readonly', true);
            $('#edit_father_dob').val(row.father_dob).attr('readonly', true);
            $('#edit_father_occupation').val(row.father_occupation).attr('readonly', true);
            $('#edit-father-image-tag').attr('src', row.father_image_link);
            $(".edit-father-search").rules("remove", "email");
            $(".father_image").rules("remove", "required");
        }, 500);


        //Mother Data
        $("#edit_mother_email").select2("trigger", "select", {
            data: {
                id: row.mother_id ? row.mother_id : "",
                text: row.mother_email ? row.mother_email : "",
            }
        });
        //Adding delay to fill data so that select2 code and this code don't conflict each other
        setTimeout(function () {
            $('#edit_mother_first_name').val(row.mother_first_name).attr('readonly', true);
            $('#edit_mother_last_name').val(row.mother_last_name).attr('readonly', true);
            $('#edit_mother_mobile').val(row.mother_mobile).attr('readonly', true);
            $('#edit_mother_dob').val(row.mother_dob).attr('readonly', true);
            $('#edit_mother_occupation').val(row.mother_occupation).attr('readonly', true);
            $('#edit-mother-image-tag').attr('src', row.mother_image_link);
            $(".edit-mother-search").rules("remove", "email");
            $(".mother_image").rules("remove", "required");
        }, 500);


        if (row.guardian_id) {
            $('#show-edit-guardian-details').attr('checked', true).trigger('change');
        } else {
            $('#show-edit-guardian-details').attr('checked', false).trigger('change');
        }

        // Guardian Data
        $("#edit_guardian_email").select2("trigger", "select", {
            data: {
                id: row.guardian_id ? row.guardian_id : "",
                text: row.guardian_email ? row.guardian_email : "",
                edit_data: true,
            }
        });

        //Adding delay to fill data so that select2 code and this code don't conflict each other
        setTimeout(function () {
            $('#edit_guardian_first_name').val(row.guardian_first_name).attr('readonly', true);
            $('#edit_guardian_last_name').val(row.guardian_last_name).attr('readonly', true);
            $('#edit_guardian_mobile').val(row.guardian_mobile).attr('readonly', true);
            if (row.guardian_gender == 'Male') {
                $('#edit_guardian_female').removeAttr('checked');
                $('#edit_guardian_male').attr('checked', 'true');
            } else {
                $('#edit_guardian_male').removeAttr('checked');
                $('#edit_guardian_female').attr('checked', 'true');
            }
            $('#edit_guardian_dob').val(row.guardian_dob).attr('readonly', true);
            $('#edit_guardian_occupation').val(row.guardian_occupation).attr('readonly', true);
            $('#edit-guardian-image-tag').attr('src', row.guardian_image_link);
            $(".edit-guardian-search").rules("remove", "email");
            $(".guardian_image").rules("remove", "required");

        }, 500);
    }
};

window.assignmentSubmissionEvents = {
    'click .edit-data': function (e, value, row, index) {
        let file_html = "";
        $('#edit_id').val(row.id);
        $('#assignment_name').val(row.assignment_name);
        $('#subject').val(row.subject);
        $('#student_name').val(row.student_name);

        $.each(row.file, function (key, data) {
            file_html += " <a target='_blank' href='" + data.file_url + "'>" + data.file_name + "</a><br>";
        });

        $('#files').html(file_html);
        if (row.assignment_points) {
            $('#points_div').show();
            $('#assignment_points').text('/ ' + row.assignment_points);
            $('#points').prop('max', row.assignment_points);
            $('#points').val(row.points);
        } else {
            $('#points_div').hide();
            $('#assignment_points').text('');
        }
        $('#feedback').val(row.feedback);
        if (row.status === 1) {
            $('#status_accept').attr('checked', true);
        } else if (row.status === 2) {
            $('#status_reject').attr('checked', true);
        }
    }
};

window.examMarksEvents = {
    'click .edit-data': function (e, value, row, index) {
        $('.student_name').html(row.student_name);
        $('.subject_container').html('');
        var no = 0;
        $.each(row.data, function (key, data) {
            var html_data = '<div class="row"><input type="hidden" id="marks_id form-control" readonly name="edit[' + no + '][marks_id]" value="' + data.id + '"/><div class="row mx-2"><input type="hidden" id="marks_id form-control" readonly name="edit[' + no + '][exam_id]" value="' + data.timetable.exam_id + '"/><div class="row mx-2"><input type="hidden" id="marks_id form-control" readonly name="edit[' + no + '][student_id]" value="' + row.student_id + '"/><div class="row mx-2"><input type="hidden" id="marks_id form-control" readonly name="edit[' + no + '][passing_marks]" value="' + data.timetable.passing_marks + '"/><div class="form-group col-sm-12 col-md-4"><input type="text" class="subject_name form-control" readonly name="edit[' + no + '][subject_name]" value="' + data.subject.name + '" /></div><div class="form-group col-sm-12 col-md-4"><input type="text" class="total_marks form-control" readonly name="edit[' + no + '][total_marks]" value="' + data.timetable.total_marks + '" /></div><div class="form-group col-sm-12 col-md-4"><input type="text" class="obtained_marks form-control" name="edit[' + no + '][obtained_marks]" value="' + data.obtained_marks + '" /></div></div>';
            $('.subject_container').append(html_data);
            no++;
        });
    }
};

window.examTimetableEvents = {
    'click .edit-data': function (e, value, row, index) {
        $('.edit_timetable_exam_id').val(row.exam_id);
        $('.edit_timetable_class_id').val(row.class_id);
        $('.edit_timetable_session_year_id').val(row.session_year_id);

        $('.edit-timetable-container').html('');
        let select_subject_html = "";
        if (row.subjects.length > 0) {
            $.each(row.subjects, function (key, data) {
                select_subject_html += "<option value='" + data.id + "'>" + data.name + ' - ' + data.type + "</option>";
            });
        } else {
            select_subject_html = "<option value=''>No Data Found</option>";
        }
        $('.edit_exam_subjects_options').html(select_subject_html);
        if (row.timetable.length != 0) {
            $.each(row.timetable, function (key, value) {
                let html = '';
                if (!$('.edit-timetable-container:last').is(':empty')) {
                    html = $('.edit-timetable-container').find('.edit_exam_timetable:last').clone();
                } else {
                    html = $('.edit_exam_timetable_tamplate').clone();
                }
                html.addClass('edit_exam_timetable').removeClass('edit_exam_timetable_tamplate');
                html.css('display', 'block');
                html.find('.error').remove();
                html.find('.has-danger').removeClass('has-danger');
                // This function will replace the last index value and increment in the multidimensional name attribute
                html.find('.form-control').each(function (key, element) {
                    this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
                        return '[' + (parseInt(p1, 10) + 1) + ']';
                    });
                })

                html.find('.remove-edit-exam-timetable-content').attr("data-timetable_id", value.id);

                html.find('.edit_timetable_id').val(value.id);

                html.find('.edit_timetable_exam_id').val(value.exam_id);

                html.find('.edit_timetable_class_id').val(value.class_id);

                html.find('.edit_exam_subjects_options').val(value.subject_id)

                html.find('.edit_total_marks').val(value.total_marks);

                html.find('.edit_passing_marks').val(value.passing_marks);

                html.find('.edit_start_time').val(value.start_time);

                html.find('.edit_end_time').val(value.end_time);

                var date = new Date(value.date),
                    yr = date.getFullYear(),
                    month = date.getMonth() < 9 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1,
                    day = date.getDate() < 9 ? '0' + date.getDate() : date.getDate(),
                    newDate = day + '-' + month + '-' + yr;

                html.find('.edit_date').val(newDate);
                $('.edit-timetable-container').append(html);
            });
            $(document).on('click', '.remove-edit-exam-timetable-content', function (e) {
                e.preventDefault();

                let $this = $(this);
                // If button has Data ID then Call ajax function to delete file
                let timetable_id = $(this).data('timetable_id');

                if (timetable_id) {
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
                                $this.parent().parent().parent().remove();
                                $('#editModal').modal('hide');
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
                    $(this).parent().parent().parent().remove();
                }

            });
        }
    }
}
window.FeesTypeActionEvents = {
    'click .edit-data': function (e, value, row, index) {
        $('#edit_id').val(row.id);
        $('#edit_name').val(row.name);
        $('#edit_description').val(row.description);
        if (row.choiceable) {
            $('#edit_choiceable_true').val(row.choiceable).attr('checked', true);
            $('#edit_choiceable_false').attr('checked', false)
        } else {
            $('#edit_choiceable_false').val(row.choiceable).attr('checked', true);
            $('#edit_choiceable_true').removeAttr('checked', false)
        }
    }
};
window.feesClassEvents = {
    'click .edit-data': function (e, value, row, index) {
        console.log("HHH");
        $('#edit_class_id').val(row.class_id);
        $('#class_id').val(row.class_id);
        $('#base_amount_edit').val(parseFloat(row.base_amount))
        $('#feesClass_id').val(row.feesClass)

        // if (row.fees_type.length) {
        //     $('.edit-extra-fees-types').html('');
        //     $.each(row.fees_type, function (key, value) {
        //         let fees_type = $('.edit-fees-type-div:last').clone().show();
        //         // Remove the error label from the main html so that duplicate error will not be show
        //         fees_type.find('select').siblings('.error').remove();

        //         //Change the Name array attribute for jquery validation
        //         //Add incremental name value
        //         fees_type.find('.form-control').each(function (key, element) {
        //             this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
        //                 return '[' + (parseInt(p1, 10) + 1) + ']';
        //             });
        //             this.id = this.id.replace(/\_(\d+)/, function (str, p1) {
        //                 return '_' + (parseInt(p1, 10) + 1);
        //             });
        //             $(element).attr('disabled', false);
        //         })
        //         //Fill the Values
        //         fees_type.find('.remove-fees-type').attr('data-id', value.id);
        //         fees_type.find('.edit-fees-type-id').val(value.id);
        //         fees_type.find('select').find("option[value = '" + value.fees_type_id + "']").attr("selected", "selected");
        //         fees_type.find('.edit_amount').val(value.amount);
        //         if(value.choiceable){
        //             fees_type.find('#editChoiceableNo_'+(key+1)).removeAttr("checked");
        //             fees_type.find('#editChoiceableYes_'+(key+1)).attr("checked",true);
        //         }else{
        //             fees_type.find('#editChoiceableYes_'+(key+1)).removeAttr("checked");
        //             fees_type.find('#editChoiceableNo_'+(key+1)).attr("checked",true);
        //         }
        //         fees_type.find('.edit_choiceable').val(value.choiceable).attr('checked',true);
        //         $('.edit-extra-fees-types').append(fees_type);
        //     })
        // } else {
        //     $('.edit-extra-fees-types').html('');
        // }


    }
};
window.feesPaidEvents = {
    'click .compulsory-data': function (e, value, row, index) {

        $(document).find('.cheque_no').val(null)
        $('.cheque_compulsory_mode').attr('checked',false);
        $('.cash_compulsory_mode').attr('checked',true).change();

        $('#student_id').val(row.student_id);
        $('#class_id').val(row.class_id);

        $('.student_name').html(row.student_name + ' - ' + row.class_name);
        $('.paid_date').val(row.current_date);

        if((row.mode == 1) && (row.type_of_fee == 0 || row.type_of_fee == 1 || row.type_of_fee == null)){
            $(document).find('.mode_container').show(200);
            $('.cash_compulsory_mode').attr('checked',false)
            $('.cheque_compulsory_mode').attr('checked',true).change();
            $(document).find('.cheque_no').val(row.cheque_no)
        }else if(row.mode == 0 && (row.type_of_fee == 0 || row.type_of_fee == 1 || row.type_of_fee == null)){
            $(document).find('.mode_container').show(200);
            $(document).find('.cheque_no').val(null)
            $('.cheque_compulsory_mode').attr('checked',false);
            $('.cash_compulsory_mode').attr('checked',true).change();
        }else if (row.mode == null){
            $(document).find('.mode_container').show(200);
            $(document).find('.cheque_no').val(null)
            $('.cheque_compulsory_mode').attr('checked',false);
            $('.cash_compulsory_mode').attr('checked',true).change();
        }else{
            $(document).find('.mode_container').hide(200);
        }
        if (row.compulsory_fees != null) {
            $('.compulsory_div').show();
            let html = '';
            let base_amount = 0;

            // Adding the data of compulsory fees with installment data
            html = '<table class="table"><tbody>'
            $.each(row.compulsory_fees, function (index, value) {
                html += '<tr><td scope="row" class="text-left"></td><td colspan="2" class="text-left">'+value.fees_type.name+'</td><td class="text-right">'+(value.amount).toFixed(2)+'</td></tr>'
            });

            //Due Charges For Whole Session Year
            if(row.due_charges.charges){
                html += '<tr class="due_charges_whole_year"><td scope="row" class="text-left"></td><td colspan="2" class="text-left">'+lang_due_charges+'<br><small>'+lang_date+' :- ('+row.due_charges.date+')</small></td><td class="text-right">'+row.due_charges.charges ?? (row.due_charges.charges).toFixed(2)+'</td></tr>'
            }

            // Pay In Installment Tick
            if(row.due_charges){
                html += '<tr class="pay_in_installment_row"><td scope="row" class="text-left"></td><td colspan="2" class="text-left">'+lang_pay_in_installment+'</td><td class="text-right"><input type="checkbox" name="pay_in_installment" class="form-check-input pay_in_installment" value="" data-base_amount="'+row.base_amount_with_due_charges+'"></td></tr>'
            }else{
                html += '<tr class="pay_in_installment_row"><td scope="row" class="text-left"></td><td colspan="2" class="text-left">'+lang_pay_in_installment+'</td><td class="text-right"><input type="checkbox" name="pay_in_installment" class="form-check-input pay_in_installment" value="" data-base_amount="'+row.base_amount+'"></td></tr>'
            }

            // Get the total Count of Installment is paid
            let paid_installment_count = -1;
            if(row.installment_data.length){
                $.each(row.installment_data, function (index, installment_data) {
                    if(installment_data.paid){
                        paid_installment_count++;
                    }
                });
            }

            // show the installment data
            if(row.installment_data.length){
                // get installment amount
                let installment_amount = (Number(row.base_amount) / Number(row.installment_data.length)).toFixed(2);
                $.each(row.installment_data, function (index, installment_data) {
                    // if due charges applicable then show the data accordingly
                    if(installment_data.due_charges_applicable){
                        let due_charges = (installment_amount * Number(installment_data.due_charges) / 100).toFixed(2)
                        let total_installment_amount = (Number(installment_amount) + Number(due_charges)).toFixed(2);

                        // if the data is last
                        if(row.installment_data.length == (index + 1 )){
                            // if the data is paid
                            if(installment_data.paid){
                                //if the count of paid installment equals to index of loop
                                if(paid_installment_count == index){
                                    // then show the cross sign
                                    html += '<tr class="installment_rows"><td scope="row" class="text-left"><span class="remove-installment-fees-paid text-left" data-id="'+installment_data.paid_id+'"><i class="fa fa-times text-danger" style="cursor:pointer" aria-hidden="true"></i></span></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-success">'+lang_paid_on+': '+installment_data.paid_on+'</small></td><td class="text-right"><lable>'+total_installment_amount+'</lable></td></tr>'
                                }else{
                                    html += '<tr class="installment_rows"><td scope="row" class="text-left"></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-success">'+lang_paid_on+': '+installment_data.paid_on+'</small></td><td class="text-right"><lable>'+total_installment_amount+'</lable></td></tr>'
                                }
                            }else{
                                // show the check box
                                html += '<tr class="installment_rows"><td scope="row" class="text-left"><input type="checkbox" name="installment_fees['+index+'][id]" class="installment-chkclass" value="' + installment_data.id + '" data-amount="' + total_installment_amount + '"></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-danger">'+lang_due_date_on+': '+installment_data.due_date+',<br>'+lang_charges+': '+installment_data.due_charges+' %</small></td><td class="text-right"><lable>'+installment_amount+'<br><small>'+due_charges+'</small><br><hr>'+total_installment_amount+'</lable><input type="hidden" name="installment_fees['+index+'][amount]" value="'+total_installment_amount+'"><input type="hidden" name="installment_fees['+index+'][fully_paid]" value="1"><input type="hidden" name="installment_fees['+index+'][due_charges]" value="'+due_charges+'"></td></tr>'
                            }
                        }else{
                            // if the installment is paid
                            if(installment_data.paid){
                                //if the count of paid installment equals to index of loop
                                if(paid_installment_count == index){
                                    // then show the cross sign
                                    html += '<tr class="installment_rows"><td scope="row" class="text-left"><span class="remove-installment-fees-paid text-left" data-id="'+installment_data.paid_id+'"><i class="fa fa-times text-danger" style="cursor:pointer" aria-hidden="true"></i></span></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-success">'+lang_paid_on+': '+installment_data.paid_on+'</small></td><td class="text-right"><lable>'+total_installment_amount+'</lable></td></tr>'
                                }else{
                                    html += '<tr class="installment_rows"><td scope="row" class="text-left"></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-success">'+lang_paid_on+': '+installment_data.paid_on+'</small></td><td class="text-right"><lable>'+total_installment_amount+'</lable></td></tr>'
                                }
                            }else{
                                // show the check box
                                html += '<tr class="installment_rows"><td scope="row" class="text-left"><input type="checkbox" name="installment_fees['+index+'][id]" class="installment-chkclass" value="' + installment_data.id + '" data-amount="' + total_installment_amount + '"></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-danger">'+lang_due_date_on+': '+installment_data.due_date+',<br>'+lang_charges+': '+installment_data.due_charges+' %</small></td><td class="text-right"><lable>'+installment_amount+'<br><small>'+due_charges+'</small><br><hr>'+total_installment_amount+'</lable><input type="hidden" name="installment_fees['+index+'][amount]" value="'+total_installment_amount+'"><input type="hidden" name="installment_fees['+index+'][fully_paid]" value="0"><input type="hidden" name="installment_fees['+index+'][due_charges]" value="'+due_charges+'"></td></tr>'
                            }
                        }
                    }else{
                        // if the due charges is not applicable to installment
                        // if the data is last
                        if(row.installment_data.length == (index + 1 )){
                            if(installment_data.paid){
                                if(paid_installment_count == index){
                                    html += '<tr class="installment_rows"><td scope="row" class="text-left"><span class="remove-installment-fees-paid text-left" data-id="'+installment_data.paid_id+'"><i class="fa fa-times text-danger" style="cursor:pointer" aria-hidden="true"></i></span></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-success">'+lang_paid_on+': '+installment_data.paid_on+'</small></td><td class="text-right"><lable>'+installment_amount+'</lable></td></tr>'
                                }else{
                                    html += '<tr class="installment_rows"><td scope="row" class="text-left"></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-success">'+lang_paid_on+': '+installment_data.paid_on+'</small></td><td class="text-right"><lable>'+installment_amount+'</lable></td></tr>'
                                }
                            }else{
                                html += '<tr class="installment_rows"><td scope="row" class="text-left"><input type="checkbox" name="installment_fees['+index+'][id]" class="installment-chkclass" value="' + installment_data.id + '" data-amount="' + installment_amount + '" ></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small>'+lang_due_date_on+': '+installment_data.due_date+',</small><br><small>'+lang_charges+': '+installment_data.due_charges+' %</small></td><td class="text-right"><lable>'+installment_amount+'</lable><input type="hidden" name="installment_fees['+index+'][amount]" value="'+installment_amount+'"><input type="hidden" name="installment_fees['+index+'][fully_paid]" value="1"></td></tr>'
                            }
                        }else{
                            if(installment_data.paid){
                                if(paid_installment_count == index){
                                    html += '<tr class="installment_rows"><td scope="row" class="text-left"><span class="remove-installment-fees-paid text-left" data-id="'+installment_data.paid_id+'"><i class="fa fa-times text-danger" style="cursor:pointer" aria-hidden="true"></i></span></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-success">'+lang_paid_on+': '+installment_data.paid_on+'</small></td><td class="text-right"><lable>'+installment_amount+'</lable></td></tr>'
                                }else{
                                    html += '<tr class="installment_rows"><td scope="row" class="text-left"></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small class="text-success">'+lang_paid_on+': '+installment_data.paid_on+'</small></td><td class="text-right"><lable>'+installment_amount+'</lable></td></tr>'
                                }
                            }else{
                                html += '<tr class="installment_rows"><td scope="row" class="text-left"><input type="checkbox" name="installment_fees['+index+'][id]" class="installment-chkclass" value="' + installment_data.id + '" data-amount="' + installment_amount + '" ></td><td colspan="2" class="text-left"><lable>'+installment_data.name+'<lable><br><small>'+lang_due_date_on+': '+installment_data.due_date+',</small><br><small>'+lang_charges+': '+installment_data.due_charges+' %</small></td><td class="text-right"><lable>'+installment_amount+'</lable><input type="hidden" name="installment_fees['+index+'][amount]" value="'+installment_amount+'"><input type="hidden" name="installment_fees['+index+'][fully_paid]" value="0"></td></tr>'
                            }
                        }
                    }
                });
            }
            html += '<tr><td scope="row" class="text-left"></td><td colspan="2" class="text-left"></td><td class="text-right"><hr></td></tr>';

            // Add Total Amount Section
            if(row.due_charges.charges){
                html += '<tr><td scope="row" class="text-left"></td><td colspan="2" class="text-left">'+lang_total_amount+' </td><td class="text-right compulsory_amount">'+(row.base_amount_with_due_charges).toFixed(2)+'</td></tr>';
            }else{
                html += '<tr><td scope="row" class="text-left"></td><td colspan="2" class="text-left">'+lang_total_amount+' </td><td class="text-right compulsory_amount">'+(row.base_amount).toFixed(2)+'</td></tr>';
            }
            html += '</tbody></table>';


            if(row.due_charges){
                $('#total_amount').val(row.base_amount_with_due_charges);
            }else{
                $('#total_amount').val(row.base_amount);
            }
            $('.compulsory_fees_content').html(html);
            $('.installment_rows').hide();

            // make Installment Payment Enabled disabled
            if(row.is_installment_paid){
                $(document).find('.pay_in_installment').click();
                $(document).find('.pay_in_installment').attr('disabled',true);
            }else if(row.fees_status == 1){
                $(document).find('.pay_in_installment_row').hide(200);
                $(document).find('.pay_in_installment').attr('disabled',true);
            }else{
                $(document).find('.pay_in_installment').attr('disabled',false);
            }

            if(row.fees_staus == 0){
                if(row.mode == 2){
                    $(document).find('.compulsory_fees_payment').prop('disabled', true);
                }else{
                    $(document).find('.compulsory_fees_payment').prop('disabled', false);
                }
            }else{
                $(document).find('.compulsory_fees_payment').prop('disabled', true);
            }


            $('.installment-chkclass').on('click', function (e) {
                let choice_amount = parseFloat($('.compulsory_amount').html());
                if ($(this).is(':checked')) {
                    $(document).find('.mode_container').show(200);
                    $(this).addClass('added_price');
                    $(this).removeClass('installment-chkclass');
                    choice_amount += parseFloat($(this).data("amount"));
                    $('.compulsory_amount').html((choice_amount).toFixed(2));
                    $('.total_amount').val((choice_amount).toFixed(2));
                } else {
                    $(document).find('.mode_container').hide(200);
                    $(this).removeClass('added_price');
                    $(this).addClass('installment-chkclass');
                    choice_amount -= parseFloat($(this).data("amount"));
                    $('.compulsory_amount').html((choice_amount).toFixed(2));
                    $('.total_amount').val((choice_amount).toFixed(2));
                }

                // Check the Amount And Make PAY Button Clickable Or Not
                    if(choice_amount > 1){
                        $(document).find('.compulsory_fees_payment').prop('disabled', false);
                    }else{
                        $(document).find('.compulsory_fees_payment').prop('disabled', true);
                    }

                $('#total_amount').val(choice_amount);
            });
        } else {
            $('.compulsory_div').hide();
        }
    },
    'click .optional-data': function (e, value, row, index) {
        // Disable PAY Button
        // $(document).find('.optional_fees_payment').prop('disabled', true);

        // Add data in Modal
        // console.log(row.class_id);
        $('#optional_student_id').val(row.student_id);
        $('#optional_class_id').val(row.class_id);
        $('.student_name').html(row.student_name + ' - ' + row.class_name);
        $('.current-date').val(row.current_date);


        if (Array.isArray(row.fees_paid) && row.fees_paid.length > 0) {
            $('input[name="months[]"]').each(function () {
                const monthValue = $(this).val();
                console.log(monthValue);
                console.log( row.fees_paid);
                console.log(  row.fees_paid.includes(monthValue));
                $(this).prop('checked', row.fees_paid.includes(monthValue));
            });
        } else {
            $('input[name="months[]"]').prop('checked', false);
        }
        // $('.current-date').val(row.current_date);

    },

    'click .edit-data': function (e, value, row, index) {
        $('#edit_id').val(row.id);
        $('#edit_student_id').val(row.student_id);
        $('#edit_class_id').val(row.class_id);
        $('.edit_total_amount').val(row.total_fees);
        $('.edit_student_name').html(row.student_name + ' - ' + row.class_name);
        $('.edit_date').val(row.formatted_date);
        if (row.mode) {
            $('#edit_mode_cheque').attr('checked', true);
            $('.edit_cheque_no_container').show(200);
            $('#edit_cheque_no').val(row.cheque_no);
        } else {
            $('#edit_mode_cash').attr('checked', true);
            $('.edit_cheque_no_container').hide(200);
        }

        if (row.fees_class_choiceable_data != null || row.fees_class_paid_choiceable_data != null) {
            $('.edit_choiceable_div').show();
            let html = '';
            html += '<div class="form-check form-check-inline"><label class="edit_paid_amount" data-amount=' + row.total_fees + '>Paid amount - ' + row.total_fees + '</label></div>'
            $.each(row.fees_class_choiceable_data, function (index, value) {
                html += '<div class="form-check form-check-inline"><label class="form-check-label"><input type="checkbox" name="add_new_choiceable_fees[]" class="form-check-input edit_new_chkclass" value="' + value.fees_type_id + '" data-amount="' + value.amount + '">' + value.fees_type.name + ' - ' + value.amount + '<i class="input-helper"></i></label></div>'
            });
            if (row.fees_class_paid_choiceable_data != null) {
                html += '<hr>';
                $.each(row.fees_class_paid_choiceable_data, function (index, value) {
                    html += '<div><label><a href="#" data-id=' + value.id + ' data-amount=' + value.amount + ' style="color:red" class="remove-paid-choiceable-fees"><i class="fa fa-remove"></i></a> ' + value.fees_type.name + ' - ' + value.amount + '</label></div>'
                });
            }
            $('.edit_choiceable_fees_content').html(html);
            $('.edit_total_amount_label').html(row.total_fees);
            let choice_amount = parseInt(row.total_fees);
            $('.edit_new_chkclass').on('click', function (e) {
                if ($(this).is(':checked')) {
                    $(this).addClass('added_price');
                    $(this).removeClass('chkclass');
                    choice_amount += $(this).data("amount");
                    $('.edit_total_amount_label').html(choice_amount);
                    $('.edit_total_amount').val(choice_amount);
                } else {
                    $(this).addClass('added_price');
                    $(this).removeClass('chkclass');
                    choice_amount -= $(this).data("amount");
                    $('.edit_total_amount_label').html(choice_amount);
                    $('.edit_total_amount').val(choice_amount);
                }
            });
        } else {
            $('.edit_choiceable_div').hide();
        }
    }
};

window.onlineExamEvents = {
    'click .edit-data': function (e, value, row, index) {
        $('#edit_id').val(row.online_exam_id);
        $('#edit-online-exam-title').val(row.title);
        $('#edit-online-exam-key').val(row.exam_key);
        $('#edit-online-exam-duration').val(row.duration);
        $('#edit-online-exam-start-date').val(row.start_date);
        $('#edit-online-exam-end-date').val(row.end_date);
    },
};
window.onlineExamQuestionsEvents = {
    'click .edit-data': function (e, value, row, index) {
        $('#edit_id').val(row.online_exam_question_id);
        $('.edit_question_type').val(row.question_type);
        $('#edit-online-exam-class-id').val(row.class_id).trigger('change');

        //added the subject on class id after 0.5 seconds
        setTimeout(() => {
            $('#edit-online-exam-subject-id').val(row.subject_id).trigger('change');
        }, 1000);

        if (row.question_type) {
            $('.edit_question').html('')
            $('.edit_option_container').html('')
            // set data in question text area
            CKEDITOR.instances['edit_equestion'].setData(row.question_row)

            $('#edit-simple-question').hide(100)
            $('#edit-equation-question').show(300);
            $('.edit_eoption_container').html('')

            let html_option = '';
            $.each(row.options, function (index, value) {
                if (index >= 2) {
                    html_option += '<div class="form-group col-md-6"><input type="hidden" class="edit_eoption_id" name="edit_eoption[' + (index + 1) + '][id]" value=' + value.id + '><label>' + lang_option + ' <span class="edit-eoption-number">' + (index + 1) + '</span> <span class="text-danger">*</span></label><textarea class="editor_options" name="edit_eoption[' + (index + 1) + '][option]" placeholder="' + lang_enter_option + '">' + value.option_row + '</textarea><div class="remove-edit-option-content"><button type="button" class="btn btn-inverse-danger remove-edit-option btn-sm mt-1" data-id="' + value.id + '"><i class="fa fa-times"></i></button></div></div>'
                    $('.edit_eoption_container').html(html_option);
                } else {
                    html_option += '<div class="form-group col-md-6"><input type="hidden" class="edit_eoption_id" name="edit_eoption[' + (index + 1) + '][id]" value=' + value.id + '><label>' + lang_option + ' <span class="edit-eoption-number">' + (index + 1) + '</span> <span class="text-danger">*</span></label><textarea class="editor_options" name="edit_eoption[' + (index + 1) + '][option]" placeholder="' + lang_enter_option + '">' + value.option_row + '</textarea></div>'
                    $('.edit_eoption_container').html(html_option);
                }
            });
            createCkeditor();
        } else {
            $('#edit-equation-question').hide(100);
            $('#edit-simple-question').show(300);
            $('.edit_option_container').html('')

            $('.edit-question').html(row.question);
            // add options and add the options in answers
            let html = ''
            $.each(row.options, function (index, value) {
                if (index >= 2) {
                    html = '<div class="form-group col-md-6"><input type="hidden" class="edit_option_id" name="edit_options[' + (index + 1) + '][id]" value=' + value.id + '><label>' + lang_option + ' <span class="edit-option-number"> ' + (index + 1) + '</span> <span class="text-danger">*</span></label><input type="text" name="edit_options[' + (index + 1) + '][option]" value="' + value.option + '" placeholder="' + lang_enter_option + '" class="form-control add-edit-question-option" /><div class="remove-edit-option-content"><button type="button" class="btn btn-inverse-danger remove-edit-option btn-sm mt-1" data-id="' + value.id + '"><i class="fa fa-times"></i></button></div></div>';
                } else {
                    html = '<div class="form-group col-md-6"><input type="hidden" class="edit_option_id" name="edit_options[' + (index + 1) + '][id]" value=' + value.id + '><label>' + lang_option + ' <span class="edit-option-number"> ' + (index + 1) + '</span> <span class="text-danger">*</span></label><input type="text" name="edit_options[' + (index + 1) + '][option]" value="' + value.option + '" placeholder="' + lang_enter_option + '" class="form-control add-edit-question-option" /><div class="remove-edit-option-content"></div></div>';
                }
                $('.edit_option_container').append(html);
            });
        }
        $('.answers_db').html('');
        $('.edit_answer_select').html('');
        if (row.answers.length) {
            $.each(row.options, function (index, value) {
                $.each(row.answers, function (answer_index, answer_value) {
                    if (value.id == answer_value.option_id) {
                        if (row.answers.length == 1) {
                            let html = '<i class="fa fa-circle" aria-hidden="true"></i> ' + lang_option + ' ' + (index + 1) + '<br>';
                            $('.answers_db').append(html);
                            return false;
                        } else {
                            let html = '<i class="fa fa-circle" aria-hidden="true"></i> ' + lang_option + ' ' + (index + 1) + ' <span class="fa fa-times text-danger remove-answers" data-id=' + answer_value.id + ' style="cursor:pointer"></span><br>';
                            $('.answers_db').append(html);
                            return false;
                        }
                    }
                });
            });
        }

        if (row.options_not_answers) {
            $.each(row.options, function (index, value) {
                $.each(row.options_not_answers, function (answer_index, option_data) {
                    if (value.id == option_data.id) {
                        $('.edit_answer_select').append('<option value="' + (option_data.id) + '">' + lang_option + ' ' + (index + 1) + '</option>');
                        return false;
                    }
                });
            });
        }

        $('.edit_answer_select').ready(function () {
            if ($('.answers_db').html() == '') {
                $('.edit_answer_select').attr('required', true);
            } else {
                $('.edit_answer_select').removeAttr('required');
            }
        })
        $('#image_preview').attr('src', row.image);
        $('.edit_note').val(row.note);
    },
};
window.teacherActionEvents = {
    'click .editdata': function (e, value, row, index) {
        $('#id').val(row.id);
        $('#user_id').val(row.user_id);
        $('#first_name').val(row.first_name);
        $('#last_name').val(row.last_name);
        $('input[name=gender][value=' + row.gender + '].edit').prop('checked', true);
        $('#current_address').val(row.current_address);
        $('#permanent_address').val(row.permanent_address);
        $('#email').val(row.email);
        $('#mobile').val(row.mobile);
        $('#dob').val(row.dob);
        $('#qualification').val(row.qualification);
        if (row.has_student_permissions) {
            $('.edit_permission_chk').prop("checked", true);
            $('.edit_permission_chk').addClass('warning_ckh')
            $(document).on('change', '.warning_ckh', function () {
                if (!this.checked) {
                    Swal.fire({
                        title: lang_delete_title,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: lang_yes_uncheck
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).prop("checked", false);
                        } else {
                            $(this).prop("checked", true);
                        }
                    })
                }
            });
        } else {
            $('.edit_permission_chk').prop("checked", false);
            $('.edit_permission_chk').removeClass('warning_ckh')
        }
    }
}
window.sliderEvents = {
    'click .edit-data': function (e, value, row, index) {
        $('#edit_id').val(row.id);

        // Select the file input field
        var fileInput = $('.edit_image');

        // Clear the selected file by resetting the input value
        fileInput.val(null);

        // Update the text input field to display "No file selected"
        fileInput.siblings('.form-control').val('');

        $('#edit_slider_image').attr('src', row.image);
    }
}
window.classEvents = {
    'click .edit-data': function (_e, _value, row) {
        //Reset the Checkbox and Radio Button
        $('input[name="section_id[]"].edit').prop('checked', false);
        $('input[name=medium_id].edit').prop('checked', false);

        $('#edit_id').val(row.id);
        $('#edit_name').val(row.name);
        $('#edit_stream_id').val(row.stream_id);
        $('#edit_shift_id').val(row.shift_id);

        $('input[name=medium_id][value=' + row.medium_id + '].edit').prop('checked', true);

        row.section_id.forEach(function (data) {
            $('input[name="section_id[]"][value=' + data + '].edit').prop('checked', true);
        });

    }
};

// Session Year
window.sessionYearEvents = {
    'click .editdata': function(e, value, row, index) {
        $('#id').val(row.id);
        $('#name').val(row.name);
        $('#start_date').val(row.start_date);
        $('#end_date').val(row.end_date);
        var cleanedPrice = row.price.replace(" DZ", "");
        $('#price_id').val(cleanedPrice);
        $('input[name="active_session_year"][value="' + row.default + '"]').prop('checked', true);


    }
};




// Bootstrap Custom Column Formatters
function fileFormatter(value, row) {
    let file_upload = "<br><h6>File Upload</h6>";
    let youtube_link = "<br><h6>Youtube Link</h6>";
    let video_upload = "<br><h6>Video Upload</h6>";
    let other_link = "<br><h6>Other Link</h6>";

    let file_upload_counter = 1;
    let youtube_link_counter = 1;
    let video_upload_counter = 1;
    let other_link_counter = 1;

    $.each(row.file, function (key, data) {
        //1 = File Upload , 2 = Youtube , 3 = Uploaded Video , 4 = Other
        if (data.type == 1) {
            // 1 = File Ulopad
            file_upload += "<a href='" + data.file_url + "' target='_blank' >" + file_upload_counter + ". " + data.file_name + "</a><br>";
            file_upload_counter++;
        } else if (data.type == 2) {
            // 2 = Youtube Link
            youtube_link += "<a href='" + data.file_url + "' target='_blank' >" + youtube_link_counter + ". " + data.file_name + "</a><br>";
            youtube_link_counter++;
        } else if (data.type == 3) {
            // 3 = Uploaded Video
            video_upload += "<a href='" + data.file_url + "' target='_blank' >" + video_upload_counter + ". " + data.file_name + "</a><br>";
            video_upload_counter++;
        } else if (data.type == 4) {
            // 4 = Other Link
            other_link += "<a href='" + data.file_url + "' target='_blank' >" + other_link_counter + ". " + data.file_name + "</a><br>";
            other_link_counter++;
        }
    })
    let html = "";
    if (file_upload_counter > 1) {
        html += file_upload;
    }

    if (youtube_link_counter > 1) {
        html += youtube_link;
    }

    if (video_upload_counter > 1) {
        html += video_upload;
    }

    if (other_link_counter > 1) {
        html += other_link;
    }

    return html;
}

function resubmissionFormatter(value, row) {
    let html = "";
    if (row.resubmission) {
        html = "<span class='alert alert-success'>YES</span>";
    } else {
        html = "<span class='alert alert-danger'>NO</span>";
    }
    return html;
}


function assignmentFileFormatter(value, row) {
    let html = "<a target='_blank' href='" + row.file + "'>" + row.name + "</a>";
    return html;
}


function assignmentSubmissionStatusFormatter(value, row) {
    let html = "";
    // 0 = Pending/In Review , 1 = Accepted , 2 = Rejected , 3 = Resubmitted
    if (row.status === 0) {
        html = "<span class='badge badge-warning'>Pending</span>";
    } else if (row.status === 1) {
        html = "<span class='badge badge-success'>Accepted</span>";
    } else if (row.status === 2) {
        html = "<span class='badge badge-danger'>Rejected</span>";
    } else if (row.status === 3) {
        html = "<span class='badge badge-warning'>Resubmitted</span>";
    }
    return html;
}

function imageFormatter(value, row) {
    if (row.image) {
        return "<a data-toggle='lightbox' href='" + row.image + "'><img src='" + row.image + "' class='img-fluid'  alt='image' onerror='onErrorImage(event)'  /></a>";
    } else {
        return '-'
    }
}
function fatherImageFormatter(value, row) {
    return "<a data-toggle='lightbox' href='" + row.father_image + "'><img src='" + row.father_image + "' class='img-fluid'  alt='image' onerror='onErrorImage(event)'/></a>";
}
function motherImageFormatter(value, row) {
    return "<a data-toggle='lightbox' href='" + row.mother_image + "'><img src='" + row.mother_image + "' class='img-fluid'  alt='image' onerror='onErrorImage(event)'/></a>";
}

function examTimetableFormatter(value, row) {
    let html = []
    if (row.timetable.length != null) {
        $.each(row.timetable, function (key, timetable) {
            html.push('<p>' + timetable.subject.name + '(' + timetable.subject.type + ')  - ' + timetable.total_marks + '/' + timetable.passing_marks + ' - ' + timetable.start_time + ' - ' + timetable.end_time + ' - ' + timetable.date + '</p>')
        });
    }
    return html.join('')
}

function examSubjectFormatter(index, row) {
    if (row.subject_name) {
        return row.subject_name;
    } else {
        return $('#subject_id :selected').text();
    }
}

function examStudentNameFormatter(index, row) {
    return "<input type='hidden' name='exam_marks[" + row.no + "][student_id]' class='form-control' value='" + row.student_id + "' />" + row.student_name
}

function obtainedMarksFormatter(index, row) {
    if (row.obtained_marks) {
        return "<input type='hidden' name='exam_marks[" + row.no + "][exam_marks_id]' class='form-control' value='" + row.exam_marks_id + "' />" +
            "<input type='number' name='exam_marks[" + row.no + "][obtained_marks]' class='form-control' min='0' value='" + row.obtained_marks + "' />" + "<input type='hidden' name='exam_marks[" + row.no + "][total_marks]' class='form-control' value='" + parseInt(row.total_marks) + "' />"
    } else {
        return "<input type='number' name='exam_marks[" + row.no + "][obtained_marks]' class='form-control' min='0' value='" + ' ' + "' />" + "<input type='hidden' name='exam_marks[" + row.no + "][total_marks]' class='form-control' value='" + parseInt(row.total_marks) + "' />"
    }
}

function teacherReviewFormatter(index, row) {
    if (row.teacher_review) {
        return "<textarea name='exam_marks[" + row.no + "][teacher_review]' class='form-control'>" + row.teacher_review + "</textarea>"
    } else {
        return "<textarea name='exam_marks[" + row.no + "][teacher_review]' class='form-control'>" + ' ' + "</textarea>"
    }
}

function examPublishFormatter(index, row) {
    if (index == 0) {
        return "<span class='badge badge-danger'>No</span>"
    } else {
        return "<span class='badge badge-success'>Yes</span>"
    }
}

function coreSubjectFormatter(value, row) {
    let core_subject_count = 1;
    let html = "<div style='line-height: 20px;'>";
    $.each(row.core_subjects, function (key, value) {
        if (value.subject) {
            html += "<br>" + core_subject_count + ". " + value.subject.name + " - " + value.subject.type
            core_subject_count++;
        }
    })
    html += "</div>";
    return html;
}

function classTeacherFormatter(value, row) {
    let class_teacher_count = 1;
    let html = "<div style='line-height: 20px;'>";
    $.each(row.teachers, function (key, value) {
        if (value) {
            html += "<br>" + class_teacher_count + ". " + value;
            class_teacher_count++;
        }
    })
    html += "</div>";
    return html;
}

function electiveSubjectFormatter(value, row) {
    let html = "<div style='line-height: 20px;'>";
    $.each(row.elective_subject_groups, function (key, group) {
        let elective_subject_count = 1;
        html += "<b>Group " + (key + 1) + "</b><br>";
        $.each(group.elective_subjects, function (key, elective_subject) {
            html += elective_subject_count + ". " + elective_subject.subject.name + " - " + elective_subject.subject.type + "<br>"
            elective_subject_count++;
        })
        html += "<b>Total Subjects : </b>" + group.total_subjects + "<br>"
        html += "<b>Total Selectable Subjects : </b>" + group.total_selectable_subjects + "<br><br>"
    })
    html += "</div>";
    return html;
}

function defaultYearFormatter(index, row) {
    if (index == 0) {
        return "<span class='badge badge-danger'>No</span>"
    } else {
        return "<span class='badge badge-success'>Yes</span>"
    }
}
function decisionPromotion(index, row) {
    if (index == 'admin') {
        return "<span class='badge badge-success'>Admin</span>"
    } else {
        return "<span class='badge badge-danger'>Ajouner</span>"
    }
}
function feesTypeChoiceable(index, row) {
    if (row.choiceable) {
        return "<span class='badge badge-success'>Yes</span>"
    } else {
        return "<span class='badge badge-danger'>No</span>"
    }
}
function feesTypeFormatter(index, row) {
    let html = [];
    if (row.fees_type.length) {
        let no = 1;
        $.each(row.fees_type, function (key, value) {
            html.push("<span>" + no + ". " + value.fees_name + " - " + value.amount + "</span><br>")
            no++;
        });
    } else {
        html.push("<p class='text-center'>-</p>")
    }
    return html.join('')

}
function feesPaidModeFormatter(index, row) {
    if (row.mode != null) {
        if (row.mode == 0) {
            return "<span class='badge badge-info'>" + lang_cash + "</span>"
        } else if (row.mode == 1) {
            return "<span class='badge badge-warning'>" + lang_cheque + "</span>"
        } else {
            return "<span class='badge badge-success'>" + lang_online + "</span>"
        }
    }
}
function feesOnlineTransactionLogParentGateway(index, row) {
    if (row.payment_gateway == 1) {
        return "<span class='badge badge-info'>RazorPay</span>";
    } else if (row.payment_gateway == 2) {
        return "<span class='badge badge-secondary'>Stripe</span>";
    } else {
        return " ";
    }
}
function feesOnlineTransactionLogPaymentStatus(index, row) {
    if (row.payment_status == 1) {
        return "<span class='badge badge-success'>" + lang_success + "</span>"
    } else if (row.payment_status == 2) {
        return "<span class='badge badge-warning'>" + lang_pending + "</span>"
    } else {
        return "<span class='badge badge-danger'>" + lang_failed + "</span>";
    }
}

function questionTypeFormatter(index, row) {
    if (row.question_type) {
        return "<span class='badge badge-secondary'>" + lang_equation_based + "</span>"
    } else {
        return "<span class='badge badge-info'>" + lang_simple_question + "</span>"
    }
}

function optionsFormatter(index, row) {
    let html = '';
    $.each(row.options, function (index, value) {
        html += "<div class='row'>";
        html += "<div class= 'col-md-1 text-center'><i class='fa fa-arrow-right small' aria-hidden='true'></i></div><div class='col-md-6'>" + value.option + "</div><br>"
        html += "</div>";
    });
    return html;
}
function answersFormatter(index, row) {
    let html = '';
    $.each(row.answers, function (index, value) {
        html += "<div class='row'>";
        html += "<span class= 'col-md-1 text-center'><i class='fa fa-arrow-right small' aria-hidden='true'></i></span><div class='col-md-6'>" + value.answer + "</div><br>"
        html += "</div>";
    });
    return html;
}

// function operateFormatter(value, row, index) {
//     return '<div class="dropdown"><button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button><div class="dropdown-menu">'+row.operate+'</div></div>';
// }

function feesPaidStatusFormatter(value, row, index) {
    if (row.fees_status == 1) {
        return "<span class='badge badge-success'>" + lang_success + "</span>"
    } else if (row.fees_status == 0) {
        return "<span class='badge badge-info'>" + lang_partial_paid + "</span>"
    } else {
        return "<span class='badge badge-warning'>" + lang_pending + "</span>";
    }
}




/**
 * Table Query Params
 */
function classQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        medium_id: $('#filter_medium_id').val(),
        shift_id: $('#filter_shift_id').val()
    };
}

function ExamClassQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        class_id: $('#filter_class_name').val(),
        exam_id: $('#filter_exam_name').val()

    };
}

function gradesQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
    };
}

function getExamResult(p) {
    var selectedOption = $('#filter_class_id option:selected');
    var class_section_id = selectedOption.data('class-section-id');

    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        class_section_id : class_section_id,
        class_id: $('#filter_class_id').val(),
        exam_id: $('#filter_exam_id').val(),

    };
}

$('#filter_exam_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
})

$('#filter_medium_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
})

$('#filter_shift_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
})

function SubjectQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        medium_id: $('#filter_subject_id').val()
    };
}

$('#filter_subject_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
})

function AssignclassQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        medium_id: $('#filter_medium_id').val(),
    };

}

function AssignTeacherQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        class_id: $('#filter_class_id').val(),
    };
}

$('#filter_class_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
})

function AssignSubjectTeacherQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        class_id: $('#filter_class_section_id').val(),
        teacher_id: $('#filter_teacher_id').val(),
        subject_id: $('#filter_subject_id').val(),
    };
}

$('#filter_class_section_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
})

$('#filter_teacher_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
})

$('#filter_subject_id').on('change', function () {
    $('#table_list').bootstrapTable('refresh');
})


function StudentDetailQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        class_id: $('#filter_class_section_id').val(),

    };
}


function AssignmentSubmissionQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        subject_id: $('#filter_subject_id').val(),

    };
}

function CreateAssignmentSubmissionQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        subject_id: $('#filter_subject_id').val(),
        class_id: $('#filter_class_section_id').val(),

    };
}

function CreateLessionQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        filter_subject_id: $('#filter_subject_id').val(),
        filter_section_id: $('#filter_section_id').val(),
        filter_trimester_id: $('#filter_trimester_id').val()
    };
}

function CreateTopicQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        subject_id: $('#filter_subject_id').val(),
        class_id: $('#filter_class_section_id').val(),
        lesson_id: $('#filter_lesson_id').val()
    };
}

function gradesQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function uploadMarksqueryParams(p) {

    var selectedOption = $('#class_id option:selected');
    var class_section_id = selectedOption.data('class-section-id');
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        'class_section_id': class_section_id,
        'class_id': $('#class_id').val(),
        'exam_id': $('#exam_id').val(),
        'subject_id': $('#subject_id').val(),
    };
}
function feesTypeQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}
function feesClassQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
    };

}
function feesPaidListQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        class_id: $('#class_name').val(),
        // session_year_id: $('#filter_session_year_id').val(),
        // mode: $('#filter_mode').val(),
    };
}


function feesPaymentTransactionQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        class_id: $('#filter_class_id').val(),
        session_year_id: $('#filter_session_year_id').val(),
        payment_status: $('#filter_payment_status').val(),
    };
}
function studentRollNumberQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        'class_section_id': $('#filter_roll_number_class_section_id').val(),
        'sort_by': $('#sort_by').val(),
    };
}
function userPermissionQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
    };
}
function onlineExamQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        'class_id': $('#filter-online-exam-class-id').val(),
        'subject_id': $('#filter-online-exam-subject-id').val(),
    };
}


$('#filter-question-class-section-id').on('change', function () {
    $('#table_list_questions').bootstrapTable('refresh');
})
$('#filter-question-subject-id').on('change', function () {
    $('#table_list_questions').bootstrapTable('refresh');
})
$('#filter-view-question-class-id').on('change', function () {
    $('#table_list_questions').bootstrapTable('refresh');
})
function onlineExamQuestionsQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        'class_id': $('#filter-view-question-class-id').val(),
        'subject_id': $('#filter-question-subject-id').val(),
    };
}
function teacherQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function onlineExamResultQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}
function studentDetailsqueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        class_id: $('#filter_class_section_id').val()
    };
}
function sessionYearQueryParams(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function resetPasswordQueryParams(p){
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}
function shiftStatusFormatter(value, row, index) {
    if (row.status == 1) {
        return "<span class='badge badge-success'>" + lang_active + "</span>";
    } else {
        return "<span class='badge badge-danger'>" + lang_inactive + "</span>";
    }
}
