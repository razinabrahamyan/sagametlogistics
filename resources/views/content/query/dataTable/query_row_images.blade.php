<div class="container p-0">
    @if(!empty($query->photos))
        @if(!empty($query->photos[0]))
            @if(file_exists(public_path().'/storage/'.$query->photos[0]))
                <img class="col-5 img-fluid image-fancy-box table_row_img p-0"
                     src="{{asset('storage/'.$query->photos[0])}}"
                     alt="Second slide">
            @else
                <img class="col-5 img-fluid image-fancy-box table_row_img p-0"
                     src="{{asset('images/no-image.webp')}}" style="object-fit: contain"
                     alt="Second slide">
            @endif
        @endif
        @if(!empty($query->photos[1]))
            @if(file_exists(public_path().'/storage/'.$query->photos[1]))
                <img class="col-5 img-fluid image-fancy-box table_row_img p-0"
                     src="{{asset('storage/'.$query->photos[1])}}"
                     alt="Second slide">
            @else
                <img class="col-5 img-fluid image-fancy-box table_row_img p-0"
                     src="{{asset('images/no-image.webp')}}" style="object-fit: contain"
                     alt="Second slide">
            @endif
        @endif
    @else
        Нету
    @endif
</div>
{{--KILL Bill Gates--}}