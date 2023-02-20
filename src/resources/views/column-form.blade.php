@extends('smart-data-export-import::master')

@section('content')
<div class="container">
    <div class="card mt-2 mb-2">
        <div class="card-header">
        {{ $table }} table's columns
        </div>
        <div class="card-body">
            <form action="{{ route('smart-data-export-import.export.download.excel') }}" method="POST">
                @csrf
                <input type="hidden" name="table" value="{{ $table }}">
                <div class="row">
                    <div class="col-1">
                        <input type="checkbox" name="" id="all-checked">
                    </div>
                    <div class="col-3 text-center">
                        Name
                    </div>
                    <div class="col-8 text-center">
                        Alias
                    </div>
                </div>
                @foreach ($columns as $column)
                    <div class="row mt-1">
                        <div class="col-1">
                            <input type="checkbox" name="columns[{{ $column }}][export]" value="yes">
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" readonly value="{{ $column }}">
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" placeholder="Column name in the excel file."  name="columns[{{ $column }}][alias]">
                        </div>
                    </div>
                @endforeach
                <div class="row mt-1">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-sm btn-success">Download</button>
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