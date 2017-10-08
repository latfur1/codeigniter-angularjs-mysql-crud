//Reference File app.js
myApp.controller('student_contrloer', function ($scope, $state, $http, $location,APP_CONSTANTS) {
    var vm = this;
  
    $scope.currentPage = 1;
    $scope.maxSize = 3;
    this.search_data = function (search_input) {
        if (search_input.length > 0)
            vm.loadData(1);

    };

    this.loadData = function (page_number) {
        var search_input = document.getElementById("search_input").value;
        $http.get(APP_CONSTANTS.BASE_URL+'/student/student_list?page=' + page_number + '&search_input=' + search_input).then(function (response) {
            vm.student_list = response.data.student_data;
            $scope.total_row = response.data.total_row;
            
        });
    };

    $scope.$watch('currentPage + numPerPage', function () {

        vm.loadData($scope.currentPage);

        var begin = (($scope.currentPage - 1) * $scope.numPerPage)
                , end = begin + $scope.numPerPage;


    });
//    

    this.addStudent = function (info) {
        $http.post(APP_CONSTANTS.BASE_URL+'/student/create_student_info', info).then(function (response) {
            vm.msg = response.data.message;
            vm.alert_class = 'custom-alert';
            document.getElementById("create_student_info_frm").reset();
            $('#create_student_info_modal').modal('toggle');
            vm.loadData($scope.currentPage);

        });
    };

    this.edit_student_info = function (student_id) {
        $http.get(APP_CONSTANTS.BASE_URL+'/student/view_student_by_student_id?student_id=' + student_id).then(function (response) {
            vm.student_info = response.data;
        });
    };


    this.updateStudent = function () {
        $http.put(APP_CONSTANTS.BASE_URL+'/student/update_student_info', this.student_info).then(function (response) {
            vm.msg = response.data.message;
            vm.alert_class = 'custom-alert';
            $('#edit_student_info_modal').modal('toggle');
            vm.loadData($scope.currentPage);
        });
    };


    this.get_student_info = function (student_id) {
        $http.get(APP_CONSTANTS.BASE_URL+'/student/view_student_by_student_id?student_id=' + student_id).then(function (response) {
            vm.view_student_info = response.data;


        });
    };


    this.delete_student_info = function (student_id) {
        $http.delete(APP_CONSTANTS.BASE_URL+'/student/delete_student_info_by_id?student_id=' + student_id).then(function (response) {
            vm.msg = response.data.message;
            vm.alert_class = 'custom-alert';
            vm.loadData($scope.currentPage);
        });
    };


});

