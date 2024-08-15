@extends('admin.layout')

@section('content')
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('admin.movies.index') }}" class="decoration_none"><h3 class="m_r text-capitalize">movies </h3></a><h3>. create</h3>
        </div>
    </div>
</div>
<div class="container my-4 ">
    <div class="row center">
        <div class="col-md-12 box_shadow p-3 m-2 alert" id="message" style="display: none">
            
        </div>

        <form class="forms-sample" id="create_movie" enctype="multipart/form-data">
            @csrf
            <div class="row box_shadow p-3">
                
                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text"  class="form-control" name="name" id="name" placeholder="Name" value="{{old('name')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="name_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text"  class="form-control" name="duration" id="duration" placeholder="1h 35m" value="{{old('duration')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="duration_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="director">Director</label>
                        <input type="text"  class="form-control" name="director" id="director" placeholder="director" value="{{old('director')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="director_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="lang">Langnuage</label>
                        <input type="text"  class="form-control" name="lang" id="lang" placeholder="lang" value="{{old('lang')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="lang_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <input type="decimal" min="1.0" max="10.0"  class="form-control" name="rating" id="rating" placeholder="rating" value="{{old('rating')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="rating_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <label for="kind">kind</label>
                    <select class="form-control"  id="kind" name="kind[]" multiple>
                    @foreach($kinds as $kind)
                        <option value="{{$kind->id}}">{{$kind->title}}</option>
                    @endforeach
                    </select>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="kind_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <label for="category">Category</label>
                    <select class="form-control"  id="category" name="category">
                    <option value="">Select Category </option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                    </select>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="category_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="release_date">Release Date</label>
                        <input type="date"  class="form-control" name="release_date" id="release_date" placeholder="release_date"  value="{{old('release_date')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="release_date_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group ">
                        <label for="poster_url">Poster Url</label>
                        <input type="file"  class="form-control" id="poster_url" name="poster_url"  value="{{old('poster_url')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="poster_url_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group ">
                        <label for="photo_url">Photo Url</label>
                        <input type="file"  class="form-control" id="photo_url" name="photo_url"  value="{{old('photo_url')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="photo_url_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="trailer_url">Trailer Url</label>
                        <input type="file"  class="form-control" id="trailer_url" name="trailer_url"  value="{{old('trailer_url')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="trailer_url_error"></p>
                    </div>
                </div>



                <div class="col-6 my-2">
                    <label class="p-1" for="submit"></label>
                    <button type="submit" id="submit" class="btn btn-primary w-100 mt-1">Submit</button>
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

<script>
    $('#create_movie').submit( function(e){
        e.preventDefault();
        $('#mainSpinner').removeClass('d-none');
        $('#name_error').text('');
        $('#duration_error').text('');
        $('#director_error').text('');
        $('#lang_error').text('');
        $('#rating_error').text('');
        $('#kind_error').text('');
        $('#category_error').text('');
        $('#release_date_error').text('');
        $('#poster_url_error').text('');
        $('#photo_url_error').text('');
        $('#message').removeClass('alert-success');
        $('#message').removeClass('alert-danger');

        var formData = new FormData($('#create_movie')[0]); 

        $.ajax({
            url: "{{ route('admin.movies.store') }}",
            enctype: 'multipart/form-data',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                if(data.status == true){
                    $('#message').text(data.message);
                    $('#message').addClass('alert-success');
                    $('#message').show();
                    $('#create_movie')[0].reset();
                    $('#mainSpinner').addClass('d-none');
                    scrollTo(0, 0);
                }
                else{
                    $('#message').text(data.message);
                    $('#message').addClass('alert-danger');
                    $('#mainSpinner').addClass('d-none');
                    $('#message').show();
                }
            },
            error: function(reject){
                $('#mainSpinner').addClass('d-none');
                let response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, value){
                    $("#"+key+"_error").text(value);
                })
                scrollTo(0, 0);

            }
        });
    });
</script>
@endsection