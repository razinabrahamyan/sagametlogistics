@if(!empty($query->videos))
    <h3 class="col-12 text-center">Видео</h3>
    <div id="carousel-video-caption-{{$query->id}}" class="carousel slide col-12"
         data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($query->videos as $key=>$video)
                <li data-target="#carousel-video-caption-{{$query->id}}" data-slide-to="{{$key}}"
                    class="active"></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach($query->videos as $key=>$video)
                <div class="carousel-item @if($key==0) active @endif">
                    <a id="single_image"
                       href="{{asset('storage/'.$video)}}">
                        <video class="img-fluid col-12 height-250"
                               src="{{asset('storage/'.$video)}}"
                               alt="Second slide" autoplay loop muted playsinline>
                        </video>
                    </a>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carousel-video-caption-{{$query->id}}"
           role="button"
           data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-video-caption-{{$query->id}}"
           role="button"
           data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@endif