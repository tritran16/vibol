<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>News</title>
        <style>
            img {
                max-width: 100%;
                width: 100%;
                height: auto;
            }
            iframe {
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="content">
            {!! $news->translate(request('lang', 'en'))->content !!}
        </div>
    </body>
</html>
