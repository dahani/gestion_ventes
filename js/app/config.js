function b64_to_utf8(str) {return decodeURIComponent(escape(window.atob(str)));}
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {IS_MOBILE=true;angular.element('html').addClass('ismobile');}
const handleThemeUpdate = (cssVars) => {const root = document.querySelector(':root');const keys = Object.keys(cssVars);keys.forEach(key => {root.style.setProperty("--"+key, cssVars[key]);});}
const hasInputSupport = function(el){try {const input = document.createElement('input');input.type = el;input.value = '!';return input.type === el && input.value !== '!';} catch (e) {return false;};
};
String.prototype.replaceAll = function(search, replacement) {var target = this;return target.replace(new RegExp(search, 'g'), replacement);};
Date.prototype.toUTC= function(){return new Date(Date.UTC(this.getFullYear(),this.getMonth(), this.getDate()));}
String.prototype.toUTC= function(){moment.utc(this,"DD/MM/YYYY").toDate();}
function makeDate(arr){var tvqs=angular.copy(arr);for(x in tvqs){if(angular.isDate(tvqs[x])){tvqs[x]=moment.utc(tvqs[x].toUTC()).format("YYYY-MM-DD").toString();tvqs[x]=tvqs[x]=="Invalid date"?null:tvqs[x];}if(typeof tvqs[x]=="object"){for(y in tvqs[x]){for(z in tvqs[x][y]){if(angular.isDate(tvqs[x][y][z])){tvqs[x][y][z]=moment.utc(tvqs[x][y][z].toUTC()).format("YYYY-MM-DD").toString();tvqs[x][y][z]=tvqs[x][y][z]=="Invalid date"?null:tvqs[x][y][z];}}}}}return tvqs;
}
function typeoof(p){if(typeof p=="undefined" || p==null){return true;}else if(p.length==0){return true;}else if(p && p.length>0){return false;}}
function getRandomInt(min, max) {return Math.floor(Math.random() * (max - min + 1)) + min;}
 $(document).click(function(){autodeconnexion(CONFIGG);})
 function autodeconnexion(AutoDecon){if(AutoDecon){CONFIGG=AutoDecon; 
 if(typeof timeOutObj!="undefined"){clearTimeout(timeOutObj);}if(typeof timeOutObjaleft!="undefined"){clearTimeout(timeOutObjaleft);}
 if(AutoDecon.active==true){timeOutObj=setTimeout(function(){window.location.hash="logout";},AutoDecon.time*60000); timeOutObjaleft=setTimeout(function(){ 
 audioElement.play();$.growl({message: "Déconnexion en 30 secondes"}, {type: "info",className: 'btn-xs btn-inverse',placement: {from: 'bottom',align:'center'},delay: 30000,animate: {enter: 'animated bounceIn',exit: 'animated bounceOut'},offset: {x: 20,y: 10}});
 },(AutoDecon.time*60000)-30000); 
 }}}
var materialAdmin = angular.module('materialAdmin', ['cfp.hotkeys','ngAnimate','ui.router','ui.bootstrap','oc.lazyLoad',"yaru22.angular-timeago","angular-ios-alertview","tableDirective","angucomplete"]);

