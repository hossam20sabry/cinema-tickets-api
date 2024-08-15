@extends('admin.layout')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-sm-3  mb-3 mb-sm-0">
            <div class="card text-bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Today Revenue</h5>
                    <p class="card-text red">${{$totalPrice}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3  mb-3">
            <div class="card text-bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Week Revenue</h5>
                    <p class="card-text red">${{$totalPriceWeek}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3  mb-3 ">
            <div class="card text-bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Month Revenue</h5>
                    <p class="card-text red">${{$totalPriceMonth}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3  mb-3">
            <div class="card text-bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Movies Counter</h5>
                    <p class="card-text red">{{$movies_count}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3  mb-3">
            <div class="card text-bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings Today</h5>
                    <p class="card-text red">{{$totalBookings}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3  mb-3">
            <div class="card text-bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings week</h5>
                    <p class="card-text red">{{$totalBookingsWeek}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3  mb-3">
            <div class="card text-bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings Month</h5>
                    <p class="card-text red">{{$totalBookingsMonth}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3  mb-3">
            <div class="card text-bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings Overall</h5>
                    <p class="card-text red">{{$allBookings}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2 border-bottom">
        <div class="col-sm-6">
            <h1 class="head-title text-center text-sm-start mt-2 text-uppercase">bookings</h1>
        </div>
        <div class="col-sm-6  d-flex justify-content-end">
            @error('search')
                    <p class="text-danger m-2 p-1">{{ $message }}</p>
            @enderror
            <form class="d-flex box_shadow m-2 p-1 rounded" role="search" action="{{ route('admin.bookings.search') }}" method="get">
                <input class="form-control me-2" type="search" placeholder="Search by email" name="search" aria-label="Search">
                <button class="btn btn-outline-info" type="submit">Search</button>
            </form>
        </div>
    </div>
    
    <table class="table table-secondary">
        <thead>
            <tr>
                <th class="table_responsive">id</th>
                <th class="table_responsive">auther</th>
                <th>Email</th>
                <th class="table_responsive">Total Tickets</th>
                <th class="table_responsive">Total Price</th>
                <th class="table_responsive">code</th>
                <th>Show</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
            <tr>
                <th class="table_responsive">{{$booking->id}}</th>
                <td class="table_responsive">{{$booking->user->name}}</td>
                <td >{{$booking->user->email}}</td>
                <td class="table_responsive">{{$booking->total_seats}}</td>
                <td class="table_responsive">${{$booking->total_price}}</td>
                <td class="table_responsive">{{$booking->QRcode}}</td>
                <td><a href="{{ route('admin.bookings.show', $booking->id)}}" class="btn btn-primary">show</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection