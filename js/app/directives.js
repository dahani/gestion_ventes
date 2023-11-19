materialAdmin.directive('easypieChart', function($timeout){
        return {restrict: 'A',scope:{percent:"=",color:"@"},link: function(scope, element) {scope.color=scope.color||"rgba(255,255,255,0.7)";$(element).attr('data-percent',scope.percent).easyPieChart({trackColor: 'rgba(255,255,255,0.2)',scaleColor: 'rgba(255,255,255,0.5)',barColor: scope.color,lineWidth: 7,lineCap:'butt',size: 148});}}
    }).directive('printtargettlank', function(growlService) {return {restrict: 'A',link: function (scope, element, attrs) {$(element).click(function(){if(scope.selectedItem==null){growlService.growl("Sélectionner une ligne ...!", 'danger'); return false;}});}};}).directive('changeLayout', function($rootScope){
        return {
            restrict: 'A',scope: {changeLayout: '='},
            link: function(scope, element, attr) {
                if(scope.changeLayout === '1') {element.prop('checked', true);}
                element.on('change', function(){$rootScope.$broadcast('containnerresized',{});
                    if(element.is(':checked')) {localStorage.setItem('ma-layout-status', 1);scope.$apply(function(){scope.changeLayout = '1';})}
                    else {localStorage.setItem('ma-layout-status', 0);scope.$apply(function(){scope.changeLayout = '0';})
                    }
                })
            }
        }
    }).directive('compileTemplate', function($compile, $parse) {return {restrict: 'A',
		link: function (scope, element, attr){
            var parsed = $parse(attr.ngBindHtml);
            function getStringValue() { return (parsed(scope) || '').toString(); }    
            scope.$watch(getStringValue, function() {
                $compile(element, null, -9999)(scope);  
             });
	}}}).directive('sparklineLine', function(){return {
            restrict: 'E',scope: {config: '='},
template:'<div class="mini-charts-item {{config.color}}"><div class="clearfix"><div class="chart" ></div><div class="count"><small>{{config.title}}</small><h2>{{config.data|SUM|currency:\'\'}}</h2></div></div></div>',
            link: function(scope, element) {
                    $($(element).find(".chart")[0]).sparkline(scope.config.data, {type: scope.type,width: 85,height: 45,lineColor: '#fff',fillColor: 'rgba(0,0,0,0)',
                        lineWidth: 2,maxSpotColor: 'rgba(255,255,255,0.4)',minSpotColor: 'rgba(255,255,255,0.4)',
                        spotColor: 3,spotRadius: 3,highlightSpotColor: '#fff',highlightLineColor: 'rgba(255,255,255,0.4)'
                    });
            }
        }
    }).directive("ngUploadChange",function(){
    return{scope:{ngUploadChange:"&"},
        link:function($scope, $element, $attrs){
            $element.on("change",function(event){$scope.$apply(function(){$scope.ngUploadChange({$event: event})})
            })
            $scope.$on("$destroy",function(){$element.off();});
        }
    }
}).directive("imgUpload",function($http,$compile,growlService){
			return {
				restrict : 'AE',
				scope : {
					url : "@",
					filesz : "=",previewData : "=" ,maxx:"@maxx",old:"="
				},
				template : 	'<input class="fileUpload" id="filesder"  type="file"  accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff"/><div class="preview row clearfix "><div class="previewData  col-sm-4 p-5" ng-repeat="data in previewData track by $index"><img ng-src="{{data.src}}" style="width:100%"></img><div class="previewControls"><span ng-click="remove($index)" class="circle remove"><i class="zmdi zmdi-close"></i></span></div></div></div><div class="dropzone"><p class="msg">Cliquez ou glissez et déposez les fichiers à télécharger</p></div>',
				link : function(scope,elem,attrs){scope.maxx=2;
					function previewFile(file){var reader = new FileReader();	
						reader.onload=function(data){
							var src = data.target.result;/*var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' mB' : (file.size/1024)+' kB';*/
							scope.$apply(function(){if((scope.old+scope.previewData.length)>=scope.maxx){growlService.growl("Max "+scope.maxx+" images", 'danger');return;};scope.filesz.push(file);scope.previewData.push({'src':src});});}
        				reader.readAsDataURL(file);
					}
					function uploadFile(e,type){e.preventDefault();	var files = "";if(type == "formControl"){files = e.target.files;} else if(type === "drop"){files = e.originalEvent.dataTransfer.files;}for(var i=0;i<files.length;i++){var file = files[i];if(file.type.indexOf("image") !== -1){previewFile(file);} else {alert(file.name + " is not supported");}}}	
					elem.find('.fileUpload').bind('change',function(e){uploadFile(e,'formControl');});
					elem.find('.dropzone').bind("click",function(e){$compile(elem.find('.fileUpload'))(scope).trigger('click');});
					elem.find('.dropzone').bind("dragover",function(e){e.preventDefault();});
					elem.find('.dropzone').bind("drop",function(e){uploadFile(e,'drop');});
					scope.remove=function(index){scope.previewData.splice(index,1);scope.filesz.splice(index,1);}
				}
			}
		}).directive('toggleSidebar', function($rootScope){
        return {
            restrict: 'A',scope: {modelLeft: '=',modelRight: '='},
            link: function(scope, element, attr) {
                element.on('click', function(){
                    if (element.data('target') === 'mainmenu') {
                        if (scope.modelLeft === false) {scope.$apply(function(){scope.modelLeft = true;$rootScope.sidebarToggle.right = false;$rootScope.sidebarToggle.recette = false;})}
                        else {scope.$apply(function(){scope.modelLeft = false;})}
                    }
                    if (element.data('target') === 'chat') {
                        if (scope.modelRight === false) {scope.$apply(function(){scope.modelRight = true;$rootScope.sidebarToggle.left = false;$rootScope.sidebarToggle.recette = false;})}
                        else {scope.$apply(function(){scope.modelRight = false;})}
                    }
                })
            }
        }
    }).directive('toggleSubmenu', function(){
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                element.click(function(){
                    element.next().slideToggle(200);
                    element.parent().toggleClass('toggled');
                });
            }
        }
    })
    .directive('stopPropagate', function(){
        return {
            restrict: 'C',
            link: function(scope, element) {
                element.on('click', function(event){
                    event.stopPropagation();
                });
            }
        }
    })
    .directive('aPrevent', function(){
        return {
            restrict: 'C',
            link: function(scope, element) {
                element.on('click', function(event){
                    event.preventDefault();
                });
            }
        }
    })
    .directive('print', function(){
        return {
            restrict: 'A',
            link: function(scope, element){
                element.click(function(){
                    window.print();
                })   
            }
        }
    }).directive('customOnChange', function() {
 return {restrict: 'A',link: function (scope, element, attrs) {var onChangeHandler = scope.$eval(attrs.customOnChange);element.on('change', onChangeHandler);element.on('$destroy', function() {element.off();});}
  };
}).directive('chartPiearchive', function ($http,growlService,$timeout) {
	return {restrict: 'E',replace: true,
		template: '<div class="card m-b-20" style="min-height: 330px;"><div class="smallloading" ng-if="LoaDing"></div><div class="card-header  "><h2><div class="row"><div ng-class="{\'col-sm-4\':isdate,\'col-sm-6\':!isdate}">{{title}}<small>{{subtitle}}</small></div><div class="col-sm-4" ng-show="isdate"><div class="row"><div class="col-xs-6" uib-tooltip="Date début" ><input ng-change="load()"  ng-model-options="{debounce: 500}"  ng-model="dated" placeholder="jj/mm/aaaa" data-input-date="{mask: \'00/00/0000\'}" type="date" class="datechart" /></div><div  class="col-xs-6"  uib-tooltip="Date fin" ><input ng-change="load()" type="date" placeholder="jj/mm/aaaa" data-input-date="{mask: \'00/00/0000\'}" ng-model="datef"  ng-model-options="{debounce: 500}"  class="datechart" /></div></div></div><div  ng-class="{\'col-sm-4\':isdate,\'col-sm-6\':!isdate}"><div data-ts-color="white" class="toggle-switch pull-right m-t-10 m-l-10 " ><input id="{{idx}}"   ng-model="inner" ng-change="changeConfig()"  type="checkbox" hidden="hidden" ><label for="{{idx}}" class="ts-helper pull-right"></label></div><select ng-show="year" class="pieselect" ng-model="excercie" ng-change="load()" ng-options="item as item for item in YEARS track by item "></select><button class="btn btn-link   pull-right" ng-click="load()"><i class="zmdi zmdi-refresh c-white" style="font-size: 26px;"></i></button></div></div></h2></div><div class="card-body"><div class="p-t-20" style="width:100%;height:100%"><div class="crtg" style="width:100%;height:100%"></div><p ng-if="DATA.length<=0" class="text-center">Aucune donnée ... </p></div></div></div>',
		scope: {data: '=',url: "@url",title: '@title',subtitle: '@subtitle',year:"=",isdate:"=?isdate",legend:"=?legend",frm:"@"},
		link: function (scope, element, attrs) {scope.DATA =[];scope.datef=moment.utc().toDate();scope.$chart=null;scope.excercie=null;scope.inner=0;scope.frm="2";
		scope.excercie=new Date().getFullYear();scope.YEARS=[];for(i=scope.excercie;i>=YEAR_START;i--){scope.YEARS.push(parseInt(i))}
		scope.dated=moment.utc(new Date(moment.utc().year()+"-01-01")).toDate();scope.idx=getRandomInt(0,100);
		scope.$on('containnerresized', function(event, data){$timeout(function () {scope.refreshChart ();})});
		scope.changeConfig=function(){if(scope.$chart!=null){scope.$chart.update({plotOptions: {pie: {innerSize:scope.inner?100:0}}})};}
		scope.refreshChart = function () {
		if(scope.DATA.length>0){
		scope.$chart=Highcharts.chart($(element).find(".crtg")[0], {chart: {type: 'pie',options3d: { enabled: true, alpha: 45, beta: 0 } },
        title: {text:scope.subtitle},subtitle: {text:scope.isdate?moment.utc(scope.dated).format("DD/MM/YYYY")+" - "+moment.utc(scope.datef).format("DD/MM/YYYY"):''},tooltip: {pointFormat: '{series.name} <b>{point.y:.'+scope.frm+'f}</b>'}, plotOptions: {pie: {innerSize:scope.inner?100:0,allowPointSelect: true,cursor: 'pointer',depth: 45, dataLabels: { y:-5, style: {fontFamily: 'tahoma',textShadow: false}, enabled: true, format:' {point.name} (<b>{point.percentage:.1f}% </b>)' }, states: {
                inactive: {
                    enabled:false
                },hover: {
                        radiusPlus: 5,
                        lineWidthPlus: 2
                    }
            
            }}},series: [{  showInLegend: scope.legend,name: ' ',data: scope.DATA}]});
		}else{if(scope.$chart!=null)scope.$chart.destroy();scope.$chart=null;} scope.LoaDing =false;
		}
		scope.load = function () {
			if(scope.dated>scope.datef){growlService.growl("La date de début est supérieure à la date de fin ...!", 'danger');return false;}
				scope.LoaDing = true;$http.post(scope.url,{year:scope.excercie,d:moment.utc(scope.dated).format("YYYY-MM-DD").toString(),f:moment.utc(scope.datef).format("YYYY-MM-DD").toString()}).then(function (res) {if (res.data.test == true) {scope.DATA = res.data.data;scope.refreshChart();}else{growlService.growl("Erreurs de chargement du "+scope.title+"...!", 'danger')};scope.LoaDing = false;}, function () { growlService.growl("Pas de connexion Internet...!", 'danger',5000);;scope.LoaDing = false;})
		}
		scope.$on(''+scope.url, function(event, data){scope.DATA =data;scope.refreshChart();});
		}
	}
}).directive('notesWidget', function ($http, growlService,LOADAPPINFOSERVICE) {
	return {
		restrict: 'EA',scope: {title: "@title",description: "@description"},replace: true,
		template: '<div id="todo-lists" ><div style="z-index: 333;" class="smallloading" ng-if="LOADING_NOTES"></div><div class="tl-header"><h2>{{title}} ({{TOTALITEMS}})</h2> <small>{{description}}</small><ul class="actions actions-alt"><li class="dropdown" uib-dropdown> <a href="#" uib-dropdown-toggle aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a><ul class="dropdown-menu dropdown-menu-right dm-icon"><li ng-click="LOAD_NOTES()"><a href="#"><i class="zmdi zmdi-refresh"></i>Refresh</a></li></ul></li></ul></div><div class="clearfix"></div><div class="tl-body"><div id="add-tl-item" data-ng-class="{\'toggled\': addTodoStat }" data-ng-click="addTodoStat = true"  > <i class="add-new-item zmdi zmdi-plus" data-ng-click="addTodo($event)" ></i><div class="add-tl-body"><textarea dir="auto"  placeholder="Ecrire note ..." ng-model="NOTE.text"></textarea><input type="file" style="position: absolute;right: 0;bottom: 11px;z-index: 23;" id="fileimg" /><div class="add-tl-actions" > <a class="zmdi zmdi-close"   uib-tooltip="Annuler"  data-ng-click="CanceNote($event)"></a><a class="zmdi zmdi-check"   uib-tooltip="Enregistrer la note"  data-ng-click="AddNote($event)" ></a></div></div></div><div class=" media p-b-20 " style="border-bottom: 1px solid #8e8e8e;" ng-repeat="x in NOTES "><div class="pull-right" ng-if="Session.admin || x.writer==Session.idx"><ul class="actions actions-alt"><li  class="dropdown" uib-dropdown > <a href="#" uib-dropdown-toggle aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a><ul class="dropdown-menu dm-icon dropdown-menu-right"><li ng-click="deleteNote(x,$index)" ><a href="#"><i class="zmdi zmdi-delete"></i> Supprimer</a></li><li ng-click="EditNote(x)"><a href="#"><i class="zmdi zmdi-edit"></i> Modifier</a></li></ul></li></ul></div><div class="media-body"><div class="lgi-heading c-white "  ng-bind-html="x.tt|unsafe" dir="auto"></div><a ng-if="x.img" href="img/notes/{{x.img}}" target="_blank">{{x.img}}<br></a><small class="lgi-text"> <time-ago from-time="{{x.date_}}"></time-ago> |{{x.date_}} <span  class="bgm-yellow" style="border-radius: 16px;padding: 0px 6px;">{{x.name}}</span></small></div></div><uib-pagination  total-items="TOTALITEMS" max-size="10" items-per-page="10" ng-model="currentPage" class="pagination " boundary-links="true" boundary-link-numbers="true" ng-change="pageChanged()" ></uib-pagination></div></div>',
		link: function ($scope, elem, attrs) {
			$scope.NOTES = [];$scope.currentPage = 1;$scope.TOTALITEMS = 0;$scope.addTodoStat = false;$scope.LOADING_NOTES = true;$scope.NOTE = {};$scope.URL = "php/notes";$scope.LOAD_NOTES = function () {$scope.LOADING_NOTES = true;
				$http.post($scope.URL + "?action=loadNotes", {pg: $scope.currentPage}).then(function (e) {
					if (e.data.test) {$scope.NOTES = e.data.data.d;$scope.TOTALITEMS = e.data.data.count;updateRangeValues();} else {growlService.growl(e.data.errors || "Erreurs ...!", 'danger');};$scope.LOADING_NOTES = false;
				}, function () {growlService.growl("Pas de connexion Internet...!", 'danger',5000);$scope.LOADING_NOTES = false;});
			}
			$scope.Session=(LOADAPPINFOSERVICE.getSession());
			$scope.range = {lower: 1,upper: 1,total: 1};
            function updateRangeValues() { $scope.range.lower = ($scope.currentPage - 1) * $scope.pageSize + 1;$scope.range.upper = Math.min($scope.currentPage * $scope.pageSize, $scope.TOTALITEMS);}
            $scope.pageChanged = function() {updateRangeValues();$scope.LOAD_NOTES();}
			$scope.deleteNote = function (id, index) {
				swal({title: "supprimer ?",text: "Es-tu sûr de vouloir le supprimer",type: "warning",showCancelButton: true,
					showLoaderOnConfirm: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Oui, Supprimer !",closeOnConfirm: true
				}, function () {
					$scope.LOADING_NOTES = true;$http.post($scope.URL + "?action=deleteNote", {idx: id.id,img:id.img,pg: $scope.currentPage}).then(function (e) {
						if (e.data.test) {
							$scope.NOTES.splice(index, 1);swal("Supprimé!", " bien Supprimé!", "success");
						} else {
							growlService.growl(e.data.errors || "Erreurs ...!", 'danger')
						};
						$scope.LOADING_NOTES = false;
					}, function () {
						$scope.LOADING_NOTES = false;
						 growlService.growl("Pas de connexion Internet...!", 'danger',5000);
					})
				});
			}
			$scope.CanceNote = function (ev) {ev.stopPropagation();$scope.addTodoStat = false;$scope.NOTE = {};}
			$scope.AddNote = function (ev) {ev.stopPropagation();
				if (typeof $scope.NOTE.text == "undefined" || $scope.NOTE.text == "") {growlService.growl("Entrer un text", 'danger');return false;}
				$scope.LOADING_NOTES = true;
				$scope.NOTE.date_=moment().format("YYYY-MM-DD HH:mm:ss").toString();
				$http({ method: 'POST',url:$scope.URL + "?action=save_edit_Note",headers: {'Content-Type': undefined},data: {pg: $scope.currentPage,info: $scope.NOTE},transformRequest: function(data, headersGetter) {var formData = new FormData();formData.append("p",data.pg);formData.append("img", document.getElementById("fileimg").files[0]);;formData.append("info",angular.toJson(data.info));return formData;}}).then(function (e) {
					if (e.data.test) {growlService.growl("Bien Ajouter !", 'info');
						$scope.NOTES = e.data.data.d;$scope.TOTALITEMS = e.data.data.count;
						document.getElementById("fileimg").value="";
					} else {growlService.growl(e.data.errors || "Erreurs ...!", 'danger')};
					$scope.LOADING_NOTES = false;$scope.addTodoStat = false;$scope.NOTE = {};
				}, function () {
					$scope.LOADING_NOTES = false;growlService.growl("Pas de connexion Internet...!", 'danger',5000);
				})
			}
			$scope.EditNote = function (x) {$scope.NOTE = x;$scope.addTodoStat = true;}
			$scope.LOAD_NOTES();
		}
	}
}).directive('chartWidget', function ($http,growlService,$timeout) {
	return {restrict: 'E',replace: true,scope:{},
		template: '<div class="card m-b-20 chartx"><div class="smallloading" ng-if="LoaDing"></div><div class="card-header"><h2>{{title}}<small>{{subtitle}}</small></h2><ul class="actions actions-alt"><li style="position: relative;top: -4px;" class="m-r-10"><select ng-model="excercie" ng-change="load()" ng-options="item as item for item in YEARS track by item "></select></li><li><a href="#" ng-click="load()"><i class="zmdi zmdi-refresh"></i></a></li><li class="dropdown" uib-dropdown ><a href="#" uib-dropdown-toggle aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a><ul class="dropdown-menu dropdown-menu-right dm-icon"><li><a href="#" ng-click="setType(\'spline\')"><i class="zmdi zmdi-chart-line"></i><i class="zmdi zmdi-check pull-right" ng-if="TYPEX==\'spline\'"></i> Courbes</a></li><li><a href="#" ng-click="setType(\'columnpyramid\')"><i class="zmdi zmdi-chart-column"></i><i class="zmdi zmdi-check pull-right" ng-if="TYPEX==\'columnpyramid\'"></i> Pyramid</a></li><li><a href="#" ng-click="setType(\'column\')"><i class="zmdi zmdi-chart-column"></i><i class="zmdi zmdi-check pull-right" ng-if="TYPEX==\'column\'"></i> Colonnes</a></li><li><a href="#" ng-click="setType(\'line\')"><i class="zmdi zmdi-check pull-right" ng-if="TYPEX==\'line\'"></i><i class="zmdi zmdi-chart-spline"></i>Lignes</a></li><li><a href="#" ng-click="setType(\'areaspline\')"><i class="zmdi zmdi-check pull-right" ng-if="TYPEX==\'areaspline\'"></i><i class="zmdi zmdi-chart-area"></i>Zones</a></li></ul></li></ul></div><div class="card-body" style="min-height: 200px;"><div class="p-t-20"><div class="crtg" style="width:100%;height:100%"></div></div></div></div>',
		scope: {xtitle:"@xtitle",url: "@url",TYPEX: '@type',title: '@title',subtitle: '@subtitle',double: '@double',frm:"@",devise:"@",stacking:"@"},
		link: function (scope, element, attrs,ngModel) {scope.excercie=null;scope.seriesx=null;
			scope.excercie=new Date().getFullYear();scope.YEARS=[];for(i=scope.excercie;i>=YEAR_START;i--){scope.YEARS.push(parseInt(i))}
			scope.TYPEX = "spline";scope.DATA =[];scope.frm="2";scope.devise=" Dh";
			scope.setType = function (t) {scope.TYPEX = t;scope.refreshChart();}
			scope.$on(''+scope.url, function(event, data){scope.DATA =data;scope.refreshChart();});
			scope.$on('containnerresized', function(event, data){$timeout(function () {scope.refreshChart ();})});
			scope.refreshChart = function () {
				Highcharts.chart($(element).find(".crtg")[0], {
					chart: {type: scope.TYPEX,options3d: {enabled: (scope.TYPEX == 'column' && scope.stacking==undefined),alpha: 1,beta: 8,depth: 33}},
					title: {text:""},yAxis: {title: {text: scope.xtitle+"<br>"}},
					subtitle: {text:scope.subtitle+"<br>"+scope.excercie},
					xAxis: {categories: ['','Janvier', 'Février', 'Mars', 'Avril', 'Mai', "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"]}, tooltip: {pointFormat: "{series.name}: <b>{point.y:."+scope.frm+"f}</b>"+scope.devise},
					series:scope.double=="true"?scope.DATA:[{name: scope.title,data: scope.DATA}],
					 plotOptions: {
        column:scope.stacking ?{stacking: 'normal',dataLabels: {enabled: true}}:{}
    , animation: {
                duration: 20000
            },series:{lineWidth: 4,
            states: {
				
                inactive: {
                    enabled: true,opacity:0.4
                },hover: {
                        radiusPlus: 5,
                        lineWidthPlus: 2
                    }
            
            },marker: {states: {
                    hover: {
                        radiusPlus: 5,
                        lineWidthPlus: 2
                    }
                },fillColor: '#F39020'},dataLabels: {enabled:true,rotation: 0,color: '#FFFFFF',align: 'center',formatter: function(){
                    return (this.y!=0)? Highcharts.numberFormat(this.y,scope.frm):"";
                    },y: 10,style: {fontSize: '13px',fontFamily: 'Verdana, sans-serif'}}},
			
				}
				})
			}
			scope.load = function () {
				scope.LoaDing = true;$http.post(scope.url,{year:scope.excercie}).then(function (res) {if (res.data.test == true) {scope.DATA = res.data.data;scope.refreshChart();}else{growlService.growl("Erreurs de chargement du "+scope.title+"...!", 'danger')};scope.LoaDing = false;}, function () { growlService.growl("Pas de connexion Internet...!", 'danger',5000);;scope.LoaDing = false;})
			}
		}
	};
}) .directive('btn', function(){
        return {
            restrict: 'C',
            link: function(scope, element) {
                if(element.hasClass('btn-icon') || element.hasClass('btn-float')) {Waves.attach(element, ['waves-circle']);}
                else if(element.hasClass('btn-light')) {Waves.attach(element, ['waves-light']);}
                else {Waves.attach(element);}
                Waves.init();
            }
        }
    }).directive('a', function () {return {restrict: 'E',link: function (scope, elem, attrs) {if (attrs.toggle || attrs.href == "#") {elem.on('click', function (e) {e.preventDefault();});}}};
}).directive('loadimage', function ($timeout) {
	return {restrict: 'A',scope:{loader:"="},link: function (scope, element) {;element.bind('load', function() {scope.$apply(function(){scope.loader=false;})})}}
}).directive('fgLine', function(){
        return {
            restrict: 'C',
            link: function(scope, element) {
                if($('.fg-line')[0]) {
                    $('body').on('focus', '.form-control', function(){$(this).closest('.fg-line').addClass('fg-toggled');})
                    $('body').on('blur', '.form-control', function(){var p = $(this).closest('.form-group');var i = p.find('.form-control').val();if (p.hasClass('fg-float')) {
                            if (i.length == 0) {$(this).closest('.fg-line').removeClass('fg-toggled');}}
                        else {$(this).closest('.fg-line').removeClass('fg-toggled');}
                    });
                }
            }
        }
    }).directive('dhPaginate', function () {
	return {restrict: 'E',replace: true,
		template: '<li class="dropdown" uib-dropdown ><a href="#" uib-dropdown-toggle aria-expanded="true" ><i class="zmdi zmdi-more-vert"></i></a><ul class="dropdown-menu pull-right dm-icon dropdown-menu-right"><li><a ng-class="{\'active\':pageSize==x}" href="#" ng-repeat="x in arr track by $index" ng-click="setr(x)">{{x}}</a></li></ul></li>',scope: {pageSize: '='},
		link: function(scope, element){scope.arr=[5,10,30,50,100,250];scope.setr=function(s){scope.pageSize=s;}}
	}
}).directive('submenudirective', function () {
	return {restrict: 'A',replace: true,scope: {},link: function(scope, element,attr){if(parseInt(attr.submenudirective)>0){element.click(function(){element.next().slideToggle(200);element.parent().toggleClass('toggled');});}}
	}
}).directive('focusMe',function($timeout, $parse){return {link: function (scope, element, attrs) {var model = $parse(attrs.focusMe);scope.$watch(model, function (value) {if (value === true) {$timeout(function () {element[0].focus();});}})}};}).directive('inputDate', function(){return {restrict: 'A',link: function(scope, element){var tt=document.createElement('input');tt.setAttribute("type","date");if(tt.type=="text"){element.mask("00/00/0000");}}}}).directive('inputMask', function(){return {restrict: 'A',scope: {inputMask: '='},link: function(scope, element){element.mask(scope.inputMask.mask);}}})
.directive('ngRandomClass', function () {
	return {restrict: 'A',replace: true,scope: {},link: function(scope, element,attr){
		var t=["bgm-deeppurple","bgm-red","bgm-red","bgm-pink","bgm-purple","bgm-indigo","bgm-blue","bgm-lightblue","bgm-cyan","bgm-teal","bgm-green","bgm-lime","bgm-yellow","bgm-amber","bgm-orange","bgm-deeporange","bgm-brown","bgm-gray"];
		$(element).addClass(t[getRandomInt(0,(t.length-1))]);
	}
}
}).directive('tableDirectiveStatic', function($http,growlService) {
    return {restrict: 'EA',scope: {'table2Options':'=opts','idx':'='},replace: true,
	template: '<div class="p-relative"><div class="smallloading" ng-if="loadintadatable" ><div class="progress" ng-style="{ width:progressIncicaor}">{{progressIncicaor}}</div></div><div style="overflow-x:auto;" ><table class=" tablex  table {{ table2Options.class}}"  cellspacing="0" width="100%"> <tr><th style="width:1%" ng-if="table2Options.index">N°</th><th style="width:{{th.width?th.width:\'auto\'}}"   ng-click="sort(th.value,th.orderable)" ng-repeat="th in table2Options.columns track by $index"   ><span ng-bind-html="th.name|unsafe" ></span><span class="iconsort" ng-show="sortKey==th.value" ng-class="{\'zmdi zmdi-long-arrow-down\':!reverse,\' zmdi zmdi-long-arrow-down iconsortUP\':reverse}"></span></th></tr><tr ng-repeat="x in table2Options.DATA | filter:table2Options.serchfield | orderBy:sortKey:reverse track by $index" ><td ng-if="table2Options.index">{{($index + 1) + (table2Options.currentPage - 1) *table2Options.pageSize}}</td><td dir="auto"  class="{{td.class}} " ng-repeat="td in table2Options.columns track by $index" ng-bind-html="x[td.value]|picker:td.filter | highlight:table2Options.serchfield|unsafe" ></td></tr><tfoot ng-if="IS_SUM && table2Options.DATA.length>0"><th ng-if="table2Options.index"></th><th  ng-repeat="th in table2Options.columns track by $index" >{{(th.sum)?(table2Options.DATA|totalr:th.value|currency:""):" "}}</th></tfoot></table></div><p ng-show="numPages>1" class="text-center p-10 m-b-0" style="font-style: oblique;">Affichage de <b>{{range.lower}}</b> à  <b>{{range.upper}}</b> sur <b>{{table2Options.TOTALITEMS}}</b> Enregistrements [ Page: {{table2Options.currentPage}} / {{numPages}} ]</p><uib-pagination total-items="table2Options.TOTALITEMS" max-size="10" items-per-page="table2Options.pageSize" ng-model="table2Options.currentPage" class="pagination " boundary-links="true" boundary-link-numbers="true" ng-show="numPages>1" num-pages="numPages" ng-change="pageChanged()" ></uib-pagination></div>',
        link: function($scope, elem, attrs) {
            if (typeof $scope.table2Options === "undefined") {throw "PARAMETRE INTROUVABLE";return false;}
            $scope.progressIncicaor="";
            $scope.loadintadatable = false;
            $scope.IS_SUM = false;var indesx = 0;
            for (x in $scope.table2Options.columns) {
                if ($scope.table2Options.columns[x].sum == true) {indesx++;}
                if ($scope.table2Options.columns[x].value.indexOf("date") >= 0) {
					if(typeof $scope.table2Options.columns[x].class=="undefined"){$scope.table2Options.columns[x].class = " text-capitalize ";}else{$scope.table2Options.columns[x].class += " text-capitalize ";}
                }
            }
            $scope.IS_SUM = (indesx > 0) ? true : false;
			$scope.range = {lower: 1,upper: 1,total: 1};
             function updateRangeValues() { $scope.range.lower = ($scope.table2Options.currentPage - 1) * $scope.table2Options.pageSize + 1;
                    $scope.range.upper = Math.min($scope.table2Options.currentPage * $scope.table2Options.pageSize, $scope.table2Options.TOTALITEMS);
                   }
            $scope.pageChanged = function() {updateRangeValues();$scope.table2Options.RELOAD();}
            $scope.sortKey = $scope.table2Options.sort.sortBy;
            $scope.reverse = $scope.table2Options.sort.direction;
            $scope.sort = function(keyname, r) {if (r && $scope.table2Options.DATA.length > 0) {$scope.sortKey = keyname;$scope.reverse = !$scope.reverse;}}
            $scope.table2Options.RELOAD = function(e) {
                $scope.loadintadatable = true;$scope.progressIncicaor="0%";
				$http({ method: 'POST',url:$scope.table2Options.ajax.url + "?action=load",headers: {'Content-Type': undefined},data:{
                    q: $scope.table2Options.serchfield,pg: $scope.table2Options.currentPage,psiz: $scope.table2Options.pageSize,id: $scope.table2Options.id,first:typeof e!="undefined"
                ,id:$scope.idx},eventHandlers: {progress: function (evt) {
					$scope.progressIncicaor=(Math.round(evt.loaded * 100 / evt.total)+"%");if(DEBUG){console.log($scope.progressIncicaor);}
					}}}).then(function(res) {
                    if (res.data.test) {$scope.firstLoad=false;
                        $scope.table2Options.DATA = res.data.d;
                        $scope.table2Options.TOTALITEMS = res.data.count;
                        if ( typeof $scope.onLoad === "function") {$scope.onLoad(res.data);}
                    } else {growlService.growl(res.data.errors || 'Erreurs ...', 'danger');}
                    $scope.loadintadatable = false;
                }, function() {
                    $scope.loadintadatable = false;growlService.growl("Pas de connexion Internet...!", 'danger',5000);
                });
            }
            if (typeof $scope.table2Options.autoLoad == "undefined" || $scope.table2Options.autoLoad) {
                $scope.table2Options.RELOAD(1);
            }
        }
    }
})
.directive("shortcuts",function(hotkeys){return{restrict : 'E',
	template:function(){
		return IS_MOBILE?'':'<div class="card hidden-xs" ng-if="SHORTCUTS.length>0"><div class="card-header"><h2>Raccourcies Clavier</h2></div><div class="card-body"><ul class="list-group"><li class="list-group-item" ng-repeat="x in SHORTCUTS"><span class="badge text-capitalize" >{{x.name}}</span> <span ng-bind-html="x.c|unsafe"></span></li></ul></div></div>';
	},
	link:function($scope, $element){$scope.SHORTCUTS=[];angular.forEach(hotkeys.get(), function(f, key){var v=angular.copy(f);
		if(v.combo[0]!="?"){v.combo[0]=v.combo[0]=="esc"?'Échappe':v.combo[0];
			v.combo[0]=v.combo[0]=="enter"?'<i class="zmdi zmdi-enter f-20"></i> ':v.combo[0];
			$scope.SHORTCUTS.push({"c":v.combo[0],"name":v.description});
		}
	})
	}
	}}).directive("vCard",function(){
    return{restrict : 'AE',scope:{data:"="},
        link:function($scope, $element, $attrs){
		$scope.$watch("data", function() {
			if($scope.data && $scope.data.nom){
			var t='BEGIN:VCARD\nVERSION:3.0\nFN;CHARSET=UTF-8:'+$scope.data.nom+'\nEMAIL;CHARSET=UTF-8;type=HOME,INTERNET:'+
			$scope.data.email+'\nTEL;TYPE=CELL:'+$scope.data.tel+'\nADR;CHARSET=UTF-8;TYPE=HOME:;;'+$scope.data.addr+';;;;\nEND:VCARD';
		$element.empty().qrcode({render: 'canvas',size: $attrs.width,fill: 'blue',text:t,mode: 0,background: null});
			} 
         });
        }
    }
}).directive('waitme', function () {
	/*{effect:'win8',color:'#fff',fontSize:'18px',bg:'rgb(125 125 125 / 75%)',text:'Please wait...'}
	effect 'none', 'rotateplane', 'stretch', 'orbit', 'roundBounce', 'win8', 'win8_linear', 'ios', 'facebook', 'rotation', 'timer', 'pulse', 'progressBar', 'bouncePulse', 'img' 
	{
effect : 'bounce',
text : '',
bg : rgba(255,255,255,0.7),
color : #000,
maxSize : '',
waitTime : -1,
textPos : 'vertical',
fontSize : '',
source : '',
onClose : function() {}
}*/
	return {restrict: 'A',scope: {waitme:"=",opps:"="},
	link: function(scope, el,attr){
		scope.$watch("waitme", function() {
			if(scope.waitme==true){
				var option=angular.extend({
					effect:"win8",
					text: 'Please wait...',
					bg: 'rgb(125 125 125 / 75%)',
					color: '#fff'
				},scope.opps);
				el.waitMe(option)
			}else{
				el.waitMe("hide");
			}
		})
	}
	}
}).directive("infoBox",function($compile){return{restrict : 'E',
	template:"<div></div>",scope:{data:'='},replace:true,
	link:function( $scope,$el,attr){
		var html="";
		var data=angular.extend({cnt:' ',title: ' ',icon:'lens',bg: '',color: 'lightblue',type:1},$scope.data);
		switch(data.type+''){
			
			case '1':{
				
				html= '<div class="info-box bgm-{{datax.bg||\'blue\'}} hover-expand-effect hover-zoom-effect"><div class="icon"><i class="zmdi zmdi-{{datax.icon}}"></i></div><div class="content "><div class="text c-white ">{{datax.title}}</div><div class="number c-white">{{datax.cnt}}</div></div></div>';
				break;
			}
			case '2':{
				html=  '<div class="info-box-2 bgm-{{datax.bg||\'blue\'}} hover-zoom-effect"><div class="icon"><i class="zmdi zmdi-{{datax.icon}}"></i></div><div class="content"><div class="text">{{datax.title}}</div><div class="number">{{datax.cnt}}</div></div></div>';
				break;
			}case '3':{
				html=  '<div class="info-box-3 bgm-{{datax.bg||\'blue\'}} hover-zoom-effect"><div class="icon "><i class="zmdi zmdi-{{datax.icon}} c-white"></i></div><div class="content"><div class="text">{{datax.title}}</div><div class="number">{{datax.cnt}}</div></div></div>';
				break;
			}case '4':{
				html=  '<div class="info-box-4  hover-expand-effect"><div class="icon"><i class="zmdi zmdi-{{datax.icon}} c-{{datax.color}}"></i></div><div class="content"><div class="text">{{datax.title}}</div><div class="number">{{datax.cnt}}</div></div></div>';
				break;
			}case '5':{
				html=  '<div class="info-box hover-zoom-effect hover-expand-effect"><div class="icon bgm-{{datax.bg||\'blue\'}}"><i class="zmdi zmdi-{{datax.icon}} "></i></div><div class="content"><div class="text">{{datax.title}}</div><div class="number">{{datax.cnt}}</div></div></div>';
				break;
			}
			default:
			html=  '<div class="info-box-4  hover-expand-effect"><div class="icon"><i class="zmdi zmdi-{{datax.icon}} c-{{datax.color}}"></i></div><div class="content"><div class="text">{{datax.title}}</div><div class="number">{{datax.cnt}}</div></div></div>';
				
		}
		var el = $compile(html)($scope);
		$el.append(el);
		$scope.datax=data;
	}
	}}).directive('chartWidgetDrill', function ($http,growlService,$timeout) {
	return {restrict: 'E',replace: true,scope:{},
		template: '<div class="card m-b-20 chartx"><div class="smallloading" ng-if="LoaDing"></div><div class="card-header"><h2>{{title}}<small>{{subtitle}}</small></h2><ul class="actions actions-alt"><li><a href="#" ng-click="load()"><i class="zmdi zmdi-refresh"></i></a></li><li ng-if="list" class="dropdown" uib-dropdown ><a href="#" uib-dropdown-toggle aria-expanded="false"><i class="zmdi zmdi-select_all"></i></a><ul class="dropdown-menu dropdown-menu-right dm-icon"><li><a href="#" ng-click="setType1(\'month\')"><i class="zmdi zmdi-insert_invitation"></i><i class="zmdi zmdi-check pull-right" ng-if="TYPEX1==\'month\'"></i> Mois</a></li><li><a href="#" ng-click="setType1(\'staff\')"><i class="zmdi zmdi-check pull-right" ng-if="TYPEX1==\'staff\'"></i><i class="zmdi zmdi-avatar6"></i>Personnel</a></li><li><a href="#" ng-click="setType1(\'type\')"><i class="zmdi zmdi-check pull-right" ng-if="TYPEX1==\'type\'"></i><i class="zmdi zmdi-diploma"></i>Formation</a></li></ul></li><li class="dropdown" uib-dropdown ><a href="#" uib-dropdown-toggle aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a><ul class="dropdown-menu dropdown-menu-right dm-icon"><li><a href="#" ng-click="setType(\'column\')"><i class="zmdi zmdi-chart-column"></i><i class="zmdi zmdi-check pull-right" ng-if="TYPEX==\'column\'"></i> Colonnes</a></li><li><a href="#" ng-click="setType(\'pie\')"><i class="zmdi zmdi-check pull-right" ng-if="TYPEX==\'pie\'"></i><i class="zmdi zmdi-donut_small"></i>Pie</a></li></ul></li></ul></div><div class="card-body" style="min-height: 200px;"><div class="p-t-20"><div class="crtg" style="width:100%;height:100%"></div></div></div></div>',
		scope: {xtitle:"@xtitle",url: "@url",TYPEX: '@type',title: '@title',subtitle: '@subtitle',list:"@"},
		link: function (scope, element, attrs,ngModel) {
			
			scope.TYPEX = "column";scope.DATA =[];scope.TYPEX1 = "month";
			scope.setType1 = function (t) {scope.TYPEX1 = t;scope.load();}
			scope.setType = function (t) {scope.TYPEX = t;scope.refreshChart();}
			scope.$on(''+scope.url, function(event, data){scope.DATA =data;scope.refreshChart();});
			scope.$on('containnerresized', function(event, data){$timeout(function () {scope.refreshChart ();})});
		scope.refreshChart = function () {
			Highcharts.chart($(element).find(".crtg")[0], {
			chart: {type: scope.TYPEX,options3d:(scope.TYPEX=="column")?{enabled:false}:{ enabled: true, alpha: 45, beta: 0 }
			},
			title: {text:scope.title},yAxis: {title: {text: scope.xtitle+"<br>"}},
			subtitle: {text:scope.subtitle},
			xAxis: {type: 'category'},
			accessibility: {announceNewData: {enabled: true}},
			legend: {enabled: false},
			plotOptions: {
				pie: {depth: 45,dataLabels: {enabled: true,format: '{point.name}: {point.percentage:.1f}%'},tooltip: {
				pointFormat: '<span >{point.name}</span>: <b>{point.y:.2f}</b><br/>'}}, 
				column: {groupPadding: 0,pointWidth: 30,borderWidth: 0,dataLabels: {enabled: true,format: '{point.y:.2f}'},
				tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> Dhs<br/>'
			}}
			},
    
			series: [{name: "Revenues par ans",colorByPoint: true,data:scope.DATA.chart}],
			drilldown:{breadcrumbs: {position: {align: 'right'}},series:scope.DATA.drill}
			})
			}
			scope.load = function () {
				scope.LoaDing = true;$http.post(scope.url,{year:scope.excercie,type:scope.TYPEX1}).then(function (res) {if (res.data.test == true) {scope.DATA = res.data.data;scope.refreshChart();}else{growlService.growl("Erreurs de chargement du "+scope.title+"...!", 'danger')};scope.LoaDing = false;}, function () { growlService.growl("Pas de connexion Internet...!", 'danger',5000);;scope.LoaDing = false;})
			}
		}
	};
})