<?php include_once("../php/cn.php"); header("Access-Control-Allow-Origin:".AllowOriginAccess);header("Content-Type: text/plain; charset=UTF-8");  ?>
<script type="text/ng-template" id="notestmpl.html">
<div class="modal-content"><div class="smallloading" ng-if="LoaDing1"></div><form  name="pay" ng-submit="save()"><div class="modal-header text-center"><h4 class="modal-title c-white">Ajouter </h4>
</div>
<div class="modal-body">
<div class="input-group m-t-20 has-success"><label class="control-label">Date</label>
	<div class="fg-line"><input type="datetime-local" ng-disabled="INFO" required class="form-control" ng-model="NEWITEM.date_"></div>
</div>

<div class="form-group m-t-20 has-success" >
<label class="control-label" >Text</label>
<div class="fg-line"  ><textarea  ng-disabled="INFO" rows="5" placeholder="Text"  autocomplete="off"  class="form-control" ng-model="NEWITEM.text" ></textarea>
</div>
</div>

	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" type="submit" ng-disabled="pay.$invalid || INFO " >OK</button>
		<button class="btn btn-link" type="reset"  ng-click="instance.close()">Cancel</button>
	</div>
	</form>
</div>
</script>

<div class="container">
<div class="card z-depth-2 border">
<div class="listview  lv-lg lv-bordered ">
<div class="lv-header-alt clearfix " ng-show="CURPAGE==0" >
<h2 class="lvh-label"><div ng-if="!MULTIPLE || selectedRowsIndexes.length==0" >  <i class="zmdi zmdi-call m-r-10"></i>  Notes ({{TOTALITEMS}})</div><ng-pluralize ng-if="MULTIPLE && selectedRowsIndexes.length>0" count="selectedRowsIndexes.length" when="{'0': 'Zéro ligne sélectionnée.','one': 'Une ligne sélectionnée .','other': '{} lignes sélectionnées.'}" ></ng-pluralize></h2>
<div class="lvh-search" ng-show="listviewSearchStat">
<i ng-click="listviewSearchStat = !listviewSearchStat" class="ah-search-close zmdi zmdi-long-arrow-left" ></i>
<input type="text" placeholder="Recherche dans la liste"  ng-keyup="$event.keyCode==27?listviewSearchStat =false:''" focus-me="listviewSearchStat" ng-model="serchfield"  ng-model-options="{debounce: 500}" ng-change="RELOAD()" class="lvhs-input" />
<i class="lvh-search-close" ng-click="serchfield='';listviewSearchStat =false;RELOAD()">&times;</i>
</div>
<ul class="lv-actions actions">
<li tooltip-class="tooltip-blue" uib-tooltip="Recherche" > <a href="#" class="ah-search-trigger" ng-click="listviewSearchStat = true;CURPAGE=0;"> <i class="zmdi zmdi-search"></i> </a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Supprimer"><a ng-class="!selectedItem && !MULTIPLE ?'opa3 ':''" ng-if="PERMISSON[2].value"  ng-click="delete()" href="#"><i class="zmdi zmdi-delete"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Modifier"><a ng-class="selectedItem==null?'opa3 ':''" ng-if="PERMISSON[1].value"  ng-click="infos(1)" href="#"><i class="zmdi zmdi-edit"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Annuler"><a ng-class="(CURPAGE==0 && (!selectedItem && !MULTIPLE))?'opa3 ':''"  ng-click="cancell();" href="#"><i class="zmdi zmdi-reply"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Informations"><a ng-class="selectedItem==null?'opa3 ':''"  ng-click="infos()" href="#"><i class="zmdi zmdi-info_outline"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Ajouter"><a  ng-click="add_ligne()" ng-if="PERMISSON[0].value" href="#"><i class="zmdi zmdi-plus"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Rafraîchir"><a  ng-click="RELOAD()" href="#"><i class="zmdi zmdi-refresh"></i></a></li>
<dh-paginate page-size="pageSize" ></dh-paginate>
</ul>
</div>
</div>
<div class="card-body o-hidden " style="min-height: 300px;"> <div class="smallloading" ng-if="LoaDing"></div>
<div class="">
<div role="tabpanel" class="tab">
<div class="tab-content p-0" >
<div role="tabpanel" class="tab-pane animated  slideIn{{class}} "  ng-class="{'active':CURPAGE==0}">
<table-directive ></table-directive>
</div>
<div class="clearfix"></div>           	   
</div>
</div>
</div>
</div>
</div></div>
