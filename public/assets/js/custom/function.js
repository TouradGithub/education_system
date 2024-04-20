"use strict";

function showErrorToast(message) {
    $.toast({
        text: message,
        showHideTransition: 'slide',
        icon: 'error',
        loaderBg: '#f2a654',
        position: 'top-right'
    });
}

function showSuccessToast(message) {
    $.toast({
        text: message,
        showHideTransition: 'slide',
        icon: 'success',
        loaderBg: '#f96868',
        position: 'top-right'
    });
}
function getNumday(day_name){

    const daysOfWeek = [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday","Sunday"];
    return daysOfWeek.indexOf(day_name) + 1;

}
function getDayName(day_name){
    var day;
    if (day_name == 1) {
        day = 'monday';
    } else if (day_name == 2) {
        day = 'tuesday';
    } else if (day_name == 3) {
        day ='wednesday' ;
    } else if (day_name == 4) {
        day ='thursday' ;
    } else if (day_name == 5) {
        day ='friday' ;
    } else if (day_name == 6) {
        day ='saturday' ;
    } else if (day_name ==7 ) {
        day ='sunday' ;
    }
    return day;
}

function ajaxRequest(type, url, data, beforeSendCallback, successCallback, errorCallback, finalCallback, processData = false) {
    /*
    * @param
    * beforeSendCallback : This function will be executed before Ajax sends its request
    * successCallback : This function will be executed if no Error will occur
    * errorCallback : This function will be executed if some error will occur
    * finalCallback : This function will be executed after all the functions are executed
    */
    $.ajax({
        type: type,
        url: url,
        data: data,
        cache: false,
        processData: processData,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            if (beforeSendCallback != null) {
                beforeSendCallback();
            }
        },
        success: function (data) {
            if (!data.error) {
                if (successCallback != null) {
                    successCallback(data);
                }
            } else {
                if (errorCallback != null) {
                    errorCallback(data);
                }
            }

            if (finalCallback != null) {
                finalCallback(data);
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.responseJSON) {
                showErrorToast(jqXHR.responseJSON.message);
            }
            if (finalCallback != null) {
                finalCallback();
            }
        }
    })
}

function formAjaxRequest(type, url, data, formElement, submitButtonElement, successCallback, errorCallback) {
    // To Remove Red Border from the Validation tag.
    formElement.find('.has-danger').removeClass("has-danger");
    formElement.validate();
    if (formElement.valid()) {
        let submitButtonText = submitButtonElement.val();

        function beforeSendCallback() {
            submitButtonElement.val('Please Wait...').attr('disabled', true);
        }

        function mainSuccessCallback(response) {
            showSuccessToast(response.message);
            if (successCallback != null) {
                successCallback(response);
            }
        }

        function mainErrorCallback(response) {
            showErrorToast(response.message);
            if (errorCallback != null) {
                errorCallback(response);
            }
        }

        function finalCallback(response) {
            submitButtonElement.val(submitButtonText).attr('disabled', false);
        }
        console.log(url);
        ajaxRequest(type, url, data, beforeSendCallback, mainSuccessCallback, mainErrorCallback, finalCallback)
    }
}

function cloneOldCoreSubjectTemplate() {
    let core_subject = $('.edit-core-subject-div:last').clone().show();
    // Remove the error label from the main html so that duplicate error will not be show
    core_subject.find('select').siblings('.error').remove();

    //Change the Name array attribute for jquery validation
    //Add incremental name value
    core_subject.find('.form-control').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
        $(element).attr('disabled', false);
    })
    return core_subject;
}

function cloneNewCoreSubjectTemplate() {
    let core_subject = $('.core-subject-div:last').clone().show();
    //Change the Name array attribute for jquery validation
    //Add incremental name value
    core_subject.find('select').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
        $(element).attr('disabled', false);
    })
    // Remove the error label from the main html so that duplicate error will not be show
    core_subject.find('select').siblings('.error').remove();
    core_subject.find('.add-core-subject i').addClass('fa-times').removeClass('fa-plus');
    core_subject.find('.add-core-subject').addClass('btn-inverse-danger remove-core-subject').removeClass('btn-inverse-success add-core-subject');
    return core_subject;
}

