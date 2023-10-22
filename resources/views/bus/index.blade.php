@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card p-0">
                <div class="card-header text-uppercase">
                    <div class="float-start mt-2">
                        All bus list
                    </div>
                    <div class="float-end">
                        <a class="btn btn-outline-primary" href="{{ route('bus.create') }}">Add Bus</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered border-primary">
                        <thead>
                            <tr class="text-uppercase">
                                <th scope="col">#</th>
                                <th scope="col">Bus Name</th>
                                <th scope="col">Num of Seats</th>
                                <th scope="col">Booked Seats</th>
                                <th scope="col">Available Seats</th>
                                <th scope="col" width="150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bus as $i => $item)
                                <tr>
                                    <th>{{ ++$i }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->seats }}</td>
                                    <td>
                                        @foreach ($buses as $bbb)
                                            @if ($bbb->id == $item->id)
                                                {{ $bbb->bookings->count() }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($buses as $bbb)
                                            @if ($bbb->id == $item->id)
                                                {{ $item->seats - $bbb->bookings->count() }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary text-uppercase"
                                            href="{{ route('bus.show', $item->id) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
