<div class="repeater">
    <div class="row">
        <div class="input-group col-sm-12 col-md-2">
            {{__('subjects.subject')}} <span class="text-danger"> *</span>
        </div>
        <div class="input-group col-sm-12 col-md-2">
            {{__('teacher.teacher')}} <span class="text-danger">*</span>
        </div>
        <div class="input-group col-sm-12 col-md-2">
            {{__('timetable.start_time')}} <span class="text-danger">*</span>
        </div>
        <div class="input-group col-sm-12 col-md-2">
            {{__('timetable.end_time')}} <span class="text-danger">*</span>
        </div>
        <div class="input-group col-sm-12 col-md-2">
            {{__('genirale.note')}}
        </div>
        <div class="input-group col-sm-12 col-md-2">
            <button data-repeater-create type="button" class="addmore d-none btn btn-gradient-info btn-sm icon-btn ml-2 mb-2">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>

    <form class="pt-3" action="{{route('school.timetable.store')}}" id="formdata" method="POST" novalidate="novalidate">
        @csrf
        <input required type="hidden" name="day" id="day" class="day">
        <input required type="hidden" name="class_section_id" id="class_section_id">
        <input required type="hidden" name="section_id" id="section_id">
