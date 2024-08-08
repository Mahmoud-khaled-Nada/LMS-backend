@isset($course)
    @method('PUT')
    <input type="hidden" value="{{ $course->id }}" name="id">
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
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.title') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <input type="text" name="{{ $name }}[name]"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       value="{{ isset($course) ? $course->getTranslation($name)->name : '' }}" placeholder="{{ __('lang.title') }}">
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
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.description') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <textarea name="{{ $name }}[description]" class="summernote form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('lang.description') }}">
                                    {{ isset($course) ? $course->getTranslation($name)->description : '' }}
                                </textarea>
                                @if($errors->has("{$name}.description"))
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        {{ $errors->first("{$name}.description") }}
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
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.will_learn') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <textarea name="{{ $name }}[will_learn]" class="summernote form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('lang.description') }}">
                                    {{ isset($course) ? $course->getTranslation($name)->will_learn : '' }}
                                </textarea>
                                @if($errors->has("{$name}.will_learn"))
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        {{ $errors->first("{$name}.will_learn") }}
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
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.requirements') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                <textarea name="{{ $name }}[requirements]" class="summernote form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('lang.description') }}">
                                    {{ isset($course) ? $course->getTranslation($name)->will_learn : '' }}
                                </textarea>
                                @if($errors->has("{$name}.requirements"))
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        {{ $errors->first("{$name}.will_learn") }}
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
            </div>
        @endforeach

        <!-- قائمة الأقسام -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.category') }}</label>
            <div class="col-lg-8">
                <select name="category_id" id="category_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                    <option value="">{{ __('lang.categories') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ isset($course) && $course->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
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


        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.instructors') }}</label>
            <div class="col-lg-8">
                <select name="user_id" id="user_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                    <option value="">{{ __('lang.users') }}</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ isset($selectedUser) && $selectedUser == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <div class="fv-plugins-message-container invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
            </div>
        </div>


    <!-- Input group for price -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.price') }}</label>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                        <input type="number" name="price"
                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            placeholder="{{ __('lang.price') }}" value="{{ $course->price ?? '' }}">
                        @if($errors->has('price'))
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{--  --}}
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.hours') }}</label>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                        <input type="number" name="hours"
                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            placeholder="{{ __('lang.hours') }}" value="{{ $course->hours ?? '' }}">
                        @if($errors->has('hours'))
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $errors->first('hours') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Start Type --}}

        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.type') }}</label>
            <div class="col-lg-8">
                <div class="form-check form-check-inline" style="margin-right: 100px;">
                    <input class="form-check-input" type="radio" name="type" id="type_online" value="online" {{ (isset($course) && $course->type == 'online') ? 'checked' : '' }}>
                    <label class="form-check-label" for="type_online">{{ __('lang.online') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="type_onsite" value="onsite" {{ (isset($course) && $course->type == 'onsite') ? 'checked' : '' }}>
                    <label class="form-check-label" for="type_onsite">{{ __('lang.onsite') }}</label>
                </div>
                @if($errors->has('type'))
                    <div class="fv-plugins-message-container invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
            </div>
        </div>
        {{-- End Type --}}

        {{--  --}}
        <!-- Input group for image -->
        <div class="fv-row mb-10 fv-plugins-icon-container">
            <label class="d-block fw-semibold fs-6 mb-5">
                <span class="required">{{ __('lang.photo') }}</span>
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
                <div class="image-input-wrapper w-125px h-125px" @isset($course->image) style='background-image:url({{ $course->image }})' @endisset></div>
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                       data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                       data-bs-original-title="Change avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-pencil fs-7">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="file" name="image" accept=".png, .jpg, .jpeg">
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
            <div class="form-text">{{ __('lang.allowedsettingtypes') }}</div>
            @if($errors->has('image'))
                <div class="fv-plugins-message-container invalid-feedback">
                    {{ $errors->first('image') }}
                </div>
            @endif
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
                <div class="image-input-wrapper w-125px h-125px" @isset($course->free_video) style='background-image:url({{ $course->free_video }})' @endisset></div>
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                       data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                       data-bs-original-title="Change avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-pencil fs-7">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="file" name="free_video" accept=".mp4">
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
            @if($errors->has('free_video'))
                <div class="fv-plugins-message-container invalid-feedback">
                    {{ $errors->first('free_video') }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#category_id').change(function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '{{ route('getUsersByCategory', '') }}/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('#user_id').empty();
                        $('#user_id').append('<option value="">{{ __('lang.users') }}</option>');
                        $.each(data, function(index, user) {
                            $('#user_id').append('<option value="'+ user.id +'">'+ user.name +'</option>');
                        });
                    }
                });
            } else {
                $('#user_id').empty();
                $('#user_id').append('<option value="">{{ __('lang.users') }}</option>');
            }
        });
    });
</script>
