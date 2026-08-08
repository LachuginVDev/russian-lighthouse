@extends('layouts.app')

@section('title', "Фотогалерея — Русский Маяк")
@section('description', "Фоторепортажи группы «Русский Маяк»: концерты, поездки в госпитали и зону СВО, гуманитарные акции и жизнь коллектива за кадром.")
@section('canonical_path', "/photos")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/photos.js'])
@endsection

@section('content')

@endsection
