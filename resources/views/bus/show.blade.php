@extends('layouts.app')

@section('content')
    @php
        $totalseats = $bus->seats;
        $cols = 4;
        $rows = ceil($totalseats / $cols);
        $seatnumber = 1;
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4 text-center">
                <div class="card">
                    <div class="card-header text-uppercase">
                        <div class="float-start mt-2">
                            {{ $bus->name }}
                        </div>
                        <div class="float-end">
                            <a class="btn btn-outline-primary" href="{{ route('bus.index') }}">All Buses</a>
                        </div>
                    </div>
                    <div class="card-body me-4">
                        <div class="row justify-content-between">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <a class="btn btn-warning mt-2 mb-4" href="#">
                                    DRIVER
                                </a>
                            </div>
                        </div>
                        @for ($i = 0; $i < $rows; $i++)
                            <div class="row justify-content-between">
                                @for ($j = 0; $j < $cols; $j++)
                                    @if ($seatnumber <= $totalseats)
                                        <div class="col-md-2">
                                            @php
                                                $seatId = $seatnumber < 10 ? 'S0' . $seatnumber : 'S' . $seatnumber;
                                                $bookedSeat = null;
                                                foreach ($books as $book) {
                                                    if ($book['seatnumber'] === $seatId) {
                                                        $bookedSeat = $book;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <button type="button"
                                                class="btn
                                                @if ($bookedSeat) btn-outline-danger
                                                @else
                                                    btn-outline-success @endif
                                                mb-3"
                                                @if ($bookedSeat) data-bs-toggle="modal" data-bs-target="#exampleModal2"
                                                onclick="showBookingDetails('{{ $bookedSeat['username'] }}', '{{ $bookedSeat['gender'] }}', '{{ $bookedSeat['phone'] }}')"
                                                @else
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    onclick="setRecipient('{{ $seatId }}', '{{ $bus->name }}')" @endif>
                                                @if ($bookedSeat)
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Booked By: {{ $bookedSeat['username'] }}">
                                                        {{ $seatId }}
                                                    </a>
                                                    @else
                                                        {{ $seatId }}
                                                        @endif
                                            </button>
                                        </div>
                                        @php
                                            $seatnumber++;
                                        @endphp
                                    @else
                                        <div class="col-md-2"></div>
                                    @endif
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('book.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="bus-name" class="col-form-label">Bus ID:</label>
                            <input type="text" class="form-control bg-secondary text-white" name="busname" id="bus-name"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="seat-number" class="col-form-label">Seat Number:</label>
                            <input type="text" class="form-control bg-secondary text-white" name="seatnumber"
                                id="seat-number" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="userName" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="userName" name="username">
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="col-form-label">Gender:</label>
                            <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender"
                                required autocomplete="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                            </select>

                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="Phone" class="col-form-label">Phone Number:</label>
                            <input type="text" class="form-control" id="Phone" name="phone">
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Book</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional modal for viewing booked seats -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel2">View Booked Seats</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your code here to display the booked seats -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function setRecipient(recipientId, busId) {
            var modal = document.getElementById("exampleModal");
            var recipientInput = modal.querySelector("#seat-number");
            recipientInput.value = recipientId;

            var busIdInput = modal.querySelector("#bus-name");
            busIdInput.value = busId;
        }

        function showBookingDetails(username, gender, phone) {
            var modal = document.getElementById("exampleModal2");
            var modalBody = modal.querySelector(".modal-body");
            modalBody.innerHTML = `
            <p><strong>Username:</strong> ${username}</p>
            <p><strong>Gender:</strong> ${gender}</p>
            <p><strong>Phone:</strong> ${phone}</p>
        `;
        }
    </script>
@endsection
