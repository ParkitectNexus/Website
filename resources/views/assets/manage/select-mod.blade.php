@extends('layouts.wide')

@section('title')
    <h1>
        Provide the GitHub repository of your mod
    </h1>
@endsection

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <form method="post" action="{{ route('assets.manage.selectmod') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="github">GitHub Repository, Full url</label>
                        <input type="text" name="resource" class="form-control" id="github" value="{{ old('resource') }}" placeholder="https://github.com/ParkitectNexus/CoasterCam">
                    </div>
                    <div class="checkbox">
                        <label for="accept">
                            <input id="accept" type="checkbox" name="terms" >
                            I hereby declare that I am the owner or have permission to publish this repository/mod and
                            its contents. I grant permission to ParkitectNexus to distribute this mod to its users. I
                            added a license to my mod and I know that ParkitectNexus is not responsible for its users
                            that break that license. I take the responsibility for my own mod as far as the license
                            states. ParkitectNexus will take no responsibility at all.
                            <br>
                            tldr; ParkitectNexus is not responsible for anything.
                        </label>
                    </div>
                    <input type="submit" value="Go!" class="btn btn-primary">
                </form>
            </div>
        </div>
@endsection