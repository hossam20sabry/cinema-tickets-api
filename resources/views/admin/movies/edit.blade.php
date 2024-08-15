@extends('admin.layout')

@section('content')
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('admin.movies.index') }}" class="decoration_none"><h3 class="m_r text-capitalize">movies </h3></a><h3>. update</h3>
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
                        <input type="text"  class="form-control" name="name" id="name" placeholder="Name" value="{{$movie->name}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="name_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text"  class="form-control" name="duration" id="duration" placeholder="Duration" value="{{$movie->duration}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="duration_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="director">Director</label>
                        <input type="text"  class="form-control" name="director" id="director" placeholder="director" value="{{$movie->director}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="director_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="lang">Langnuage</label>
                        <input type="text"  class="form-control" name="lang" id="lang" placeholder="lang" value="{{$movie->lang}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="lang_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <input type="decimal" min="1.0" max="10.0"  class="form-control" name="rating" id="rating" placeholder="rating" value="{{$movie->rating}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="rating_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <label for="kind">kind</label>
                    <select class="form-control"  id="kind" name="kind[]" multiple>
                    @foreach($movie->kinds as $kind)
                    <option value="{{$kind->id}}" selected>{{$kind->title}}</option>
                    @endforeach
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
                    @foreach($categories as $category)
                    <option @if($category->id == $movie->category->id) selected @endif value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                    </select>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="category_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="release_date">Release Date</label>
                        <input type="date"  class="form-control" name="release_date" id="release_date" placeholder="release_date"  value="{{$movie->release_date}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="release_date_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group ">
                        <label for="poster_url">Poster Url</label>
                        <input type="file"  class="form-control" id="poster_url" name="poster_url"  value="{{$movie->poster_url}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="poster_url_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group ">
                        <label for="photo_url">Photo Url</label>
                        <input type="file"  class="form-control" id="photo_url" name="photo_url"  value="{{$movie->photo_url}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="photo_url_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label for="trailer_url">Trailer Url</label>
                        <input type="file"  class="form-control" id="trailer_url" name="trailer_url"  value="{{$movie->trailer_url}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="trailer_url_error"></p>
                    </div>
                </div>

                <div class="col-6 my-2">
                    <label class="p-1" for="submit"></label>
                    <button type="submit" id="submit" class="btn btn-primary w-100 mt-1">Submit</button>
                </div>


                {{-- images --}}
                <div class="col-3">
                    <label for="" class="p-2">Poster</label>
                    <img src="/posters/{{$movie->poster_url}}" class="img-fluid" alt="">
                </div>
                <div class="col-4">
                    <label for="" class="p-2">Wide Poster</label>
                    <img src="/photos/{{$movie->photo_url}}" class="img-fluid" alt="">
                </div>
                <div class="col-5">
                    <label for="" class="p-2">Trailer</label>
                    <div class="ratio ratio-16x9 my-3">
                        <iframe src="/trailers/{{$movie->trailer_url}}" title="MOVIE TRAILER" allowfullscreen></iframe>
                    </div>
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
            url: "{{ route('admin.movies.update', $movie->id) }}",
            enctype: 'multipart/form-data',
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                if(data.status == true){
                    $('#mainSpinner').addClass('d-none');
                    $('#message').text(data.message);
                    $('#message').addClass('alert-success');
                    $('#message').show();
                    location.reload();
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
            }
        });
    });
</script>
@endsection