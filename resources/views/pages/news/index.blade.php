@extends('layouts.app')

@section('title', "Новости — Русский Маяк")
@section('description', "Новости группы «Русский Маяк»: поездки в госпитали и зону СВО, релизы, концерты и благотворительные сборы.")
@section('canonical_path', "/news")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/news.js'])
@endsection

@section('content')

@endsection
