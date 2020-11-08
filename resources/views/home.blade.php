@extends('layouts.app')

@section('content')

                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="appContainer">
                        <router-view></router-view>
                    </div>
                </div>
@endsection
