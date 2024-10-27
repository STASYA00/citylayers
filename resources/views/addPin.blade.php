
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

    <?php require_once("js/graph/graph.js");?>
    
    let db = new DBConnection();
    let questions = [];

    // let project_name = "Urban%20Observations%202024";
    let project_name = {!! json_encode($project_name) !!};
    
    db.init()
                    
        .then(d=>{
            return db.read(QUERYS.CONFIG_QUESTIONS_HL, {"name": project_name.replaceAll("%20", " ")})
            .then(res =>{
                let questions = res.map(r=>[
                    r.get(GRAPH_KEYS.QUESTION).properties.value,
                    r.get(GRAPH_KEYS.QUESTION).properties.help,
                    r.get(GRAPH_KEYS.STEP).properties.step,
                ]
            ).sort((a,b)=>{return a[2]-b[2]})
             .map(r=>r[0])
             .filter(onlyUnique)
             .map(q=>new Question(q, res.filter(r=>
                    r.get(GRAPH_KEYS.QUESTION).properties.value==q)
                            .map(t=>t.get(GRAPH_KEYS.QUESTION).properties.help)[0],
                            res.filter(r=>
                    r.get(GRAPH_KEYS.QUESTION).properties.value==q)
                            .map(t=>t.get(GRAPH_KEYS.STEP).properties.step)[0]
                    ));
            
            let qas = questions.map((q, i)=>{
                let a = res.filter(r=>r.get(GRAPH_KEYS.QUESTION).properties.value==q.content)[0];
                let qaset = new QASet(i);
                qaset.add(new QAPair(q, AnswerParser.make(
                                    a.get(GRAPH_KEYS.ANSWER).properties.atype, 
                                    a.get(GRAPH_KEYS.ANSWER).properties)));
                return qaset;
                }
            );

            return qas;
        });
    }
        )
        .then(qas=>{
            console.log("stage 2", qas);
            return db.read(QUERYS.FOLLOWUP_QUESTIONS, {"name": project_name.replaceAll("%20", " ")})
                            .then(res =>{
                                let questions = res.map(r=>
                [
                    r.get(GRAPH_KEYS.QUESTION).properties.value,
                    r.get(GRAPH_KEYS.QUESTION).properties.help
                ]
            ).sort((a,b)=>{return a[2]-b[2]})
             .map(r=>r[0])
             .filter(onlyUnique)
             .map(q=>new Question(q, res.filter(r=>
                    r.get(GRAPH_KEYS.QUESTION).properties.value==q)
                            .map(t=>t.get(GRAPH_KEYS.QUESTION).properties.help)[0],
                            res.filter(r=>
                    r.get(GRAPH_KEYS.QUESTION).properties.value==q)
                            .map(t=>t.get(GRAPH_KEYS.STEP).properties.step)[0]
                    )).forEach((q, i)=>{
                let a = res.filter(r=>r.get(GRAPH_KEYS.QUESTION).properties.value==q.content)[0];
                return qas[q.step-1].add(new QAPair(q, AnswerParser.make(
                                    a.get(GRAPH_KEYS.ANSWER1).properties.atype, 
                                    // a.get(GRAPH_KEYS.ANSWER1).properties,
                                    res.filter(re=>re.get(GRAPH_KEYS.QUESTION).properties.value==q.content)
                                        .map(c=>c.get(GRAPH_KEYS.CHOICE).properties.name)
                                )))})
                
            return qas;
                }
            );
            
        })
        .then(
            qas=>{
                const mainContainer = document.getElementById('main-container');
                /*We know that questions belong to the same aspect by checking it in question_locs->aspect_id */

                let qtree = new QuestionTree({}, 
                                            {},
                                            questions);
                let answerTree = new AnswerTree();
                const qPanel = new QPanel('main-container');
                qPanel.initiate();
                console.log("--!", qas);
                qPanel.load(qas);
                // qPanel.load(qtree, answerTree);


            }
        )
    

    const lat = 10;
    const lng = 10;

    

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