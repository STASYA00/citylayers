@extends('layouts.app')
<!-- @vite('resources/js/legal.js') -->
@vite('resources/css/legal.css')

@php use \App\Http\Controllers\GlobalController; @endphp
@php  $pages = GlobalController::pages();@endphp

@section('main')
    <div class="main">
        @php $locale = session()->get('locale');  @endphp
        <div class="legalpanel">
        <div class="legaltitle">
            Impressum
        </div>
        <div class="legalbody">
            DEPARTMENT OF VISUAL CULTURE (E264-03) 
            <br>
            INSTITUTE OF ART AND DESIGN TU Wien
            <br>
            Karlsplatz 13/264-03, 1040 Vienna
            <br>
            +43 1 58801-26403 
            <br>
            visualculture@tuwien.ac.at
            <br>
        </div>
        </div></div>
@endsection