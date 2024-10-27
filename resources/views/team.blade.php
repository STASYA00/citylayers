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
                
                <?php require_once("js/ui/component/logo.js");?>
                <?php require_once("js/ui/component/partnerElement.js");?>
                <?php require_once("js/ui/component/closeButton.js");?>
                <?php require_once("js/ui/component/switch.js");?>
                <?php require_once("js/ui/component/textElement.js");?>
                <?php require_once("js/ui/component/linkElement.js");?>
                <?php require_once("js/ui/container.js");?>
                <?php require_once("js/ui/panel/contentPanel.js");?>
                <?php require_once("js/ui/component/projectComponent.js");?>
                <?php require_once("js/ui/component/imageContainerElement.js");?>
                
                <?php require_once("js/ui/panelcomponent/landing.js");?>
                <?php require_once("js/ui/panelcomponent/teamComponent.js");?>
                <?php require_once("js/ui/panel/legal.js");?>
                <?php require_once("js/ui/panel/teamPanel.js");?>

                <?php require_once("js/graph/graph.js");?>

                let db = new DBConnection();
                let team = [];
                let projects = [];

                db.init()
                .then(d=>
                        db.read(QUERYS.TEAM_PROJECT, {})
                        .then(res =>{
                            console.log(res);
                        
                        res.forEach(r => {
                            
                            let name = r.get('t').properties.name;
                            let link = r.get('t').properties.link;
                            if (team.filter(t=>t.name==name).length==0){
                                team.push(new TeamPerson(name, link, [], false));
                            }
                            let teamMember = team.filter(t=>t.name==name)[0];
                            teamMember.role.push(new Role(r.get('r').properties.value,
                                                            r.get('p').properties.name))
                        }
                            );
                            return team;
                        })
                    )
                
                
                .then(team=>
                    {let page = new TeamPanel("main");
                    page.initiate();
                    page.load(team);}
                    );
            </script>
    
@endsection
