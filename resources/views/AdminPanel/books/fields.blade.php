@isset($book)
@method('PUT')
<input type="hidden" value="{{ $book->id }}" name="id">
@endisset
@csrf
<div class="card-body border-top p-9">
    <ul class="nav nav-light-success nav-pills" id="myTab" role="tablist">

        @foreach ( LaravelLocalization::getSupportedLocales() as $name => $value)

        <li class="nav-item" data-bs-toggle="tab">
            <a class="nav-link {{LaravelLocalization::getCurrentLocale() == $name ?'active':''}}" id="{{$name}}-tab"
                data-bs-toggle="tab" href="#{{$name}}" role="tab" aria-controls="{{$name}}"
                aria-selected="{{ LaravelLocalization::getCurrentLocale() == $name  ? 'true' : 'false'}}">{{$value['native']}}</a>
        </li>

        @endforeach
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        @foreach ( LaravelLocalization::getSupportedLocales() as $name => $value)
        <div class="tab-pane fade {{(LaravelLocalization::getCurrentLocale() == $name) ? 'show active':''}}"
            id="{{$name}}" role="tabpanel" aria-labelledby="{{$name}}-tab">
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
                                value="{{ isset($book)? $book->getTranslation($name)->name : '' }}" placeholder="{{__('lang.name')}}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
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
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.description') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8">
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-12 fv-row fv-plugins-icon-container">
                            <textarea name="{{ $name }}[description]" class="summernote form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('lang.description') }}">
                                {{ isset($book) ? $book->getTranslation($name)->description : '' }}
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

            <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.learning') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8">
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-12 fv-row fv-plugins-icon-container">
                            <textarea name="{{ $name }}[learning]" class="summernote form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ __('lang.description') }}">
                                {{ isset($book) ? $book->getTranslation($name)->learning : '' }}
                            </textarea>
                            @if($errors->has("{$name}.learning"))
                                <div class="fv-plugins-message-container invalid-feedback">
                                    {{ $errors->first("{$name}.learning") }}
                                </div>
                            @endif
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Col-->
            </div>

        </div>
        @endforeach
    </div>

    {{-- Start Chapers --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.chapters') }}</label>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12 fv-row fv-plugins-icon-container">
                    <input type="number" name="chapters" min="1"
                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                        placeholder="{{ __('lang.chapters') }}" value="{{ $book->chapters ?? '' }}">
                    @if($errors->has('chapters'))
                        <div class="fv-plugins-message-container invalid-feedback">
                            {{ $errors->first('chapters') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- end chapters --}}
  {{-- Start publish --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.publish') }}</label>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12 fv-row fv-plugins-icon-container">
                    <input type="date" name="publish" min="1"
                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                        placeholder="{{ __('lang.publish') }}" value="{{ old('publish', isset($book) ? $book->publish : '') }}">
                    @if($errors->has('publish'))
                        <div class="fv-plugins-message-container invalid-feedback">
                            {{ $errors->first('publish') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
{{-- end publish --}}

    {{-- Price --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.price') }}</label>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12 fv-row fv-plugins-icon-container">
                    <input type="number" name="price" min="1"
                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                        placeholder="{{ __('lang.price') }}" value="{{ $book->price ?? '' }}">
                    @if($errors->has('price'))
                        <div class="fv-plugins-message-container invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- end Price --}}
    {{-- Satrt Instructor --}}
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.instructors') }}</label>
        <div class="col-lg-8">
            <select name="user_id" id="user_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                <option value="">{{ __('lang.users') }}</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ (isset($book) && $book->user_id == $teacher->id) ? 'selected' : '' }}>
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


    {{-- end Instructor --}}

        <!--begin::Input group-->
        <div class="fv-row mb-10 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="d-block fw-semibold fs-6 mb-5">
                <span class="required">{{__('lang.photo')}}</span>
            </label>
            <!--end::Label-->
            <!--begin::Image input placeholder-->
            <style>
                .image-input-placeholder {
                    background-image: url({{asset('assets/media/svg/files/blank-image.svg')}})
                }

                [data-bs-theme="dark"] .image-input-placeholder {
                    background-image: url({{asset('assets/media/svg/files/blank-image-dark.svg')}});
                }
            </style>
            <!--end::Image input placeholder-->
            <!--begin::Image input-->
            <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-125px h-125px" @isset($book->image)
                    style='background-image:url({{$book->image}})'@endisset>
                </div>
                <!--end::Preview existing avatar-->
                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                    data-bs-original-title="Change avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-pencil fs-7">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <!--begin::Inputs-->
                    <input type="file" name="image" accept=".png, .jpg, .jpeg">
                    <input type="hidden" name="avatar_remove">
                    <!--end::Inputs-->
                </label>
                <!--end::Label-->
                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar"
                    data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <!--end::Cancel-->
                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar"
                    data-bs-original-title="Remove avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <!--end::Remove-->
            </div>
            <!--end::Image input-->
            <!--begin::Hint-->
            <div class="form-text">{{__('lang.allowedsettingtypes')}}</div>
            <!--end::Hint-->
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
        </div>
        <!--end::Input group-->

        <div class="fv-row mb-10 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="d-block fw-semibold fs-6 mb-5">
                <span class="required">{{__('lang.document')}}</span>
            </label>
            <!--end::Label-->
            <!--begin::Image input placeholder-->
            <style>
                .image-input-placeholder {
                    background-image: url({{asset('assets/media/svg/files/blank-image.svg')}})
                }

                [data-bs-theme="dark"] .image-input-placeholder {
                    background-image: url({{asset('assets/media/svg/files/blank-image-dark.svg')}});
                }
            </style>
            <!--end::Image input placeholder-->
            <!--begin::Image input-->
            <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-125px h-125px" @isset($book->document)
                    style='background-image:url({{$book->document}})'@endisset>
                </div>
                <!--end::Preview existing avatar-->
                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                    data-bs-original-title="Change avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-pencil fs-7">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <!--begin::Inputs-->
                    <input type="file" name="document" accept=".pdf,">
                    <input type="hidden" name="avatar_remove">
                    <!--end::Inputs-->
                </label>
                <!--end::Label-->
                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar"
                    data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <!--end::Cancel-->
                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar"
                    data-bs-original-title="Remove avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <!--end::Remove-->
            </div>
            <!--end::Image input-->
            <!--begin::Hint-->
            <div class="form-text">{{__('lang.allowedsettingtypes')}}</div>
            <!--end::Hint-->
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
        </div>
        <!--end::Input group-->
    </div>
</div>
