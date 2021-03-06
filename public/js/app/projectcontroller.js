function ProjectController ($scope,$http,Project,ProjectGroup,UserGroup,User,MSG,OBJ) {

	/**
	 * Reference to the project form
	 * @type {[type]}
	 */
	var projectForm = $("#project_form");
	
	var projectDefault= {
		id : "",
		name : "",
		description : ""
	};

	$scope.formTitle = "Add Project";
	$scope.projects = [];
	$scope.userGroups = [];
	$scope.projectGroups = [];

	$scope.users = [];
	$scope.projectUsers = [];

	$scope._currentProjectId ;
	/**
	 * Gets all projects
	 * @return void
	 */
	function getProjects (){
		Project.query(function (res){
			$scope.projects = angular.copy(res.data);
		})
	}

	/**
	 * When the user clicks the refresh button to reload new records that might been added
	 * @return {void} 
	 */
	$scope.reload = function (){
		getProjects();
	}

	$scope.addProject = function (newProject){
		var project = OBJ.rectify(angular.copy(newProject),projectDefault);
		if (project["id"]){
			Project.update(project, function (res){
				afterSave(res, {message : "Project Updated"});
			});
		} else {
		
			var theProject = new Project(project);
			theProject.$save(function (res){
				afterSave(res, {message : "Project created"});
			});
		}
	}

	/**
	 * Method to be run after saving /updating a record
	 * @param  {object}   res      the response from the server
	 * @param  {object}   obj      an object containing extra info to be used id no response is sent
	 * @param  {Function} callback an additional callback function that we might want to run
	 * @return {[void]}     
	 */
	function afterSave(res,obj,callback){
		var msg = "";
		if(res.success){
			//reload data into grid
			getProjects();
			msg = res.message || obj.message || "Project Saved";
			MSG.show(msg,"success");
			$scope.clear();
			projectForm.modal("hide");
			
			//any other business
			if(callback)
				callback();
		}else {
			msg = res.message || obj.message || "Sorry, errors were ecountered";
			MSG.show(msg);
		}
	}

	function getUsers(){
		User.query(function (res){
			$scope.users = res.data;
		});
		// User.get().then(function (res){
		// 	$scope.users = res.data;
		// });
	}

	function getProjectGroups(id){
		ProjectGroup.query({projectId : id },function (res){
			$scope.projectGroups =  res.data;
		});
	}

	function getUserGroups (id){
		UserGroup.query({projectId : id }, function (res){
			$scope.userGroups =  res.data;
		});
	}

	/**
	 * Brings the form which allows us to add a user  to a group
	 * @param  {object} project to be updated
	 * @return {void}   
	 */
	$scope.updateProjectDetails = function(project){
		//console.log(project);
		var form = $("#projectDetails");
		form.modal();
		$scope.currentProject = {}
		$scope.currentProject.name = project.name;
		$scope.currentProject.projectId = project.id;
		getUsers();
		getProjectGroups(project.id);
		getUserGroups(project.id);
	}

	$scope.addProjectGroup = function (currentProject){
		var group =  new ProjectGroup(angular.copy(currentProject));
		group["name"] = group["newGroup"];
		group["description"] = "";
		
		//todo add description later
		group.$save(function (res){
			if (res.success){
				var msg = res.message || "Project Group created"; 
				MSG.show(msg,"success");
				getProjectGroups(currentProject.projectId);
				currentProject.newGroup = "";
			} else {
				var msg = res.message || "Sorry errors were ecountered"; 
				MSG.show(msg);
			}
		});
	}

	$scope.addUserToGroup =  function (userGroup){
		console.log(userGroup)
		var projectUserGroup = new UserGroup(userGroup);
		$scope._currentProjectId = $scope.currentProject.projectId
		projectUserGroup.$save(function (res){
			if(res.success){
				var msg = res.message || "User added to group created"; 
				MSG.show(msg,"success");
				//load the user
				getUserGroups($scope._currentProjectId);
			}else {
				var msg = res.message || "Sorry errors were ecountered"; 
				MSG.show(msg);

				
			}
		});
	}


	$scope.showNewProject = function () {
		$scope.clear();
		$scope.formTitle =  "Add Project";
	}

	/**
	 * Shows the form for editing the project
	 * @param  {object} project the project object
	 * @return {void}  
	 */
	$scope.editProject = function (project){
		$scope.formTitle = "Edit Project";
		projectForm.modal("show");
		$scope.newProject = angular.copy(project);
	}

	/**
	 * Delete the project
	 * @param  {object} project the project object
	 * @return {void} 
	 */
	$scope.deleteProject = function(project){

	}


	$scope.clear =  function (){
		$scope.newProject = {};
		//$scope.title = "Add New User";
		//$scope.statusText = "Add User";
	}


	//make calls here
	getProjects();

}