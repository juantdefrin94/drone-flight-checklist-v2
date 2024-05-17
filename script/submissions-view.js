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
            let answerString = `<div><div class='group' id='group-${groupNum}'><div class='group-title'>Assessment</div><div class='drop-symbol' id='symbol-${groupNum}'><i class='fa-solid fa-caret-up'></i></div><div id='group-${groupNum}-answer' style='display: none;'>`;
            for(let i = 0; i < length; i++){
                answerString += `<div>${assessment.answer[i].questionName} : ${assessment.answer[i].answer}</div>`
            }
            answerString += "</div></div>";
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
                
                let answerString = `<div><div class='group' id='group-${groupNum}'><div class='group-title'>${text}</div><div class='drop-symbol' id='symbol-${groupNum}'><i class='fa-solid fa-caret-up'></i></div><div id='group-${groupNum}-answer' style='display: none;'>`;
                let length = pre.answer[i - 1].data.length;
                for(let j = 0; j < length; j++){
                    answerString += `<div>${pre.answer[i - 1].data[j].questionName} : ${pre.answer[i - 1].data[j].answer}</div>`
                }
                answerString += "</div></div>";
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

                let answerString = `<div><div class='group' id='group-${groupNum}'><div class='group-title'>${text}</div><div class='drop-symbol' id='symbol-${groupNum}'><i class='fa-solid fa-caret-up'></i></div><div id='group-${groupNum}-answer' style='display: none;'>`;
                let length = post.answer[i - 1].data.length;
                for(let j = 0; j < length; j++){
                    answerString += `<div>${post.answer[i - 1].data[j].questionName} : ${post.answer[i - 1].data[j].answer}</div>`
                }
                answerString += "</div></div>";
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
                    $groupAnswer.css('display', 'block');
                }
            })
        }
    }

    init();

});