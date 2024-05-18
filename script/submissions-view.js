let groupNum = 1;

$(document).ready(function () {

    function init(){
        loadData();
        groupEvent();
    }

    function loadData(){
        let $json = $('#json')[0].value;
        $json = JSON.parse($json);

        let assessment = $json.formData.find((item) => item.type === "assessment");
        let pre = $json.formData.find((item) => item.type === "pre");
        let post = $json.formData.find((item) => item.type === "post");

        if(assessment){
            initVal = "assessment";
            let length = assessment.answer.length;

            let $assessmentAnswer = $('#assessment-answer');
            let answerString = `
                <div>
                    <div class='group' id='group-${groupNum}'>
                        <div class='group-title'>
                                <div class="assessment-group-title">
                                    Assessment
                                </div>  
                                <div class='drop-symbol' id='symbol-${groupNum}'>
                                    <i class='fa-solid fa-caret-up fa-2x' style='color:#d4e9ea;'></i>
                                </div>                       
                        </div>
                    
                    <div class="all-question" id='group-${groupNum}-answer' style='display: none;'>
                        <table>
                            <tr>
                                <th class="col-1">Question / Statement</th>
                                <th class="col-2">Answer</th>
                                <th class="col-3">Data Changed</th>
                            </tr>
                    `;
            for(let i = 0; i < length; i++){
                answerString += `
                <tr>
                    <td class="col-1">${assessment.answer[i].questionName}</td>
                    <td class="col-2">${assessment.answer[i].answer}</td>
                    <td class="col-3">${assessment.answer[i].dataChanged}</td>
                </tr>
                `
            }
            answerString += "</table></div></div>";
            $assessmentAnswer.append(answerString);
            groupNum++;
        }

        if(pre){
            if(initVal == ""){
                initVal = "pre";
            }
            let preLength = pre.answer.length;
            maxPre = preLength;
            let $preAnswer = $('#pre-answer');
            for(let i = 1; i <= preLength; i++){
                let text = "Pre-Flight #" + i;
                
                let answerString = `
                <div>
                    <div class='group' id='group-${groupNum}'>
                        <div class='group-title'>
                            <div class="pre-group-title">
                                ${text}
                            </div>
                            <div class='drop-symbol' id='symbol-${groupNum}'>
                                <i class='fa-solid fa-caret-up fa-2x' style='color:#d4e9ea;'></i>
                            </div>
                        </div>
                    
                    <div class="all-question" id='group-${groupNum}-answer' style='display: none;'>
                        <table>
                                <tr>
                                    <th class="col-1">Question / Statement</th>
                                    <th class="col-2">Answer</th>
                                    <th class="col-3">Data Changed</th>
                                </tr>`;
                let length = pre.answer[i - 1].data.length;
                for(let j = 0; j < length; j++){
                    answerString += `
                    <tr>
                        <td class="col-1">${pre.answer[i - 1].data[j].questionName}</td>
                        <td class="col-2">${pre.answer[i - 1].data[j].answer}</td>
                        <td class="col-3">${pre.answer[i - 1].data[j].dataChanged}</td>
                    </tr>
                    `
                }
                answerString += "</table></div></div>";
                $preAnswer.append(answerString);
                groupNum++;
            }
        }
        
        if(post){
            if(initVal == ""){
                initVal = "post";
            }
            let postLength = post.answer.length;
            maxPost = postLength;
            let $postAnswer = $('#post-answer');
            for(let i = 1; i <= postLength; i++){
                let text = "Post-Flight #" + i;

                let answerString = `
                <div>
                    <div class='group' id='group-${groupNum}'>
                        <div class='group-title'>
                            <div class="post-group-title">
                                ${text}
                            </div>
                            <div class='drop-symbol' id='symbol-${groupNum}'>
                                <i class='fa-solid fa-caret-up fa-2x' style='color:#d4e9ea;'></i>
                            </div>
                        </div>
                        
                        <div class='all-question' id='group-${groupNum}-answer' style='display: none;'>
                        <table>
                            <tr>
                                <th class="col-1">Question / Statement</th>
                                <th class="col-2">Answer</th>
                                <th class="col-3">Data Changed</th>
                            </tr>
                        `;
                let length = post.answer[i - 1].data.length;
                for(let j = 0; j < length; j++){
                    answerString += `
                    <tr>
                        <td class="col-1">${post.answer[i - 1].data[j].questionName}</td>
                        <td class="col-2">${post.answer[i - 1].data[j].answer}</td>
                        <td class="col-3">${post.answer[i - 1].data[j].dataChanged}</td>
                    </tr>
                    `
                }
                answerString += "</table></div></div>";
                $postAnswer.append(answerString);
                groupNum++;
            }
        }
        
    }

    function groupEvent(){
        let $group = $('.group');
        let length = $group.length;
        for(let i = 0; i < length; i++){
            let groupId = $group[i].id;
            let symbolId = "symbol-" + groupId.split("-")[1];

            $('#' + groupId).on('click', function (){
                let $symbolEl = $('#' + symbolId);
                let groupAnswerString = groupId + "-answer";
                let $groupAnswer = $('#' + groupAnswerString);
                if($symbolEl.hasClass('group-open')){
                    $symbolEl.removeClass('group-open');
                    $groupAnswer.css('display', 'none');
                }else{
                    $symbolEl.addClass('group-open');
                    $groupAnswer.css('display', 'flex');
                }
            })
        }
    }

    init();

});