$(document).ready(function (){
    
    function init(){
        handleSetData();
        loadData();
        handleUI();
    }

    function loadData(){
        let $formId = $('#template-id')[0].value;
        if($formId != 0){
            let $json = JSON.parse($('#json')[0].value);
            let templateName = $json.templateName;
            let assessmentId = $json.assessmentId;
            let preId = $json.preId;
            let postId = $json.postId;
            
            $('#template-name')[0].value = templateName;
            $('#assessment-select')[0].value = assessmentId;
            $('#pre-select')[0].value = preId;
            $('#post-select')[0].value = postId;
            
        }
    }

    function handleSetData(){
        let $saveButton = $('#save-button');
        let $save = $('#save');

        $saveButton.on('click', function (){
            let isEmpty = false;
            let templateName = $('#template-name');
            let alertMsg = "";

            let $assessmentDropdown = $('#assessment-select :selected')[0].value;
            let $preDropdown = $('#pre-select :selected')[0].value;
            let $postDropdown = $('#post-select :selected')[0].value;
            
            if(templateName[0].value == ""){
                isEmpty = true;
                alertMsg = "Please make sure all component are filled!";
            }else{
                
                if($assessmentDropdown == "empty" && $preDropdown == "empty" && $postDropdown == "empty"){
                    isEmpty = true;
                    alertMsg = "Please choose at least one form!";
                }
            }


            if(isEmpty){
                alert(alertMsg);
            }else{
                $('#assessment-id')[0].value = $assessmentDropdown;
                $('#pre-id')[0].value = $preDropdown;
                $('#post-id')[0].value = $postDropdown;
    
                $save.click();
            }

        })
    }

    function handleUI(){
        let $container = $('#container');
        let topBarHeight = $('#top-bar').height();
        let winHeight = window.screen.height;
        let height = winHeight - topBarHeight;
        $container.height(height);
    }

    init();

});