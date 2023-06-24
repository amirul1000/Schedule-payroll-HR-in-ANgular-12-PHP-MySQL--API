    // create the module and name it spaApp
    // also include ngRoute for all our routing needs //,'ngTouch','ngAnimate','ui.bootstrap'
   var spaApp = angular.module('spaApp', ['ngRoute','ngTouch','ngAnimate','ui.bootstrap']);

    // configure our routes
    spaApp.config(function($routeProvider) {
              $routeProvider
              // route for the home page
              .when('/', {
                  templateUrl : 'http://localhost/pm/index.php/member/schedule/index',
                  controller  : 'mainController'
              })
			  .when('/about', {
                  templateUrl : 'about.html',
                  controller  : 'aboutController'
              })
			   .when('/contact', {
                  templateUrl : 'contact.html',
                  controller  : 'contactController'
              })
    });



// create the controller and inject Angular's $scope
spaApp.controller('mainController', function($scope,$http,$routeParams,$uibModal){
	         
	  
				
			
	});
	/*$scope.loadData2 = function(){
		        // Simple GET request example:
				$http({
				  method: 'POST',
				   data:{
					    cmd:'load_data'},
				  url: 'http://localhost/tutorial/spa_crud/api/crud.php'
				}).then(function successCallback(response) {
					   $scope.users = response.data;
					   console.log($scope.users);
					// this callback will be called asynchronously
					// when the response is available
				  }, function errorCallback(response) {
					// called asynchronously if an error occurs
					// or server returns response with an error status.
				  });	
		 	
		}*/
 spaApp.controller("ModelHandlerController",function($scope,$uibModalInstance,$http){
  
		 if((typeof user === "object" || typeof user === 'function') && (user !== null))
		 {
		   $scope.first_name = user[0].first_name;
		   $scope.last_name = user[0].last_name;
		   $scope.address = user[0].address;
		   $scope.id = user[0].id;
		 }
		  
		 $scope.cancelModal = function(){
			 console.log("cancelmodal");
			 $uibModalInstance.dismiss('close');
		 }
		 /*$scope.ok = function(){
		 $uibModalInstance.close('save');
		 
		 }*/
		 $scope.AddUser = function(){
		 $http({
				  method: 'POST',
				   data:{
					    cmd:'add',
						first_name:$scope.first_name,
						last_name:$scope.last_name,
						address:$scope.address,
						id:$scope.id },
				  url: 'http://localhost/tutorial/spa_crud/api/crud.php'
				}).then(function successCallback(response) {
					   alert(response.data);
					  // $scope.loadData();
					   
					// this callback will be called asynchronously
					// when the response is available
				  }, function errorCallback(response) {
					// called asynchronously if an error occurs
					// or server returns response with an error status.
				  });	
		 }
		 	
		 
 
});	
	
	
// create the controller and inject Angular's $scope
spaApp.controller('aboutController', function($scope,$routeParams){
	    $scope.first_name = "Jon";
		$scope.last_name = "Smith";
		$scope.changeName = function(){
			$scope.first_name = "New Jon";
		    $scope.last_name = "Mew Smith";
		}
	});
spaApp.controller('contactController', function($scope,$routeParams){
	    
	});	
	
	

