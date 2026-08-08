@extends('layouts.app')

@section('title', "Концерты и афиша — Русский Маяк")
@section('description', "Афиша концертов группы «Русский Маяк»: благотворительные выступления, поездки с концертами в госпитали и зону СВО, акустические вечера.")
@section('canonical_path', "/concerts")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/concerts.js'])
@endsection

@section('content')

@endsection
