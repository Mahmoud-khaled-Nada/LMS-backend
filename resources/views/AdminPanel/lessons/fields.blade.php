@isset($lesson)
    @method('PUT')
    <input type="hidden" value="{{ $lesson->id }}" name="id">
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
                                       value="{{ isset($lesson) ? $lesson->getTranslation($name)->name : '' }}" placeholder="{{ __('lang.title') }}">
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
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.short_description') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <textarea name="{{ $name }}[short_description]" class="summernote form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('lang.description') }}">
                                    {{ isset($lesson) ? $lesson->getTranslation($name)->short_description : '' }}
                                </textarea>
                                @if($errors->has("{$name}.short_description"))
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        {{ $errors->first("{$name}.short_description") }}
                                    </div>
                                @endif
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--begin::Input group-->

            </div>
        @endforeach

        <!-- قائمة الأقسام -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.courses') }}</label>
            <div class="col-lg-8">
                <select name="course_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                    <option value="">{{ __('lang.courses') }}</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ isset($lesson) && $lesson->course_id == $course->id ? 'selected' : '' }}>
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


    </div>
</div>
