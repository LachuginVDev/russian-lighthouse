@extends('layouts.app')

@section('title', "Дискография — все альбомы группы «Русский Маяк»")
@section('description', "Полная дискография группы «Русский Маяк»: альбомы о силе духа, доме и передовой. Слушайте песни, которые звучат в госпиталях и в зоне СВО.")
@section('canonical_path', "/albums")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/albums.js'])
@endsection

@section('content')

@endsection
