<hr class="v-double-margin">
<div class="row post {{ $post->trashed() ? 'deleted' : '' }}" id="post-{{ $post->id }}">
    <div class="col-xs-12 col-sm-2">
        <p class="avatar-info">
            <a href="{{ $post->user->getPresenter()->url() }}">{!! $post->userName !!}</a>
            <br>
            @if($post->user->flair != '')
                <span class="label label-primary">
                    {{ $post->user->flair }}
                </span>
            @endif
        </p>
        <p>
            <img class="avatar" src="{{ $post->user->getPresenter()->avatarUrl }}">
        </p>
        <p>
            <span>
                {{ $post->user->title }}
            </span>
        </p>
        <p class="user-statistics text-muted">
            {{ $post->user->assetCount }} Uploads
            <br>
            {{ $post->user->posts()->count() }} Posts
            <br>
            {{ $post->user->likeSum }} Likes
        </p>

        <p class="text-muted">
            Registered
            <br>
            {{ $post->user->getPresenter()->registrationDate }}
        </p>
        {{--<hr class="visible-xs">--}}
    </div>
    <div class="col-xs-12 col-sm-10 post-content">

        @if (!is_null($post->parent))
            <p>
                <strong>
                    {{ trans('forum/general.response_to', ['item' => $post->parent->userName]) }}
                    (<a href="{{ $post->parent->url }}">{{ trans('forum/posts.view') }}</a>):
                </strong>
            </p>
            <blockquote>
                {!! \PN\Social\MarkdownParser::parse(\Illuminate\Support\Str::limit($post->parent->content, 200)) !!}
            </blockquote>
        @endif

        @if ($post->trashed())
            <span class="label label-danger">{{ trans('forum/general.deleted') }}</span>
        @else
            {!! \PN\Social\MarkdownParser::parse($post->content) !!}
        @endif

        @if(Auth::user())
            <like-forum-post class="text-muted like"
                  num-likes="{{ $post->like_count }}"
                  type="post"
                  id="{{ $post->id }}"
                  can-like="{{\Auth::check()}}"
                  @if(\Auth::check())liked="{{ var_export(\Auth::user()->liked($post), true) }}"@endif>
            </like-forum-post>

        @endif
        <span class="text-muted">
            {{ trans('forum/general.posted') }} {{ $post->posted }}
            @if ($post->hasBeenUpdated())
                | {{ trans('forum/general.last_updated') }} {{ $post->updated }}
            @endif
        </span>
        <span class="pull-right">
        <a href="{{ $post->url }}">#{{ $post->id }}</a>
            @if (!$post->trashed())
                @can ('edit', $post)
                - <a href="{{ $post->editRoute }}">{{ trans('forum/general.edit') }}</a>
                @endcan
            @endif
            @if (!$post->trashed())
                - <a href="{{ $post->replyRoute }}">{{ trans('forum/general.reply') }}</a>
            @endif
            @if (Request::fullUrl() != $post->route)
                - <a href="{{ $post->route }}">Permalink</a>
            @endif
            @if (isset($thread))
                @can ('deletePosts', $thread)
                @if (!$post->isFirst)
                    <input type="checkbox" name="items[]" value="{{ $post->id }}">
                @endif
                @endcan
            @endif
        </span>
    </div>
</div>
