@extends('layouts.wide')

@section('title')
    <h1>
        {{ $page->title }}
    </h1>
@endsection

@section('content')
    @yield('download')
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#windows-panel" aria-controls="windows-panel" role="tab" data-toggle="tab">
                Windows
            </a>
        </li>
        <li role="presentation">
            <a href="#osx-panel" aria-controls="osx-panel" role="tab" data-toggle="tab">
                OSX
            </a>
        </li>
        <li role="presentation">
            <a href="#linux-panel" aria-controls="linux-panel" role="tab" data-toggle="tab">
                Linux
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="windows-panel">

            <div class="row">
                <div class="col-md-6"><img src="/img/client-screenshot-1.png" width="100%"></div>
                <div class="col-md-6">
                    <h2>Windows</h2>

                    {!! \PN\Social\MarkdownParser::parse($page->content) !!}
                    <a href="{{ route('client.downloadwin') }}" class="btn btn-primary btn-block btn-lg"
                       title="Download ParkitectNexus Client">Download ParkitectNexus Client</a>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="osx-panel">
            <div class="row">
                <div class="col-md-6"><img src="/img/client-screenshot-1.png" width="100%"></div>
                <div class="col-md-6">
                    <h2>OSX</h2>

                    {!! \PN\Social\MarkdownParser::parse($page->content) !!}
                    <h3>Requirements</h3>
                    <p>
                        Requires: <a href="http://download.mono-project.com/archive/4.4.2/macos-10-universal/MonoFramework-MDK-4.4.2.11.macos10.xamarin.universal.pkg">mono runtime</a>
                    </p>
                    <a href="{{ route('client.downloadosx') }}" class="btn btn-primary btn-block btn-lg"
                       title="Download ParkitectNexus Client">Download ParkitectNexus Client</a>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="linux-panel">
            <div class="row">
                <div class="col-md-6"><img src="/img/client-screenshot-1.png" width="100%"></div>
                <div class="col-md-6">
                    <h2>Linux (unofficial)</h2>

                    {!! \PN\Social\MarkdownParser::parse($page->content) !!}
                    <h3>Ubuntu</h3>
                    <div class="well well-lg">
                        <div>sudo add-apt-repository ppa:mpollind/parkitectnexus</div>
                        <div>sudo apt-get update</div>
                        <div>sudo apt-get install parkitect-nexus-client</div>
                    </div>
                    <h3>Requirements</h3>
                    <p>
                        Requires: <a href="http://www.mono-project.com/download/">mono runtime</a>
                    </p>
                    <a href="https://github.com/pollend/ParkitectNexusClient/releases" class="btn btn-primary btn-block" title="Download ParkitectNexus Client">Download</a>
                </div>
            </div>
        </div>
    </div>

    <h1>Change Log</h1>
    <client-history repository="{{ $change_log_repo }}" user="{{ $change_log_user }}"></client-history>

    <script type="text/html" id="client-history-template">
        <div class="history-container">
            <div v-for="result in results" class="history-entry">
                <a href="@{{result.html_url}}"><h4>@{{result.tag_name}}</h4></a>
                <div class="body" v-html="result.body"></div>
            </div>
        </div>
    </script>
@endsection
