<!--begin::Table-->
<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <!--begin::Thead-->
    <thead>
        <tr class="fw-6 fw-semibold text-gray-600">
            <th class="min-w-250px">{{ __('lang.name') }}</th>
            <th class="min-w-100px">{{ __('lang.email') }}</th>
            <th class="min-w-100px">{{ __('lang.role') }}</th>
            <th class="min-w-100px">{{ __('lang.role') }}</th>
            <th class="min-w-150px">{{ __('lang.actions') }}</th>
        </tr>
    </thead>
    <!--end::Thead-->
    <!--begin::Tbody-->
    <tbody>
        @foreach ( $teachers as $teacher )
            <tr>
                <td>
                    <span class="badge badge-light-success fs-7 fw-bold">{{ $teacher->name }}</span>
                </td>
                <td>{{ $teacher->email }}</td>
                <td>
                    <span class="badge badge-light-success fs-7 fw-bold">{{ $teacher->roles->first()->name }}</span>
                </td>
                <td>
                    <span class="fs-7 fw-bold d-inline"><img src="{{ $teacher->image }}"
                    style="width: 50px; height: 50px; border-radius: 50% display: inline"> </span>
                </td>
                <td>
                    @if (auth()->user()->can('Update Teacher'))
                        @if (
                            $teacher->id == 1 &&
                                !auth()->user()->hasRole('superadmin'))
                            @continue
                        @endif
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-light me-2">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    @endif
                    @if(auth()->user()->can('Delete Teacher'))
                    @if ($teacher->id != 1)
                        <form method="POST" action="{{ route('teachers.destroy', $teacher->id) }}" style="display: inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger me-2">
                                <i class="bi bi-file-x-fill"></i>
                            </button>
                        </form>
                    @endif
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>
    <!--end::Tbody-->
</table>
<!--end::Table-->




<script>
    $(document).ready(function() {
        $('#kt_datatable_dom_positioning').dataTable({
            "searching": true,
            "ordering": true,
            responsive: true,
        });
    });
</script>
