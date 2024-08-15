@extends('admin.layout')

@section('content')
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('admin.kinds.index') }}" class="decoration_none"><h3 class="m_r text-capitalize">Kinds </h3></a><h3>. update</h3>
        </div>
    </div>
</div>
<div class="container my-4 ">
    <div class="row center">
        <div class="col-md-12 box_shadow p-3 m-2 alert alert-success" id="message" style="display: none">
            Kind is Updated successfully
        </div>

        <form class="forms-sample" id="showTimeForm">
            @csrf
            <div class="row box_shadow p-3">
                
                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="title" class="py-2">Title</label>
                        <input type="text"  class="form-control" name="title" id="title" placeholder="title" value="{{$kind->title}}">
                    </div>
                    
                    <div class="form-error py-1">
                        <p class="text-danger mb-3" id="title_error"></p>
                    </div>
                </div>

                
                <div class="col-6 my-3">
                    <label class="p-1" for=""></label>
                    <button type="submit" class="btn btn-primary w-100 mt-1">Update</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
</form>
<div class="mainSpinner d-none" id="mainSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>


@endsection
@section('script')
<script>
    $("#showTimeForm").submit(function(e){
        e.preventDefault();
        $('#message').hide();
        $('#mainSpinner').removeClass('d-none');
        $('#title_error').text('');
        let title = $("#title").val();
        let _token = $('input[name="_token"]').val();
        console.log(title);
        console.log(_token);
        $.ajax({
            url: "{{ route('admin.kinds.update', $kind->id) }}",
            method: "PUT",
            data: {
                title: title,
                _token: _token
            },
            success: function(data){
                if(data.status === true){
                    $("#message").show();
                    $("#showTimeForm")[0].reset();
                    $('#mainSpinner').addClass('d-none');
                    $("#title").val(data.title);
                }
            },
            error: function(reject){
                let response = $.parseJSON(reject.responseText);
                $('#mainSpinner').addClass('d-none');
                $.each(response.errors, function(key, value){
                    $("#"+key+"_error").text(value);
                })
            }
        })
        console.log('hi');
    })
</script>
@endsection