function cloneOldElectiveSubjectGroup() {
    let html = $('.edit-elective-subject-group-div:last').clone().show();
    html.children('.subject-list').find('div').slice(1).remove();
    html.find('.form-control').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
        $(element).attr('disabled', false);
    })
    return html;
}

function cloneNewElectiveSubjectGroup() {
    let html = $('.elective-subject-group-div:last').clone().show();
    html.children('.subject-list').find('div').slice(1).remove();
    html.find('.form-control').each(function (key, element) {
        this.name = this.name.replace(/\[(\d+)\]/, function (str, p1) {
            return '[' + (parseInt(p1, 10) + 1) + ']';
        });
        $(element).attr('disabled', false);
    })
    return html;
}

function cloneNewElectiveSubject(add_new_elective_subject_button_element) {
    //add-new-elective-subject class button element
    let subject_list = $(add_new_elective_subject_button_element).siblings('.elective-subject-div:last').clone();
    subject_list.find('#remove-elective-subject').show();
    subject_list.children('select').each(function (key, element) {
        this.name = this.name.replace(/\[subject_id]\[(\d+)\]/, function (str, p1) {
            return '[subject_id][' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    subject_list.children('input').each(function (key, element) {
        this.name = this.name.replace(/\[class_subject_id]\[(\d+)\]/, function (str, p1) {
            return '[class_subject_id][' + (parseInt(p1, 10) + 1) + ']';
        });
    })
    subject_list.children('select').siblings('.error').remove()
    subject_list.find('i').css('visibility', 'visible');
    let or = $('.or:last').clone();
    return $.merge(or, subject_list);
}

/**
 *
 * @param searchElement
 * @param searchUrl
 * @param data Object
 * @param placeHolder
 * @param templateDesignEvent
 * @param onTemplateSelectEvent
 */
function parentSearch(searchElement, searchUrl, data, placeHolder, templateDesignEvent, onTemplateSelectEvent) {
    //Select2 Ajax Searching Functionality function
    if (!data) {
        data = {};
    }
    $(searchElement).select2({
        tags: true,
        ajax: {
            url: searchUrl,
            dataType: 'json',
            delay: 250,
            cache: true,
            data: function (params) {
                data.email = params.term;
                data.page = params.page;
                return data;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            }
        },
        placeholder: placeHolder,
        minimumInputLength: 1,
        templateResult: templateDesignEvent,
        templateSelection: onTemplateSelectEvent,
    });
}

function parentSearchSelect2DesignTemplate(repo) {
    /**
     * This function is used in Select2 Searching Functionality
     */
    if (repo.loading) {
        return repo.text;
    }
    if (repo.id && repo.text) {
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'></div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo.text);
    } else {
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='row'>" +
            "<div class='col-1 select2-result-repository__avatar' style='width:20px'>" +
            "<img src='" + repo.image + "' class='w-100' onerror='onErrorImage(event)'/>" +
            "</div>" +
            "<div class='col-10'>" +
            "<div class='select2-result-repository__title'></div>" +
            "<div class='select2-result-repository__description'></div>" +
            "</div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.first_name + " " + repo.last_name);
        $container.find(".select2-result-repository__description").text(repo.email);
    }

    return $container;
}
function createCkeditor() {
    for(var equation_editor in CKEDITOR.instances){
        CKEDITOR.instances[equation_editor].destroy();
    }
    CKEDITOR.replaceAll(function(textarea,config){
        if(textarea.className == "editor_question"){
            config.mathJaxLib = '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML';
            config.extraPlugins = 'mathjax';
            config.height = 200;
            return true;
        }
        if(textarea.className == "editor_options"){
            config.mathJaxLib = '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML';
            config.extraPlugins = 'mathjax';
            config.height = 100
            return true;
        }
        return false;
    });

    // inline editors
    var elements = CKEDITOR.document.find( '.equation-editor-inline' ),i = 0,element;
    while ( ( element = elements.getItem( i++ ) ) ) {
        CKEDITOR.inline(element,{
            mathJaxLib : '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
            extraPlugins : 'mathjax',
            readOnly:true,
        });
    }
}
