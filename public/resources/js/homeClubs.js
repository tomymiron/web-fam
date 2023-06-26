var app = angular.module("myApp", []); 
app.controller("myCtrl", function($scope) {
    $scope.badri = function(v) {
        var name = $('#nameToSearch').val();
        $.ajax({
            url: "search.php",
            type: "POST",
            data: {
                name: name
            },
            success: function($data){
                $("#mainContent").html($data);
            }
        });
    }
});  

addEventListener('load', ()=>{
    var name = $('#nameToSearch').val();
    $.ajax({
        url: "search.php",
        type: "POST",
        data: {
            name: name
        },
        success: function($data){
            $("#mainContent").html($data);
        }
    });
});