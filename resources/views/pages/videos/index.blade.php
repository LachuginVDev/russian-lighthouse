@extends('layouts.app')

@section('title', "Видео — концерты, поездки и интервью группы «Русский Маяк»")
@section('description', "Видеогалерея группы «Русский Маяк»: концертные съёмки, поездки в госпитали и зону СВО, документальные ролики и интервью.")
@section('canonical_path', "/video")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/video.js'])
@endsection

@section('content')

@endsection
