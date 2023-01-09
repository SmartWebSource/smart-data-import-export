@extends('smart-data-export-import::master')

@section('content')
    <div class="container">
        <div class="card mt-2 mb-2">
            <div class="card-header">
            {{ $table }} table's Import
            </div>
            <div class="card-body">
                <form action="{{ route('smart-data-export-import.import.file-upload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="table" value="{{ $table }}">
                    <div class="form-group">
                        <label for="excel-file">Excel file</label><br>
                        <input type="file" name="excel_file" class="form-control" id="excel-file">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary mb-2 mt-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection