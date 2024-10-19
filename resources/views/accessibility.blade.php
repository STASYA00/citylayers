@extends('layouts.app')
<!-- @vite('resources/js/legal.js') -->
@vite('resources/css/legal.css')

@php use \App\Http\Controllers\GlobalController; @endphp
@php  $pages = GlobalController::pages();@endphp

@section('main')
<script>
    </script>
    <div class="legalpanel">
        @php $locale = session()->get('locale');  @endphp
        <div class="legaltitle">
            Accessibility
    </div>
        <div class="legalbody">
            <div>
                City Layers make every effort to make our website accessible in accordance 
                with the <a href="https://www.parlament.gv.at/gegenstand/XXVI/I/574">Web Accessibility Act</a> ("Web-Zugänglichkeits-Gesetz" - WZG). 
                This declaration on Accessibility applies to the website and the corresponding web app, 
                hosted on a TU.it server and connected to the central TUW TYPO3 system.
                To fulfil the requirements of the Web-Zugänglichkeits-Gesetz (WZG) and 
                the <a href="https://www.w3.org/TR/WCAG21/">>Web Content Accessibility Guidelines (WCAG) 2.1</a>, level AA 
                we have implemented various accessibility features, including:
            </div>
            <div class="legaltextframed">
                A fully responsive design that works on all devices;
            </div>
            <div class="legaltextframed">
                Clear and consistent headings, labels, and instructions;
            </div>
            <div class="legaltextframed">
                High color contrast to make text and images easier to read.
            </div>
            <div>
                If you notice any barriers that prevent you from using our website, 
                please let us know by <a href="mailto:lovro.koncar-gamulin@tuwien.ac.at">e-mail</a>. We will check your request and contact 
                you as soon as possible.
                
            </div>
        </div>
        
    <div>
@endsection