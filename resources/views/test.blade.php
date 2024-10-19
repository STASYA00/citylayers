@extends('layouts.app')
<!-- @vite('resources/js/legal.js') -->
@vite('resources/css/legal.css')

@php use \App\Http\Controllers\GlobalController; @endphp
@php use \App\Http\Controllers\CategoryController; @endphp
@php  $pages = GlobalController::pages();@endphp
@php $categories = CategoryController::all();@endphp

@section('main')
    <div class="main">
        @php $locale = session()->get('locale');  @endphp
        <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>

        <form id="configform" target="dummyframe">
            <label for="config_name">Config:</label>
            <input type="text" id="name" name="name"><br><br>
            <label for="config_descr">Description:</label>
            <input type="text" id="description" name="description"><br><br>
            
            <input type="submit" value="Submit">
        </form>

        <form id="projectform" target="dummyframe">
            <label for="Project_name">Project:</label>
            <input type="text" id="project_name" name="name"><br><br>
            <label for="project_descr">Description:</label>
            <input type="text" id="project_description" name="description"><br><br>
            <input type="submit" value="Submit">
        </form>

        <form id="catform" target="dummyframe">
            <label for="category_name">Category:</label>
            <input type="text" id="category_name" name="name"><br><br>
            <label for="category_descr">Description:</label>
            <input type="text" id="category_description" name="description"><br><br>
            <input type="submit" value="Submit">
        </form>
        
    <div>
        <script>
            $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            document.getElementById("configform").addEventListener("submit", function (e) {
                    e.preventDefault();
                    const _form = Object.fromEntries(new FormData(e.target));
                    let d = new FormData();
                    d.append("name", _form["name"]);
                    d.append("description", _form["description"]);

                    // output as an object
                    
                    sendRequest(d, "save-config")
            });
            document.getElementById("projectform").addEventListener("submit", function (e) {
                    e.preventDefault();
                    const _form = Object.fromEntries(new FormData(e.target));
                    let d = new FormData();
                    d.append("name", _form["name"]);
                    d.append("description", _form["description"]);

                    // output as an object
                    
                    sendRequest(d, "save-project")
            });
            document.getElementById("catform").addEventListener("submit", function (e) {
                const _form = Object.fromEntries(new FormData(e.target));
                    let d = new FormData();
                    d.append("name", _form["name"]);
                    d.append("description", _form["description"]);

                    // output as an object
                    
                    sendRequest(d, "save-category")
            });
            function sendRequest(d, url, callback) {
                return $.ajax({
                    type: 'POST',
                    url: `/${url}`,
                    data: d,
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function (data) {
                        if (callback!=undefined){
                            callback(data);
                        }
                        // window.location.href = '/add-pin/post-success';
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // window.location.href = '/add-pin/post-error';
                        console.log(textStatus, errorThrown);
                    }
                });

            }
        </script>
@endsection