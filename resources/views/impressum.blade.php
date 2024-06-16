@extends('layouts.app')
<!-- @vite('resources/js/legal.js') -->
@vite('resources/css/legal.css')

@php use \App\Http\Controllers\GlobalController; @endphp
@php  $pages = GlobalController::pages();@endphp

@section('main')
    <div class="main">
        @php $locale = session()->get('locale');  @endphp

        <script>
            <?php require_once("js/container.js");?>
            <?php require_once("js/legal.js");?>
            
        </script>

        <script>
            const pageInput = {!! json_encode($pages) !!};
            const url = location.href.split("/");
            const endpoint = url[url.length-1];
            
            let pageInfo = pageInput.filter(p=>
                p.title.toLowerCase().replaceAll(" ", "")==endpoint.toLowerCase()
            );
            const legalPanel = new LegalPanel("main", pageInfo);
            legalPanel.initiate();
            legalPanel.load();

        </script>
        
    <div>
@endsection