@extends('layouts.app')

@section('content')
    <main-content
        :user="{{ Auth::user() }}"
    ></main-content>
@endsection
