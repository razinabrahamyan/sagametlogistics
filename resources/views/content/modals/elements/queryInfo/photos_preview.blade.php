@if(!empty($query->photos))
    <h3 class="col-12 text-center">Фотографии</h3>
    <div id="carousel-example-caption-{{$query->id}}" class="carousel slide col-12"
         data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($query->photos as $key=>$photo)
                <li data-target="#carousel-example-caption-{{$query->id}}" data-slide-to="{{$key}}"
                    class="active"></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach($query->photos as $key=>$photo)
                <div class="carousel-item @if($key==0) active @endif">
                    @if(file_exists(public_path().'/storage/'.$photo))
                        <a id="single_image" href="{{asset('storage/'.$photo)}}">
                            <img class="img-fluid col-12 height-250" src="{{asset('storage/'.$photo)}}" alt="ssl"/>
                        </a>
                    @else
                        <a id="single_image" href="{{asset('images/no-image.webp')}}">
                            <img class="img-fluid col-12 height-250" src="{{asset('images/no-image.webp')}}" alt="ssl"/>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carousel-example-caption-{{$query->id}}"
           role="button"
           data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-example-caption-{{$query->id}}"
           role="button"
           data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@endif