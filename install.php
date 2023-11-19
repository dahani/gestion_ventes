<?php if(file_exists("php/config.php")){@header("location:login");} include_once("php/cn.php"); $cssfiles=array("css/icomoon/style.css","css/app.min.1.css","css/app.min.2.css"); $jsfiles=array("js/angular.min.js");

if(isset($_REQUEST['action'])){
	if($_REQUEST['action']=="check"){
		$js = json_decode(file_get_contents("php://input"));
		if(@$js->host!="" and @$js->user!="" ){
			try {$pdo = new PDO("mysql:host=".@$js->host.";",@$js->user,@$js->pass);echo json_encode(array("test"=>true));}
		catch (PDOException $e) {
			echo json_encode(array("test"=>false,"error"=> $e->getMessage()));exit;
		}
		}else{
			echo json_encode(array("test"=>false,"error"=>"enter host and user"));exit;
		}
		
	}else if($_REQUEST['action']=="install"){
		$js = json_decode(file_get_contents("php://input"));$js=$js->c;
		if(@$js->host!="" and @$js->user!="" ){
			try {
				$c=fopen("php/config.php","w+");$str='<?php define("MLSLDBLKQS","'.encryptIt($js->db_name).'");define("LSDJSHOSTLSDJ","'.encryptIt($js->chost).'") ;define("DLZEDUSERJQSDJZ","'.encryptIt($js->cuser).'"); define("MSKASJJAPASSDSDJ","'.encryptIt($js->cpass).'");';
			
			if(fputs($c,$str)){echo json_encode(array("test"=>true));}exit;
	
			}
		catch (PDOException $e) {
			echo json_encode(array("test"=>false,"error"=> $e->getMessage()));exit;
		}
		}else{
			echo json_encode(array("test"=>false,"error"=>"enter host and user"));exit;
		}
	}
exit;	
}
 ?>
<!DOCTYPE html><html  lang="fr">
<head>
  <html class="login-content" data-ng-app="materialAdmin" >
        <title>INTALL APP</title>
		<meta name="theme-color" content="#009688">
       <?php foreach($cssfiles as $f){ echo '<link href="'.$f."?v=".VERSION.'" rel="stylesheet">';} ?>

    </head>

    <body class="login-content" data-ng-controller="loginCtrl as lctrl">

        <div class="lc-block toggled" >
		<p>Server config</p><br>
			 <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-security"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" ng-model="config.host" placeholder="Host">
                </div>
            </div>
		   <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-avatar6"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" ng-model="config.user" placeholder="User">
                </div>
            </div>
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                <div class="fg-line">
                    <input type="password" ng-model="config.pass" class="form-control" placeholder="Pass">
                </div>
            </div>
			 <div class="input-group m-b-20">
			
               <button class="btn  btn-icon-text {{connection_class}}"  ng-click="verify()"><i class="zmdi {{connection_state}}"></i> Verify connection</button>
            </div><br>
			<p>Install information</p><br>
			 <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="fg-line">
                    <input type="text"  ng-model="config.db_name" class="form-control" placeholder="DB NAME">   
                </div>
            </div>
			 <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-security"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" ng-model="config.chost" placeholder="Host">
                </div>
            </div>
		   <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-avatar6"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" ng-model="config.cuser" placeholder="User">
                </div>
            </div>
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                <div class="fg-line">
                    <input type="password" ng-model="config.cpass" class="form-control" placeholder="Pass">
                </div>
            </div>
			
			 <div class="input-group m-b-20">
			
               <button class="btn  btn-icon-text btn-success"  ng-click="install()"><i class="zmdi zmdi-upload"></i> Install</button>
            </div><br>
            <div class="clearfix"></div>
        </div>
<div class="page-loader-wrapper" ng-show="loadinng"><div class="loader"><div class="preloader"><div class="preloader pl-xl"><svg class="pl-circular" viewBox="25 25 50 50"><circle class="plc-path" cx="50" cy="50" r="20" /></svg></div></div><p>Please wait...</p></div>
    </div>
        <!-- Angular -->
		  <?php foreach($jsfiles as $f){ echo ' <script  src="'.$f."?v=".VERSION.'" ></script>';} ?>
		 <script>
		var materialAdmin = angular.module('materialAdmin', []);
		materialAdmin .controller('loginCtrl', function($scope,$http){$scope.loadinng=false;
			$scope.config={host:"localhost",chost:"localhost",user:"root",cuser:"root",pass:"",cpass:""};$scope.connection_state="";$scope.connection_class="btn-default";
        $scope.verify=function(){$scope.loadinng = true;
			$http.post("?action=check",{user:$scope.config.user,pass:$scope.config.pass,host:$scope.config.host}).then(function(e){
				if(e.data.test==true){
					$scope.connection_state="zmdi-verified_user";$scope.connection_class="btn-success";
				}else{$scope.connection_state="zmdi-block";$scope.connection_class="btn-warning";
					alert(e.data.error);
				}
				
				$scope.loadinng = false;
		},function(){alert("error");$scope.loadinng = false;});}
		
		$scope.install=function(){$scope.loadinng = true;
			$http.post("?action=install",{c:$scope.config}).then(function(e){
				if(e.data.test==true){window.location.assign("login");}else{alert(e.data.error);}
				$scope.loadinng = false;
		},function(){alert("error");$scope.loadinng = false;});}
		
    })</script>
	<div class="page-loader-wrapper" ng-show="loadinng"><div class="loader"><div class="preloader"><div class="preloader pl-xl"><svg class="pl-circular" viewBox="25 25 50 50"><circle class="plc-path" cx="50" cy="50" r="20" /></svg></div></div><p>Please wait...</p></div>
    </div>
    </body>
</html>

