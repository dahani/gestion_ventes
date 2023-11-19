<div class=" p-relative">
<div ng-if="loadingprofile"  class="progggresdf" ><div id="cont" data-pct="{{PERCENTt}}">
<svg id="svg" width="200" height="200" viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
<circle r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle><circle id="bar" r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0" style="stroke-dashoffset:{{proggg}}px;"></circle>
</svg>
</div></div>
<button class="bgm-blue btn btn-float m-btn visible-xs"  ng-click="save()"  style="right: 10px;"><i class="zmdi zmdi-check-all"></i></button>
<div class="card  m-b-0 border">
<div class="listview lv-bordered lv-lg">
<div class="lv-header-alt clearfix ">
<h2 class="lvh-label"> <i class="zmdi zmdi-info_outline  m-r-10"></i>A PROPOS </h2>
<ul class="lv-actions actions hidden-xs"><li ><a  ng-click="save()" href="#"><i class="zmdi zmdi-check-all"></i></a></li></ul>
</div>
</div>
<div class="card-body card-padding">
<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 pull-right " >
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="  background-image: url(img/{{INFO.logo}});background-repeat: no-repeat;background-position: center;background-size: contain;"></div>
<div class="text-center"><span class="btn btn-info btn-file"><span class="fileinput-new">Sélectionnez une image</span><span class="fileinput-exists">Changer</span><input type="file" name="..." id="jpokp">
</span><a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Retirer</a>
</div>
</div>
</div><br>
<div class="row clearfix">
<div class="col-12 col-sm-6 col-md-4" >
<div class="form-group  has-feedback has-success" >
<label class="control-label" for="name">App Name</label>
<div class="fg-line"  ><input  placeholder="Raison sociale"  type="text" autocomplete="off"  class="form-control" ng-model="INFO.name" id="name" name="name">
</div>
</div>
</div>

<div class="col-12 col-sm-6 col-md-4" >
<div class="form-group  has-feedback has-success" >
<label class="control-label" for="email">Email</label>
<div class="fg-line"  ><input  placeholder="Email"  type="email" autocomplete="off"  class="form-control" ng-model="INFO.email" id="email" name="email">
</div>
</div>
</div>

<div class="col-12 col-sm-6 col-md-4" >
<div class="form-group  has-feedback has-success" >
<label class="control-label" for="addr">Adresse</label>
<div class="fg-line"  ><input  placeholder="Adresse"  type="text" autocomplete="off"  class="form-control" ng-model="INFO.addr" id="addr" name="addr">
</div>
</div>
</div>

</div>
</div>
</div>
</div>