@isset($lecture)
    @method('PUT')
    <input type="hidden" value="{{ $lecture->id }}" name="id">
@endisset
@csrf
<div class="card-body border-top p-9">
    <ul class="nav nav-light-success nav-pills" id="myTab" role="tablist">
        @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
            <li class="nav-item" data-bs-toggle="tab">
                <a class="nav-link {{ LaravelLocalization::getCurrentLocale() == $name ? 'active' : '' }}" id="{{ $name }}-tab"
                   data-bs-toggle="tab" href="#{{ $name }}" role="tab" aria-controls="{{ $name }}"
                   aria-selected="{{ LaravelLocalization::getCurrentLocale() == $name ? 'true' : 'false' }}">{{ $value['native'] }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        @foreach (LaravelLocalization::getSupportedLocales() as $name => $value)
            <div class="tab-pane fade {{ LaravelLocalization::getCurrentLocale() == $name ? 'show active' : '' }}" id="{{ $name }}" role="tabpanel" aria-labelledby="{{ $name }}-tab">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.name') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <input type="text" name="{{ $name }}[name]"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       value="{{ isset($lecture) ? $lecture->getTranslation($name)->name : '' }}" placeholder="{{ __('lang.title') }}">
                                @if($errors->has("{$name}.name"))
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        {{ $errors->first("{$name}.name") }}
                                    </div>
                                @endif
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->

            </div>
        @endforeach

      <!-- قائمة الأقسام -->
<div class="row mb-6">
    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.courses') }}</label>
    <div class="col-lg-8">
        <select name="course_id" id="course_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
            <option value="">{{ __('lang.courses') }}</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ isset($lecture) && $lecture->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
        @if($errors->has('category_id'))
            <div class="fv-plugins-message-container invalid-feedback">
                {{ $errors->first('category_id') }}
            </div>
        @endif
    </div>
</div>

<!-- حقل مخفي للاحتفاظ بالدرس المختار مسبقًا -->
    <input type="hidden" id="selected_lesson_id" value="{{ isset($lecture) ? $lecture->lesson_id : '' }}">

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.lessons') }}</label>
        <div class="col-lg-8">
            <select name="lesson_id" id="lesson_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                <option value="">{{ __('lang.lessons') }}</option>
            </select>
            @if($errors->has('category_id'))
                <div class="fv-plugins-message-container invalid-feedback">
                    {{ $errors->first('category_id') }}
                </div>
            @endif
        </div>
    </div>



        <!-- Input group for video -->
        <div class="fv-row mb-10 fv-plugins-icon-container">
            <label class="d-block fw-semibold fs-6 mb-5">
                <span class="required">{{ __('lang.video') }}</span>
            </label>
            <style>
                .image-input-placeholder {
                    background-image: url({{ asset('assets/media/svg/files/blank-image.svg') }})
                }
                [data-bs-theme="dark"] .image-input-placeholder {
                    background-image: url({{ asset('assets/media/svg/files/blank-image-dark.svg') }});
                }
            </style>
            <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                <div class="image-input-wrapper w-125px h-125px" @isset($lecture->video) style='background-image:url({{ $course->free_video }})' @endisset></div>
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                       data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                       data-bs-original-title="Change avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-pencil fs-7">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="file" name="video" accept=".mp4">
                    <input type="hidden" name="avatar_remove">
                </label>
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar"
                      data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar"
                      data-bs-original-title="Remove avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
            </div>
            @if($errors->has('video'))
                <div class="fv-plugins-message-container invalid-feedback">
                    {{ $errors->first('video') }}
                </div>
            @endif
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#course_id').change(function () {
            var courseId = $(this).val();
            var selectedLessonId = $('#selected_lesson_id').val();
            if (courseId) {
                $.ajax({
                    url: '{{ url("/get-lessons") }}/' + courseId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#lesson_id').empty();
                        $('#lesson_id').append('<option value="">{{ __("lang.lessons") }}</option>');
                        $.each(data, function (key, value) {
                            $('#lesson_id').append('<option value="' + value.id + '"' + (value.id == selectedLessonId ? ' selected' : '') + '>' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#lesson_id').empty();
                $('#lesson_id').append('<option value="">{{ __("lang.lessons") }}</option>');
            }
        });

        // Trigger change event on page load to populate lessons if course is already selected
        if ($('#course_id').val()) {
            $('#course_id').trigger('change');
        }
    });
</script>
