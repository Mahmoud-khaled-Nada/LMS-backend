@isset($intro)
    @method('PUT')
    <input type="hidden" value="{{ $intro->id }}" name="id">
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
                                       value="{{ isset($intro) ? $intro->getTranslation($name)->name : '' }}" placeholder="{{ __('lang.title') }}">
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
                                    {{ isset($intro) ? $intro->getTranslation($name)->description : '' }}
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
            </div>
        @endforeach

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
                <div class="image-input-wrapper w-125px h-125px" @isset($intro->image) style='background-image:url({{ $intro->image }})' @endisset></div>
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


    </div>
</div>
