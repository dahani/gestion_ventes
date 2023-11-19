<div class="container">
<div class="card" id="profile-main">
<div class="pm-overview c-overflow">
<div class="pmo-pic o-hidden">
<div class="smallloading" ng-if="loadingprofile">{{PERCENTt}}</div>
<div class="p-relative"> <img loadimage loader="loadingprofile"  class="img-responsive" ng-src="img/profiles/{{INFO.src}}"  alt=""><input accept="image/*" type="file" ng-upload-change="fileNameChanged($event)"  style="width: 95%;height: 60px;position: absolute;right: 5px;top: 3px;opacity: 0;z-index:4;cursor: pointer;"/>
<div class="dropdown pmop-message" uib-dropdown  is-open="open"><button uib-dropdown-toggle class="btn bgm-white btn-float"><i class="zmdi zmdi-edit"></i></button>
<div class="dropdown-menu stop-propagate"><div class="smallloading" ng-if="jdhjde"></div>
   <input uib-tooltip="Votre Nom" tooltip-class="tooltip-blue" tooltip-placement="bottom" tooltip-trigger="focus"  placeholder="Nom"  type="text" autocomplete="off"  class="form-control" ng-model="INFO.name" >
	<button class="btn bgm-green btn-float" ng-click="save()"><i class="zmdi zmdi-check"></i></button>
</div>
</div>
<a href="#" class="pmop-edit"><i class="zmdi zmdi-camera"></i> <span>Mettre à jour la photo de profile</span></a> 
</div>
<div class="pmo-stat">
<h2 class="m-0 c-white">{{INFO.name}}</h2>
</div>
</div>
</div>
<div class="pm-body clearfix">
<div role="tabpanel p-relative">
<div class="smallloading" ng-if="LoaDing && info"></div>
<ul class="tab-nav tn-justified" role="tablist">
<li class=" waves-effect" ng-class="{'active':PAGE==1}"><a href="#" ng-click="PAGE=1" ><i class="zmdi zmdi-avatar6 pull-left" style="font-size: 18px;color: #2379ff;"></i> Profile</a></li>
<li class="waves-effect" ng-class="{'active':PAGE==2}"><a href="#" ng-click="PAGE=2" ><i class="zmdi zmdi-lock pull-left" style="font-size: 18px;color: #2379ff;"></i> Changer le mot de passe</a></li>
</ul>
<div class="tab-content o-hidden">
<div role="tabpanel" class="tab-pane active animated fadeInRight" ng-class="{'active':PAGE==1}">
<div class="pmb-block">
<div class="pmbb-header">
<h2><i class="zmdi zmdi-account m-r-5"></i> Information</h2>
</div>
<div class="pmbb-body">
<div class="pmbb-view">
<dl class="dl-horizontal">
<dt>Nom</dt>
<dd><b>{{INFO.name}}</b></dd>
</dl>
<dl class="dl-horizontal">
<dt>Email</dt>
<dd><b>{{INFO.email}}</b></dd>
</dl>
<dl class="dl-horizontal">
<dt>Date création</dt>
<dd style="width: max-content;"><b>{{INFO.createime|date:'EEEE dd LLLL yyyy'}}</b></dd>
</dl>
</div>
</div>
</div>
</div>
<div role="tabpanel" class="tab-pane animated fadeInRight " ng-class="{'active':PAGE==2}">
<div class="col-md-12 col-sm-12 " style="float: none;margin: auto;" >
<div class="lb-body" style="padding:30px">
<form name="MYDATA">
<div class="form-group  has-feedback has-success" >
<label class="control-label" for="email">Email</label>
<div class="fg-line"  ><input  placeholder="Email"   type="email" autocomplete="off"  class="form-control" ng-model="DATA.email" id="email" name="email">
<small ng-show="MYDATA.email.$touched && MYDATA.email.$invalid " class="help-block palette-Red text animated slideInDown">Email Invalide</small>
</div>
</div>
<div class="form-group  has-feedback has-success" >
<label class="control-label" for="pass">Ancien mot de passe</label>
<div class="fg-line"  ><input  placeholder="Ancien mot de passe" required  type="text" autocomplete="off"  class="form-control" ng-model="DATA.pass" id="pass" name="pass">
</div>
</div>
<div class="form-group  has-feedback has-success" >
<label class="control-label" for="npass">Nouveau mot de passe</label>
<div class="fg-line"  ><input uib-tooltip="Le nouveau mot de pass est obligatoire 4 lenght" required tooltip-class="tooltip-blue" tooltip-placement="bottom" tooltip-trigger="focus"   placeholder="Nouveau mot de passe" ng-minlength="4"   type="text" autocomplete="off"  class="form-control" ng-model="DATA.npass" id="npass" name="npass"><small ng-show="MYDATA.npass.$error.minlength && MYDATA.npass.$touched && MYDATA.npass.$invalid " class="help-block palette-Red text animated slideInDown">Le nouveau mot de pass est obligatoire 4 lenght</small>
</div>
</div>
<button class="btn bgm-teal bg waves-effect" ng-click="save_password()" ng-disabled="!MYDATA.$valid"><i class="zmdi zmdi-check"></i> Mettre à jour</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>