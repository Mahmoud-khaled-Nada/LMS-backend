@isset($role)
    @method('PUT')
@endisset
@csrf
<div class="card-body border-top p-9">
    @isset($role)
        <input type="hidden" value="{{ $role->id }}" name='id'>
    @endisset
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
                    <input type="text" name="name"
                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                        placeholder="{{ __('lang.name') }}" value="{{ $role->name ?? '' }}">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
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
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.permession') }}</label>
        <!--end::Label-->

        <!--begin::Col-->
        <div class="col-lg-8">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-12 fv-row fv-plugins-icon-container">
                    <select id="kt_select2_3"
                        class="js-example-basic-multiple form-control select2 select2-hidden-accessible"
                        name="permessions[]" multiple="multiple">
                        <option value='all'>{{ __('lang.selectall') }}</option>
                        @foreach ($permessions as $permession)
                            <option value="{{ $permession->id }}"
                                {{ isset($rolePermissions) && in_array($permession->id, $rolePermissions) ? 'selected' : '' }}>
                                {{ $permession->name }}
                            </option>
                        @endforeach

                    </select>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->

</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            placeholder: "{{ __('lang.select') }}",
            allowClear: true
        });

        // Add event listener for the "Select All" option
        $('.js-example-basic-multiple').on('select2:select', function(e) {
            if (e.params.data.id === 'all') {
                $(this).find('option').prop('selected', true);
                $(this).trigger('change');
            }
        });
    });
</script>
