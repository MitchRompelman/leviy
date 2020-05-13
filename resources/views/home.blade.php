@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    <div class="content">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <a class="btn margin-right" href="{{ route('csvDownload') }}">
            {{ __('Download CSV') }}
        </a>
        <a class="btn" href="{{ route('csvDownloadGenerated') }}">
            {{ __('Download Command generated CSV') }}
        </a>
    </div>
@endsection
