<table class="table table-bordered crud-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Gaurd Name</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($role_list as $item)
            <tr>
                <th>{{ $item->id }}</th>
                <th>{{ $item->name }}</th>
                <th>{{ $item->guard_name }}</th>
                <td class="text-center">
                    <a href="{{ route($route_prefix . '.edit', $item) }}" class="btn btn-sm btn-success btn-edit-row">
                        <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;Modify
                    </a>
                    
                    <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-delete-row">
                        <i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;Delete
                    </a>

                    <form method="POST" class="form-delete-row" action="{!! route($route_prefix . '.destroy', $item) !!}" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row pull-right">
    <div class="col-md-12">
        {!! $role_list->links() !!}
    </div>
</div>