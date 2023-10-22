@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card p-0">
                <div class="card-header text-uppercase">
                    <div class="float-start mt-2">
                        Add bus
                    </div>
                    <div class="float-end">
                        <a class="btn btn-outline-primary" href="{{ route('bus.index') }}">All Buses</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('bus.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="inputBusname" class="form-label">Enter Bus Name</label>
                                <input type="text" class="form-control" id="inputBusname" name="busname">
                                @error('busname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="inputSeats" class="form-label">Enter Seats Count</label>
                                <input type="number" class="form-control" id="inputSeats" name="seats">
                                @error('seats')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
