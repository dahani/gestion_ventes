var map,markers=[],mapx;materialAdmin.controller('headerCtrl', function($uibModal,$timeout,$scope,$rootScope,growlService,$state,LOADAPPINFOSERVICE){
        this.openSearch = function(){angular.element('#header').addClass('search-toggled');angular.element('#searchtopselect').find('input').focus();}
        this.closeSearch = function(){angular.element('#header').removeClass('search-toggled');}
       this.clicks=function(s){if($state.$current.name==s.obj.type){$rootScope.$broadcast(s.obj.type,{id:s.id,name:s.obj.extra,ob:s.obj});
		   }else{ $state.go(s.obj.type, {'data':{id:s.id,name:s.obj.extra,ob:s.obj}});}this.searchStr="";this.closeSearch();
	   }
	   this.NEWITEM={};
	   this.openSynthese = function(){$scope.instance=$uibModal.open({animation: true,templateUrl: 'views/fiche',scope: $scope,size: "sm",backdrop: true,keyboard: false})}
	   this.add2days=()=>{
		   this.NEWITEM.date2=moment.utc(this.NEWITEM.date1).add(2,"day").toDate();
	   }
	   $rootScope.NOTIFS=LOADAPPINFOSERVICE.getNotification();
	   $scope.INFO=LOADAPPINFOSERVICE.getSession();
	   $scope.$watch('NOTIFS.msg.count', function(newValue, oldValue) {if (newValue){if(newValue>oldValue){audioElement.play();}}});
	   $scope.$watch('NOTIFS.notif', function(newValue, oldValue) {if (newValue){if(newValue.length>oldValue.length){audioElement.play();}}});
	   var unregisterFn=$scope.$on('refreshNotif', function(event, data){$rootScope.NOTIFS=data.d1;});$scope.$on('$destroy', unregisterFn);
	   this.clearNotification = function($event) {
            $event.preventDefault();var x = angular.element($event.target).closest('.listview');var y = x.find('.lv-item');var z = y.size();angular.element($event.target).parent().fadeOut();
            x.find('.list-group').prepend('<i class="grid-loading hide-it"></i>');x.find('.grid-loading').fadeIn(1500);
            var w = 0;
            y.each(function(){var z = $(this);$timeout(function(){z.addClass('animated fadeOutRightBig').delay(1000).queue(function(){z.remove();});}, w+=150);
            })
            $timeout(function(){angular.element('#notifications').addClass('empty');}, (z*150)+200);
        }
		$scope.IS_FULL_SCREEN=true;
        this.fullScreen = function() {
            function launchIntoFullscreen(element) {if(element.requestFullscreen) {element.requestFullscreen();} else if(element.mozRequestFullScreen) {element.mozRequestFullScreen();} else if(element.webkitRequestFullscreen) {element.webkitRequestFullscreen();} else if(element.msRequestFullscreen) {element.msRequestFullscreen();}}
            function exitFullscreen() {if(document.exitFullscreen) {document.exitFullscreen();} else if(document.mozCancelFullScreen) {document.mozCancelFullScreen();}else if(document.webkitExitFullscreen) {document.webkitExitFullscreen();}}
            if (exitFullscreen()) {launchIntoFullscreen(document.documentElement);}else {launchIntoFullscreen(document.documentElement);};
			$scope.IS_FULL_SCREEN = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
        }
		this.shortcuts=[{title:'Profile',icon:'account',color:'red',url:"app.profile"},{title:"Coopératives",icon:"people",color:"pink",url:"app.settings.coop"},{title:"Infos",icon:"avatar6",color:"green",url:"app.settings.about"},{title:"Dépenses",icon:"coins",color:"blue",url:"app.deps"},{title:"Paramètres",icon:"settings",color:"teal",url:"app.settings.about"},{title:"Statistiques",icon:"chart-column",color:"orange",url:"app.statistiques"}];
}).controller('sessionsCrtl', function($scope,URL_API,$http,$timeout,growlService,$sce,$uibModal) {$scope.pageSize=5;
	$scope.URL=URL_API+"sessions";$scope.currentPage = 1;$scope.LISTE=[];$scope.TOTALITEMS=0;$scope.SELECTED_DATE=moment.utc().toDate();$par={animation: true,templateUrl: 'modalColor.html',scope: $scope,size: "lg",backdrop: true,keyboard: false};$scope.instance=null;
	$scope.load=function(){$scope.LoaDing = true;$http.post($scope.URL+"?action=load",{pg:$scope.currentPage,date:$scope.SELECTED_DATE}).then(function(e){if(e.data.test){$scope.LISTE=e.data.data.d;$scope.TOTALITEMS=e.data.data.count;
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing = false;
	},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing = false;})
	}
	$scope.sort = function(keyname,r){$scope.sortKey=keyname;$scope.reverse = !$scope.reverse;}
	$scope.pageChanged = function(){$scope.currentPage=n;$scope.load();}
	$scope.load();
	$scope.openGraph=function(s){var $chart=null;$scope.instance=$uibModal.open($par);$scope.LoaDinglist=true;
	$timeout(function(){
		$http.post($scope.URL+"?action=loadgraph",{id:s,m:("0"+($scope.SELECTED_DATE.getMonth()+1)).slice(-2),y:$scope.SELECTED_DATE.getFullYear()}).then(function(e){if(e.data.test){
		if($chart!=null)$chart.destroy();
		$chart=Highcharts.chart("chart_session",{chart:{type:"areaspline"},credits:{enabled:false},subtitle:{text:''+e.data.name},title: {text: 'Nombres des heures travaillée par jour'},xAxis: {type: 'category'},
        yAxis: {labels: {formatter: function() {return Highcharts.numberFormat(this.value/3600000,0);}},title: {text: 'Les Heures'},tickInterval: 3600000},tooltip: true, plotOptions: {series: {borderWidth: 0,dataLabels: {enabled: true,formatter: function() {return  this.y>0?Highcharts.dateFormat('%Hh%M',new Date(this.y)):'';}}}
        },xAxis: { type: 'category'},series:[{name:"Les Jours",dataLabels: {  enabled: true, rotation:0,color: '#FFFFFF',align: 'right', y: 10,style: { fontSize: '11px', fontFamily: 'Verdana, sans-serif'} },data:e.data.data,marker: {
                    fillColor: '#F39020'
                }}]});
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};
		$scope.LoaDinglist=false;
	},function(){$scope.LoaDinglist=false;})},2000)
	}
	$scope.cancel = function () {$scope.instance.close();};
	$scope.addDay=function(s){if(s==0){ $scope.SELECTED_DATE=(moment.utc($scope.SELECTED_DATE).add(1,"day").toDate());
	}else{ $scope.SELECTED_DATE=(moment.utc($scope.SELECTED_DATE).add(-1,"day").toDate());} $scope.load();}
}).controller('menuCtrl', function($scope,LOADAPPINFOSERVICE){
	$scope.INFO=LOADAPPINFOSERVICE.getSession();
	$scope.MY_MENU=LOADAPPINFOSERVICE.getPermissions();
	$scope.toggle=function(x){for(c in $scope.MY_MENU){if($scope.MY_MENU[c].icon!=x.icon){$scope.MY_MENU[c].toggled=false}}x.toggled=!x.toggled;}
}).controller('notificationsCtrl', function($scope,URL_API,$http,$timeout,growlService,$state) {
	$scope.URL=URL_API+"notifications";$scope.DATA=[];$scope.isCollapsed=false;
	$scope.load=function(){$scope.LoaDing = true;$http.post($scope.URL+"?action=load",{pg:$scope.currentPage}).then(function(e){if(e.data.test){$scope.DATA=e.data.data;}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing = false;
	},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing = false;})}
	$scope.goTo=function(to,id){$state.go(to, { 'data':{id:id,redirect:"app.notifications"}})}
	$scope.load();
	$scope.sendEmail=function(a){$scope.LoaDing = true;
		 $http.post(URL_API+"mailer/mail/creditemail?action&id="+a).then(function(e) {$scope.LoaDing = false;if(e.data.test){growlService.growl(e.data.msg||"Email Bien Evoyer",'info')}else{growlService.growl("Erreur d'envoi",'danger')}
		},function(res) {$scope.LoaDing =false;});
	}
}).controller('profileCtrl',function($scope,$http,URL_API,$timeout,growlService,$rootScope,LOADAPPINFOSERVICE ) {$scope.DATA={};
	$scope.description=false;$scope.URL=URL_API+"profile";$scope.loadingprofile=true;$scope.PAGE=1;$scope.open=false;
	$scope.save_password=function(){$rootScope.loadinng = true;
		$http.post($scope.URL+"?action=updatepass",{d:$scope.DATA}).then(function(e){if(e.data.test){growlService.growl(e.data.errors||'Bien Modifié', 'success');$scope.DATA.pass="";$scope.DATA.npass="";
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$rootScope.loadinng = false;
	},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);;$rootScope.loadinng = false;})
}
$scope.INFO=angular.copy(LOADAPPINFOSERVICE.getSession());$scope.DATA.email=$scope.INFO.email;
$scope.save=function(){ $scope.data=null;$scope.jdhjde = true;
		$http.post($scope.URL+"?action=save",{d:$scope.INFO}).then(function(e){if(e.data.test){
			$scope.description=false;$scope.info=false;$scope.open=false;$scope.infoextra=false;growlService.growl("Bien Enregistrer", 'success');
			LOADAPPINFOSERVICE.getSession().name=$scope.INFO.name;LOADAPPINFOSERVICE.getSession().email=$scope.INFO.email;LOADAPPINFOSERVICE.getSession().tel=$scope.INFO.tel;
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.jdhjde = false;
	},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.jdhjde = false;})
}
$scope.fileNameChanged=function($event){
	$scope.loadingprofile=true;
		$http({ method: 'POST',url: $scope.URL+'?action=photo',headers: {'Content-Type': undefined},
			data: {upload: $event.target.files[0]},eventHandlers: {progress: function (evt) {$scope.PERCENTt=(Math.round(evt.loaded * 100 / evt.total)+"%");}
        },
        uploadEventHandlers: {progress: function (evt) {if (evt.lengthComputable) {$scope.PERCENTt=( Math.round(evt.loaded * 100 / evt.total)+"%");} else {$scope.PERCENTt=""}}
        },
        transformRequest: function(data, headersGetter) {
          var formData = new FormData();formData.append("files", data.upload);formData.append("src",$scope.INFO.src);return formData;
        }
      }).then(function(res){growlService.growl(res.data.errors||'Bien Enregistrer', 'success');$event.target.value="";$scope.INFO.src=res.data.src;$scope.loadingprofile=false;$("#PROFILEPIC").attr('src',"img/?t=resize&w=60&h=60&url=profiles/"+res.data.src);
	  }, function(e){$scope.loadingprofile=false;;growlService.growl("Erreurs ...!", 'danger');});
}
}).controller('gestioncomptes', function($scope,$document,$http,URL_API,$filter,$timeout,growlService,LOADAPPINFOSERVICE,$rootScope) {
$scope.COMPTE=[];$scope.LOADING_ACCOUNT = false;$scope.URL=URL_API+"settings";$scope.TAB1=true;$scope.TMP_COMPT={};$scope.ADD=false;
$scope.resett2=function(){$scope.filter12='';}
	$scope.load=function(){$scope.LOADING_ACCOUNT = true;
		$http.post($scope.URL+"?action=loadAccountx").then(function(e){if(e.data.test){$scope.COMPTE=e.data.data;$scope.defaultMenu=e.data.menu;
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LOADING_ACCOUNT = false;
	},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LOADING_ACCOUNT =false;});
	}
	$scope.load();
	$scope.setAdmin=function(cn){$scope.LOADING_ACCOUNT = true;$http.post($scope.URL+"?action=setAdmin",{id:cn.id,admin:!cn.admin}).then(function(e){if(e.data.test){cn.admin=!cn.admin;growlService.growl("Compte ("+cn.name+(cn.admin==1?") est Administrateur":") est utilisateurs"), 'success');
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LOADING_ACCOUNT= false;
	},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LOADING_ACCOUNT = false;})
	}
	$scope.setAcive=function(d,id,name){$scope.LOADING_ACCOUNT = true;$http.post($scope.URL+"?action=setActive",{id:id,active:d}).then(function(e){if(e.data.test){growlService.growl("Compte ("+name+(d?") est Activé":") est Désactiver"), 'success');
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LOADING_ACCOUNT= false;
	},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LOADING_ACCOUNT = false;})
	}
	$scope.defaultPerm=function(){$scope.TMP_COMPT.menus=angular.copy($scope.defaultMenu);}
	$scope.deleteAccount=function(id,name,index ){
		swal({title: "supprimer ?",text: "Es-tu sûr de vouloir le supprimer",type: "warning",showCancelButton: true,showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",confirmButtonText: "Oui, Supprimer ("+name+")",closeOnConfirm: true
        }, function(){
		$rootScope.loadinng = true;
		$http.post($scope.URL+"?action=deleteAccount",{id:id}).then(function(e){if(e.data.test){$scope.COMPTE.splice(index,1);swal("Supprimé!",name+" est bien Supprimé!", "success");
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};;$rootScope.loadinng = false;
	},function(){$rootScope.loadinng=false ; growlService.growl("Pas de connexion Internet...!", 'danger',5000);;})});
	}
	$scope.setAccess=function(cn){var tmp=angular.copy(cn);
	$scope.TMP_COMPT=tmp;
	$scope.TAB1=false;$scope.ADD=false}
	$scope.accessBack=function(cn){$scope.TAB1=true;$timeout(function() {$scope.TMP_COMPT={};},500);}
	$scope.addUser=function(cn){$scope.TMP_COMPT={menus:angular.copy($scope.defaultMenu)};$scope.TAB1=false;$scope.ADD=true;}
	$document.on('click', function(e) {if ($(e.target.parentElement).parents('.sazsz2ze').length<=0) {$scope.$apply(function(){$scope.showDropdown2=false})}});
	$scope.saveNewAcount=function(){
		if($scope.ADD){
			if(typeoof($scope.TMP_COMPT.email)){growlService.growl("Entrer un email valide",'danger');return false;}
			if(typeoof($scope.TMP_COMPT.pass)){growlService.growl('Entrer le mot de pass','danger');return false;}
			if(typeoof($scope.TMP_COMPT.name)){growlService.growl('Entrer le nom et le prénom','danger');return false;};$scope.LOADING_ACCOUNT = true;
			$http.post($scope.URL+"?action=saveAccount",{data:$scope.TMP_COMPT}).then(function(e){if(e.data.test){
			$scope.COMPTE=e.data.data;$scope.accessBack();growlService.growl("Bien Enregistrer", 'success');
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LOADING_ACCOUNT= false;
	},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LOADING_ACCOUNT = false;})
		}else{
			if(typeoof($scope.TMP_COMPT.email)){growlService.growl("Entrer un email valide",'danger');return false;}
			if(typeoof($scope.TMP_COMPT.name)){growlService.growl('Entrer le nom et le prénom','danger');return false;}$scope.LOADING_ACCOUNT = true;
			$http.post($scope.URL+"?action=saveAccount",{data:$scope.TMP_COMPT}).then(function(e){if(e.data.test){
			$scope.COMPTE=e.data.data;$scope.accessBack();growlService.growl("Bien Modifié", 'success');
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LOADING_ACCOUNT= false;
		},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LOADING_ACCOUNT = false;})
		}
	}
}).controller('infosCtrl', function($scope,$http,LOADAPPINFOSERVICE,growlService) {
	$scope.PERCENTt=0;$scope.proggg=565.487;$scope.INFO=LOADAPPINFOSERVICE.getInfos();
	$scope.save=function(e){$scope.loadingprofile=true;
		$http({ method: 'POST',url:'php/fn?action=saveInfos',headers: {'Content-Type': undefined},data: {upload:document.getElementById("jpokp").files[0],info:$scope.INFO},eventHandlers: {progress: function (evt) {$scope.PERCENTt=(Math.round(evt.loaded * 100 / evt.total));$scope.proggg=((100-$scope.PERCENTt)/100)* Math.PI*(90*2);}},
        uploadEventHandlers: {progress: function (evt) {if (evt.lengthComputable) {$scope.PERCENTt=( Math.round(evt.loaded * 100 / evt.total));$scope.proggg=((100-$scope.PERCENTt)/100)* Math.PI*(90*2)} else {$scope.PERCENTt=""}}},
        transformRequest: function(data, headersGetter) {var formData = new FormData();formData.append("files", data.upload);;formData.append("info",angular.toJson(data.info));return formData;}
      }).then(function(e){if(e.data.test){LOADAPPINFOSERVICE.setInfos($scope.INFO);growlService.growl("Bien Enregistrer", 'success');
	  $scope.PERCENTt=0;$scope.proggg=565.487;
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.loadingprofile=false;
		},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.loadingprofile=false;});
	}
}).controller('tmplCtrl', function($scope,$http,URL_API,growlService) {$scope.TMPLS={credits:''};$scope.LoaDing=false;
	$scope.addText=function(t){var cursorPos = $("#emailTEXT").prop('selectionStart');var textBefore = $scope.TMPLS.credits.substring(0,  cursorPos);var textAfter  = $scope.TMPLS.credits.substring(cursorPos, $scope.TMPLS.credits.length);$("#emailTEXT").val(textBefore + t + textAfter);}
	$scope.save=function(e){$scope.LoaDing=true;$http.post(URL_API+"fn?action=saveTmpl",{data:$scope.TMPLS}).then(function(e){if(e.data.test){growlService.growl("Bien Enregistrer", 'success')}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing=false;},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing=false;;})}
	$http.post(URL_API+"fn?action=loadtmpl").then(function(e){$scope.TMPLS=e.data;$scope.LoaDing= false;
		},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing = false;})
}).controller('chatCtrl', function($scope,URL_API,growlService,LOADAPPINFOSERVICE,$http,$rootScope){var def={AutoD: {active: false, time: "0"},theme:{'bgcolor':'#00897b','primarycolor':'#ffffff','fontsize':16,'fontfamily':'Roboto'}};
$scope.skinList = [["#E91E63","#FFFFFF"],["#9C27B0","#FFFFFF"],["#673AB7","#FFFFFF"],["#3F51B5","#FFFFFF"],["#2196F3","#FFFFFF"],["#03A9F4","#FFFFFF"],["#00BCD4","#FFFFFF"],["#009688","#FFFFFF"],["#4CAF50","#FFFFFF"],["#8BC34A","#FFFFFF"],["#CDDC39","#FFFFFF"],["#ffe821","#000"],["#FFC107","#FFFFFF"],["#FF9800","#FFFFFF"],["#FF5722","#FFFFFF"],["#795548","#e9c01e"],["#9E9E9E","#FFFFFF"],["#607D8B","#FFFFFF"],["#000000","#FFFFFF"],["#ffffff","#000000"]];
$scope.FontsList = ['Roboto','Revalia','Rajdhani','cursive','Merienda','Electrolize','digital','monospace','Changa','Dancing','Teko','Righteous','Courgette','Orbitron','Philosopher','Bangers','Palanquin','Fira','Abril','Jura','Amaranth','Nova'];
	 $scope.CURPAGE=0;$scope.LoaDing = false;$scope.SESS=LOADAPPINFOSERVICE.getSession();
	 $scope.AutoDecon=angular.copy(LOADAPPINFOSERVICE.getConfigAuto());$scope.AutoDecon=$.extend({},def,$scope.AutoDecon);
	handleThemeUpdate($scope.AutoDecon.theme);handleThemeUpdate({'fontsize':$scope.AutoDecon.theme.fontsize+"px"});
	$("#thecolor").attr('content',$scope.AutoDecon.theme.bgcolor);
	$scope.setColor=function(){handleThemeUpdate({'primarycolor':$scope.AutoDecon.theme.primarycolor});}
	$scope.setBgColor=function(){$("#thecolor").attr('content',$scope.AutoDecon.theme.bgcolor);handleThemeUpdate({'bgcolor':$scope.AutoDecon.theme.bgcolor});}
	$scope.setColor3=function(s){$("#thecolor").attr('content',s[0]);handleThemeUpdate({'bgcolor':s[0],'primarycolor':s[1]});$scope.AutoDecon.theme.bgcolor=s[0];$scope.AutoDecon.theme.primarycolor=s[1];}
	$scope.setFonts = function (w) {$scope.AutoDecon.theme.fontfamily=w;handleThemeUpdate({'fontfamily':w});}
	$scope.SetFontSize = function () {handleThemeUpdate({'fontsize':$scope.AutoDecon.theme.fontsize+"px"});}
	LOADAPPINFOSERVICE.firtRun="ss";
	$scope.$watch('sidebarToggle.right', function(n, o){if (n !== o) {if(n==false){$scope.saveAuto(1)}}})
	$scope.reload=false;
	$scope.$watch('AutoDecon.header', function(n, o) {
		if(o!=n){$scope.reload=true;}
	});
	$scope.saveAuto=function(s){
		if($scope.AutoDecon.AutoD.active && $scope.AutoDecon.AutoD.time=='0'){growlService.growl("sélectionnez une durée", 'danger');return false;}
		$scope.LoaDing=true;
		$http.post(URL_API+"settings?action=saveAuto",{data:$scope.AutoDecon}).then(function(e){if(e.data.test){
			autodeconnexion({active:$scope.AutoDecon.AutoD.active,time:$scope.AutoDecon.AutoD.time});
			if(typeof s=="undefined"){growlService.growl("Bien Enregistrer", 'success');}
			LOADAPPINFOSERVICE.setConfigAuto($scope.AutoDecon);
			if($scope.reload){window.location.reload();}
	 	}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing=false;
	  },function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing=false;;})
	}
	$scope.seected_event=$scope.SESS.event||'...........';
	$scope.LOCALCONFIG= JSON.parse(localStorage.getItem('LOCALCONFIG'));
	$scope.chsdz=function(v,ind){localStorage.setItem("LOCALCONFIG",JSON.stringify($scope.LOCALCONFIG));}

	$scope.PRINTERS=[];
		try{startConnection().then(function(){
			qz.printers.find().then(function(data) {var list = [];
				for(var i = 0; i < data.length; i++) {list.push(data[i]);}
				$scope.$apply(function(){$scope.PRINTERS=list;});endConnection();
			})
		}).catch(handleConnectionError);}catch{}
	$scope.$on('$destroy', function(){console.log('$destroy info');endConnection();});

}).controller('configsCtrl', function($scope,growlService,URL_API,LOADAPPINFOSERVICE,$http){$scope.LoaDing = false;$scope.CONFIGS=LOADAPPINFOSERVICE.getInfos();
	$scope.save=function(e){$scope.LoaDing=true;$http.post(URL_API+"fn?action=saveInfos1",{data:$scope.CONFIGS}).then(function(e){if(e.data.test){growlService.growl("Bien Enregistrer", 'success')}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing=false;},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing=false;;})}
}).controller('materialadminCtrl', function($timeout, $http,$state,hotkeys,$rootScope, growlService,$scope,LOADAPPINFOSERVICE,data){
	LOADAPPINFOSERVICE.init(data);
	this.data=data;
	this.layoutType =data.config.header==2?0:localStorage.getItem('ma-layout-status');
        $rootScope.sidebarToggle = {left: false,right: false};this.$state = $state;this.listviewSearchStat = false;this.lvSearch = function() {this.listviewSearchStat = true; };this.lvMenuStat = false;
		$rootScope.IS_MOBILE=IS_MOBILE;
}).controller('statistiquesCtrl', function($timeout,$http, $state,URL_API, $scope,$rootScope,LOADAPPINFOSERVICE){$scope.URL=URL_API+"statistiques"; $scope.creator=$(".creator option:last").val();
	$scope.load=function(){$rootScope.loadinng = true;
		$http.post($scope.URL+"?action=load",{id:$scope.creator,f:moment.utc().format("YYYY-MM-DD"),d:moment.utc(new Date(moment.utc().year()+"-01-01")).format("YYYY-MM-DD")}).then(function(e){$scope.SHARED=e.data.globall;angular.forEach(e.data,function(el,indx){if(indx!="total"){$rootScope.$broadcast('php/statistiques?action='+indx,el.data);}});;$rootScope.loadinng = false;
	},function(){$rootScope.loadinng =false;});}
	$scope.load();
	$scope.globall=function(){$scope.loadinng = true;$http.post($scope.URL+"?action=globall",{id:$scope.creator}).then(function(e){$scope.SHARED=e.data;;$scope.loadinng = false;},function(){$scope.loadinng =false;});}

}).controller('st_modelCtrl',  function($scope,LOADAPPINFOSERVICE,URL_API,$state,$stateParams,$uibModal,growlService,$http,$rootScope) {$scope.PERMISSON=LOADAPPINFOSERVICE.getPermission($state.$current.name);$scope.URL=URL_API+"st_model";$scope.mois=$stateParams.table;$scope.currentPage=1;$scope.TOTALITEMS=0;$scope.DATA=[];$scope.pageSize=50;$scope.NEWITEM={}; $scope.listviewSearchStat = false;$scope.instance=null;$par={animation: true,templateUrl: 'myModalContent.html',scope: $scope,size: "md",backdrop: "static",keyboard: false};
$scope.TITLE=$stateParams.title;$scope.ARABE=$stateParams.arabe;
$scope.PRICE=$stateParams.price;
	$scope.table2Options={index:true,class:' teal hover ',sort:{sortBy:''},ajax:{url:$scope.URL,isSync:true},columns:[{name:"Nom",value:"name",orderable:true}]}
	$scope.add_ligne=function(){$scope.instance=$uibModal.open($par);$scope.NEWITEM={};$scope.selectedItem= null;}
    $scope.cancel = function () {$scope.selectedItem=null,$scope.NEWITEM={};$scope.instance.dismiss('cancel');};
	if($scope.PRICE){$scope.table2Options.columns.push({name:"Prix",value:"price",orderable:true})}
	$scope.save=function(){
		if(typeoof($scope.NEWITEM.name)){growlService.growl("Entrez le nom",'danger');return false;}
		if($scope.PRICE){if(typeoof($scope.NEWITEM.price)){growlService.growl("Entrez le Prix",'danger');return false;}}
		$rootScope.loadinng = true;
		$http.post($scope.URL+"?action=save_edit",{mois:$scope.mois,data:$scope.NEWITEM,q:$scope.serchfield,pg:$scope.currentPage,psiz:$scope.pageSize}).then(function(e){if(e.data.test){growlService.growl("Bien "+((typeof $scope.NEWITEM.id=="undefined")?"Enregistrer":"Modifier"), 'success');$scope.DATA=e.data.data.d;$scope.TOTALITEMS=e.data.data.count;$scope.NEWITEM=null;$scope.selectedItem=null;}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$rootScope.loadinng= false;$scope.instance.close();},function(e){ growlService.growl(e.data.errors||"Pas de connexion Internet...!", 'danger',5000);$rootScope.loadinng = false;$scope.instance.close();});
	}
	$scope.infos=function(){if ($scope.selectedItem != null) {var tmp=$scope.selectedItem;$scope.NEWITEM=angular.copy(tmp);$scope.instance=$uibModal.open($par);}else{growlService.growl("Sélectionner une ligne ...!", 'danger');}}
}).controller('depensesCtrl',  function($scope,LOADAPPINFOSERVICE,$state,URL_API,growlService,$http,$stateParams,$uibModal) {$scope.PERMISSON=LOADAPPINFOSERVICE.getPermission($state.$current.name);$scope.URL=URL_API+"depenses";$scope.CURPAGE=0;$scope.currentPage=1;$scope.TOTALITEMS=0;$scope.DATA=[];$scope.pageSize=50;$scope.NEWITEM={}; $scope.listviewSearchStat = false;$scope.mois="-1";$scope.excercice=new Date().getFullYear().toString();$scope.extra={};
	$scope.table2Options={asyncSort:true,index:true,class:' teal hover z-depth-1',sort:{sortBy:''},ajax:{url:$scope.URL,isSync:true},
		columns:[{name:"Montant",value:"mtn",sum:true,orderable:true,filter:"currency"},{name:"Date",value:"date_",orderable:true,filter:"date#EEEE dd LLLL yyyy"},{name:"Nature",value:"nrt",orderable:false},{name:"Motif",value:"motif",orderable:true},{name:"Crée Par",value:"cr",orderable:true},{width:"54px",name:"Image",value:"image",orderable:true,class:" p-0 ",orderable:false}
		]
	}

		$scope.functionx=function(x,td,ev){
			if(td.value=="image" && x.img!=""){ev.preventDefault();$.magnificPopup.open({items: {src: "img/ps/"+x.img},type: 'image'});
				$scope.selectedItem= null;return;
			}
		}
	$scope.modify=function(){$scope.INFO=false;}
	$scope.loadsearch=function(id){$scope.LoaDing = true;$http.post($scope.URL+"?action=load&id="+id).then(function(e){if(e.data.test){$scope.selectedItem=e.data.d[0]||{};$scope.infos();}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')}
		$scope.LoaDing = false;},function(){$scope.LoaDing = false;});}
	$scope.$on("app.depenses",function(ev,data){$scope.loadsearch(data.id);})
	if($stateParams.data!==null ){$scope.loadsearch($stateParams.data.id);}
	$scope.add_ligne=function(){$scope.INFO=false;$scope.NEWITEM={date_:new Date()};$scope.selectedItem= null ;$scope.class='Right';$scope.CURPAGE=1;}
	$scope.save=function(){
		if(typeoof($scope.NEWITEM.mtn)){growlService.growl("Entrez le Montant",'info');return false;}$scope.LoaDing = true;
		var fd = new FormData();fd.append("info",angular.toJson($scope.NEWITEM));
        fd.append('file', document.getElementById("ps").files[0]); document.getElementById("ps").value="";
		$http.post($scope.URL+"?action=save_edit",fd,{transformRequest: angular.identity,headers: {'Content-Type': undefined}}).then(function(e){if(e.data.test){growlService.growl("Bien Enregistrer", 'success');$scope.DATA=e.data.data.d;$scope.TOTALITEMS=e.data.data.count;$scope.NEWITEM=null;$scope.selectedItem=null;$scope.CURPAGE=0;
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing = false;
		},function(){ growlService.growl("Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing = false;});
	}
	$scope.infos=function(s){if ($scope.selectedItem != null) {$scope.INFO=(typeof s=="undefined");var tmp=$scope.selectedItem;tmp.date_=new Date(tmp.date_);$scope.class='Right';
	$scope.NEWITEM=angular.copy(tmp);$scope.CURPAGE=1;}else{growlService.growl("Sélectionner une ligne ...!", 'danger');}}
	$scope.cancellx=function(){$scope.class="Left";$scope.CURPAGE=0;$scope.selectedItem=null,$scope.NEWITEM={};}
}).controller('securiteCrtl', function($scope,$http,growlService) {$scope.currentPage=1;$scope.TOTALITEMS=0;$scope.DATA=[];$scope.pageSize=50; 
	$scope.table2Options={index:true,class:' teal hover ',sort:{sortBy:''},ajax:{url:"php/securite",isSync:true},
		columns:[{name:"Text",value:"text",orderable:true},{name:"Date",value:"date_",orderable:true,filter:"date#dd/MM/yyyy HH:mm:ss"},{name:"Envoyer Par mail",value:"mail",orderable:true}]
	}
}).controller('homeCrtl', function($scope,$rootScope,$http,growlService,LOADAPPINFOSERVICE) {
	$scope.box=[];
	for($i=1;$i<=6;$i++){
		$d={title:"title "+$i,color:"blue",cnt:$i,icon:'delete',bg:'blue',type:$i};
$scope.box.push($d);
	}
$scope.MySession=LOADAPPINFOSERVICE.getSession();
if(typeof OneSignal!="undefined"){
if(!OneSignal.__initAlreadyCalled){
var externalUserId=$scope.MySession.idx+"";
 window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({appId:"05e10fef-e24b-4945-8e21-4de6768b6e17"});
  });
  OneSignal.showSlidedownPrompt({force:true});
	OneSignal.on('subscriptionChange', function (isSubscribed) {
		console.log("subscriptionChange",isSubscribed);
	  OneSignal.getUserId(function(userId) {
		  if(isSubscribed==true){
			   //$http.post($scope.URL+"?action=push",{id:userId}).then(function(e){});
		  }
  });
  });
  
  OneSignal.push(function() {
  OneSignal.setExternalUserId(externalUserId);
});

$rootScope.logOut=()=>{
OneSignal.push(function() {
  OneSignal.removeExternalUserId().then(e=>{
	  location.href="logout";
  });
});
}
}
}else{
	$rootScope.logOut=()=>{location.href="logout";}
}
}).controller('notesCtrl',  function($scope,LOADAPPINFOSERVICE,$state,growlService,$http,$stateParams,$uibModal) {$scope.PERMISSON=LOADAPPINFOSERVICE.getPermission($state.$current.name);$scope.URL="php/note";$scope.CURPAGE=0;$scope.currentPage=1;$scope.TOTALITEMS=0;$scope.DATA=[];$scope.pageSize=10;$scope.NEWITEM={}; $scope.listviewSearchStat = false;$scope.instance=null;var $par={templateUrl:"notestmpl.html",animation: true,scope: $scope,size: "md",backdrop: "static",keyboard: false};
	$scope.table2Options={index:true,class:' teal hover ',sort:{sortBy:''},ajax:{url:$scope.URL,isSync:true},
		columns:[{name:"Date",value:"dt",orderable:true,width:"18%",filter:"date#EEEE dd LLLL yyyy HH:mm"},{name:"Text",value:"text",orderable:true}
		]
	}
	

		
	$scope.add_ligne=function(){$scope.INFO=false;$scope.NEWITEM={};$scope.selectedItem= null ;
	$scope.instance=$uibModal.open($par);
	}
	
	$scope.save=function(){
		$scope.LoaDing = true;$scope.NEWITEM.time=moment($scope.NEWITEM.date_).format("HH:mm:ss");

		$http.post($scope.URL+"?action=save_edit",{data:$scope.NEWITEM,q:$scope.serchfield,pg:$scope.currentPage,psiz:$scope.pageSize}).then(function(e){if(e.data.test){growlService.growl("Bien Enregistrer", 'success');$scope.DATA=e.data.data.d;$scope.TOTALITEMS=e.data.data.count;$scope.NEWITEM=null;$scope.selectedItem=null;$scope.instance.close();
		}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing = false;
		},function(){ growlService.growl("Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing = false;});
	}
	$scope.infos=function(s){if ($scope.selectedItem != null) {$scope.INFO=(typeof s=="undefined");var tmp=$scope.selectedItem;
	tmp.date_=new Date(tmp.date_);
	$scope.NEWITEM=angular.copy(tmp);$scope.instance=$uibModal.open($par);}else{growlService.growl("Sélectionner une ligne ...!", 'danger');}}
}).controller('fournisseursCtrl',  function($scope,$timeout,LOADAPPINFOSERVICE,$state,growlService,$http,$stateParams) {$scope.PERMISSON=LOADAPPINFOSERVICE.getPermission($state.$current.name);$scope.URL="php/fournisseurs";$scope.CURPAGE=0;$scope.currentPage=1;$scope.TOTALITEMS=0;$scope.DATA=[];$scope.pageSize=10;$scope.NEWITEM={}; $scope.listviewSearchStat = false;
$scope.table2Options={asyncSort:true,actions:'<li><a target="_blank" ng-href="export/office/sn_fournisseurs/{{selectedItem.id}}"><i class="zmdi zmdi-print"></i> Imprimer la synthèse du Fournisseur </a></li>',index:true,class:' teal hover ',sort:{sortBy:''},ajax:{url:$scope.URL},
	columns:[{name:"Nom/Raison sociale",value:"nom",orderable:true},{name:"I.F",value:"iff",orderable:true},{name:"Tel",value:"tel",orderable:true},{name:"CIN/R.C",value:"cin",orderable:true},{name:"Ville",value:"ville",orderable:true},{name:"Saisie par",value:"cr"},{width:"54px",name:"Image",value:"image",orderable:true,class:" p-0 ",orderable:false}
	]
}

 
$scope.functionx=function(x,td,ev){
	if(td.value=="image" && x.logo!=""){ev.preventDefault();$.magnificPopup.open({items: {src: "img/coop/"+x.logo},type: 'image'});
		$scope.selectedItem= null;return;
	}
}
$scope.goTo=function(){$state.go("app.sn_fournisseur", {'data':{id:$scope.selectedItem.id,name:$scope.selectedItem.nom}});}
$scope.modify=function(){$scope.INFO=false;}
$scope.infosAll=function(id){$scope.LoaDing = true; $http.post($scope.URL+"?action=getall",{id:id}).then(function(e){
	$scope.selectedItem=$scope.CLX=e.data.data;
	$scope.LOTS.DATA=$scope.CLX.lots.d;$scope.LOTS.TOTALITEMS=$scope.CLX.lots.count;

$scope.CURPAGE=4;$scope.class='Right';$scope.LoaDing = false;},function(){$scope.LoaDing = false;});
}
;$scope.$on("app.settings.fournisseurs",function(ev,data){$scope.infosAll(data.id);})
if( $stateParams.data!==null ){$scope.infosAll($stateParams.data.id);}
$scope.add_ligne=function(){document.getElementById("jpokpjj").value="";$scope.INFO=false;$scope.NEWITEM={};$scope.selectedItem= null ;$scope.class='Right';$scope.CURPAGE=1;$timeout(()=>{angular.element(".fileinput-exists").click();},500);}
$scope.save=function(e){
	$scope.loadingprofile=true;
	//if(angular.isDate($scope.NEWITEM.date_n)){$scope.NEWITEM.date_n=$scope.NEWITEM.date_n.toUTC();}
	$http({ method: 'POST',url:$scope.URL+"?action=save_edit",headers: {'Content-Type': undefined},
		data: {upload:document.getElementById("jpokpjj").files[0],info:$scope.NEWITEM},eventHandlers: {progress: function (evt) {$scope.PERCENTt=(Math.round(evt.loaded * 100 / evt.total));$scope.proggg=((100-$scope.PERCENTt)/100)* Math.PI*(90*2);}
	},
	uploadEventHandlers: {progress: function (evt) {if (evt.lengthComputable) {$scope.PERCENTt=( Math.round(evt.loaded * 100 / evt.total));$scope.proggg=((100-$scope.PERCENTt)/100)* Math.PI*(90*2)} else {$scope.PERCENTt=""}}
	},
	transformRequest: function(data, headersGetter) {
	  var formData = new FormData();formData.append("files", data.upload);;formData.append("info",angular.toJson(data.info));return formData;
	}
  }).then(function(e){if(e.data.test){$scope.RELOAD();growlService.growl("Bien Enregistrer", 'success');$scope.CURPAGE=0;$scope.PERCENTt=0;$scope.proggg=565.487;document.getElementById("jpokpjj");$scope.DATA=e.data.data.d;$scope.TOTALITEMS=e.data.data.count;$scope.selectedItem=null;
	}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.loadingprofile=false;$scope.PERCENTt=0;$scope.proggg=565.487;
	},function(){ growlService.growl("Pas de connexion Internet...!", 'danger',5000);$scope.loadingprofile=false;});
}
$scope.infos=function(s){if ($scope.selectedItem != null) {if(typeof s=="undefined"){$scope.infosAll($scope.selectedItem.id);return;}var tmp=$scope.selectedItem;$scope.class='Right';
$scope.NEWITEM=angular.copy(tmp);$scope.CURPAGE=1;$timeout(()=>{angular.element(".fileinput-exists").click();},500);}else{growlService.growl("Sélectionner une ligne ...!", 'danger');}}
$scope.cancellx=function(){$scope.class="Left";$scope.CURPAGE=0;$scope.selectedItem=null,$scope.NEWITEM={};}


$scope.LOTS={serchfield:'',autoLoad:false,currentPage:1,TOTALITEMS:0,DATA:[],pageSize:10,id:$scope.DOSSIER,index:true,class:'card teal hover ',sort:{sortBy:''},ajax:{url:$scope.URL+"?action=lots"},columns:[{name:"Lot n°",value:"lot",orderable:true},{name:"N° Facture",value:"bl",orderable:true},{name:"Date Entrée",value:"date_en",orderable:true,filter:"date#dd/MM/yyyy"},{name:"Total",value:"total",orderable:true,sum:true},{name:"Quantité",value:"qn",orderable:true,sum:true},{name:"Date péremption",value:"date_pre",orderable:true,filter:"date#dd/MM/yyyy"},{name:"Remarque",value:"rm",orderable:true},{name:"Saisie par",value:"name"}]
}


}).controller('produitsCtrl',  function($scope,$timeout,growlService,$http,$stateParams,iosAlertView,LOADAPPINFOSERVICE,$state) {$scope.PERMISSON=LOADAPPINFOSERVICE.getPermission($state.$current.name);;$scope.URL="php/produits";$scope.CURPAGE=0;$scope.currentPage=1;$scope.TOTALITEMS=0;$scope.DATA=[];$scope.pageSize=10;$scope.NEWITEM={}; $scope.listviewSearchStat = false;$scope.PERCENTt=0;$scope.proggg=565.487; 
$scope.table2Options={asyncSort:true,index:true,class:' teal hover ',sort:{sortBy:''},ajax:{url:$scope.URL},
	columns:[{name:"Nom",value:"name",orderable:true},{name:"Code",value:"code",orderable:true},{name:"Prix",value:"prix",orderable:true},{name:"Q. Min",value:"qn_min",orderable:true},{name:"Taux TVA",value:"tva",orderable:true},{width:"54px",name:"Image",value:"image",orderable:true,class:" p-0 ",orderable:false}
	]
}
/*get product onscan*/
$scope.loadsearch=function(id){$scope.LoaDing = true;$http.post($scope.URL+"?action=load&code="+id).then(function(e){if(e.data.test){if(!e.data.d[0]){$scope.LoaDing = false;growlService.growl("not found ...!", 'danger');return};$scope.selectedItem=e.data.d[0]||{};$scope.infos(1);}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')}
	$scope.LoaDing = false;},function(){$scope.LoaDing = false;});
};

onScan.attachTo(document, {
suffixKeyCodes: [13],
onKeyDetect:function(){return false},
reactToPaste: true, 
onScan: function(sCode, iQty) {console.log(sCode);
	if($scope.CURPAGE==1 && !$scope.NEWITEM.id){
		$scope.NEWITEM.code=sCode;
	}else{
		if($scope.listviewSearchStat){$scope.serchfield=sCode;$scope.RELOAD();}else{
			if(!isNaN(parseInt(sCode))){$scope.loadsearch(sCode);}
		}
		
	}
		
},
onKeyDetect: function(iKeyCode){return false},
onScanError: function(oDebug) { console.log('onScanError: ',oDebug); },
onScanButtonLongPress: function() { console.log('onScanButtonLongPress: '); }
});
$scope.$on('$destroy', function(){try{onScan.detachFrom(document)}catch{}});

$scope.functionx=function(x,td,ev){
	if(td.value=="image" && x.img!=""){ev.preventDefault();$.magnificPopup.open({items: {src: "img/produits/"+x.img},type: 'image'});
		$scope.selectedItem= null;return;
	}
}

$scope.modify=function(){$scope.INFO=false;}




$scope.VENTES={serchfield:'',autoLoad:false,currentPage:1,TOTALITEMS:0,DATA:[],pageSize:10,id:$scope.DOSSIER,index:true,class:' teal hover ',sort:{sortBy:''},ajax:{url:$scope.URL+"?action=vente"},columns:[{name:"Date Vente",value:"date_vente",orderable:true,filter:'date#dd/MM/yyyy'},{name:"Quantité",value:"q",orderable:true,sum:true},{name:"N° ",value:"n_facture",orderable:true},{name:"Prix",value:"prix",orderable:true},{name:"Vendus par",value:"resp",orderable:true}]
}

$scope.infosAll=function(id,code){$scope.kdenkleeze = true; $http.post($scope.URL+"?action=getall",{id:id,code:code}).then(function(e){$scope.selectedItem=$scope.CLX=e.data.data;
$scope.VENTES.DATA=$scope.CLX.ventes.d;$scope.VENTES.TOTALITEMS=$scope.CLX.ventes.count;
	$scope.CURPAGE=4;$scope.class='Right';$scope.kdenkleeze = false;},function(){$scope.kdenkleeze = false;});
}
$scope.$on("app.produits",function(ev,data){$scope.infosAll(data.id);})
if( $stateParams.data!==null ){$scope.infosAll($stateParams.data.id);}



$scope.add_ligne=function(){$timeout(()=>{angular.element(".fileinput-exists").click();},500);$(".img_preview").attr("src","");$scope.INFO=false;$scope.NEWITEM={};$scope.selectedItem= null ;$scope.class='Right';$scope.CURPAGE=1;$scope.PERCENTt=0;$scope.proggg=565.487;}
$scope.save=function(){
	$scope.LoaDing = true; 
	$http({ method: 'POST',url: $scope.URL+'?action=save_edit',headers: {'Content-Type': undefined},data: {upload:document.getElementById("logoimg").files[0],pg:$scope.currentPage,psiz:$scope.pageSize,info:$scope.NEWITEM},eventHandlers: {progress: function (evt) {$scope.PERCENTt=(Math.round(evt.loaded * 100 / evt.total));$scope.proggg=((100-$scope.PERCENTt)/100)* Math.PI*(90*2);}},uploadEventHandlers: {progress: function (evt) {if (evt.lengthComputable) {$scope.PERCENTt=( Math.round(evt.loaded * 100 / evt.total));$scope.proggg=((100-$scope.PERCENTt)/100)* Math.PI*(90*2)} else {$scope.PERCENTt=""}}
	},transformRequest: function(data, headersGetter) {
	  var formData = new FormData();formData.append("files", data.upload);;formData.append("info",angular.toJson(data.info));return formData;
	}
  }).then(function(e){if(e.data.test){growlService.growl("Bien Enregistrer", 'success');document.getElementById("logoimg").value="";$scope.DATA=e.data.data.d;$scope.TOTALITEMS=e.data.data.count;$scope.selectedItem=null;$scope.CURPAGE=0;/*jQuery.ajax({type: 'GET',crossDomain: true,dataType: 'jsonp',url:e.data.url,success: function(jsondata){}});*/$scope.serchfield="";$timeout(()=>{angular.element(".fileinput-exists").click();},500);
	}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing = false;$scope.PERCENTt=0;$scope.proggg=565.487;
	},function(a,b,c){growlService.growl("Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing = false;});
}
$scope.infos=function(s){$timeout(()=>{angular.element(".fileinput-exists").click();},500);if ($scope.selectedItem != null) {if(typeof s=="undefined"){$scope.infosAll($scope.selectedItem.id);return;}var tmp=angular.copy($scope.selectedItem);$scope.class='Right';
$scope.NEWITEM=tmp;$scope.CURPAGE=1;}else{growlService.growl("Sélectionner une ligne ...!", 'danger');}}
$scope.cancellx=function(){$scope.class="Left";$scope.CURPAGE=0;$scope.selectedItem=null,$scope.NEWITEM={};}
}).controller('ventesCtrl',  function($scope,$document,$uibModal,hotkeys,LOADAPPINFOSERVICE,$rootScope,$timeout,$state,iosAlertView,growlService,$http,$stateParams) {$scope.PERMISSON=LOADAPPINFOSERVICE.getPermission($state.$current.name);$scope.URL="php/ventes";$scope.CURPAGE=0;$scope.currentPage=1;$scope.TOTALITEMS=0;$scope.DATA=[];$scope.pageSize=10;$scope.NEWITEM={}; $scope.listviewSearchStat = false;$scope.dizabled=false;$scope.mois="-1";$scope.excercice=new Date().getFullYear().toString();$scope.TMP={};$scope.STAST={};$scope.SESSX=LOADAPPINFOSERVICE.getSession();
$scope.table2Options={actions:'<li><a target="_blank" ng-href="export/pdf/facture/{{selectedItem.id}}"><i class="zmdi zmdi-print"></i> Imprimer Facture</a></li><li><a target="_blank" ng-href="export/pdf/bl/{{selectedItem.id}}"><i class="zmdi zmdi-invoice2"></i> Imprimer BL</a></li>',index:true,class:' teal hover ',sort:{sortBy:''},ajax:{url:$scope.URL,isSync:true},
	columns:[{name:"Date Vente",value:"vd",orderable:true,filter:"date#EEEE dd LLLL yyyy"},{name:"N° BL",value:"n_facture",orderable:true},{sum:true,name:"Total ",value:"total",orderable:true,filter:"currency#''"},
	{name:"Quantité",sum:true,value:"q",orderable:true},{name:"Nbr Produits",value:"nbr",orderable:true},{name:"Client",value:"cl",orderable:true},{name:"Mode p.",value:"mode",orderable:true},{name:"Statut",value:"statut",orderable:true,class:"p-relative"},{name:"Vendus par",value:"cr",orderable:true}]
}

$scope.PrintPdf=function(s){
	if(s=="PDF"){
		QzPrintPdf("export/pdf/facture/"+$scope.INFOS.id+"&t=S");
	}else if(s=="PDFBL"){
		QzPrintPdf("export/pdf/bl/"+$scope.INFOS.id+"&t=S");
	}
	
}
$scope.sendEmail=function(a){var url=a==0?"export/pdf/facture/":"export/pdf/bl/";$scope.LoaDing = true;
	 $http.post(url+$scope.selectedItem.id+"&t=M").then(function(e) {$scope.LoaDing = false;
		if(e.data.test){growlService.growl(e.data.msg||"Facture Bien Evoyer",'info')}else{growlService.growl("Erreur d'envoi",'danger')}
	},function(res) {$scope.LoaDing =false;});
}

$scope.printticket=function(s){if ($scope.INFOS != null && !IS_MOBILE) {printRaw($scope.INFOss,angular.copy($scope.INFOS),$scope.SESSX);}else{growlService.growl("Sélectionner une ligne ...!", 'danger');}}
$scope.instance=null;
$scope.popUpCheque=function(){if($scope.NEWITEM.mode_p==2){$scope.instance=$uibModal.open({animation: true,templateUrl: 'chaquedata.html',scope: $scope,size: "md",backdrop: "static",keyboard: false});}}

$scope.LOCALCONFIG= JSON.parse(localStorage.getItem('LOCALCONFIG'))||{AutoSelect:false,backToList:true};$scope.INFOss=LOADAPPINFOSERVICE.getInfos();
if($scope.LOCALCONFIG.printicket==true){startConnection();}



$scope.chsdz=function(v,ind){if(!IS_MOBILE){if($scope.LOCALCONFIG.printicket==true){startConnection();}else{endConnection();}};localStorage.setItem("LOCALCONFIG",JSON.stringify($scope.LOCALCONFIG));}
$scope.looacode=function(sCode){$scope.LoaDing = true;
	 $http.post("php/filter?action=code&code="+sCode, {code:sCode}).then(function(res) {console.log(res);$scope.LoaDing = false;
	if(typeof res.data[0]!="undefined"){$scope.TMP=angular.copy(res.data[0]);if($scope.LOCALCONFIG.AutoSelect){$scope.add_line();}else{$scope.txnshe=$scope.TMP.name;}}
	},function(res) {$scope.LoaDing =false;});
	}
$scope.onLoad=function(d){$scope.lastnum=d.num;}
$scope.$on('DELETE_DATATABLE', function(event, data){$scope.lastnum=data.data.data.num;});
$scope.onSelect = function (r) {$scope.TMP=angular.copy(r.obj);$scope.TMP.name=$scope.TMP.namex;$scope.TMP.q=1;if($scope.LOCALCONFIG.AutoSelect){$scope.add_line();};$("input.qntt")[0].focus()}

onScan.attachTo(document, {
suffixKeyCodes: [13],
onKeyDetect:function(){return false},
reactToPaste: true, 
onScan: function(sCode, iQty) {console.log(sCode, iQty);
	if($scope.CURPAGE==0){$scope.add_ligne();}
	$timeout(function() {$scope.looacode(sCode);},200)
},
onScanError: function(oDebug) { console.log('onScanError: ',oDebug); },
onScanButtonLongPress: function() { console.log('onScanButtonLongPress: '); }
});

$scope.add_ligne=function(){$scope.dizabled=false;$scope.INFO=false;$scope.TMP={};$scope.STAST={};$scope.NEWITEM={ch:{},mode_p:"1",n_facture:$scope.lastnum,items:[],date_vente:new Date(),cr:$scope.SESSX.name};$scope.selectedItem= null ;$scope.class='Right';$scope.CURPAGE=1;if(!IS_MOBILE){$timeout(function() {$(".autocompletedh input.getfocus")[0].focus()},300)}}
$scope.add_line=function(){
	if($scope.TMP.q<=0){growlService.growl("Ajouter une quantité différente de 0",'danger');return false;}
	if($scope.TMP.q>$scope.TMP.qt){growlService.growl("La quantité saisie est supérieur de la quantité disponible ",'danger');$scope.TMP.q=$scope.TMP.qt;}
	if(typeoof($scope.TMP.id) || typeoof($scope.TMP.q)){growlService.growl("Sélectionnez un produit et une quantité différente de 0",'danger');return false;}
	var ty=$scope.checkinarray($scope.TMP);
	if(ty==22){growlService.growl("La quantité saisie est supérieur de la quantité disponiblex ",'danger');return;}
	if(ty==true){$scope.TMP={};$scope.txnshe="";return;};$scope.TMP.rm=$scope.TMP.rm||0;
	$scope.TMP.rm=($scope.LOCALCONFIG.isper)?$scope.TMP.rm:parseFloat((($scope.TMP.rm/$scope.TMP.prix)*100).toFixed(2));
	$scope.TMP.tt=(($scope.TMP.prix*$scope.TMP.q)-($scope.TMP.prix*$scope.TMP.rm*$scope.TMP.q)/100).toFixed(2);
	$scope.NEWITEM.items.push(angular.copy($scope.TMP));$scope.TMP={};$scope.txnshe="";
}
$scope.SetClient = function (r) {$scope.STAST=r.obj;}

$scope.Q_change = function () {if($scope.TMP.q>$scope.TMP.qt){growlService.growl("La quantité saisie est supérieur de la quantité disponible ",'info');$scope.TMP.q=$scope.TMP.qt;}}
$scope.checkinarray=function(d){var v=false;angular.forEach( $scope.NEWITEM.items, function(value, key) {if( value.id==d.id){
	$scope.NEWITEM.items[key].q+=d.q;
		$scope.NEWITEM.items[key].tt=(($scope.NEWITEM.items[key].prix*$scope.NEWITEM.items[key].q)-($scope.NEWITEM.items[key].prix*$scope.NEWITEM.items[key].rm*$scope.NEWITEM.items[key].q)/100).toFixed(2);v=true;return true;}});return v;}
$scope.delet=function(x,id){if(typeoof(id)){$scope.NEWITEM.items.splice(x,1); }else{
	iosAlertView.confirm('êtes vous sûr de supprimer ?').then(function(p) {                
	if (p!==null) {$scope.LoaDing = true;
	$http.post($scope.URL + "?action=deletell", {dl:id}).then(function(res) {$scope.LoaDing = false;$scope.NEWITEM.items.splice(x,1)},function(res) {$scope.LoaDing =false;});}})}
}

$scope.save=function(){
	if($scope.NEWITEM.total+$scope.STAST.reste>$scope.STAST.crpl && $scope.NEWITEM.mode_p==3){if(!confirm('le Plafond de credit sera dépassé après cette transaction. Souhaitez vous continuer')){return;}else{$scope.NEWITEM.crd={crpl:$scope.STAST.crpl,reste:$scope.NEWITEM.total+$scope.STAST.reste};}}
	if(typeoof($scope.NEWITEM.date_vente)){growlService.growl("Entrez date Vente",'danger');return false;}
	if($scope.NEWITEM.items.length==0){growlService.growl("Entrez au moins un article ",'danger');return false;};

	
	$rootScope.loadinng = true;var tmp=angular.copy($scope.NEWITEM);
	$http.post($scope.URL+"?action=save_edit",{data:tmp,q:$scope.serchfield,pg:$scope.currentPage,psiz:$scope.pageSize}).then(function(e){if(e.data.test){

		growlService.growl("Bien Enregistrer", 'success');$scope.DATA=e.data.data.d;$scope.TOTALITEMS=e.data.data.count;$scope.lastnum=e.data.data.num;$rootScope.loadinng = false;$scope.TMP={};
		if($scope.LOCALCONFIG.printicket==true){printRaw($scope.INFOss,angular.copy($scope.NEWITEM),$scope.SESSX);}
	if(tmp.id || $scope.LOCALCONFIG.backToList){$scope.NEWITEM=null;$scope.selectedItem=null;$scope.CURPAGE=0;}
	else{$scope.NEWITEM={mode_p:"1",n_facture:$scope.lastnum,items:[],date_vente:new Date(),cr:LOADAPPINFOSERVICE.getSession()['name']};}
	}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$rootScope.loadinng=false;
	},function(){ growlService.growl("Pas de connexion Internet...!", 'danger',5000);$rootScope.loadinng = false;});
}
$scope.$on('$destroy', function(){console.log('$destroy');endConnection();try{onScan.detachFrom(document)}catch{}});$scope.SHORTCUTS=[];
$scope.infosAll=function(s){if ($scope.selectedItem != null) {$scope.TMP={};
$scope.INFO=(typeof s=="undefined");var tmp=$scope.selectedItem;$rootScope.loadinng = true; $http.post($scope.URL+"?action=getall",{id:tmp.id,idcl:tmp.id_cl}).then(function(e){$scope.INFOS=angular.copy(tmp);$scope.INFOS.data=e.data;$scope.INFOS.CALC={total:0,tva:0,rm:0,ht:0}
angular.forEach($scope.INFOS.data.items,function(el,ind){el.rmx=el.prix-((el.rm*el.prix)/100);
	var ht=Math.round((el.tt/((el.tva*0.01)+1))* 100) / 100;tva=Math.round(((ht*el.tva)/100)* 100) / 100;
	$scope.INFOS.CALC.total+=el.tt;
	$scope.INFOS.CALC.tva+=tva;
	$scope.INFOS.CALC.rm+=((el.prix*el.q)*el.rm)/100;
	$scope.INFOS.CALC.ht+=ht;
})
$scope.CURPAGE=2;$scope.class='Right';$rootScope.loadinng = false;},function(){$rootScope.loadinng = false;});
}else{growlService.growl("Sélectionner une ligne ...!", 'danger');}}

$scope.cancellx=function(){$scope.class="Left";$scope.CURPAGE=0;$scope.selectedItem=null,$scope.NEWITEM={};}
}).controller('achatsCtrl',  function($uibModal,$scope,$document,hotkeys,LOADAPPINFOSERVICE,$timeout,$state,iosAlertView,growlService,$http,$stateParams) {$scope.PERMISSON=LOADAPPINFOSERVICE.getPermission($state.$current.name);$scope.URL="php/achats";$scope.CURPAGE=0;$scope.currentPage=1;$scope.TOTALITEMS=0;$scope.DATA=[];$scope.pageSize=10;$scope.NEWITEM={}; $scope.listviewSearchStat = false;$scope.dizabled=false;$scope.mois="-1";$scope.excercice=new Date().getFullYear().toString();
$opt={animation: true,templateUrl: 'editentree.html',scope: $scope,size: "md",backdrop: "static",keyboard: false};$scope.extra={};
$scope.instance=null;
$scope.table2Options={index:true,class:' teal hover ',sort:{sortBy:''},ajax:{url:$scope.URL,isSync:true},
	   columns:[{name:"Date Entree",value:"vd",orderable:true,filter:"date#EEEE dd LLLL yyyy"},
	   {name:"Produits",value:"pr",orderable:true},{name:"Quantité",sum:true,value:"q",orderable:true},{name:"Fournissuer ",value:"frn",orderable:true},{name:"Prix Achat",sum:true,value:"prix_achat",filter:"currency",norderable:true},{name:"Sortie par",value:"resp",orderable:true}]
   }
	/*hotkeys.bindTo($scope).add({combo:["R","r"],description: 'Recherche',
	 callback: function() {if($scope.CURPAGE==0){$scope.listviewSearchStat=true;}}
   }).add({combo:["del","s","S"],description: 'Supprimer',
	 callback: function() {if($scope.CURPAGE==0 && $scope.selectedItem && $scope.PERMISSON[2].value){$scope.delete();}}
   }).add({combo:["N","n"],description: 'Ajouter',
	 callback: function() {if($scope.CURPAGE==0 &&  $scope.PERMISSON[0].value){$scope.add_ligne();}}
   }).add({combo:["M","m"],description: 'Modifier',
	 callback: function() {if($scope.CURPAGE==0 && $scope.selectedItem && $scope.PERMISSON[1].value){$scope.infos(1);}}
   }).add({combo:["I","i"],description: 'Informations',
	 callback: function() {if($scope.CURPAGE==0 && $scope.selectedItem){$scope.infos();}}
   }).add({combo:["A","a"],description: 'Actualier',
	 callback: function() {$scope.RELOAD();}
   }).add({combo:["alt+s","alt+S"],description: 'Enregistrer', allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
	 callback: function() {if($scope.CURPAGE==1 && !$scope.FORM1.$invalid && !$scope.INFO){$scope.save();}}
   }).add({combo: 'esc',description: 'Annuler',
	 callback: function() {if($scope.listviewSearchStat==true){$scope.listviewSearchStat=false;$scope.serchfield="";}
		 if($scope.CURPAGE!=0){$scope.cancellx();}
		 if($scope.CURPAGE==0 && $scope.selectedItem){$scope.cancell();}
	 }
   })*/
   
   
   
   /* onScan.attachTo(document, {
   suffixKeyCodes: [13],
   onKeyDetect:function(){return false},
   reactToPaste: true, 
   onScan: function(sCode, iQty) {console.log("sortie()",sCode);
   //$scope.mois=sCode;$scope.RELOAD()
	   //if(!isNaN(parseInt(sCode))){$scope.loadsearch(sCode);}		
   },
   onKeyDetect: function(iKeyCode){return false},
   onScanError: function(oDebug) { console.log('onScanError: ',oDebug); },
   onScanButtonLongPress: function() { console.log('onScanButtonLongPress: '); }
});
$scope.$on('$destroy', function(){try{onScan.detachFrom(document)}catch{}});
   */
   
   
   $scope.add_ligne=function(){$scope.dizabled=false;$scope.INFO=false;$scope.NEWITEM={items:[{q:0}],date_en:new Date()};$scope.selectedItem= null ;$scope.class='Right';$scope.CURPAGE=1;}
   $scope.add_line=function(){var t=$scope.NEWITEM.items[$scope.NEWITEM.items.length-1];
   if(t){
	   if(typeof t.id=="undefined" && typeof t.xxx=="undefined"){growlService.growl("Sélectionner un Produits",'info');return false;}
	   if(t.q<=0){growlService.growl("Ajouter une quantité différente de 0 ",'info');return false;}
   }
   $scope.NEWITEM.items.push({q:1});}
   $scope.addProduct=(x)=>{
		iosAlertView.prompt({form:{inputValue:x.namex},title:"Nom du Produit",inputType:'text'}).then(function(p) {  
		  if (typeof p!='undefined') {
			  if( p.length<3){growlService.growl("Entrez un nom valide qui contient trois lettres au moins", 'info');return;}
			  $scope.LoaDing = true;
				$http.post("php/produits?action=add_product",{name:p}).then(function(e){if(e.data.test){growlService.growl("Bien Enregistrer", 'success');
				x.namex=p;x.q=1;x.id=e.data.last;
				$timeout(function() {$scope.add_line();},300);
				}else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing = false;
				},function(){ growlService.growl("Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing = false;});
		  }else{
			  growlService.growl("Entrez un nom valide qui contient trois lettres au moins", 'danger');
		  }
		})
	}
	$scope.clearFoor=function(){$scope.extra={four:"-1"};$scope.edsde="";$scope.RELOAD();}
	$scope.setFourReload=function(z){$scope.extra.four=z.id;$scope.RELOAD();}
$scope.onSelect = function (r,i,index) {
	if(r.id=="add"){return $scope.addProduct(i);}
	i.q=1;i.prix_vente=parseFloat(r.obj.prix);if ($scope.checkinarray(r.id)){$scope.NEWITEM.items.splice(index,1);}$timeout(function() {$scope.add_line();},300);}
	
   $scope.checkinarray=function(d){var v=false;angular.forEach( $scope.NEWITEM.items, function(value, key) {if( value.id==d){$scope.NEWITEM.items[key].q++;v=true;return v;}});return v;}
   $scope.delet=function(x,id){if(typeoof(id)){$scope.NEWITEM.items.splice(x,1);}}
   
   $scope.save=function(d){
	   if(typeof d=="undefined"){if($scope.NEWITEM.items.length==0 || $scope.NEWITEM.items[0].q==0){growlService.growl("Entrez au moins un Produits ",'info');return false;}
	   if(typeoof($scope.NEWITEM.frn)){growlService.growl("Ajouter un fournisseur ",'info');return false;}}
	   $scope.LoaDing = true;
	   $http.post($scope.URL+"?action=save_edit",{data:$scope.NEWITEM,q:$scope.serchfield,pg:$scope.currentPage,psiz:$scope.pageSize}).then(function(e){if(e.data.test){growlService.growl("Bien Enregistrer", 'success');$scope.DATA=e.data.data.d;$scope.TOTALITEMS=e.data.data.count;$scope.NEWITEM=null;$scope.selectedItem=null;$scope.CURPAGE=0;$scope.lastnum=e.data.data.num;$scope.lastfacture=e.data.data.numf;if(typeof d!="undefined"){$scope.instance.close();}
	   }else{growlService.growl(e.data.errors||"Erreurs ...!", 'danger')};$scope.LoaDing = false;
	   },function(){ growlService.growl("Pas de connexion Internet...!", 'danger',5000);$scope.LoaDing = false;});
   }
   $scope.infos=function(s){if ($scope.selectedItem != null) {$scope.dizabled=false;
   $scope.INFO=(typeof s=="undefined");var tmp=$scope.selectedItem;tmp.date_en=new Date(tmp.date_en);
   tmp.date_pre=new Date(tmp.date_pre);
   $scope.NEWITEM=angular.copy(tmp);
   $scope.instance=$uibModal.open($opt);
   
   }else{growlService.growl("Sélectionner une ligne ...!", 'danger');}}
   $scope.cancellx=function(){$scope.class="Left";$scope.CURPAGE=0;$scope.selectedItem=null,$scope.NEWITEM={};}
})