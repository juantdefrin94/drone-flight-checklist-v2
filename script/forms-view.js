var question = 1;

$(document).ready(function () {

    function init(){
        handleNewField();
        handleSetJson();
        loadData();
        handleUI();
        $('#add-new-field').click();
    }

    function loadData(){
        let $formId = $('#form-id')[0].value;
        if($formId != 0){
            let $json = JSON.parse($('#json')[0].value);
            let $formData = $json.formData;
            let i = 1;
            let questionId = 0;
            for(let data in $formData){
                questionId = parseInt(data.match(/\d+/)[0]);
                generateField(questionId, $formData[data]);
            }
            $('#form-name')[0].value = $json.formName;
            question = questionId + 1;
        }
    }

    function handleSetJson(){
        let $json = $('#json');
        let $saveButton = $('#save-button');
        let $save = $('#save');

        $saveButton.on('click', function (){
            let $fieldBox = $('.field-box');
            let fieldLength = $fieldBox.length;

            let $formTypeDropdown = $('#form-type-dropdown :selected')[0].value;
            let $formType = $('#form-type');
            $formType[0].value = $formTypeDropdown;

            let jsonTemp = {};
            for(let i = 0; i < fieldLength; i++){
                let id = $fieldBox[i].id.split('-')[1];
                let questionId = "question" + id;
                let statement = $("#statement-" + id)[0].value;
                let type = $('#answer-' + id)[0].className.split("-")[0];
                let option = [];
                if(type === "dropdown"){
                    let container = $('#' + type + "-container-" + id + " option");
                    let containerLength = container.length;
                    for(let i = 0; i < containerLength; i++){
                        option.push(container[i].value);
                    }
                }else if(type === "multiple" || type === "checklist"){
                    let container = $('#' + type + "-container-" + id + " input");
                    let containerLength = container.length;
                    for(let i = 0; i < containerLength; i++){
                        option.push(container[i].value);
                    }
                }
                let required = $("#required-" + id + " input");
                for(let i = 0; i < 2; i++){
                    if(required[i].checked){
                        required = required[i].value;
                    }
                }
                let isRequired = required === "Yes" ? true : false;

                jsonTemp[questionId] = {
                    "question": statement,
                    "type": type,
                    "option": option,
                    "required": isRequired
                }
            }
            let jsonStructure = JSON.stringify(jsonTemp);
            $json[0].value = jsonStructure;
            $save.click();
        })
    }

    function handleNewField() {
        let $button = $('#add-new-field');
        if ($button) {
            $button.on('click', function (e) {
                e.preventDefault();
                generateField(question, {});
                question++;
            });
        }
    }

    function generateField(question, data) {
        let field = generateStringField(question, data);
        $('#container-field').append(field);

        if(!$.isEmptyObject(data)){
            if(data.type === 'multiple' || data.type === 'checklist'){
                addEventAdd(question, data.type);
            }
        }

        addEventTypeDropdown(question);
        addEventDeleteQuestion(question);
    }

    function generateStringField(question, data) {
        if ($.isEmptyObject(data)) {
            return `
                <div class="container-field">
                    <div class="field-box" id="question-${question}">
                            <div class="left-field">
                                <div class="statement">
                                    <input type="text" class="title-field-input-text" id="statement-${question}" placeholder="Please input your question or statement here">
                                </div>
                                
                                <div id="required-${question}" style="display: flex;" class="required">
                                    <div class="required-title">Required</div>
                                    <div class="required-option">
                                        <input type="radio" id="yes-${question}" name="req-${question}" value="Yes" checked>
                                        <label class="radio-label" for="req-${question}">Yes</label>
                                        <input type="radio" id="no-${question}" name="req-${question}" value="No" style="margin-left:15px;">
                                        <label class="radio-label" for="req-${question}">No</label>
                                    </div>
                                </div>
                                <div class="answer">
                                    <div class="answer-title">Type of Answer</div>
                                    <div class="answer-option">
                                        <select id="type-${question}" class="title-field-input-dropdown">
                                            <option value="text" selected>Text</option>
                                            <option value="multiple">Multiple Choice</option>
                                            <option value="checklist">Checklist</option>
                                            <option value="longtext">Long Text</option>
                                            <option value="date">Date</option>
                                            <option value="time">Time</option>
                                            <option value="datetime">Date Time</option>
                                            <option value="dropdown">Dropdown</option>
                                        </select>
                                    </div>
                                </div>
                            

                                <div id="answer-${question}" class="text-field bot-field answer-input">
                                    <input type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled />
                                </div>
                            </div>
                        </div>
                        <div class="delete-button">
                            <button class="delete-field" id="delete-${question}"><i class='fa-regular fa-circle-xmark fa-3x' style='color:#ffffff'></i></button>
                        </div>
                    </div>
                
            `
        } else {
            let html = `
                <div class="field-box" id="question-${question}">
                    <div class="top-field">
                        <div class="header-field">
                            Statement
                            <input type="text" class="title-field-input-text" value="${data.question}" id="statement-${question}">
                        </div>
                        <div id="required-${question}" style="display: flex;">
                            Required : 
                            <input type="radio" id="yes-${question}" name="req-${question}" value="Yes" ${data.required ? "checked" : ""}>
                            <label for="req-${question}">Yes</label><br>
                            <input type="radio" id="no-${question}" name="req-${question}" value="No" ${data.required ? "" : "checked"}>
                            <label for="req-${question}">No</label><br>
                        </div>
                        <div class="header-field">
                            Type of Answer
                            <select id="type-${question}" class="title-field-input-dropdown">
                                <option value="text" ${data.type === "text" ? "selected" : ""}>Text</option>
                                <option value="multiple" ${data.type === "multiple" ? "selected" : ""}>Multiple Choice</option>
                                <option value="checklist" ${data.type === "checklist" ? "selected" : ""}>Checklist</option>
                                <option value="longtext" ${data.type === "longtext" ? "selected" : ""}>Long Text</option>
                                <option value="date" ${data.type === "date" ? "selected" : ""}>Date</option>
                                <option value="time" ${data.type === "time" ? "selected" : ""}>Time</option>
                                <option value="datetime" ${data.type === "datetime" ? "selected" : ""}>Date Time</option>
                                <option value="dropdown" ${data.type === "dropdown" ? "selected" : ""}>Dropdown</option>
                            </select>
                        </div>
                        <div class="delete-margin">
                            <button class="delete-field" id="delete-${question}"><i class='fa-regular fa-circle-xmark fa-2x' style='color:#ffffff'></i></button>
                        </div>
                    </div>
            `;
            // for edit
            if (data.type === 'text') {
                html = html + `
                        <div id="answer-${question}" class="text-field bot-field">
                            <input type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled />
                        </div>
                    </div>
                `;
            } else if (data.type === 'multiple') {
                html = html + `
                        <div id="answer-${question}" class="multiple-field">
                        <div id="multiple-container-${question}">`
                $.each(data.option, function (_, opt){
                    let lowOpt = opt.toLowerCase();
                    html = html + `
                        <input type="radio" id="${lowOpt}-${question}" name="multiple-${question}" value="${opt}">
                        <label for="${lowOpt}-${question}">${opt}</label><br> 
                    `
                });
                html = html + `
                    </div>
                    <input type="text" name="new-option-${question}" id="new-option-${question}">
                    <button id="add-multiple-${question}">Add New Option</button>
                </div>
                `;
            } else if (data.type === 'checklist') {
                html = html + `
                        <div id="answer-${question}" class="checklist-field">
                        <div id="checklist-container-${question}">`
                $.each(data.option, function (_, opt){
                    let lowOpt = opt.toLowerCase();
                    html = html + `
                        <input type="checkbox" id="${lowOpt}-${question}" name="checklist-${question}" value="${opt}">
                        <label for="${lowOpt}-${question}">${opt}</label><br> 
                    `
                });
                html = html + `
                    </div>
                    <input type="text" name="new-option-${question}" id="new-option-${question}">
                    <button id="add-checklist-${question}">Add New Option</button>
                </div>
                `;
            } else if (data.type === 'longtext') {
                html = html + `
                        <div id="answer-${question}" class="longtext-field bot-field">
                            <textarea type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled></textarea>
                        </div>
                    </div>
                `;
            } else if (data.type === 'date') {
                html = html + `
                        <div id="answer-${question}" class="longtext-field bot-field">
                            <textarea type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled></textarea>
                        </div>
                    </div>
                `;
            } else if (data.type === 'time') {
                html = html + `
                        <div id="answer-${question}" class="longtext-field bot-field">
                            <textarea type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled></textarea>
                        </div>
                    </div>
                `;
            } else if (data.type === 'datetime') {
                html = html + `
                        <div id="answer-${question}" class="longtext-field bot-field">
                            <textarea type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled></textarea>
                        </div>
                    </div>
                `;
            } else if (data.type === 'dropdown') {
                html = html + `
                    <div id="answer-${question}" class="dropdown-field bot-field">
                        <select id="dropdown-container-${question}">
                `;
                $.each(data.option, function(_, opt){
                    html = html + `
                        <option value="${opt}">${opt}</option>
                    `
                });       
                html = html + `
                        </select>
                        <input type="text" name="new-option-${question}" id="new-option-${question}">
                        <button id="add-dropdown-${question}">Add New Value</button>
                    </div>
                `;
            }
            return html;
        }
    }

    function addEventTypeDropdown(question) {
        let questionId = '#type-' + question;
        let answerId = '#answer-' + question;
        let $typeDropdown = getElement(questionId);
        if ($typeDropdown) {
            $typeDropdown.on('change', function (e) {
                e.preventDefault();
                let val = getValue(questionId);
                let answerField = getElement(answerId);
                if (answerField[0]) {
                    if (!answerField[0].classList.contains(val + '-field')) {
                        //value and answer field is not the same
                        let newField = "";
                        // if there is a change of type
                        let addEvent = false;
                        if (val === 'text') {
                            newField = `
                                <div id="answer-${question}" class="text-field bot-field">
                                    <input type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled />
                                </div>
                            `;
                        } else if (val === 'multiple') {
                            newField = `
                                <div id="answer-${question}" class="multiple-field">
                                    <div id="multiple-container-${question}"></div>
                                    <input type="text" name="new-option-${question}" id="new-option-${question}">
                                    <button id="add-multiple-${question}">Add New Option</button>
                                </div>
                            `;
                            addEvent = true;
                        } else if (val === 'checklist') {
                            newField = `
                                <div id="answer-${question}" class="checklist-field">
                                    <div id="checklist-container-${question}"></div>
                                    <input type="text" name="new-option-${question}" id="new-option-${question}">
                                    <button id="add-checklist-${question}">Add New Option</button>
                                </div>
                            `;
                            addEvent = true;
                        } else if (val === 'longtext') {
                            newField = `
                                <div id="answer-${question}" class="longtext-field bot-field">
                                    <textarea type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled></textarea>
                                </div>
                            `;
                        } else if (val === 'date') {
                            newField = `
                                <div id="answer-${question}" class="date-field bot-field">
                                    <input type="date" disabled>
                                </div>
                            `;
                        } else if (val === 'time') {
                            newField = `
                                <div id="answer-${question}" class="time-field bot-field">
                                    <input type="time disabled">
                                </div>
                            `;
                        } else if (val === 'datetime') {
                            newField = `
                                <div id="answer-${question}" class="datetime-field bot-field">
                                    <input type="datetime-local" disabled>
                                </div>
                            `;
                        } else if (val === 'dropdown') {
                            newField = `
                                <div id="answer-${question}" class="dropdown-field bot-field">
                                    <select id="dropdown-container-${question}"></select>
                                    <input type="text" name="new-option-${question}" id="new-option-${question}">
                                    <button id="add-dropdown-${question}">Add New Value</button>
                                </div>
                            `;
                            addEvent = true;
                        }
                        answerField.replaceWith(newField);
                        if(addEvent){
                            addEventAdd(question, val);
                        }
                    }
                }
            });
        }
    }

    function addEventDeleteQuestion(question) {
        let deleteId = "#delete-" + question;
        let questionId = "#question-" + question;
        let $delete = getElement(deleteId);
        if ($delete) {
            $delete.on('click', function (e) {
                e.preventDefault();
                getElement(questionId).remove();
            })
        }
    }

    function addEventAdd(question, val) {
        let containerId = '#' + val + '-container-' + question;
        let buttonId = '#add-' + val + '-' + question;
        let newOptionId = '#new-option-' + question;

        let $addButton = getElement(buttonId);
        if ($addButton) {
            $addButton.on('click', function (e) {
                e.preventDefault();
                let newOptVal = getValue(newOptionId);
                if (newOptVal) {
                    newOptVal = $.trim(newOptVal.replaceAll(/\s+/g, ' '));
                    let newId = newOptVal.replaceAll(' ', '-') + "-" + question
                    let newField = '';
                    let type = val === "multiple" ? "radio" : val === "checklist" ? "checkbox" : "dropdown";
                    if(type === "checkbox" || type === "radio"){
                        newField = `
                                <input type="${type}" id="${newId}" name="${val}-${question}" value="${newOptVal}">
                                <label for="${newId}">${newOptVal}</label><br>
                            `;
                    }else{
                        newField = `
                                <option value="${newOptVal}">${newOptVal}</option>
                            `;
                    }
                    let $container = getElement(containerId);
                    if ($container) {
                        $container.append(newField);
                        getElement(newOptionId)[0].value = null;
                    }
                }
            });
        }
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

function getValue(questionId) {
    return $(questionId)[0].value ? $(questionId)[0].value : null;
}

function getElement(element) {
    return $(element);
}

function getStringId(string) {
    return '#' + string;
}

function changeUse(e, type, currEl) {
    e.preventDefault();
    currType = type;
    $(getStringId($('.selected-type')[0].id)).removeClass('selected-type');
    $(getStringId(currEl.id)).addClass('selected-type');
    showHideByType();
}

function showHideByType() {
    let otherType = typeList.filter((type) => type != currType);
    $.each(otherType, function (_, type) {
        let otherClassList = $('.' + type);
        $.each(otherClassList, function (_, currClass) {
            let $el = getElement('#' + currClass.id);
            $el.hide();
        });
    })
    let classList = $('.' + currType);
    $.each(classList, function (_, currClass) {
        let $el = getElement('#' + currClass.id);
        $el.show();
    });
}