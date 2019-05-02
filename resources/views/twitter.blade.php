<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <title>Koya Tweets</title>
</head>

<body>
    <div class="bs-component">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="/">Koyas Tweets</a>
        </nav>
    </div>
    <div class="container">
        <p></p>
        <form method="POST" action="{{route('posts.tweet')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Oh snap!</strong> {{$error}} .
                </div>
                @endforeach
            @endif
            <fieldset>
                <div class="form-group">
                    <label for="exampleTextarea">Tweet Message</label>
                    <textarea class="form-control" id="exampleTextarea" rows="2" name="tweet"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Upload Imgaes</label>
                    <input type="file" class="form-control-file" id="exampleInputFile" name="images[]" aria-describedby="fileHelp" multiple>
                    
                </div>
                <button type="submit" class="btn btn-primary">Post Tweet</button>
            </fieldset>
        </form>
        <p></p>
        @if(!empty($data)) @foreach($data as $key=>$value)
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                </div>
                <p class="mb-1">{{$value['text']}}
                    <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>{{$value['favorite_count']}}
                    <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>{{$value['retweet_count']}}
                </p>
                @if(!empty($value['extended_entities']['media'])) @foreach($value['extended_entities']['media'] as $img)
                <img src="{{$img['media_url_https']}}" width="200px"> @endforeach @endif
            </a>
        </div>
        <br> @endforeach @else
        <p>No tweets available</p>
        @endif

    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
toastr.options.closeButton = true;
@if(Session::has('error'))
toastr.error("{{ Session::get('error') }}",'',{timeOut: 4000});
@endif;
@if(Session::has('success'))
toastr.success("{{ Session::get('success') }}",'',{timeOut: 4000});
@endif;
</script>
</body>

</html>
