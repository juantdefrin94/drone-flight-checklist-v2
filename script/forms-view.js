var question = 1;

$(document).ready(function () {

    function init(){
        handleNewField();
        handleSetJson();
        loadData();
        handleUI();
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
            $('#form-type-dropdown')[0].value = $json.formType;
            question = questionId + 1;
        }
    }

    function handleSetJson(){
        let $json = $('#json');
        let $saveButton = $('#save-button');
        let $save = $('#save');

        $saveButton.on('click', function (){
            let statementInput = $('.statement-input');
            let length = statementInput.length;
            let isEmpty = false;
            for(let i = 0; i < length; i++){
                let currEl = statementInput[i];
                if(currEl.value == ""){
                    isEmpty = true;
                    break;
                }
            }

            let formName = $('#form-name');
            if(formName[0].value == ""){
                isEmpty = true;
            }

            if(!isEmpty){
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
                    let isRequired = $("#required-" + id)[0].checked;     
    
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
            }else{
                alert('Please make sure all component are filled!');
            }

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
                let answerContainer = $('#answer-' + question + " .option-answer-container input");
                let answerContainerLength = answerContainer.length;
                for(let i = 0; i < answerContainerLength; i++){
                    let id = answerContainer[i].id;
                    addEventDeleteOptionAnswer(id);
                }
            }
        }

        addEventTypeDropdown(question);
        addEventDeleteQuestion(question);
    }

    function generateStringField(question, data) {
        if ($.isEmptyObject(data)) {
            return `
                <div class="container-field" id="container-field-${question}">
                    <div class="field-box" id="question-${question}">
                            <div class="top-field">
                                <div class="statement-type">
                                    <div class="statement">
                                        <div class="statement-title">Statement/Question</div>
                                        <div>
                                            <input type="text" class="statement-input" id="statement-${question}" placeholder="Please input your question or statement here" required>
                                        </div>
                                    </div> 
                                    
                                    <div class="type-answer">
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
                                </div>

                                <div id="answer-${question}" class="text-field bot-field answer-input">
                                    <input type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled />
                                </div>

                                <label class="toggle">
                                    <span class="toggle-label">Required</span>
                                    <input id="required-${question}" class="toggle-checkbox" type="checkbox" checked>
                                    <div class="toggle-switch"></div>               
                                </label>
                                
                            </div>
                        </div>
                        <div class="delete-button" id="delete-${question}">
                            <button class="delete-field"><i class='fa-solid fa-trash-can fa-2x' style='color:#ffffff'></i></button>
                        </div>
                    </div>
                
            `
        } else {
            let html = `
                <div class="container-field" id="container-field-${question}">
                    <div class="field-box" id="question-${question}">
                        <div class="top-field">
                            <div class="statement-type">
                                <div class="statement">
                                    <div class="statement-title">Statement/Question</div>
                                    <div>
                                        <input type="text" class="statement-input" id="statement-${question}" placeholder="Please input your question or statement here" value="${data.question}" required>
                                    </div>
                                </div> 
                            
                                <div class="type-answer">
                                    <div class="answer-title">Type of Answer</div>
                                    <div class="answer-option">
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
                                </div>
                            </div>
            `;
            // for edit
            if (data.type === 'text') {
                html = html + `
                            <div id="answer-${question}" class="text-field bot-field">
                                <input type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled />
                            </div>
                `;
            } else if (data.type === 'multiple') {
                html = html + `
                            <div id="answer-${question}" class="multiple-field">
                                <div id="multiple-container-${question}">`
                $.each(data.option, function (_, opt){
                    let lowOpt = opt.toLowerCase();
                    let newOptVal = $.trim(lowOpt.replaceAll(/\s+/g, ' '));
                    let newId = newOptVal.replaceAll(' ', '-') + "-" + question;
                    html = html + `
                                    <div id="${newId}-answer" class="option-answer-container">
                                        <div class="left-option">
                                            <input class="options" type="radio" id="${newId}" name="multiple-${question}" value="${opt}" disabled>
                                            <label class="options-label" for="${newId}">${opt}</label><br> 
                                        </div>
                                        <div class="right-option">
                                            <button class="delete-answer" id="${newId}-delete"><i class="fa-solid fa-circle-xmark fa-lg" style="color:#ff0000c7"></i></button>
                                        </div>
                                    </div>
                    `
                });
                html = html + `
                                </div>
                                <div class="option-field">
                                    <input class="multiple-input" type="text" name="new-option-${question}" id="new-option-${question}">
                                    <button class="add-option-button" id="add-multiple-${question}">Add Option</button>
                                </div>
                            </div>
                `;
            } else if (data.type === 'checklist') {
                html = html + `
                            <div id="answer-${question}" class="checklist-field">
                                <div id="checklist-container-${question}">`
                $.each(data.option, function (_, opt){
                    let lowOpt = opt.toLowerCase();
                    let newOptVal = $.trim(lowOpt.replaceAll(/\s+/g, ' '));
                    let newId = newOptVal.replaceAll(' ', '-') + "-" + question;
                    html = html + `
                                <div id="${newId}-answer" class="option-answer-container">
                                    <div class="left-option">
                                        <input class="options" type="checkbox" id="${newId}" name="checklist-${question}" value="${opt}" disabled>
                                        <label class="options-label" for="${newId}">${opt}</label> 
                                    </div>
                                    <div class="right-option">
                                        <button class="delete-answer" id="${newId}-delete"><i class="fa-solid fa-circle-xmark fa-lg" style="color:#ff0000c7"></i></button>
                                    </div>
                                </div>
                    `
                });
                html = html + `
                                </div>
                                <div class="option-field">
                                    <input class="checklist-input" type="text" name="new-option-${question}" id="new-option-${question}">
                                    <button class="add-option-button" id="add-checklist-${question}">Add Option</button>
                                </div>
                            </div>
                `;
            } else if (data.type === 'longtext') {
                html = html + `
                            <div id="answer-${question}" class="longtext-field bot-field">
                                <textarea type="text" class="answer-input-area" placeholder="The answer will be here . . ." disabled></textarea>
                            </div>
                `;
            } else if (data.type === 'date') {
                html = html + `
                            <div id="answer-${question}" class="date-field bot-field">
                                <input class="date-input" type="date" disabled>
                            </div>
                `;
            } else if (data.type === 'time') {
                html = html + `
                            <div id="answer-${question}" class="time-field bot-field">
                                <input class="time-input" type="time" disabled>
                            </div>
                `;
            } else if (data.type === 'datetime') {
                html = html + `
                            <div id="answer-${question}" class="datetime-field bot-field">
                                <input class="date-time-input" type="datetime-local" disabled>
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
                                <div class="value-field">
                                    <input class="dropdown-input" type="text" name="new-option-${question}" id="new-option-${question}">
                                    <button class="add-value-button" id="add-dropdown-${question}">Add Value</button>
                                </div>
                            </div>
                `;
            }

            html = html + `
                                <label class="toggle">
                                    <span class="toggle-label">Required</span>
                                    <input id="required-${question}" class="toggle-checkbox" type="checkbox" ${data.required ? "checked" : ""}>
                                    <div class="toggle-switch"></div>               
                                </label>
                                
                            </div>
                        </div>
                        <div class="delete-button" id="delete-${question}">
                            <button class="delete-field"><i class='fa-solid fa-trash-can fa-2x' style='color:#ffffff'></i></button>
                        </div>
                    </div>
                </div>
            `
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
                                    <div class="option-field">
                                        <input class="multiple-input" type="text" name="new-option-${question}" id="new-option-${question}">
                                        <button class="add-option-button" id="add-multiple-${question}">Add Option</button>
                                    </div>
                                </div>
                            `;
                            addEvent = true;
                        } else if (val === 'checklist') {
                            newField = `
                                <div id="answer-${question}" class="checklist-field">
                                    <div id="checklist-container-${question}"></div>
                                    <div class="option-field">
                                        <input class="checklist-input" type="text" name="new-option-${question}" id="new-option-${question}">
                                        <button class="add-option-button" id="add-checklist-${question}">Add Option</button>
                                    </div>
                                </div>
                            `;
                            addEvent = true;
                        } else if (val === 'longtext') {
                            newField = `
                                <div id="answer-${question}" class="longtext-field bot-field">
                                    <textarea type="text" class="answer-input-area" placeholder="The answer will be here . . ." disabled></textarea>
                                </div>
                            `;
                        } else if (val === 'date') {
                            newField = `
                                <div id="answer-${question}" class="date-field bot-field">
                                    <input class="date-input" type="date" disabled>
                                </div>
                            `;
                        } else if (val === 'time') {
                            newField = `
                                <div id="answer-${question}" class="time-field bot-field">
                                    <input class="time-input" type="time" disabled>
                                </div>
                            `;
                        } else if (val === 'datetime') {
                            newField = `
                                <div id="answer-${question}" class="datetime-field bot-field">
                                    <input class="date-time-input" type="datetime-local" disabled>
                                </div>
                            `;
                        } else if (val === 'dropdown') {
                            newField = `
                                <div id="answer-${question}" class="dropdown-field bot-field">
                                    <select id="dropdown-container-${question}">
                                        <option value="" disabled selected>Select option</option>
                                    </select>
                                    <div class="value-field">
                                        <input class="dropdown-input" type="text" name="new-option-${question}" id="new-option-${question}">
                                        <button class="add-value-button" id="add-dropdown-${question}">Add Value</button>
                                    </div>
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
        let containerId = "#container-field-" + question;
        let $delete = getElement(deleteId);
        if ($delete) {
            $delete.on('click', function (e) {
                e.preventDefault();
                getElement(containerId).remove();
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
                                <div class="option-answer-container" id="${newId}-answer">
                                    <div class="left-option">
                                        <input class="options" type="${type}" id="${newId}" name="${val}-${question}" value="${newOptVal}" disabled>
                                        <label class="options-label" for="${newId}">${newOptVal}</label><br>
                                    </div>
                                    <div class="right-option">
                                        <button class="delete-answer" id="${newId}-delete"><i class="fa-solid fa-circle-xmark fa-lg" style="color:#ff0000c7"></i></button>
                                    </div>
                                </div>
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
                        addEventDeleteOptionAnswer(newId);
                    }

                }
            });
        }
    }

    function addEventDeleteOptionAnswer(newId){
        let $deleteButton = $('#' + newId + "-delete");
        if($deleteButton){
            $deleteButton.on('click', function (e){
                e.preventDefault();
                getElement('#' + newId + "-answer").remove();
            })
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