materialAdmin.run(function($templateCache,$rootScope,growlService,$location,LOADAPPINFOSERVICE,$state,$transitions,$http,$timeout,$interval) {$rootScope.loadinng = true;
	 $transitions.onSuccess({}, function($transition) {
		/* if(($transition.$to().parent.name=="app.settings") && LOADAPPINFOSERVICE.getSession().admin==false){
		 var xx=LOADAPPINFOSERVICE.getPermission($transition.$to().parent.name);
		if(xx===false){growlService.growl('page inaccessible', 'danger'); $state.go('app.home') }
	}*/
	var namex=LOADAPPINFOSERVICE.getPermission($transition.$to().name,"text");$("title").text(LOADAPPINFOSERVICE.getInfos()['name']+" ("+namex+")");
	$rootScope.titlepage=namex;$timeout(function(){$rootScope.loadinng = false; });window.scrollTo(0,0);
	 $rootScope.SELECTED_PAGE=$transition.$to().name;});
   $transitions.onError({}, function(a) {$rootScope.loadinng = false;
   switch(a._error.type){
    case 5: {console.log(a.error().message);return;};break;
	case 6: {growlService.growl("Pas de connexion Internet...!", 'danger',5000);};break;
	default: {console.log(a.error().message);return;};break;
}
   })
     $transitions.onBefore({}, function($transition) {
		 
	 if($transition.params().cache==false){;$templateCache.remove($transition.$to().views['content@'].templateUrl);}
	if(typeof $transition.$to().self.exclude=="undefined"){
		 var xx=LOADAPPINFOSERVICE.getPermission($transition.$to().name);
		if(xx===false){growlService.growl('page inaccessible ', 'danger'); return false; }
	 }else{console.log("exl");return true;}
 });
	  $transitions.onStart({}, function($transition) {if($transition.$to().name==$transition.$from().name){return false;};$rootScope.loadinng = true;$('.tnotify-overlay').remove();
	  $rootScope.sidebarToggle = {left: false,right: false}
});
if(!DEBUG){$location.path("home");}
}).config(function($locationProvider,$httpProvider,$stateProvider,$urlRouterProvider,$animateProvider,$compileProvider,timeAgoSettings,$qProvider,data){
    $qProvider.errorOnUnhandledRejections(false);
	timeAgoSettings.allowFuture=true;
	$compileProvider.debugInfoEnabled(DEBUG);$compileProvider.commentDirectivesEnabled(DEBUG);$animateProvider.classNameFilter( /\banimated\b/ );
	$httpProvider.interceptors.push('HttpInterceptor');$locationProvider.hashPrefix('');
        $urlRouterProvider.otherwise("/home");
        $stateProvider.state('app', {url: '',views: {'chat@':{templateUrl:"views/chat",controller:'chatCtrl'},'menu@':{templateUrl:"views/menu",controller:'menuCtrl'},'header@':{templateUrl:"views/header"+(data.config.header||"1"),controller:'headerCtrl  as hctrl'}},abstract: true}).state ('app.home', {
                url: '/home',views: {'content@': {templateUrl: 'views/home',controller:"homeCrtl"}},resolves:{loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'vendors',insertBefore: '#app-level-js',files: ['js/jquery.easypiechart.min.js',"js/jquery.sparkline.min.js","js/plugins/highcharts/highcharts.js","https://cdn.onesignal.com/sdks/OneSignalSDK.js"]}])}}
            }).state ('app.profile', {
                url: '/profile',views: {'content@': {templateUrl: 'views/profile',controller:"profileCtrl"}}
            }).state ('app.settings', {url: '/settings',exclude:true,views: {'content@': {templateUrl: 'views/settings'}}
            }).state ('app.settings.about', {url: '/about',exclude:true,controller:"infosCtrl",templateUrl: 'views/about',resolve: {loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'vendors',insertBefore: '#app-level-js',files: ['js/fileinput.js']}])}}
            }).state ('app.settings.tmpl', {url: '/tmpl',exclude:true,controller:"tmplCtrl",templateUrl: 'views/tmpl'
            }).state ('app.settings.type_d', {params: {title:"Nature dépenses",table:'type_depenses'},url: '/type_depenses',exclude:true,controller:"st_modelCtrl",templateUrl: 'views/st_model.html'
            }).state ('app.settings.certificat', {params: {title:"Certificat",table:'cert'},url: '/certificat',exclude:true,controller:"st_modelCtrl",templateUrl: 'views/st_model.html'
            }).state ('app.settings.configs', {url: '/configs',exclude:true,controller:"configsCtrl",templateUrl: 'views/configs'})
			.state ("app.gestioncomptes", {url: '/gestioncomptes',views: {'content@': {templateUrl: 'views/gestioncomptes',controller:"gestioncomptes"}},resolve:{loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'ngDragToReorder',insertBefore: '#app-level-js',files: ["js/list.draggable.js"]}])}}
            }).state ('app.settings.fournisseurs',{params: {'data':null},url: '/fournisseurs',controller:"fournisseursCtrl",templateUrl: 'views/fournisseurs',resolve: {loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'vendors',insertBefore: '#app-level-js',files: ['js/fileinput.js',"js/jquery.magnific-popup.min.js"]}])}} })
            .state ('app.statistiques', {params: {cache:false,'data':null},views: {'content@': {templateUrl: 'views/statistiques',controller:"statistiquesCtrl"}},url: '/statistiques',resolve:{loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'vendors',insertBefore: '#app-level-js',files: ['js/jquery.easypiechart.min.js',"js/jquery.sparkline.min.js","js/plugins/highcharts/highcharts.js"]}])}}
            }).state('app.sessions', {url: '/sessions',views: {'content@': {templateUrl: 'views/sessions',controller: 'sessionsCrtl'}},
			resolve:{loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'vendors',insertBefore: '#app-level-js',files: ["js/plugins/highcharts/highcharts.js"]}])}}
			}).state ('app.notifications', {url: '/notifications',views: {'content@': {templateUrl: 'views/notifications',controller:"notificationsCtrl"}}
            }).state ("app.depenses", {params: {'data':null},url: '/depenses',views: {'content@': {templateUrl: 'views/depenses',controller:"depensesCtrl"}}
            }).state('app.securite', {url: '/securite',exclude:true,views: {'content@': {templateUrl: 'views/securite',controller: 'securiteCrtl'}}
			}).state ('app.export', {url: '/export',views: {'content@': {templateUrl: 'views/export'}}
            }).state ("app.notes", {params: {'data':null},
                url: '/notes',views: {'content@': {templateUrl: 'views/note',controller:"notesCtrl"}}
            }).state("app.produits", {params: {'data':null,cache:false},url: '/produits',views:{'content@': {templateUrl: 'views/produits',controller:"produitsCtrl"}},resolve:{loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'vendors',insertBefore: '#app-level-js',files: ['js/fileinput.js','js/onscan.min.js',"js/jquery.magnific-popup.min.js"]}])}}
        }).state("app.ventes", {params: {'data':null},url: '/ventes',views: {'content@': {templateUrl: 'views/ventes',controller:"ventesCtrl"}},resolve:{loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'vendors',insertBefore: '#app-level-js',files: ['js/onscan.min.js']}])}}
         }).state ('app.achats', {params: {'data':null},url: '/achats',views: {'content@': {templateUrl: 'views/achats',controller:"achatsCtrl"}},
			resolve:{loadPlugin: function($ocLazyLoad) {return $ocLazyLoad.load ([{name: 'vendors',insertBefore: '#app-level-js',files: ['js/onscan.min.js']}])}}
            })
    });
