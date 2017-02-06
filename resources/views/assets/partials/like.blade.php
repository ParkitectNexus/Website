@if(\Auth::check())
    <like-button likes="{{ $asset->like_count }}"
          type="asset"
          id="{{ $asset->id }}"
          @if(\Auth::check())
             liked="{{ var_export(\Auth::user()->liked($asset), true) }}"
          @endif
          can-like="{{ $asset->canBeLiked() }}"
          is-buildoff="{{ $asset->inBuildOff() }}"
          num-likes="{{ $asset->like_count }}"

    >
    </like-button>
@else
    <div class="row">
        <div class="col-xs-6 text-center" title="Views">
            <i class="fa icon-xl fa-heart"></i>
        </div>
        <div class="col-xs-6 text-center" title="Downloads">
            <b>
                {{ $asset->like_count }}
            </b>

            <p>
                @if($asset->like_count == 1)
                    Person like this
                @else
                    People like this
                @endif
            </p>
        </div>
    </div>
@endif

<hr>