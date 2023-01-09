@extends('smart-data-export-import::master')

@section('content')
<div class="container">
    <div class="card mt-2 mb-2">
        <div class="card-header">
        {{ $table }} table's columns mapping
        </div>
        <div class="card-body">
            <form action="{{ route('smart-data-export-import.import.excel') }}" method="POST">
                @csrf
                <input type="hidden" name="table" value="{{ $table }}">
                <input type="hidden" name="file_name_with_location" value="{{ $file_name_with_location }}">
                <div class="row">
                    <div class="col-1">
                        <input type="checkbox" name="" id="all-checked">
                    </div>
                    <div class="col-5">
                        Table Column Name
                    </div>
                    <div class="col-6">
                        Options
                    </div>
                </div>
                @foreach ($columns as $column)
                    <div class="row mt-1">
                        <div class="col-1">
                            <input type="checkbox" name="columns[{{ $column }}][import]" value="yes">
                        </div>
                        <div class="col-5">
                            <input type="text" class="form-control" readonly value="{{ $column }}">
                        </div>
                        <div class="col-6">
                            <select class="form-select" name="columns[{{ $column }}][equivalent]" id="">
                                <option value="">Select One</option>
                                @foreach ($headings as $heading)
                                    <option value="{{ $heading }}" {{ $column == $heading ? 'selected' : '' }}>{{ $heading }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
                <div class="row mt-1">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-sm btn-success">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        const allCheckedBtn = document.querySelector('#all-checked');
        allCheckedBtn.addEventListener('click', function(){
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = allCheckedBtn.checked;
            }
        });
    </script>
@endpush