@extends('layouts.columns')

@section('pagetitle')
    {{ $asset->name }} - ParkitectNexus
@endsection

@section('title')
    <h1>
        {{ $asset->name }}
    </h1>
@endsection

@section('sidebar')
    @if(\Gate::allows("update",$asset) || \Gate::allows("delete",$asset))
        <div id="update-section">
            @can('update', $asset)

                <a href="{{ route('assets.manage.update', [$asset->identifier]) }}" class="btn btn-primary btn-block">
                    Update
                </a>
            @endcan
            @can('delete', $asset)
                <form method="post" action="{{ route('assets.manage.delete', [$asset->identifier]) }}">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}

                    <input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary btn-block" value="Delete" />
                </form>
            @endcan

            <hr>
        </div>
    @endif

    @include('users.partials.profile', ['user' => $asset->getUser()])
    <hr>

    <div class="row">
        <div class="col-xs-6 text-center border-right" title="Views">
            <i class="fa fa-eye icon-xl"></i>

            <p>
                {{ $asset->view_count }}
            </p>
        </div>
        <div class="col-xs-6 text-center" title="Downloads">
            <i class="fa fa-download icon-xl"></i>

            <p>
                {{ $asset->download_count }}
            </p>
        </div>
    </div>

    <hr>

    @include('assets.partials.like')

    <div id="download-section" class="text-center">
        @if($asset->getPresenter()->canBeDownloaded())
            <a href="{{ $asset->getPresenter()->downloadUrl() }}" class="btn btn-primary btn-block">
                Download
            </a>
        @endif

        @if($asset->getPresenter()->canBeInstalled())
            <a href="{{ $asset->getPresenter()->installUrl() }}" class="btn btn-primary btn-block" onclick="registerDownload('asset', '{{ $asset->id }}');">
                Install with ParkitectNexus Client
            </a>

            <a href="{{ route('client.download') }}">
                Download client
            </a>
        @endif
    </div>

    @if($asset->type == 'mod')
        <h3>
            GitHub
        </h3>
        <a href="{{ $asset->getResource()->source }}" target="_blank">View this mod on GitHub</a>
    @endif

    @if(count($asset->getTags()) > 0)
        <h3>
            Tags
        </h3>
        <ul>
            @foreach($asset->getTags() as $tag)
                <li>
                    {{ $tag->tag }}
                </li>
            @endforeach
        </ul>
    @endif

    <hr>

    <div class="v-margin">
        {!! Ads::show('sidebar') !!}
    </div>
@endsection

@section('content')
    @include('assets.partials.slider', ['asset' => $asset])

    <div class="v-margin">
        {!! Ads::show('content') !!}
    </div>

    <div class="row">
        <div class="col-sm-12">
            {!! $asset->getPresenter()->description !!}
        </div>
    </div>

    <?php
    $stats = $asset->getResource()->getStats();
    $i = 0;
    ?>
    @if(count($stats) > 0)
        <div class="row">
            <div class="col-sm-4">
                @foreach($asset->getResource()->getPresenter()->getStatGroups() as $groupName => $groupStats)
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                {{ $groupName }}
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        @foreach($groupStats as $groupStat)
                            <tr>
                                <td>
                                    {{ $stats[$groupStat]['title'] }}
                                </td>
                                <td>
                                    {{ $stats[$groupStat]['value'] }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @if((++$i) % 2 == 0)
            </div>
            <div class="col-sm-4">
                @endif
                @endforeach
            </div>
        </div>
    @endif

    <div id="comments">
        @if(Auth::check())
            <div class="row">
                <div class="col-xs-12">
                    <form method="post" class="form-horizontal" action="{{ route('comments.store') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="asset_id" value="{{ $asset->id }}"/>

                        <div class="form-group">
                            <label for="comment" class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10">
                                <textarea id="comment" class="form-control" name="body"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <input type="submit" class="btn btn-primary" value="Post comment"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @foreach($comments as $comment)
            <hr>
            <div class="comment">
                <div class="comment-header">
                    @can('update', $comment)
                        <div class="comment-buttons">
                            <a href="{{ route('comments.edit', [$comment->id]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <form method="post" action="{{ route('comments.destroy', [$comment->id]) }}">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}

                                <button class="btn btn-primary">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endcan
                    <img src="{{ $comment->getUser()->getPresenter()->avatarUrl }}">

                    <a href="{{ $comment->getUser()->getPresenter()->url }}" title="{{ $comment->getUser()->username }}">
                        {{ $comment->getUser()->getPresenter()->displayName }}
                    </a>
                    <br>
                    {{ $comment->getPresenter()->timestamp }}
                </div>
                <div class="comment-body">
                    {!! $comment->getPresenter()->text !!}
                </div>
            </div>
        @endforeach
    </div>
@endsection
