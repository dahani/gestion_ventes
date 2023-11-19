 <?php include_once("../php/cn.php"); header("Access-Control-Allow-Origin:".AllowOriginAccess);header("Content-Type: text/plain; charset=UTF-8");  ?>
 <div id="searchtopselect" class="top-search-wrap"><div class="tsw-inner"><i id="top-search-close" class="zmdi zmdi-long-arrow-left c-brown" data-ng-click="hctrl.closeSearch()"/><angucomplete showlabel="false" placeholder="Recherche : ............" on-select="hctrl.clicks(result)" idx="homeinputsearch" stylex="font-size:26px;padding: 20px 20px 20px 50px;border-radius: 35px;border: none;" showfield="name" pause="100" url="php/search?c=" classx="" searchStr="hctrl.searchStr" minlength="1" matchclass="highlighted"/></div></div>
 <ul class="header-inner clearfix">
      <li class="visible-sm visible-xs" id="menu-trigger" data-target="mainmenu" data-toggle-sidebar data-model-left="sidebarToggle.left" data-ng-class="{ 'open': sidebarToggle.left === true }"><div class="line-wrap"><div class="line top"/><div class="line center"/><div class="line bottom"/></div></li>
	  <li class=" hidden-sm hidden-xs">
      <ul class="top-menu leftmenu">
		<?php 
		foreach($_SESSION[ACCESS] as $m){
			if(!@$m->hideMenu){
				if(isset($m->childrens) and count($m->childrens)>0){
					echo '<li class="dropdown" uib-dropdown="">
		  <a uib-dropdown-toggle="" href=""# class="dropdown-toggle" ><span class="tm-label">'.$m->text.'</span></a>
          <ul class="dropdown-menu">';
		  foreach($m->childrens as $x){
			  echo '<li style="width: 100%;"  class="waves-effect" data-ui-sref-active="active">
          <a  ui-sref="'.$x->url.'"> <i class="zmdi zmdi-'.$x->icon.' m-r-10" style="color:#1a78c2;"></i> '.$x->text.'</a>
        </li>';
		  }
         echo '</ul></li>';
				}else{
				echo '<li  class="waves-effect" data-ui-sref-active="active">
          <a  ui-sref="'.$m->url.'"><span class="tm-label">'.$m->text.'</span></a>
        </li>';
			}
		}
		}
		?>
      </ul>
    </li>
      <li class="pull-right">
        <ul class="top-menu"><li id="top-search"><a href="" data-ng-click="hctrl.openSearch()"><i class="tm-icon zmdi zmdi-search"/></a></li>
		<li class="dropdown" uib-dropdown>   <a uib-dropdown-toggle ><i class="tm-icon zmdi zmdi-chat_bubble"></i> <i class="tmn-counts" ng-if="NOTIFS.msg.count>0">{{NOTIFS.msg.count}}</i></a>   <div class="dropdown-menu dropdown-menu-lg stop-propagate pull-right">  <div class="listview" id="message">  <div class="lv-header m-b-0">Messages  <ul class="actions"><li></li></ul>  </div>  <div class="lv-body">  <a class="lv-item" data-ui-sref="app.messages" ng-repeat="w in NOTIFS.msg.data track by $index"  ng-class="{'unread':(w.vue==0 && w.user!=w.sendTo)}"><div class="media"><div class="lv-avatar pull-left"><img ng-src="img/60/60/profiles/{{w.img}}" alt="{{w.name}}"></div><div class="media-body"><div class="lv-title"><span ng-if="w.sendermsg">{{w.sendermsg}} <i ng-class="{'zmdi-arrow_back':w.sender==0,'zmdi-arrow_forward':w.sender==1}" class=" zmdi "></i></span>{{ w.name }}</div><small class="lv-small">{{ w.text }}</small><small class="lv-actions c-gray">{{ w.date_ }}</small></div></div></a>  </div>  <div class="clearfix"></div><a class="lv-footer"  data-ui-sref="app.messages">Voir tout</a>  </div>   </div>   </li>
		<li  class="dropdown hidden-xs" uib-dropdown><a uib-dropdown-toggle href=""><i class="tm-icon zmdi zmdi-notifications"/><i class="tmn-counts" ng-if="NOTIFS.notif.length>0">{{NOTIFS.notif.length}}</i></a><div class="dropdown-menu dropdown-menu-lg stop-propagate pull-right"><div class="listview" id="notifications"><div class="lv-header m-b-0">Notification<ul class="actions"><li><a href="" data-ng-click="hctrl.clearNotification($event)"><i class="zmdi zmdi-check-all c-gray"/></a></li></ul></div><div class="lv-body"><a class="lv-item" ng-href="{{w.href}}" ng-repeat="w in NOTIFS.notif track by $index"><div class="media"><div class="media-body"><b class="lv-title c-blue">{{ w.name }}</b><small class="lv-small">{{ w.text }}</small></div></div></a></div><div class="clearfix"/><a class="lv-footer" data-ui-sref="app.notifications">Voir Tout</a></div></div></li><li class="dropdown  h-apps" uib-dropdown><a uib-dropdown-toggle href="#" tooltip title="Raccourci"><i class="tm-icon zmdi zmdi-apps"/></a><ul class="dropdown-menu pull-right">
		<li ng-repeat="x in hctrl.shortcuts"><a data-ui-sref="{{x.url}}"><i class="z-depth-1 bgm-{{x.color}} bg zmdi zmdi-{{x.icon}}"/><small>{{x.title}}</small><span class="bgm-{{x.color}} bganimatio"/></a></li>
		</ul></li><li ><a data-ng-click="hctrl.openSynthese()" href="#"><i class="tm-icon zmdi zmdi-invoice"/></a></li><li class="hidden-xs"><a data-ng-click="hctrl.fullScreen()" href=""><i class="tm-icon zmdi fullscreen" ng-class="{'zmdi-fullscreen':IS_FULL_SCREEN,'zmdi-fullscreen_exit':!IS_FULL_SCREEN}"/></a></li><li data-target="chat" data-toggle-sidebar data-model-right="sidebarToggle.right" data-ng-class="{ 'open': sidebarToggle.right === true }"><a href="#"><i class="tm-icon zmdi zmdi-color_lenspalette"/></a></li><li class="dropdown" uib-dropdown><a uib-dropdown-toggle href=""><i class="tm-icon zmdi zmdi-more-vert"/></a><ul class="dropdown-menu dm-icon pull-right"><li><a ng-if="INFO.admin" data-ui-sref="app.gestioncomptes"><i class="zmdi zmdi-people c-orange"/>Gestion des comptes</a></li><li ng-if="INFO.admin"><a data-ui-sref="app.sessions"><i class="zmdi zmdi-update c-green"/>Sessions</a></li><li ng-if="INFO.admin"><a data-ui-sref="app.securite"><i class="zmdi zmdi-security c-blue"/>Notifications de sécurité</a></li><li><a data-ui-sref="app.settings.about"><i class="zmdi zmdi-settings c-lime"/>Paramètres</a></li><li><a data-ui-sref="app.profile"><i class="zmdi zmdi-account c-pink"/>Mon Compte</a></li><li><a href="logout"><i class="zmdi zmdi-power c-red"/>Se déconnecter</a></li></ul></li></ul>
      </li>
    </ul>