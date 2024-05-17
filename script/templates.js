$(document).ready(function () {

    function init(){
        handleUI();
        handleDelete();
    }

    function handleDelete(){
        let $tableData = $('.table-data');
        for(let i = 0; i < $tableData.length; i++){
            let idString = $tableData[i].id;
            let id = idString.split("-")[1];
            $('#delete-' + id).on("click", function(){
                $('#template-id').val(id);
                $('#modal').css("display", "block");
            })
        }
    }

    function handleUI(){
        let $sideBar = $('#sidebar-menu');
        let winHeight = window.screen.height;
        $sideBar.height(winHeight);
    }

    init();

});