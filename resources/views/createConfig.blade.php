@extends('layouts.app')
<!-- @vite('resources/js/legal.js') -->
@vite('resources/css/legal.css')
@vite('resources/css/api.css')
@php use \App\Http\Controllers\ConfigController; @endphp
@php use \App\Http\Controllers\GlobalController; @endphp
@php use \App\Http\Controllers\CategoryController; @endphp
@php use \App\Http\Controllers\SubcategoryController; @endphp
@php $pages = GlobalController::pages();@endphp
@php $configs = ConfigController::all();@endphp
@php $categories = CategoryController::all();@endphp
@php $subcategories = SubcategoryController::all();@endphp

@section('main')
    <div class="main">
        @php $locale = session()->get('locale');  @endphp
        <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>

        <form id="configform" target="dummyframe" class="api">
            <label for="config">Choose a config file:</label>
            <select id="config" name="config"></select>
            <label for="configcategories">Choose categories to assign:</label>
            <select id="configcategory" name="configcategory"></select>
            <div>
                <label for="color">Color:</label>
                <input type="text" id="color" name="color"><br><br>
                <label for="low">Low:</label>
                <input type="text" id="low" name="low"><br><br>
                <label for="high">High:</label>
                <input type="text" id="high" name="high"><br><br>
            </div>
            <label for="configsubcategories">Choose subcategories to assign:</label>
            <select id="configsubcategory" name="configsubcategory"></select>
            <input type="submit" value="Submit">
        </form>
    <div>
        <script>
            
            const configInput = {!! json_encode($configs) !!};
            const categoryInput = {!! json_encode($categories) !!};
            const subcategoryInput = {!! json_encode($subcategories) !!};
            
            generateOptions("config", configInput.map(e=>e.name));
            generateOptions("configcategory", categoryInput.map(e=>e.name));
            generateOptions("configsubcategory", subcategoryInput.map(e=>e.name));

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
            document.getElementById("configform").addEventListener("submit", function (e) {
                    e.preventDefault();
                    const _form = Object.fromEntries(new FormData(e.target));
                    console.log(_form);
                    let d = new FormData();
                    
                    d.append("config_id", configInput.filter(c=>c.name==_form["config"])[0].id);
                    d.append("category_id", categoryInput.filter(c=>c.name==_form["configcategory"])[0].id);
                    d.append("color", _form["color"]);
                    d.append("low", _form["low"]);
                    d.append("high", _form["high"]);
                    d.append("subcategories", _form["configsubcategory"]);
                    console.log(d);

                    // output as an object
                    
                    sendRequest(d, "assign-config")
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