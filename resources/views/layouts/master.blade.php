<!doctype html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('pagetitle', 'ParkitectNexus - Share your mods, blueprints and parks')</title>

    <meta name="description" content="Here you will find mods, coasters and parks created by players for Parkitect.  We already have 68 mods, 785 blueprints and 113 parks ready for download!"/>

    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link rel="stylesheet" media="screen" type="text/css" href="{{ mix('css/app.css') }}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/6.1.5/css/bootstrap-slider.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-markdown/2.10.0/css/bootstrap-markdown.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

    @yield('css')

    @yield('head')
</head>
<body>

<div id="app">
    @section('body')
        @include('partials.topbar')

        <div class="container v-margin">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- PN Top -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-2512015227578629"
                 data-ad-slot="3315984023"
                 data-ad-format="auto"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

        <div class="container" id="site">
            <div class="row">
                @yield('fullcontent')
            </div>
        </div>
        <div class="container" id="footer">
            @include('partials.footer')
        </div>
    @show
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/6.1.5/bootstrap-slider.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-markdown/2.10.0/js/bootstrap-markdown.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/commonmark/0.25.1/commonmark.min.js"></script>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
@yield('js')
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-67252152-1', 'auto');
    ga('send', 'pageview');

    ga('_setCustomVar', 1, 'logged_in', 'true', 2);
</script>
<noscript><p><img src="//piwik.parkitectnexus.com/piwik.php?idsite=1" style="border:0;" alt=""/></p></noscript>
</body>
</html>
