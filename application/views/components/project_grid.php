<div class="tab-pane" id="project" ng-controller="ProjectController">         
  <div class="btn-toolbar" style="margin-bottom: 9px">
    <div class="btn-group">
      <button class='btn btn-success' ng-click="showNewProject()" data-toggle="modal" href="#project_form"> <i class='icon-white icon-th-list'></i></button>
      <button class='btn btn-info' ng-click="reload()"> <i class='icon-white icon- icon-repeat'></i> </button>
    </div>
  </div>
  <table  class='table table-striped table-bordered my-table'>
      <thead>
        <tr>
          <th class="grid_action1">#</th>
          <th>Title</th>
          <th>Description</th>
          <th>Date Created</th>
          <th class='grid_action3'></th>
        </tr>
      </thead>
      <tbody>
        <!-- <tr>
          <td colspan='100'>No Projects created.</td>
        </tr> -->

        <tr ng-repeat="project in projects">
            <td> {{ $index + 1}}</td>
            <td> {{project.name}} </td>
            <td> {{project.description }} </td>
            <td> {{project.createdAt}} </td>
            <td> 
              <a href="#"  ng-click="updateProjectDetails(project)"> <i class='icon icon-plus'> </a></i>
              <a href="#"  ng-click="editProject(project)"> <i class='icon icon-pencil'> </a></i>  
              <a href="#"  ng-click="deleteProject(project)"> <i class='icon icon-remove'> </a></i>  
            </td>
        </tr>
      </tbody>
  </table>

<?php echo View::make("components.project_form");  ?>
<?php echo View::make("components.project_detail_form");  ?>

</div>
