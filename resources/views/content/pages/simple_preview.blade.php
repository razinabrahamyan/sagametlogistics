<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Заявка</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
          integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
          crossorigin="anonymous"/>

    @include('content/panels/styles')
</head>

<body class="vertical-layout vertical-menu-modern">
<div class="preloader">
    <div class="preloader__row">
        <div class="preloader__item"></div>
        <div class="preloader__item"></div>
    </div>
</div>
<div class="app-content" style="padding: 0 !important;">
    <div class="modal-content  fast-preview" style="border-radius: 0;">
        <div class="modal-header">
            <h3 class="modal-title" id="queryInfoTitle">Заявка #{{$query->id}}</h3>
        </div>
        <div class="modal-body row">
            @include('content.modals.elements.queryInfo.base_table',['query' => $query])
            @include('content.modals.elements.queryInfo.photos_preview',['query' => $query])
            @include('content.modals.elements.queryInfo.videos_preview',['query' => $query])
            @include('content.modals.elements.queryInfo.crew',['query' => $query])
        </div>
    </div>
</div>

@include('content.panels.scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
        integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
        crossorigin="anonymous"></script>
<script type="text/javascript">
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14
                , height: 14
            });
        }

        $().fancybox({
            selector: '.modal-body.row .carousel-item a',
            hash: false,
            thumbs: {
                autoStart: false
            },
        });
    })
</script>
</body>
</html>