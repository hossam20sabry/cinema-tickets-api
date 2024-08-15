@extends('admin.layout')

@section('content')
<div class="container my-4">
    @if (session('status'))
    <div class="row">
        <div class="col-md-12 box_shadow alert alert-success ">
            {{session('status')}}
        </div>
    </div>
    @endif
    @if (session('error'))
    <div class="row">
        <div class="col-md-12 box_shadow alert alert-danger ">
            {{session('error')}}
        </div>
    </div>
    @endif
    <div class="row center flex-space-between mx-1">
    
        <div class="col-md-4 box_shadow p-3 my-1">
            <a href="{{ route('admin.register') }}" class="btn btn-primary w-100 text-capitalize">add new Admin</a>
        </div>
        
    </div>
</div>
<div class="container mt-3">
    
    @if(isset($admins) && $admins->count() > 0)
    <table class="table table-secondary">
        <thead>
            <tr>
                <th class="table_responsive">id</th>
                <th class="table_responsive">name</th>
                <th>Email</th>
                <th>Main</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
            <tr>
                <th class="table_responsive">{{$admin->id}}</th>
                <td class="table_responsive">{{$admin->name}}</td>
                <td >{{$admin->email}}</td>
                
                <td>
                    @if($admin->main == 0)
                    <form action="{{ route('admin.main', $admin->id)}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Main</button>
                    </form>
                    @endif
                </td>
                <td>
                    @if($admin->main == 0)
                    <form action="{{ route('admin.delete', $admin->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h3 class="text-center">No bookings found with the email '{{ request()->get('search') }}'</h3>
    @endif
</div>
@endsection