const isValidBarcode=function (value) {
  if (!value.match(/^(\d{8}|\d{12,14})$/)) {return false;}
  const paddedValue = value.padStart(14, '0');
  let result = 0;
  for (let i = 0; i < paddedValue.length - 1; i += 1) {
    result += parseInt(paddedValue.charAt(i), 10) * ((i % 2 === 0) ? 3 : 1);
  }
  return ((10 - (result % 10)) % 10) === parseInt(paddedValue.charAt(13), 10);
}
    function handleConnectionError(err) {console.log(err)
        if (err.target != undefined) {
            if (err.target.readyState >= 2) { 
                console.log("QZ:"+"Connection to QZ Tray was closed");
            } else {
                console.log("QZ:"+"A connection error occurred, check log for details");
            }
        } else {var url=location. protocol+'//'+location.hostname+location.pathname+"driver.zip";
            console.log("QZ:"+err);
			$.growl({message:'<a href="'+url+'" target="_blank">Installer le driver de l\'imprimante ticket ,Cliquez ici pour le Télécharger</a>'}, {type:"info",className: 'btn-xs btn-inverse',delay:0,placement:{from: 'top',align:'left'},offset: {x: 10,y: 10},animate: {enter: 'animated bounceIn',exit: 'animated bounceOut'}});
			if(confirm("Installer le driver de l'imprimante ticket")){if(!window.open(url)){window.location.href=url;$(".openWindow").attr("href",url)[0].click();}}
        }
    }
	 function startConnection() {if(!IS_MOBILE){
        if (!qz.websocket.isActive()) {
          return  qz.websocket.connect({ retries: 2, delay: 1 }).then(function() {
				console.log("QZ:"+"connected");
            }).catch(handleConnectionError);
        } else {
            console.log("QZ:"+'An active connection with QZ already exists.');
        }
	 }else{console.log("ticket disabled for mobile")}}
    function endConnection() {
        if (qz.websocket.isActive()) {
            qz.websocket.disconnect().then(function() {
                console.log("QZ:"+"disconnect");
            }).catch(handleConnectionError);
        } else {
            console.log("QZ:"+'No active connection with QZ exists.');
        }
    }
	
	function showNotif(msg,t){
		$.growl({message:msg}, {type:"success",className: 'btn-xs btn-inverse',placement:{from: 'bottom',align:'left'},delay:2500,animate: {enter: 'animated bounceIn',exit: 'animated bounceOut'},offset: {x: 20,y: 50}});if(t==0){$("#printindicator").hide();}else{$("#printindicator").show();}
	} 
		function printRaw(info,newitem,session){var ITEMS=newitem.items||newitem.data.items||{};
		
var data = ['\x1B' + '\x40','\x1B' + '\x21' + '\x30','\x1B' + '\x61' + '\x31',info.name + '\x0A',info.name,'\x0A',info.name+'\x0A',info.name+'\x0A','\x1B' + '\x61' + '\x30','\x0A','\x0A','\x1B' + '\x45' + '\x0D','RECU N :'+newitem.n_facture+'\x0A', '\x1B' + '\x45' + '\x0A','\x1B\x61\x30',moment.utc().format("DD/MM/YYYY HH:mm:ss"),'\x0A',
'\x1B\x61\x30Responsable :',newitem.cr];
data.push("\x0A\x0A");
data.push('\x1B' + '\x45' + '\x0D');//bold
data.push(("Produits").padEnd(28,' ')+"Total".padEnd(7,' ')+"\x0A\x0A");data.push('\x1B' + '\x45' + '\x0A');//remove bold
var TTC=0,TVA=0,RM=0,HT=0;
angular.forEach(ITEMS,function(el,ind){el.rmx=el.prix-((el.rm*el.prix)/100);el.tt=parseFloat(el.tt);
		var ht=Math.round((el.tt/((el.tva*0.01)+1))* 100) / 100;tva=Math.round(((ht*el.tva)/100)* 100) / 100;TTC+=el.tt;TVA+=tva;RM+=((el.prix*el.q)*el.rm)/100;HT+=ht;
		el.name=(el.name+'').substr(0,23);el.qn=parseInt(el.q);el.ttt=(el.tt).toFixed(2)+''.substr(0,7);
		var txt=(el.qn+"X "+el.name).padEnd(28,' ')+el.ttt.padEnd(7,' ') +"\x0A";
		data.push(txt);
	});
data.push("\x0A\x1B\x61\x30");HT=(HT.toFixed(2)+"").padStart(7,' ');TVA=(TVA.toFixed(2)+"").padStart(7,' ');RM=(RM.toFixed(2)+"").padStart(7,' ');TTC=(TTC.toFixed(2)+"").padStart(7,' ');
data.push("Nombre de produit :\x1B\x45\x0D"+ITEMS.length+'\x0A');data.push("\x0A\x1B\x61\x32");
data.push('\x1B\x4D\x30'+'Total H.T'.padEnd(14,' ')+':\x1B\x45\x0D'+HT+'\x0A');data.push('Total TVA'.padEnd(14,' ')+':\x1B\x45\x0D'+TVA+'\x0A');
data.push('Total REMISE'.padEnd(14,' ')+':\x1B\x45\x0D'+RM+'\x0A');data.push('Total TTC'.padEnd(14,' ')+':\x1B\x45\x0D'+TTC+'\x0A');data.push('\x0A\x1B\x61\x31\x0A');
data.push('BONNE SANTE\x0A\x0A');
var qr = newitem.id+";"+newitem.cr+";"+moment.utc().format("YYYY-MM-DD");;var dots = '\x09';var qrLength = qr.length + 3;var size1 =  String.fromCharCode(qrLength % 256);var size0 = String.fromCharCode(Math.floor(qrLength / 256));
data.push(  '\x1D' + '\x28' + '\x6B' + '\x04' + '\x00' + '\x31' + '\x41' + '\x32' + '\x00'+
   '\x1D' + '\x28' + '\x6B' + '\x03' + '\x00' + '\x31' + '\x43' + dots+
   '\x1D' + '\x28' + '\x6B' + '\x03' + '\x00' + '\x31' + '\x45' + '\x30'+
   '\x1D' + '\x28' + '\x6B' + size1 + size0 + '\x31' + '\x50' + '\x30' + qr+'\x1D' + '\x28' + '\x6B' + '\x03' + '\x00' + '\x31' + '\x51' +'\x30' +
   '\x1D' + '\x28' + '\x6B' + '\x03' + '\x00' + '\x31' + '\x52' +'\x30' )
data.push('\x1B\x61\x30');data.push('\x0A\x0A\x0A\x0A\x0A\x0A\x0A');data.push('\x1B\x69');

var printer=JSON.parse(localStorage.getItem('LOCALCONFIG'));if(typeof printer.printer=="undefined" || printer.printer==""){
	showNotif("Sélectionnez une imprimante dans les paramètres de l'application",0);return;
}
var config = qz.configs.create(printer.printer);
if(qz.websocket.isActive()){showNotif("Impression en Cours",1);
	qz.print(config,data).then(function(){showNotif("Impression terminer",0);
}).catch(function(e) { console.error("QZ:"+e);$("#printindicator").hide(); });
}else{
	startConnection().then(function() {showNotif("Impression en Cours",1);
		qz.print(config,data).then(function(){showNotif("Impression terminer",0);
		}).catch(function(e) { console.error("QZ:"+e);$("#printindicator").hide(); });
 }).catch(handleConnectionError);
}
}