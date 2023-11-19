<?php 
if(!file_exists("php/config.php")){@header("location:install");}include_once("php/cn.php");check();
$cssfiles=array("css/icomoon/style.css","css/app.min.1.css","css/app.min.2.css","css/animate.min.css");
$jsfiles=array("js/jquery.min.js","js/angular.min.js","js/autocomplete.js","js/angular-ui-router.min.js","js/plugins.js","js/ui-bootstrap-tpls.min.js","js/app/config.js","js/app/main.js","js/app/services.js","js/app/templates.js","js/app/directives.js");

?>
<!DOCTYPE html><html  ng-class="{'o-hidden':sidebarToggle.right}"  data-ng-controller="materialadminCtrl as mactrl"><![endif]>
<head><style> :root {--bgcolor: #292929;--primarycolor: #ffffff;--fontsize:16px;--fontfamily:'Roboto'}.modal-header,.ios-alertview-button,.ios-alertview-inner,[tooltipss]:before, .smallloading .progress, #todo-lists, #header, .card-header,  .top-search-wrap,.add-tl-actions,.buttons:nth-last-child(1), .lv-header-alt, .action-header,.profile-menu > a .profile-info {background-color: var(--bgcolor)!important;color: var(--primarycolor)!important;}
body,html{font-size:var(--fontsize) !important;font-family:var(--fontfamily),'Roboto'!important;}
.ismobile .growl-animated {width: 100%!important;right: 0px!important;left: 0px!important;top: 0px!important;margin: 0px!important;bottom: unset!important;height: 73px;line-height: 3;text-align: center;animation-duration: .4s;}
.ismobile  .alert-dismissable .close{color: white;top: 0px;right: -30px;opacity: 1;font-size: 39px;}
.textupdate{width: 50%;margin: auto;margin-top: 96px;font-size: var(--fontsize) !important;font-family: var(--fontfamily),'Roboto'!important;    background-color: var(--bgcolor)!important;
    color: var(--primarycolor)!important;}
</style>
<noscript><meta http-equiv="refresh" content="0; url=noscript.html" /></noscript>
<meta charset="utf-8"><?php if(!preg_match("/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i",$_SERVER['HTTP_USER_AGENT'])){echo "<style>::-webkit-scrollbar {width: 16px;}::-webkit-scrollbar-track {-webkit-box-shadow: inset 0 0 6px #029688;-webkit-border-radius: 10px;border-radius: 10px}::-webkit-scrollbar-thumb {-webkit-border-radius: 10px;border-radius: 20px;background: #581c1c;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.5)}</style>";}
 ?> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="shortcut icon" href="favicon.ico">
<meta name="theme-color" id="thecolor" content="#00897b">
<title><?=GLOBALNAME ?></title>
<?php foreach($cssfiles as $f){ echo '<link href="'.$f."?v=".VERSION.'" rel="stylesheet">';} ?>
</head>
<body data-ng-class="{ 'sw-toggled': mactrl.layoutType === '1','header2':mactrl.data.config.header==2}" class="ng-cloak"   >
<header id="header"  data-ui-view="header" ng-class="{'sellwrap':seller}"></header>
<section id="main" >
<aside id="sidebar" data-ui-view="menu" data-ng-class="{ 'toggled': sidebarToggle.left === true }"></aside>
<aside id="chat" class="chat"  data-ui-view="chat" data-ng-class="{ 'toggled': sidebarToggle.right === true }"></aside>
<section id="content"  data-ui-view="content"  class="page animated page-view" ></section>
</section>
<div class="overlay" ng-show="sidebarToggle.right==true||sidebarToggle.left== true" ng-click="sidebarToggle.right=false;sidebarToggle.left=false;" ><p ng-if="sidebarToggle.right==true"  class="hidden-xs p-10 text-justify textupdate">
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div>
<footer id="footer" >COPYRIGHT <a style="color: red;font-weight: bolder;" target="_blank" href="http://www.kompassit.com">WWW.KOMPASSIT.COM</a> <?php echo "&copy; 2013-".date("Y")." v: ".VERSION;?>
<ul class="f-menu"><li ><a  ><small>© Tous droits réservés. Toute reproduction, même partielle, est interdite.</small></a></li></ul></footer>
<div class="page-loader-wrapper" ng-show="loadinng"><div class="loader"><div class="preloader"><div class="preloader pl-xl"><svg class="pl-circular" viewBox="25 25 50 50"><circle class="plc-path" cx="50" cy="50" r="20" /></svg></div></div><p>Please wait...</p></div>
</div>
<style>
.page.ng-leave{ z-index:9999; }.page.ng-enter{ z-index:8888; }.page.ng-enter{ -webkit-animation:zoomIn .7s both ease-in;-moz-animation:zoomIn .7s both ease-in;animation:zoomIn .7s both ease-in;animation-delay: .3s;}
.page.ng-leave{-webkit-animation:zoomOut 0.6s both ease-in;-moz-animation:zoomOut 0.6s both ease-in;animation:zoomOut 0.6s both ease-in; }
@media print {header#header,.action-header ,.tablex + p,dir-pagination-controls,footer#footer,[ui-view="menu"] {display: none;}section#main {padding: 0;margin: 0;}table th{background: #d2d0d0 !important;}table td{border:1px solid #b3aeae;padding: 1px!important;}table tr.selected{background:none!important}@page { margin: 0; size: auto;} body { margin: 0mm 0mm 0mm 0mm !important; padding: 0mm !important; } #header, .c-header, #footer, #s-user-alerts, #s-main-menu, #chat, .growl-animated, .m-btn { display: none !important; } *, *:before, *:after { background: transparent !important; color: #000 !important; box-shadow: none !important; text-shadow: none !important; } a, a:visited { text-decoration: underline; } a[href]:after { content: " (" attr(href) ")"; } abbr[title]:after { content: " (" attr(title) ")"; } a[href^="#"]:after, a[href^="javascript:"]:after { content: ""; } pre, blockquote { border: 1px solid #999; page-break-inside: avoid; } thead { display: table-header-group; } tr, img { page-break-inside: avoid; } img { max-width: 100% !important; } p, h2, h3 { orphans: 3; widows: 3; } h2, h3 { page-break-after: avoid; } .navbar { display: none; } .btn > .caret, .dropup > .btn > .caret { border-top-color: #000 !important; } .label { border: 1px solid #000; }}
@media screen and  (max-width:768px){section#content {padding: 30px 10px 20px 10px;}}
@media screen and (min-width: 1600px) {#content {width: 1370px;margin: auto;}}
@media screen and (min-width: 1400px) {#content {width: 100%;margin: auto;}}

.header2 .overlay{z-index:9}
.header2 .leftmenu .active{color: #ffd402;}
.right-sidebar {height: 100%;}


@font-face{font-family:'Roboto';font-style:normal;font-weight:400;src:local('Roboto'), local('Roboto-Regular'), url(css/fn/roboto.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{font-family:'Changa';font-style:normal;font-weight:300;font-display:swap;src:url(css/fn/Changa.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{font-family:'Dancing';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Dancing.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{font-family:'Teko';font-style:normal;font-weight:300;font-display:swap;src:url(css/fn/Teko.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{font-family:'Righteous';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Righteous.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{font-family:'Courgette';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Courgette.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{font-family:'Orbitron';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Orbitron.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{/*https://fonts.gstatic.com/s/philosopher/v14/vEFV2_5QCwIS4_Dhez5jcWBuT00.woff2*/font-family:'Philosopher';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Philosopher.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{/*https://fonts.gstatic.com/s/bangers/v13/FeVQS0BTqb0h60ACH55Q2A.woff*/font-family:'Bangers';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Bangers.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{/*https://fonts.gstatic.com/s/palanquin/v6/9XUilJ90n1fBFg7ceXwUrn9Yw5Gr.woff2*/ font-family:'Palanquin';font-style:normal;font-weight:600;font-display:swap;src:url(css/fn/Palanquin.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{/*https://fonts.gstatic.com/s/firasans/v10/va9E4kDNxMZdWfMOD5Vvl4jL.woff2*/font-family:'Fira';font-style:normal;font-weight:600;font-display:swap;src:url(css/fn/Fira.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{/*https://fonts.gstatic.com/s/abrilfatface/v12/zOL64pLDlL1D99S8g8PtiKchq-dmjQ.woff2*/font-family:'Abril Fatface';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Abril.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{/*https://fonts.gstatic.com/s/jura/v15/z7NOdRfiaC4Vd8hhoPzfb5vBTP1v7ZumR_g.woff2*/font-family:'Jura';font-style:normal;font-display:swap;font-weight:bolder;src:url(css/fn/Jura.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{/*https://fonts.gstatic.com/s/amaranth/v11/KtkuALODe433f0j1zMnFHdA.woff2*/font-family:'Amaranth';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Amaranth.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}@font-face{/*https://fonts.gstatic.com/s/novaflat/v12/QdVUSTc-JgqpytEbVeb0viFl.woff2*/font-family:'Nova';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Nova.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}

@font-face{font-family:'Merienda';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Merienda-Regular.ttf)}
@font-face{font-family:'Electrolize';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Electrolize-Regular.ttf)}
@font-face{font-family:'Revalia';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Revalia-Regular.ttf)}
@font-face{font-family:'Rajdhani';font-style:normal;font-weight:400;font-display:swap;src:url(css/fn/Rajdhani.ttf)}

</style>
<?php foreach($jsfiles as $f){ echo ' <script  src="'.$f."?v=".VERSION.'" ></script>';} ?>
<script id="app-level-js">var IsMobile="<?=$_SESSION[TOKEN]?>";var YEAR_START="<?=YEAR_START?>";var DEBUG=<?=DEBUG?'true':'false'?>;
var SESSION_NUMBER="<?=AllowOriginAccess.'login?id='.$_SESSION[TOKEN]?>";
var CONFIGG=null,IS_UTC=false;var IS_MOBILE=false;const MAP_API="AIzaSyD1cZtqidvg0m-f8Hd3S6RHx1mY-omuLS4";
var audioElement = new Audio("img/door_-_bell.mp3");const appendChild=Element.prototype.appendChild;const urlCatchers=["/AuthenticationService.Authenticate?","/QuotaService.RecordEvent?"];Element.prototype.appendChild=function(element){const isGMapScript=element.tagName==='SCRIPT'&&/maps\.googleapis\.com/i.test(element.src);const isGMapAccessScript=isGMapScript&&urlCatchers.some(url=>element.src.includes(url));;if(!isGMapAccessScript){return appendChild.call(this,element);}
return element;};

(function(){
angular.element(document).ready(()=>{
	var inj=angular.injector(["ng"])
	var $http=inj.get("$http");
	$http({url:"php/fn?action=load",method:"GET",headers:{'X-Requested-With': 'XMLHttpRequest','X-Csrf-Token': IsMobile}}).then(function(e){
		materialAdmin.constant("data",e.data).value("CHART_FOOTER","produit de KOMPASSIT").value("URL_API","php/");
		;autodeconnexion(e.data.config.AutoD);
		if(typeof e.data.config=="undefined"){
			if(!DEBUG){window.location.href="logout";return false;}
		}
		angular.bootstrap(document,['materialAdmin']);
	})
})
})()
</script>
</body>
</html>

