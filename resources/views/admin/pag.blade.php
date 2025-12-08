@extends('layouts.admin')

@section('title', $title ?? 'Admin')

@section('content')
<div class="container">
    <h1>{{ $title ?? 'Admin' }}</h1>
    <p>Page admin minimale pour: {{ $title ?? 'admin' }}.</p>
    {{-- Add more admin UI here as needed --}}
</div>
@endsection
