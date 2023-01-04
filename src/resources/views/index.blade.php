@extends('smart-data-export-import::master')

@section('content')
<div class="container">
    <div class="card mt-2 mb-2">
        <div class="card-header">
        Table List
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($models as $model)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ (new $model)->getTable() }}</td>
                            <td>
                                <a href="{{ route('smart-data-export-import.table.columns', $model) }}" class="btn btn-sm btn-info">Columns</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection