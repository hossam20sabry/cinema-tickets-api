@extends('home.layout')

@section('content')
<div class="container-fluid px-lg-5 mt-5">
    @if (count($bookings) > 0)
    <table class="table table-info">
        <tr>
            <th class="text-uppercase">movie</th>
            <th class="text-uppercase">theater</th>
            <th class="text-uppercase">day</th>
            <th class="text-uppercase table_responsive">time</th>
            <th class="text-uppercase table_responsive">booking status</th>
            <th class="text-uppercase table_responsive">tickets</th>
            <th class="text-uppercase table_responsive">total price</th>
            <th class="text-uppercase">show</th>
        </tr>
        <tbody>
            @foreach ($bookings as $booking)
            <tr>
                <td class="text-capitalize">{{$booking->movie->name}}</td>
                <td class="text-capitalize">{{$booking->ShowTime->theater->name}}</td>
                <td class="text-capitalize">{{$booking->ShowTime->date}}</td>
                <td class="text-capitalize table_responsive">{{$booking->ShowTime->start_time}}</td>
                <td class="text-capitalize table_responsive">{{$booking->booking_status}}</td>
                <td class="text-capitalize table_responsive">{{$booking->seats->count()}}</td>
                <td class="text-capitalize table_responsive">${{$booking->total_price}}</td>
                <td>
                    <a href="{{route('bookings.show', $booking->id)}}" class="btn btn-primary">show</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h3>No bookings found</h3>
    @endif
</div>
@endsection
