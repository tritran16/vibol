<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>News</title>
    </head>
    <body>
        <div class="content">
            {!! $news->translate('en')->content !!}
        </div>
    </body>
</html>
