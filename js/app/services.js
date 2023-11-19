const iterate = (obj) => {
    Object.keys(obj).forEach(key => {
	if(angular.isDate(obj[key])){obj[key]=moment.utc(obj[key].toUTC()).format("YYYY-MM-DD").toString();obj[key]=obj[key]=="Invalid date"?null:obj[key];}
    if (typeof obj[key] === 'object' && obj[key] !== null) {iterate(obj[key])}
    })
}
materialAdmin .filter('unsafe', function ($sce) {return function (text) {if (typeof text != "undefined") {return $sce.trustAsHtml(text.replaceAll("\n", "<br>"))}}})
.filter('capitalize', function () {return function (t) {if(t){return t.substr(0, 1).toUpperCase();}}}).filter('filiere', function() {return function(input) {var t="";for(x in input){if(input[x].val==true){t+=input[x].name+',';}}return t.slice(0,-1);}}).filter('charAt', function () {return function (token) {if(token){return token.charAt(0).toUpperCase() + token.slice(1);}}}).filter('SUM', function () {return function (t) {
	if(angular.isArray(t)){const total=t.reduce((total,item)=>{return total+=item;},0);
		;return total;}else{return 0;}
	}}).filter('percent', function ($filter) {return function (bz,taux) {
	if(typeof taux=="undefined"){return bz}else{return (bz-(bz*(taux/100)));}
	}}).filter('setcolappse', function () {return function (input,v) {
		if(v?.length>0){
			input.map((e)=>{e.isCollapsed=true;e.children?.map((c)=>{c.isCollapsed=true;return c;});return e;})
		}
	return input
	};	
	}).filter('icon', function($sce) {
    return function(text) {
       if(text){
            if (text.match(/pdf/g)) {
                return " zmdi-pdf";
            } else if (text.match(/jpg|png|jpeg/g)) {
                return " zmdi-photo";
            } else if (text.match(/doc|docx/g)) {
                return " zmdi-word";
            } else if (text.match(/xml|html|htm/g)) {
                return " zmdi-xml";
            } else if (text.match(/xls|xlsx/g)) {
                return " zmdi-excel";
            } else  {
                return " zmdi-folder";
            } 
	   }	 
    }
}).filter('round', function () {return function (input) {return Math.round(input)}})
materialAdmin.service('LOADAPPINFOSERVICE', function ($http,$interval,$rootScope,data) {
	var $data = angular.copy(data);;var $menu = {};
	$menu.getInfos = function () {return $data.infos;}
	$menu.setInfos = function (s) { $data.infos=s;}
	$menu.getSession = function () {return $data.session;}
	$menu.getConfigAuto = function () {return $data.config;}
	$menu.setConfigAuto = function (s) {$data.config = s;}
	$menu.getPermissions = function (s) {return $data.permissions;}
	$menu.getNotification = function () {return $data.notifs;}
	$menu.setNotification = function (s) {$data.notifs=s;}
	reloadNofifications = function () {$http.get("php/fn?action=refreshNotif").then(function(data){$rootScope.$broadcast('refreshNotif',data.data);},function(){console.log('Notifications retrieval failed.');});
    };
	var dfgtt=null;$menu.getPermission = function (page,text) {
		if ($data.permissions) {var perm = false;
			for (x in $data.permissions) {
				if ($data.permissions[x].url == page) {perm =text?$data.permissions[x][text]:$data.permissions[x].access;}
				if ($data.permissions[x].childrens) {
					for (y in $data.permissions[x].childrens) {
						if ($data.permissions[x].childrens[y].url == page.replace("/", "")) {perm = text?$data.permissions[x].childrens[y][text]:$data.permissions[x].childrens[y].access;}
					}
				}
			}
			if(text){return perm==false? "Paramètres" :perm;}else{return perm;}
		}
	}; 
	$menu.init = function (s) {$data = s;if(!DEBUG){var dfgtt=null;$interval(reloadNofifications, 30000);}};return $menu;
}).service('growlService', function () {
	var gs = {};gs.growl = function (message, type,delay,config) {
		$CX={type: type,allow_dismiss: true,label: 'Annuler',className: 'btn-xs btn-inverse',placement: config||{from: 'bottom',align:'center'},delay: delay||3500,animate: {enter: 'animated bounceIn',exit: 'animated bounceOut'},offset: {x: 20,y: 10}};
		if(IS_MOBILE){$CX.placement={from: 'top',align:'center'};$CX.animate={enter: 'animated slideInDown',exit: 'animated slideOutUp'};$CX.offset= {x: 0,y: 0}}
		$.growl({message: message}, $CX);
	};return gs;
}).factory('HttpInterceptor', ['$rootScope', '$q', function ($rootScope, $q, growlService) {
			return {
				'request': function (config) {
					config.headers['X-Requested-With'] = 'XMLHttpRequest';config.headers['X-Csrf-Token'] = IsMobile;config.headers['zone'] = moment().format('Z');
				if(typeof config.data!=="undefined"){
					iterate(config);
					if(!config.data.upload && config.url.indexOf("action")>0 && typeof config.transformRequest!="function"){
					config.transformRequest=function (e) {data=angular.copy(e);
						for(x in data.data){
						if(angular.isDate(data.data[x])){data.data[x]=moment.utc(data.data[x].toUTC()).format("YYYY-MM-DD").toString();data.data[x]=data.data[x]=="Invalid date"?null:data.data[x];}
					}
					 return JSON.stringify(makeDate(data));
				}
					}
				}
					if (!config.eventHandlers === undefined) {
						config.eventHandlers = {
							progress: function (evt) {
								if (evt) {console.log( "downd "+Math.round(evt.loaded * 100 / evt.total)+"%");}
							}
						}
					}
					if (!config.uploadEventHandlers === undefined) {
						config.uploadEventHandlers = {
							progress: function (evt) {
								if (evt.lengthComputable) {
									console.log("up"+ Math.round(evt.loaded * 100 / evt.total)+"%");
								}
							}
						}
					}
					return config || $q.when(config);
				},
				'requestError': function (rejection) {$q.reject(rejection);},
				'response': function (response) {
					if(!DEBUG){if(response.config.url.indexOf("action")>0){try{var rs=(b64_to_utf8(response.data).substr(14));
					rs=rs.replaceAll("♫","{");rs=rs.replaceAll("♪","}");rs=rs.replaceAll("☼",":");rs=rs.replaceAll("♣",";");
					rs=JSON.parse(rs);response.data=rs;}catch(e){console.log(e)}}}
					if(response.data.test==false && response.data.code=="406"){setTimeout(function(){location.href="logout";},3000);}
					return response || $q.when(response);
				},
				'responseError': function (rejection) {
					return $q.reject(rejection);
				}
			};
		}
	]);