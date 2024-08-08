<!--begin::Table-->
<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <div class="row mb-6">
        <!--begin::Label-->
        <label class="col-lg-6 col-form-label  fw-semibold fs-6">{{ __('lang.filter') }}</label>
        <!--end::Label-->

        <!--begin::Col-->
        <div class="col-lg-6">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-12 fv-row fv-plugins-icon-container">
                    <select class="form-select form-select-solid filter ml-lg-5 ml-md-5 w-50" id="kt_datatable_search_status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select a Team Member" name="status" data-select2-id="select2-data-72-ljg2"
                        tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                        <option value="all" data-select2-id="select2-data-74-kng8" selected>{{__('lang.selectall')}}</option>
                        <option value="{{__('lang.active')}}" data-select2-id="select2-data-74-kng8"  >{{__('lang.active')}}</option>
                        <option value="{{__('lang.inactive')}}" data-select2-id="select2-data-131-9yfh"  >{{__('lang.inactive')}}</option>

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
    <!--begin::Thead-->
    <thead>
        <tr class="fw-6 fw-semibold text-gray-600">
            <th class="min-w-250px">{{ __('lang.name') }}</th>
            <th class="min-w-250px">{{ __('lang.email') }}</th>
            <th class="min-w-250px">{{ __('lang.points') }}</th>
            <th class="min-w-250px">{{ __('lang.status') }}</th>
            <th class="min-w-150px no-export">{{ __('lang.actions') }}</th>
        </tr>
    </thead>
    <!--end::Thead-->
    <!--begin::Tbody-->
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>
                    <span class="badge badge-light-success fs-7 fw-bold">{{ $user->name }}</span>
                </td>
                <td>
                    <span class=" fs-7 fw-bold">{{ $user->email }}</span>
                </td>
                <td>
                    <span class=" fs-7 fw-bold">{{ $user->points }}</span>
                </td>
                <td>
                    @if ($user->status == 1)
                        <span class="badge badge-light-success fs-7 fw-bold">{{ $user->statustype }}</span>
                    @else
                        <span class="badge badge-light-danger fs-7 fw-bold">{{ $user->statustype }}</span>
                    @endif

                </td>
                <td class="no-export">
                    @if(auth()->user()->can('Edit User'))
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-light me-2 {{ $user->status==1? 'bg-danger' :'bg-success' }}">
                            @if ($user->status == 1)
                                <i class="bi bi-file-x-fill"></i>
                            @else
                                <i class="bi bi-arrow-repeat"></i>
                            @endif


                        </a>
                    @endif

                    @if(auth()->user()->can('Send Email'))
                    <a
                        class="btn btn-sm btn-light me-2 " data-bs-toggle="modal" data-bs-target="#emailmodal{{$user->id}}">
                            <i class="bi bi-envelope-at"></i>
                    </a>
                    @endif
                    {{-- @if(auth()->user()->can('Delete user'))
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                        style="display: inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger me-2">
                            <i class="bi bi-file-x-fill"></i>
                        </button>
                        </form>
                    @endif --}}

                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="emailmodal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{__('lang.sendemail').$user->name}}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                novalidate="novalidate" enctype="multipart/form-data" action="{{ route('users.sendemail') }}"
                                method="POST">
                                @csrf
                                <input type='hidden' value="{{$user->id}}" name='user_id'>
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.subject')
                                        }}</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <input type="text" name="subject"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="{{__('lang.subject')}}">
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
                                <!--begin::Input group-->
                                <div class="row mb-3">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('lang.message')
                                        }}</label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <textarea name="message" class="summernote"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "></textarea>
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
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
    <!--end::Tbody-->
</table>
<!--end::Table-->

<style>
    div.dt-top-container {
    display: grid;
    grid-template-columns: auto auto auto;
    }

    div.dt-center-in-div {
    margin: 0 auto;
    }

    div.dt-filter-spacer {
    margin: 10px 0;
    }
</style>


<script>
    $(document).ready(function() {
        var table = $('#kt_datatable_dom_positioning').DataTable({
            "searching": true,
            "ordering": true,
            responsive: true,
            dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<"dt-filter-spacer"f><ip>',
            buttons: [
                {
                extend: 'excelHtml5',
                text: '{{__('lang.exportexcel')}}',
                exportOptions: {
                columns: ':not(.no-export)' // Exclude columns with class 'no-export'
                },
                customize: function(xlsx) {
                // No need to hide the "Actions" column in this case
                }
                },
                {
                extend: 'pdfHtml5',
                text: '{{__('lang.exportpdf')}}',
                exportOptions: {
                columns: ':not(.no-export)' // Exclude columns with class 'no-export'
                },
                customize: function(xlsx) {
                // No need to hide the "Actions" column in this case
                }
                },

            ],

        });
        $('.filter').on('change', function() {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        if (val==='all'){
            table.column(3).search('.' ? '.' : '', true, false).draw();
        }else{
            table.column(3).search(val ? '^'+val+'$' : '', true, false).draw();
        }

        });
    });

</script>


