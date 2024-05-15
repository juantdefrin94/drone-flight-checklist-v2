$(document).ready(function () {

    function init(){
        addEventRow();
    }

    function addEventRow(){
        let $tableData = $('.table-data');    
        let length = $tableData.length;
        let user = $('#user')[0].value;
        for(let i = 0; i < length; i++){
            let id = $tableData[i].id.split('-')[1];
            let rowId = $("#data-" + id);
            rowId.on('click', function (){
                window.location.href = `index.php?view=viewSubmissions&user=${user}&id=${id}`;
            })
        }
    }

    init();

});