@extends('layouts.app')
<!-- @vite('resources/js/legal.js') -->
@vite('resources/css/legal.css')
@vite('resources/css/api.css')
@php use \App\Http\Controllers\ProjectController; @endphp
@php use \App\Http\Controllers\GlobalController; @endphp
@php use \App\Http\Controllers\CategoryController; @endphp
@php use \App\Http\Controllers\SubcategoryController; @endphp
@php $pages = GlobalController::pages();@endphp
@php $projects = ProjectController::all();@endphp

@section('main')
    <div class="main">
        @php $locale = session()->get('locale');  @endphp
        <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>

        <form id="partnerform" target="dummyframe" class="api">
            <div> Add a new partner: </div>
            <div>
                <label for="partner">Partner:</label>
                <input type="text" id="name" name="name"><br><br>
                <label for="link">Link:</label>
                <input type="text" id="link" name="link"><br><br>
                <label for="image">Image:</label>
                <input type="text" id="image" name="image"><br><br>
            </div>
            <label for="project">Choose projects to assign:</label>
            <select id="project" name="project"></select>
            <input type="submit" value="Submit">
        </form>
    <div>
        <script>
            
            const projectInput = {!! json_encode($projects) !!};
            
            generateOptions("project", projectInput.map(e=>e.name));

            function generateOptions(selectId, options){
                let select = document.getElementById(selectId);
                
                for (var i = 0; i < options.length; i++) {
                    var option = document.createElement("option");
                    option.value = options[i];
                    option.text = options[i];
                    select.appendChild(option);
                }
            }
        
            $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            document.getElementById("partnerform").addEventListener("submit", function (e) {
                    e.preventDefault();
                    const _form = Object.fromEntries(new FormData(e.target));
                    console.log(_form);
                    let d = new FormData();
                    
                    d.append("project_id", projectInput.filter(c=>c.name==_form["project"])[0].id);
                    d.append("name", _form["name"]);
                    d.append("link", _form["link"]);
                    d.append("image", _form["image"]);
                    console.log(d);

                    // output as an object
                    
                    sendRequest(d, "save-partner")
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