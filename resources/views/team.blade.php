@php use \App\Http\Controllers\GlobalController; @endphp
@php use \App\Http\Controllers\ProjectController; @endphp
@php use \App\Http\Controllers\TeamController; @endphp


@php  $team = TeamController::all();@endphp
@php  $teamprojects = TeamController::teamProjects();@endphp
@php  $projects = ProjectController::all();@endphp

@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp

@extends('layouts.app')


@vite('resources/css/team.css')
@vite('resources/css/app.css')

@section('main')
   
            <script>
                <?php require_once("js/classnames.js");?>
                <?php require_once("js/logic/project.js");?>
                <?php require_once("js/logic/teamperson.js");?>
                <?php require_once("js/logic/state.js");?>

                
                <?php require_once("js/ui/component/celement.js");?>
                <?php require_once("js/ui/component/contentElement.js");?>
                <?php require_once("js/ui/component/imageElement.js");?>
                <?php require_once("js/ui/component/imageContainerElement.js");?>
                <?php require_once("js/ui/component/logo.js");?>
                <?php require_once("js/ui/component/partnerElement.js");?>
                <?php require_once("js/ui/component/closeButton.js");?>
                <?php require_once("js/ui/component/switch.js");?>
                <?php require_once("js/ui/component/textElement.js");?>
                <?php require_once("js/ui/component/linkElement.js");?>
                <?php require_once("js/ui/container.js");?>
                <?php require_once("js/ui/panel/contentPanel.js");?>
                <?php require_once("js/ui/component/projectComponent.js");?>
                
                
                <?php require_once("js/ui/panelcomponent/landing.js");?>
                <?php require_once("js/ui/panelcomponent/teamComponent.js");?>
                <?php require_once("js/ui/panel/legal.js");?>
                <?php require_once("js/ui/panel/teamPanel.js");?>

                
                const teamInput = {!! json_encode($team) !!};
                const roleInput = {!! json_encode($teamprojects) !!};
                const projectInput = {!! json_encode($projects) !!};
                
                console.log(teamInput);
                console.log(roleInput);
                console.log(projectInput);
                
                let team = teamInput.filter(p=>p.external==0)
                                    .map(p => new TeamPerson(p.id, p.name, p.link, 
                                                            roleInput.filter(r=>r.team_id==p.id)
                                                                     .map(r=> new Role(r.id, r.role, r.project_id, 
                                                                                projectInput.filter(proj=>proj.id==r.project_id
                                                                                ).length>0 ? projectInput.filter(proj=>proj.id==r.project_id)[0].name:"")),
                                                                      p.external));
                
                
                
                
                
                let page = new TeamPanel();
                page.initiate();
                page.load(team);



            </script>
            


        <!-- </div> -->

        


    <!-- </div> -->
    
@endsection
