$(document).ready(function () {

    function init(){
        handleUI();
        handleModal();
        handleDelete();
        handleRowAction();
    }

    function handleUI(){
        let $sideBar = $('#sidebar-menu');
        let winHeight = window.screen.height;
        $sideBar.height(winHeight);
    }

    function handleModal(){
        let $modal = $('#modal');
        $modal.on('click', function (){
            $modal.css("display", "none");
        })
    }

    function handleDelete(){
        let $tableData = $('.table-data');
        for(let i = 0; i < $tableData.length; i++){
            let idString = $tableData[i].id;
            let id = idString.split("-")[1];
            $('#delete-' + id).on("click", function(e){
                e.stopPropagation();
                $('#form-id').val(id);
                $('#modal').css("display", "flex");
            })
        }
    }

    function handleRowAction(){
        let $tableData = $('.table-data');
        let length = $tableData.length;
        let user = $('#user')[0].value;
        for(let i = 0; i < length; i++){
            let rowId = $tableData[i].id;
            let $rowEl = $('#' + rowId);
            let id = rowId.split('-')[1];
            $rowEl.on('click', function (){
                window.location.href = `index.php?view=viewForms&user=${user}&id=${id}`;
            });
        }
    }

    init();

});