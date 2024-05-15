var initVal = "";
var maxPre = 0;
var maxPost = 0;

$(document).ready(function () {

    function init(){
        loadData();
    }

    function loadData(){
        let $json = $('#json')[0].value;
        $json = JSON.parse($json);

        let assessment = $json.formData.find((item) => item.type === "assessment");
        let pre = $json.formData.find((item) => item.type === "pre");
        let post = $json.formData.find((item) => item.type === "post");

        let $type = $('#type');

        if(assessment){
            initVal = "assessment";
            $type.append(new Option("Assessment", "assessment"));
            let length = assessment.answer.length;

            let $assessment = $('#assessment-answer')
            for(let i = 0; i < length; i++){
                $assessment.append(`<p>${assessment.answer[i].questionName} : ${assessment.answer[i].answer}</p>`)
            }
        }

        if(pre){
            if(initVal == ""){
                initVal = "pre";
            }
            let $pre = $('#pre-answer');
            let preLength = pre.answer.length;
            maxPre = preLength;
            for(let i = 1; i <= preLength; i++){
                let text = "Pre-Flight #" + i;
                let value = "pre-" + i;
                $type.append(new Option(text, value));

                let appendText = `<div id="pre-answer-${i}" style="display: none">`;
                let length = pre.answer[i - 1].data.length;
                for(let j = 0; j < length; j++){
                    appendText += `<p>${pre.answer[i - 1].data[j].questionName} : ${pre.answer[i - 1].data[j].answer}</p>`;
                }
                appendText += `</div>`;
                $pre.append(appendText);
            }
        }
        
        let $post = $('#post-answer');
        if(post){
            if(initVal == ""){
                initVal = "post";
            }
            let postLength = post.answer.length;
            maxPost = postLength;
            for(let i = 1; i <= postLength; i++){
                let text = "Post-Flight #" + i;
                let value = "post-" + i;
                $type.append(new Option(text, value));

                let appendText = `<div id="post-answer-${i}" style="display: none">`;
                let length = post.answer[i - 1].data.length;
                for(let j = 0; j < length; j++){
                    appendText += `<p>${post.answer[i - 1].data[j].questionName} : ${post.answer[i - 1].data[j].answer}</p>`;
                }
                appendText += `</div>`;
                $post.append(appendText);
            }
        }

        setOnChangeSelect($type);
    }

    function setOnChangeSelect($selection){
        showAnswer(initVal);
        $selection.on('change', function (){
            let value = this.value;
            showAnswer(value);
        })
    }

    function showAnswer(value){
        let ansId = "";
        if(value === "assessment"){
            ansId = "#assessment-answer";
            hideOther("assessment", 0);
        }else if(value.includes("pre")){
            let id = value.split("-")[1];
            ansId = "#pre-answer-" + id;
            hideOther("pre", id);
        }else{
            let id = value.split("-")[1];
            ansId = "#post-answer-" + id;
            hideOther("post", id);
        }

        $(ansId).css("display", "block");
    }

    function hideOther(value, id){
        if(value == "assessment"){
            for(let i = 1; i <= maxPre; i++){
                $("#pre-answer-" + i).css("display", "none");
            }
            for(let i = 1; i <= maxPost; i++){
                $("#post-answer-" + i).css("display", "none");
            }
        }else if(value == "pre"){
            $("#assessment-answer").css("display", "none");
            for(let i = 1; i <= maxPre; i++){
                if(i !== id){
                    $("#pre-answer-" + i).css("display", "none");
                }
            }
            for(let i = 1; i <= maxPost; i++){
                $("#post-answer-" + i).css("display", "none");
            }
        }else{
            $("#assessment-answer").css("display", "none");
            for(let i = 1; i <= maxPre; i++){
                $("#pre-answer-" + i).css("display", "none");
            }
            for(let i = 1; i <= maxPost; i++){
                if(i !== id){
                    $("#post-answer-" + i).css("display", "none");
                }
            }
        }
    }

    init();

});