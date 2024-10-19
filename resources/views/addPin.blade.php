@php use \App\Http\Controllers\GlobalController; @endphp
@php use \App\Http\Controllers\ProjectController; @endphp
@php use \App\Http\Controllers\ConfigController; @endphp

@php  $questions = GlobalController::questions();@endphp
@php  $categories = GlobalController::categories();@endphp
@php  $subcategories = GlobalController::subcategories();@endphp
@php  $config = ProjectController::getConfig($project_id);@endphp
@php  $aspects = ConfigController::getAspects($config->id);@endphp
@php  $aspect_hierarchy = ConfigController::getHierarchy($config->id);@endphp
@php  $levels = ConfigController::getLevels($config->id);@endphp
@php  $questions = ConfigController::getQuestions($config->id);@endphp
@php  $question_locs = ConfigController::getQuestionLocs($config->id);@endphp
@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp
@extends('layouts.app')

@vite('resources/css/app.css')
@vite('resources/css/landing.css')


@section('main')

@vite('resources/css/dataCollection.css')
<?php 
$lat = $_GET['lat'] ?? null; 
$lng = $_GET['lng'] ?? null; 
?> 


<div id="main-container">
<script>
    
    <?php require_once("js/classnames.js");?>
    <?php require_once("js/utils.js");?>
                
    <?php require_once("js/ui/component/celement.js");?>
    <?php require_once("js/ui/component/contentElement.js");?>
    <?php require_once("js/ui/component/imageElement.js");?>
    <?php require_once("js/ui/component/logo.js");?>
    <?php require_once("js/ui/component/switch.js");?>
    <?php require_once("js/ui/component/textElement.js");?>
    <?php require_once("js/ui/container.js");?>
    <?php require_once("js/ui/panel/contentPanel.js");?>
    <?php require_once("js/ui/component/cbutton.js");?>
    <?php require_once("js/ui/component/hrElement.js");?>


    <?php require_once("js/ui/component/spanElement.js");?>
    <?php require_once("js/ui/component/inputElement.js");?>

    <?php require_once("js/ui/panelcomponent/question.js");?>
    <?php require_once("js/ui/panel/qPanel.js");?>

    <?php require_once("js/question/answerTree.js");?>
    <?php require_once("js/question/questionTree.js");?>
    <?php require_once("js/question/question.js");?>

    <?php require_once("js/parser/parser.js");?>
    <?php require_once("js/parser/question.js");?>

    <?php require_once("js/logic/illustration.js");?>
    
    

    const mainContainer = document.getElementById('main-container');
    const cats = {!! json_encode($categories) !!};
    const subcats = {!! json_encode($subcategories) !!};
    const questions = QuestionParser.make({!! json_encode($questions) !!});
    
    console.log({!! json_encode($levels) !!});
    // console.log({!! json_encode($aspect_hierarchy) !!});
    // console.log(questions);
    /*We know that questions belong to the same aspect by checking it in question_locs->aspect_id */

    let qtree = new QuestionTree({!! json_encode($aspect_hierarchy) !!}, 
                                 {!! json_encode($question_locs) !!},
                                questions);
    let answerTree = new AnswerTree();
    const qPanel = new QPanel('main-container');
    qPanel.initiate();
    qPanel.load(qtree, answerTree);

    const lat = {!! json_encode($lat) !!};
    const lng = {!! json_encode($lng) !!};

    function uuidv4() {
        return "10000000-1000-4000-8000-100000000000".replace(/[018]/g, c =>
            (+c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> +c / 4).toString(16)
        );
    }

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
                window.location.href = '/add-pin/post-error';
            }
        });

    }

    function submitData(place_data) {

        

        place_data["id"] = uuidv4();

        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
            var $inputs = $('input[type="file"]:not([disabled])', place_data);
            $inputs.each(function(_, input) {
                if (input.files.length == 0) {
                    $(input).prop('disabled', true);
                }
                
            });
        }

        const d = new FormData();
        d.set("longitude", place_data["longitude"].toString());
        d.set("latitude", place_data["latitude"].toString());

        if (place_data["comment"]!=undefined && place_data["comment"]!=null && place_data["comment"]!=""){
            d.set("comment", place_data["comment"].toString());
        }

        if (place_data["image"]!=undefined && place_data["image"]!=null && place_data["image"]!=""){
            d.set("image_name", `${uuidv4()}.${place_data["image"].name.split('.').pop()}`);
            d.set("image", place_data["image"]);
        }
        let cats = [];
        place_data["categories"].forEach((indata, i)=>{
            if (indata["grade"]!=null && indata["grade"]!=undefined){
                cats.push({
                "category_id": indata["id"],
                "grade": indata["grade"],
                "subgrades": indata.tags.filter(tag=>tag!=null && tag!=undefined && tag!="").map(tag=>tag.toString())
                });
            }
        });
        d.append("observations", JSON.stringify(cats));
        sendRequest(d, "save-all");
        window.location.href = '/add-pin/post-success';
    }
</script>
</div>
@endsection