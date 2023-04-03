@php
    $count = $subsicribers->count();
@endphp

@forelse ($subsicribers as $subscribe)
    <tr id="row_{{ $subscribe->id }}">
        <td>
            {{ $count }}
            @php
                $count--;
            @endphp
        </td>
        <td>{{ $subscribe->name }}</td>
        <td>{{ $subscribe->student_id }}</td>
        <td>{{ $subscribe->university->name }}</td>
        <td>{{ $subscribe->specialization->name }}</td>
        @canAny(['delete_university_id', 'edit_university_id'])
            <td>
                @can('edit_university_id')
                    <a href="{{ route('admin.subscribes.edit', $subscribe->id) }}" title="{{ __('admin.Edit') }}" type="button"
                        class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i>
                    </a>
                @endcan
                @can('delete_university_id')
                    <form class="d-inline delete_form" action="{{ route('admin.subscribes.destroy', $subscribe->id) }}"
                        method="POST">
                        @csrf
                        @method('delete')
                        <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete"> <i
                                class="fas fa-trash"></i>
                        </button>
                    </form>
                @endcan
            </td>
        @endcanAny
    </tr>
@empty
    <td colspan="12" style="text-align: center">
        <img src="{{ asset('adminAssets/dist/img/folder.png') }}" alt="" width="300">
        <br>
        <h4>{{ __('admin.NO Data Selected') }}</h4>
    </td>
@endforelse
