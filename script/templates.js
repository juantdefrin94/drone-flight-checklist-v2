$(document).ready(function () {

    function init(){
        handleDelete();
    }

    function handleDelete(){
        let $tableData = $('.table-data');
        for(let i = 0; i < $tableData.length; i++){
            let idString = $tableData[i].id;
            let id = idString.split("-")[1];
            $('#' + idString).on("click", function(){
                $('#template-id').val(id);
                $('#modal').css("display", "block");
            })
        }
    }

    init();

});