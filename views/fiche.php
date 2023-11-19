<?php include_once("../php/cn.php"); header("Access-Control-Allow-Origin:".AllowOriginAccess);header("Content-Type: text/plain; charset=UTF-8");  ?>
<form  action="export/office/absence" target="_blank" method="post"><div class="modal-header text-center"><h4 class="modal-title c-white">Sélectionner les Jours </h4></div><div class="modal-body"><br>
<div class="form-group  has-feedback has-success" >
<label class="control-label" >FORMATIONS <span class="c-red">*</span> </label>
<div class="fg-line"  >
<select   required class="form-control" name="frm"    ><?php foreach(getStConfig(FORMATIONS) as $k=>$v){echo "<option  value='{$k}'>{$v}</option>";}?></select>
</div>
</div>
<div class="form-group  has-feedback has-success" >
<label class="control-label" >Date 1 </label>
<div class="fg-line"  ><input ng-model-options="{debounce: 200}" name="date1" ng-change="hctrl.add2days()"  required type="date" autocomplete="off"  class="form-control" ng-model="hctrl.NEWITEM.date1" >
</div>
</div>
<div class="form-group  has-feedback has-success" >
<label class="control-label" >Date 2</label>
<div class="fg-line"  ><input  required type="date" name="date2" autocomplete="off"  class="form-control" ng-model="hctrl.NEWITEM.date2" >
</div>
</div>
<br></div><div class="modal-footer"><a class="btn btn-link" ng-click="instance.close()" >Annuler</a><button class="btn btn-primary" >Télécharger</button></div></form>