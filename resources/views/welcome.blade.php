<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Swagger UI</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Source+Code+Pro:300,600|Titillium+Web:400,600,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('swagger/dist/swagger-ui.css') }}" >
        <link rel="icon" type="image/png" href="{{ asset('swagger/dist/favicon-32x32.png') }}" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ asset('swagger/dist/favicon-16x16.png') }}" sizes="16x16" />

        <!-- Styles -->
        <style>
            html
            {
                box-sizing: border-box;
                overflow: -moz-scrollbars-vertical;
                overflow-y: scroll;
            }
            *,
            *:before,
            *:after
            {
                box-sizing: inherit;
            }
            body
            {
                margin:0;
                background: #fafafa;
            }
        </style>
    </head>
    <body>
    <div id="swagger-ui"></div>

    <script src="{{ asset('swagger/dist/swagger-ui-bundle.js') }}"> </script>
    <script src="{{ asset('swagger/dist/swagger-ui-standalone-preset.js') }}"> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            data: {
                "_token": "{{ csrf_token() }}"
            },
        });

        var cookie_str = document.cookie;

        window.onload = function() {
            // Build a system
            const ui = SwaggerUIBundle({
                // url: url = window.location.protocol + "//" + window.location.hostname + ":" + window.location.port + "/swagger/swagger.json",
                // url: url = window.location.protocol + "//" + window.location.hostname + ":" + window.location.port + "/swagger/swagger.json",
                url: location.protocol + "/swagger/swagger.json",
                dom_id: '#swagger-ui',
                authorizations: {
                    csrf: function () {
                        var cookiearray = document.cookie.split(';');
                        for (var i = 0; i < cookiearray.length; ++i) {
                            if (cookiearray[i].trim().match('^XSRF-TOKEN=')) {
                                this.headers['RequestVerificationToken'] =
                                    cookiearray[i].replace(`XSRF-TOKEN=`, '').trim();
                            }
                        }
                        return true;
                    },
                },
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                data: {
                    "_token": cookie_str
                },
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout"
            });
            window.ui = ui
        }
    </script>
    </body>
</html>
