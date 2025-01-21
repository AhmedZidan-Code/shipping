@extends('Admin.layouts.inc.app')

@section('title')
    الطلبات
@endsection
@section('css')
    <style>
        <style>body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            gap: 20px;
        }

        .table {
            border: 2px solid #000;
            border-radius: 5px;
            overflow: hidden;
            width: 200px;
            background-color: #f9f9f9;
        }

        .header {
            background-color: #4CAF50;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .row {
            display: flex;
        }

        .cell {
            flex: 1;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        .table:nth-child(1) .header {
            background-color: #007bff;
        }

        .table:nth-child(2) .header {
            background-color: #d1613f;
        }

        .total-row {
            background-color: #ddd;
            font-weight: bold;
        }

        .cell {
            background-color: #e3f2fd;
        }
    </style>
@endsection
@section('content')
    {{-- <form action="{{ route('treasury.index') }}"> --}}
    <div class="row mb-3">
        <div class="col-md-4 ">
            <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> من تاريخ </span>

            </label>
            <input type="date" id="fromDate" value="{{ request('fromDate') ?? '' }}" name="fromDate"
                class="showBonds form-control">

        </div>
        <div class="col-md-4">
            <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> إلي تاريخ </span>

            </label>
            <input type="date" id="toDate" value="{{ request('toDate') ?? '' }}" name="toDate"
                class="showBonds form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary my-4" id="filter">بحث</button>
        </div>
    </div>

    {{-- </form> --}}

    <div class="card">

        <div class="card-body" id="content">

        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            $.ajax({
                url: '{{ route('daily-treasury.data') }}',
                type: 'GET',
                success: function(response) {
                    console.log(response.view);

                    $('#content').html(response.view);
                },
                error: function(xhr, status, error) {
                    console.log(erro);

                    $('#content').html('<p>Failed to fetch data.</p>');
                }
            });
        });
        $('#filter').on('click', function() {
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            $.ajax({
                url: '{{ route('daily-treasury.data') }}',
                type: 'GET',
                data: {
                    fromDate: fromDate,
                    toDate: toDate
                },
                success: function(response) {
                    console.log(response.view);

                    $('#content').html(response.view);
                },
                error: function(xhr, status, error) {
                    console.log(erro);

                    $('#content').html('<p>Failed to fetch data.</p>');
                }
            });

        })
    </script>
@endsection
