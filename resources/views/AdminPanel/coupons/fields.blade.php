@isset($coupon)
    @method('PUT')
    <input type="hidden" name="id" value="{{ $coupon->id }}">
@endisset
@csrf
<div class="card-body border-top p-9">

    <div class="tab-content mt-5" id="myTabContent">


        <!-- Input group for price -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.number_of_use') }}</label>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                        <input type="number" name="number_of_use" start="1" min="1"
                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            placeholder="{{ __('lang.number_of_use') }}" value="{{ $coupon->number_of_use ?? '' }}">
                        @if($errors->has('number_of_use'))
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $errors->first('number_of_use') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

              <!-- Input group for price -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.expire_date') }}</label>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                        <input type="date" name="expire_date"
                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            placeholder="{{ __('lang.expire_date') }}" value="{{ $coupon->expire_date ?? '' }}">
                        @if($errors->has('expire_date'))
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $errors->first('expire_date') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.value') }}</label>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                        <input type="number" name="value" step="1" min="1"
                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            placeholder="{{ __('lang.value') }}" value="{{ $coupon->value ?? '' }}">
                        @if($errors->has('value'))
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $errors->first('value') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.type') }}</label>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                        </label>
                        <select class="form-control w-100" name="type" required>
                            <option value="0" {{ isset($coupon) && $coupon->type == 0 ? 'selected' : '' }}>
                                {{ __('lang.amount') }}</option>
                            <option value="1" {{ isset($coupon) && $coupon->type == 1 ? 'selected' : '' }}>
                                {{ __('lang.percentage') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        @error('type')
            <p class="text-danger">{{ $errors->first('type') }}</p>
        @enderror

        <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.status') }}</label>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                    <select class="form-control w-100" name="status" required>
                        <option value="0" {{ isset($coupon) && $coupon->status == 0 ? 'selected' : '' }}>
                            {{ __('lang.inactive') }}</option>
                        <option value="1" {{ isset($coupon) && $coupon->status == 1 ? 'selected' : '' }}>
                            {{ __('lang.active') }}</option>
                    </select>
                </div>
                </div>
            </div>
        </div>

    </div>
</div>
