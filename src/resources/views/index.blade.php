@extends('smart-data-export-import::master')

@section('content')
    <div class="container">
        @if (Session::has('smart-data-export-import-message'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ Session::get('smart-data-export-import-message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
                                <td>{{ (new $model())->getTable() }}</td>
                                <td>
                                    <a href="{{ route('smart-data-export-import.export.columns', $model) }}"
                                        class="btn btn-sm btn-primary" title="Export Data">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="{{ route('smart-data-export-import.import.file-upload', $model) }}"
                                        class="btn btn-sm btn-info" title="Import Data">
                                        <i class="fas fa-upload"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
