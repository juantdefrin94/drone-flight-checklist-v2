$(document).ready(function (){
    
    function init(){
        handleSetData();
    }

    function handleSetData(){
        let $saveButton = $('#save-button');
        let $save = $('#save');

        $saveButton.on('click', function (){
            let $assessmentDropdown = $('#assessment-select :selected')[0].value;
            let $preDropdown = $('#pre-select :selected')[0].value;
            let $postDropdown = $('#post-select :selected')[0].value;
            
            $('#assessment-id')[0].value = $assessmentDropdown;
            $('#pre-id')[0].value = $preDropdown;
            $('#post-id')[0].value = $postDropdown;

            $save.click();
        })
    }

    init();

});