var appwx = angular.module('tableDirective', ['angular-ios-alertview','ng-context-menu']);
appwx.filter('picker', function($filter) {
    return function(value, filterName) {
        if (filterName) {
            v = filterName.split("#");
			if(v[0]=="currency"){
				return ($filter(v[0])(value,""));
			}else if(v[0]=="date"){
				return $filter("date")(value, v[1] || '',IS_UTC?'UTC':'');
			}else{
				return $filter(v[0])(value, v[1] || '',v[2] || '');
			}
        } else {
            return value
        }
    }
    ;
});
appwx.filter('highlight', function($sce) {
    return function(text, phrase) {
        var htmlRegex = /<([A-Za-z][A-Za-z0-9]*)\b[^>]*>(.*?)<\/\1>/;
        if (htmlRegex.test(text)) {
            return text
        }
        if (typeof text != "undefined") {
            text = text + "";
            if (phrase)
                text = text.replace(new RegExp('(' + phrase + ')','gi'), '<span class="highlighted">$1</span>');
            return (text);
        }
    }
});
appwx.filter('coloredx', function($sce) {
    return function(obj) {
       if(obj){
            if (obj.statusx == "0") {
                return "text palette-Green";
            } else if (obj.statusx == "1") {
                return "text palette-Orange-600";
            } else if (obj.statusx == "2") {
                return "text palette-Red";
            } 
	   }	 
    }
});
appwx.filter('colored', function($sce) {
    return function(text, obj) {
        if (text == "congestate") {
            if (obj.state ==1) {
                return "c-green";
            }else if (obj.state ==2) {
                return "c-red";
            }
        }
    }
});
appwx.filter('totalr', function() {
    return function(input, property) {
        var i = input instanceof Array ? input.length : 0;
        if (typeof property === 'undefined' || i === 0) {
            return i;
        } else {
            var total = 0;
            while (i--) {
                if (!isNaN(parseFloat(input[i][property]))) {
                    total += parseFloat(input[i][property]);
                }
            }
            return total;
        }
    }
    ;
});
appwx.directive('tableDirective', function($parse, $http, $sce, $timeout, iosAlertView, $filter, $rootScope, growlService,$compile) {
    return {restrict: 'EA',scope: false,replace: true,
        template: '<div style="min-height: 300px;"><div class="dropdown p-fixed" style="z-index: 2;" id="menu-tadatable"><ul class="dropdown-menu dm-icon" role="menu"><li ng-if="PERMISSON[1].value" ><a ng-class="selectedItem==null?\'opa3 \':\'\'" ng-click="infos(1)" href="#" class=""><i class="zmdi zmdi-edit"></i> Modifier</a></li><li ng-if="PERMISSON[2].value"><a ng-class="!selectedItem && !MULTIPLE ?\'opa3 \':\'\'"  ng-click="delete()" href="#"><i class="zmdi zmdi-delete"></i> Supprimer</a></li><li><a ng-class="selectedItem==null?\'opa3 \':\'\'"  ng-click="infos()" href="#"><i class="zmdi zmdi-info_outline"></i> Informations</a></li></ul></div><div class="smallloading" ng-if="loadintadatable" ><div class="progress" ng-style="{ width:progressIncicaor}">{{progressIncicaor}}</div></div><div style="overflow-x:auto;" class="tablecontainnr"><table class="card tablex  table {{ table2Options.class}}"  cellspacing="0" width="100%"> <tr><th style="width:1%" ng-if="table2Options.index">N°</th><th style="width:{{th.width?th.width:\'auto\'}}"   ng-click="sort(th.value,th.orderable)" ng-repeat="th in table2Options.columns track by $index"   ><span ng-bind-html="th.name|unsafe" ></span><span class="iconsort" ng-show="sortKey==th.value" ng-class="{\'zmdi zmdi-long-arrow-down\':!reverse,\' zmdi zmdi-long-arrow-down iconsortUP\':reverse}"></span></th></tr><tr  ng-repeat="x in DATA | filter:serchfield | orderBy:sortKey:reverse|limitTo: pageSize track by $index"  context-menu="setMenu(x,$event)" data-target="menu-tadatable" ng-click="setSelected(x,$event,$index)" class="{{x|coloredx}}"  ng-class="{selected: x.id === selectedItem.id || isRowSelected(x.id)}" ><td ng-if="table2Options.index">{{($index + 1) + (currentPage - 1) *pageSize}}</td><td dir="auto" ng-click="functionx(x,td,$event)" class="{{td.class}} {{td.class|colored:x}}" compile-template ng-repeat="td in table2Options.columns track by $index" ng-bind-html="x[td.value]|picker:td.filter | highlight:serchfield|unsafe" ></td></tr><tfoot ng-if="IS_SUM && DATA.length>0"><th ng-if="table2Options.index"></th><th  ng-repeat="th in table2Options.columns track by $index" >{{(th.sum)?(DATA|totalr:th.value|currency:""):" "}}</th></tfoot></table></div><p ng-show="numPages>1" class="text-center p-10 m-b-0" style="font-style: oblique;">Affichage de <b>{{range.lower}}</b> à  <b>{{range.upper}}</b> sur <b>{{TOTALITEMS}}</b> Enregistrements [ Page: <b>{{currentPage}}</b> / <b>{{numPages}}</b> ]</p><uib-pagination total-items="TOTALITEMS" max-size="10" items-per-page="pageSize" ng-model="currentPage" ng-show="numPages>1" num-pages="numPages" class="pagination " boundary-links="true"  force-ellipses="true" ng-change="pageChanged()" rotate="true" ></uib-pagination></div>',
        link: function($scope, elem, attrs) {if (typeof $scope.table2Options === "undefined") {throw "PARAMETRE INTROUVABLE ";return false;}
		$("#menu-tadatable .dropdown-menu").append(	$compile($scope.table2Options.actions)($scope));
            $scope.selectedRowsIndexes = [];$scope.selectedItem = null;$scope.progressIncicaor="";$scope.loadintadatable = false;$scope.DATA = [];$scope.MULTIPLE = false;$scope.IS_SUM = false;var indesx = 0;
            for (x in $scope.table2Options.columns) {
                if ($scope.table2Options.columns[x].sum == true) {indesx++;}
                if ($scope.table2Options.columns[x].value.indexOf("date") >= 0) {
					if(typeof $scope.table2Options.columns[x].class=="undefined"){$scope.table2Options.columns[x].class = " text-capitalize ";}else{$scope.table2Options.columns[x].class += " text-capitalize ";}
                }
            }
            $scope.IS_SUM = (indesx > 0) ? true : false;
            $scope.range = {lower: 1,upper: 1,total: 1};
            function updateRangeValues() { $scope.range.lower = ($scope.currentPage - 1) * $scope.pageSize + 1;$scope.range.upper = Math.min($scope.currentPage * $scope.pageSize, $scope.TOTALITEMS);}
            $scope.pageChanged = function() {updateRangeValues();$scope.RELOAD();}
			$scope.$watch("")
			 $scope.$watch('pageSize', function(n, o) {
				 if(o!=n){$scope.RELOAD();
				 }
			 })
            $scope.sortKey = $scope.table2Options.sort.sortBy;
            $scope.reverse = $scope.table2Options.sort.direction;
            $scope.isRowSelected = function(rowIndex) {return $scope.selectedRowsIndexes.indexOf(rowIndex) > -1;}
            function select(rowIndex) {if (!$scope.isRowSelected(rowIndex)) {$scope.selectedRowsIndexes.push(rowIndex)}}
            function changeSelectionStatus(rowIndex) {if ($scope.isRowSelected(rowIndex)) {unselect(rowIndex);} else {select(rowIndex);}}
            function select(rowIndex) {if (!$scope.isRowSelected(rowIndex)) {$scope.selectedRowsIndexes.push(rowIndex)}}
            function unselect(rowIndex) {var rowIndexInSelectedRowsList = $scope.selectedRowsIndexes.indexOf(rowIndex);var unselectOnlyOneRow = 1;$scope.selectedRowsIndexes.splice(rowIndexInSelectedRowsList, unselectOnlyOneRow);}
            $scope.setSelected = function(selectedItem, ev, rowIndex) {
				if( ev.target.nodeName=="TD"){
                if ($scope.table2Options.selected != false) {
                    $scope.listviewSearchStat = false; $scope.CURPAGE=0;
                    if (ev.ctrlKey) {
						if($scope.selectedItem!=null){changeSelectionStatus($scope.selectedItem.id);}
                        $scope.selectedItem = null;
                        $scope.MULTIPLE = true;
                        changeSelectionStatus(selectedItem.id);
                    } else {
                        $scope.selectedRowsIndexes = [];
                        $scope.MULTIPLE = false;
                        if ($scope.selectedItem == selectedItem) {
                            $scope.selectedItem = null;
                        } else {
                            $scope.selectedItem = selectedItem;
                            var newss = ($scope.selectedItem);
                        }
                        ;
                    }
                }
            }
		}
		  $scope.setMenu = function(selectedItem, ev) {if( ev.target.nodeName=="TD"){if ($scope.table2Options.selected != false) {$scope.selectedRowsIndexes = [];$scope.MULTIPLE = false;$scope.selectedItem = selectedItem;}}}
            $scope.sort = function(keyname, r) {
                if (r && $scope.DATA.length > 0) {
                    $scope.sortKey = keyname;
                    $scope.reverse = !$scope.reverse;
                }
            }
            $scope.RELOAD = function(e) {
                $scope.selectedItem = null;
				if(typeof $scope.extra!="undefined"){
					if(typeof $scope.extra.datef!="undefined" && typeof $scope.extra.dated!="undefined"){
					if($scope.extra.dated>$scope.extra.datef){growlService.growl("La date de début est supérieure à la date de fin ...!", 'danger');return false;}
					}
				}
                $scope.loadintadatable = true;$scope.progressIncicaor="0%";
				$http({ method: 'POST',url:$scope.table2Options.ajax.url + "?action=load",headers: {'Content-Type': undefined},data:{
                    q: $scope.serchfield,
                    pg: $scope.currentPage,
                    psiz: $scope.pageSize,
                    year: $scope.excercice,
					extra: $scope.extra,first:typeof e!="undefined",
					mois: $scope.mois
                },eventHandlers: {progress: function (evt) {
					$scope.progressIncicaor=(Math.round(evt.loaded * 100 / evt.total)+"%");if(DEBUG){console.log($scope.progressIncicaor);}
					}}}).then(function(res) {
                    if (res.data.test) {$scope.firstLoad=false;
                        $scope.DATA = res.data.d;
                        $scope.TOTALITEMS = res.data.count;
                        if ( typeof $scope.onLoad === "function") {$scope.onLoad(res.data);} 
						updateRangeValues();
                    } else {
                        growlService.growl(res.data.errors || 'Erreurs ...', 'danger');
                    }
                    $scope.loadintadatable = false;
                }, function() {
                    $scope.loadintadatable = false;
                    growlService.growl("Pas de connexion Internet...!", 'danger',5000);
                });
            }
            $scope.delete = function() {
				  if ($scope.selectedItem != null || $scope.MULTIPLE) {
                    var msg = "Bien Supprimer";var code = (Math.floor(100000 + Math.random() * 900000)).toString().slice(-4);
                    if ($scope.selectedItem != null && !$scope.MULTIPLE) {
                        if ($scope.table2Options.ajax.url.indexOf("students") >= 0) {
                            msg = "L'Etudiant (" + $scope.selectedItem.lname + ") est bien supprimer";
                        }else {
                            msg = "Bien supprimer";
                        }
                    }
                    var sup = $scope.MULTIPLE ? "(" + $scope.selectedRowsIndexes.length + ") lign" + ($scope.selectedRowsIndexes.length > 1 ? "es" : "e") + ($scope.selectedRowsIndexes.length > 1 ? " seront" : " sera") + "  effacée ?" : "";
                    iosAlertView.prompt({okText:"Valider",form:{inputValue:''},inputType:'number',title:'Êtes vous sûr de supprimer ?' ,text: sup+"Confirmez Le code <b class='c-orange f-20'>"+code+"</b>"}).then(function(p) {                
					  if (p!==null) {
							if(code==p){$scope.loadintadatable = true;$scope.progressIncicaor="0%";
						$http({ method: 'POST',url:$scope.table2Options.ajax.url + "?action=delete",headers: {'Content-Type': undefined},data:{
                                y: $scope.excercice,
                                c: $scope.SELECTED_ID,
                                q: $scope.serchfield,
                                dl: $scope.MULTIPLE ? $scope.selectedRowsIndexes : [$scope.selectedItem.id],
                                pg: $scope.currentPage,
                                psiz: $scope.pageSize,
								extra: $scope.extra,
								mois: $scope.mois,
								year: $scope.excercice
                            },eventHandlers: {progress: function (evt) {
					$scope.progressIncicaor=(Math.round(evt.loaded * 100 / evt.total)+"%");if(DEBUG){console.log($scope.progressIncicaor);}
					}}}).then(function(res) {
                                if (res.data.test) {
                                    $rootScope.$broadcast("DELETE_DATATABLE", {
                                        url: $scope.table2Options.ajax.url,
										data:res.data,
                                        deleted: $scope.MULTIPLE ? $scope.selectedRowsIndexes : [$scope.selectedItem.id]
                                    });
                                    $scope.DATA = res.data.data.d;$scope.serchfield="";
                                    $scope.TOTALITEMS = res.data.data.count;
                                    $scope.selectedItem = null;$scope.selectedRowsIndexes=[];
                                    growlService.growl(msg, 'info',8000);
                                    ;$scope.MULTIPLE = false;
                                } else {
                                    growlService.growl(res.data.errors || "Erreurs ...!", 'danger');
                                }
                                $scope.loadintadatable = false;
                            }, function() {
                                $scope.loadintadatable = false;
                                 growlService.growl("Pas de connexion Internet...!", 'danger',5000);
                            });
							}else{ growlService.growl("Erreurs de code  ...!", 'danger');}
                        }
                    },function(){});
                } else {
                    growlService.growl("Sélectionner une ligne ...!", 'danger');
                }
            }
            ;
            if (typeof $scope.table2Options.autoLoad == "undefined" || $scope.table2Options.autoLoad) {
                $scope.RELOAD(1);
            }
            $scope.MULTIPLE = false;
            $scope.cancell = function() {
                $scope.selectedItem = null;
                $scope.MULTIPLE = false;
                $scope.selectedRowsIndexes = [];
            }
        }
    }
});
angular.module('angucomplete', []).directive('angucomplete', function($parse, $http, $sce, $timeout, $document) {
    return {
        restrict: 'EA',
        replace: true,
        scope: {
            "id": "@id",
            "placeholder": "@placeholder",
            "classx": "@classx",
            "selectedObject": "=?selectedobject",
            "url": "@url",
            "userPause": "@pause",
            "style": "@stylex",
            "st": "@st",
            "dizabled": "=dizabled",
            "showfieldw": "@showfield",
            "showlabel": "=showlabel",
            "selectedid": "=?selectedid",
            "minLengthUser": "@minlength",
            "title": "@title",
            'onSelect': '&',
            'searchStr': '=?searchstr',
            'clax': '=?clax',
            "matchClass": "@matchclass"
        },
        template: '<div class="form-group  has-feedback has-success autocompletedh"  style="{{st}}" ><div ng-show="searching" id="demoIn" class="demo-bar mprogress-custom-parent"><div id="mprogress3" class="ui-mprogress"><div class="indeter-bar" role="mpbar3"></div><div class="bar-bg"></div></div></div><label class="control-label" for="{{id}}" ng-if="showlabel">{{title}}</label><div class="fg-line"  ><input  ng-disabled="dizabled" type="search" autocomplete="off"    ng-model="searchStr" placeholder="{{placeholder}}"  id="{{id}}" ng-class="{ok:clax,notok:!clax}" class="form-control  {{classx}} " style="{{style}}"/></div><ul ng-show="showDropdown"><li ng-if="errrored" class="palette-Red bg"  ng-click="hideDrop()">Erreur ...<span style="position: relative;right: 9px;top: 4px;" class="zmdi-warning pull-right c-red text zmdi"></span></li><li ng-repeat="x in results track by $index" ng-mousedown="selectResult(x)"   ng-mouseover="hoverRow()" ng-class="{\'selecteddh\': $index == currentIndex}">{{$index+1}} - <span ng-bind-html="x.name"></span></li><li ng-click="hideDrop()" ng-if="results.length==0 && !errrored">aucun resultat trouvé</li></ul></div>',
        link: function($scope, elem, attrs) {
            $document.on('click', function(e) {
                if (elem !== e.target && !elem[0].contains(e.target)) {
                    $scope.$apply(function() {
                        if ($scope.showDropdown) {
                            $scope.showDropdown = false;
                        }
                    });
                }
            });
            $scope.hideDrop = function() {
                $scope.showDropdown = false;
                $scope.searchStr = "";
            }
            $scope.lastSearchTerm = null;
            $scope.currentIndex = null;
            $scope.pause = 500;
            $scope.minLength = 1;
            $scope.showfield = "name";
            $scope.searching = false;
            $scope.DATA = [];
            $scope.showDropdown = false;
            $scope.searchTimer = null;
            $scope.errrored = false;
            if ($scope.minLengthUser && $scope.minLengthUser != "") {
                $scope.minLength = $scope.minLengthUser;
            }
            if ($scope.showfieldw && $scope.showfieldw != "") {
                $scope.showfield = $scope.showfieldw;
            }
            $scope.hoverRow = function(index) {
                $scope.currentIndex = index;
            }
            $scope.processResults = function(responseData, str) {
                if (responseData && responseData.length > 0) {
                    $scope.results = [];
                    for (var i = 0; i < responseData.length; i++) {
                        var text = (responseData[i][$scope.showfield]);
                        responseData[i][$scope.showfield] = $sce.trustAsHtml(responseData[i][$scope.showfield]);
                        if ($scope.matchClass) {
                            var re = new RegExp(str,'i');
                            if (text.match(re) != null) {
                                var strPart = text.match(re)[0];
                            } else {
                                var strPart = "";
                            }
                            text = $sce.trustAsHtml(text.replace(re, '<span class="' + $scope.matchClass + '">' + strPart + '</span>'));
                        }
                        var resultRow = {
                            name: text,
                            id: responseData[i].id,
                            obj: responseData[i]
                        };
                        $scope.results[$scope.results.length] = resultRow;
                    }
                    ;
                } else {
                    $scope.results = [];
                }
				if($scope.results.length==1 && isValidBarcode(str)){
					$scope.selectResult($scope.results[0]);$scope.results=[];
					 $scope.searching = false;$scope.errrored = false;$scope.showDropdown = false;
					return
				}else{ $scope.showDropdown = true;}
            }
            var inputField = elem.find('input');
			$scope.keyPressed = function(event) {
                if (!(event.which == 38 || event.which == 40 || event.which == 13)) {
                    if (!$scope.searchStr || $scope.searchStr == "") {
                        $scope.showDropdown = false;
                        $scope.lastSearchTerm = null
                    } else {
                        if ($scope.lastSearchTerm != $scope.searchStr) {
                            $scope.currentIndex = -1;
                            $scope.results = [];
							$scope.changexx();
                        }
                    }
                } else {
                    event.preventDefault();
                }
            }
            inputField.on('keyup', $scope.keyPressed);
			$scope.changexx=function(){
				var str=$scope.searchStr||"";
				if (str.length >= $scope.minLength) {
                    $scope.searching = true;
                    $scope.lastSearchTerm = $scope.searchStr;
                    $http.post($scope.url + str, {c: str
                    }).then(function(res) {
                        $scope.searching = false;
                        $scope.processResults(res.data, str);
                        $scope.errrored = false;
                    }, function(a,b,c) {
						console.log((a,b,c),"ethe")
                        $scope.searching = false;
                        $scope.showDropdown = true;
                        $scope.errrored = true;
                    }).catch(function(data) {
						console.log((data),"catch")
                        $scope.searching = false;
                        $scope.showDropdown = true;
                        $scope.errrored = true;
                    });
                }
			}
            $scope.selectResult = function(result) {
                if ($scope.matchClass) {
                    result.name = result.name.toString().replace(/(<([^>]+)>)/ig, '');
                }
                $scope.searchStr = $scope.lastSearchTerm = result.name;
                $scope.selectedObject = result.obj;
                $scope.selectedid = result.id;
                $scope.showDropdown = false;
                $scope.results = [];
                $scope.onSelect({result});
            }
        }
    };
}).directive('selectautocomplate', function($parse, $http, $sce, $timeout, $document) {
    return {
        restrict: 'EA',
        replace: true,
        scope: {
            "id": "@id",
            "placeholder": "@placeholder",
            "selectedObject": "=?selectedobject",
            "dizabled": "@",
			"DATAS": "=datas",
            "showlabel": "=showlabel",
            "selectedid": "=?selectedid",
            "title": "@title",
            'searchStr': '=?searchstr','onSelect': '&',
        },
        template: '<div class="form-group  has-feedback has-success autocompletedh" ><label class="control-label" for="{{id}}" ng-if="showlabel">{{title}}</label> <div class="fg-line"  ><i ng-click="toogleShow()" class="trigger zmdi zmdi-keyboard_arrow_down"></i><input autocomplete="new-password" ng-change="showDropdown = true" type="search" ng-model="searchStr" placeholder="{{placeholder}}" id="{{id}}"  ng-disabled="dizabled"  class="w3-input  form-control" /></div><ul ng-show="showDropdown"><li ng-repeat="yy in DATAS|filter:{name:searchStr}" ng-mousedown="selectResult(yy)"  >{{$index+1}} - <span ng-bind-html="yy.name|highlight:searchStr|unsafe"></span></li></ul> </div>',
        link: function($scope, elem, attrs) {
            $document.on('click', function(e) {if (elem !== e.target && !elem[0].contains(e.target)) {$scope.$apply(function() {if ($scope.showDropdown) {$scope.showDropdown = false;}});}});
			$scope.DATAS=[];$scope.showDropdown = false;
             $scope.selectResult = function(result) {$scope.searchStr = result.name;$scope.selectedObject = result;$scope.selectedid = result.id;$scope.showDropdown = false;$scope.onSelect({result});
            }
			$scope.toogleShow=function(){$scope.showDropdown=!$scope.showDropdown;};
			elem.find('input').on("focus", function(event) {$scope.showDropdown = true;}).on("blur", function(event) {$scope.showDropdown = false;}).on('click',function(){ this.select(); });
        }
    };
})