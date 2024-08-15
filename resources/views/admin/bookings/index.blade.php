@extends('admin.layout')

@section('content')
<div class="container mt-3">
    <div class="row mb-2 border-bottom">
        <div class="col-sm-6">
            <a href="{{ route('admin.bookings.index') }}" class="text-decoration-none text-dark">
                <h1 class="head-title text-center text-sm-start mt-2 text-uppercase">bookings</h1>
            </a>
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
    @if(isset($bookings) && $bookings->count() > 0)
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
    @else
    <h3 class="text-center">No bookings found with the email '{{ request()->get('search') }}'</h3>
    @endif
</div>
@endsection