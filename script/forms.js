$(document).ready(function () {

    function init(){
        handleUI();
        handleDelete();
    }

    function handleUI(){
        let $sideBar = $('#sidebar-menu');
        let winHeight = window.screen.height;
        $sideBar.height(winHeight);
    }

    function handleDelete(){
        let $tableData = $('.table-data');
        for(let i = 0; i < $tableData.length; i++){
            let idString = $tableData[i].id;
            let id = idString.split("-")[1];
            $('#' + idString).on("click", function(){
                $('#form-id').val(id);
                $('#modal').css("display", "block");
            })
        }
    }

    init();

});