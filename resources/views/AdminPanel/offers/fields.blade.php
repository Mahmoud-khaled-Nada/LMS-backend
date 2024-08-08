@isset($offer)
    @method('PUT')
    <input type="hidden" value="{{ $offer->id }}" name="id">
@endisset
@csrf
<div class="card-body border-top p-9">
    <div class="tab-content mt-5" id="myTabContent">

        <!-- قائمة الأقسام -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.courses') }}</label>
            <div class="col-lg-8">
                <select name="course_id" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
                    <option value="">{{ __('lang.courses') }}</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}"
                            @if(isset($offer) && $offer->course_id == $course->id) selected @endif>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('course_id'))
                    <div class="fv-plugins-message-container invalid-feedback">
                        {{ $errors->first('course_id') }}
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
                        <input type="number" name="new_price"
                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            placeholder="{{ __('lang.new_price') }}" value="{{ old('new_price', $offer->new_price ?? '') }}">
                        @if($errors->has('new_price'))
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $errors->first('new_price') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Input group for expire date -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.expire_date') }}</label>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                        <input type="date" name="expire_date"
                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            placeholder="{{ __('lang.expire_date') }}" value="{{ old('expire_date', $offer->expire_date ?? '') }}">
                        @if($errors->has('expire_date'))
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $errors->first('expire_date') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
