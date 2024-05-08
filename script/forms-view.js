var question = 1;

$(document).ready(function () {

    function init(){
        handleNewField();
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
                <div class="field-box" id="question-${question}">
                    <div class="top-field">
                        <div class="header-field">
                            Statement
                            <input type="text" class="title-field-input-text">
                        </div>
                        <div class="header-field">
                            Type of Answer
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
                        <div class="delete-margin">
                            <button class="delete-field" id="delete-${question}"><i class='fa-regular fa-circle-xmark fa-2x' style='color:#ffffff'></i></button>
                        </div>
                    </div>
                    <div id="answer-${question}" class="text-field bot-field">
                        <input type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled />
                    </div>
                </div>
            `
        } else {
            let html = `
                <div class="field-box" id="question-${question}">
                    <div class="top-field">
                        <div class="header-field">
                            Statement
                            <input type="text" class="title-field-input-text">
                        </div>
                        <div class="header-field">
                            Type of Answer
                            <select id="type-${question}" class="title-field-input-dropdown">
                                <option value="text" ${data.type === "text" ? "selected" : ""}>Text</option>
                                <option value="multiple" ${data.type === "multiple" ? "selected" : ""}>Multiple Choice</option>
                                <option value="checklist" ${data.type === "checklist" ? "selected" : ""}>Checklist</option>
                                <option value="longtext" ${data.type === "longtext" ? "selected" : ""}>Long Text</option>
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
                $.each(data.answer, function (_, ans){
                    let lowAns = ans.toLowerCase();
                    html = html + `
                        <input type="radio" id="${lowAns}-${question}" name="multiple-${question}" value="${ans}">
                        <label for="${lowAns}-${question}">${ans}</label><br> 
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
                $.each(data.answer, function (_, ans){
                    let lowAns = ans.toLowerCase();
                    html = html + `
                        <input type="checkbox" id="${lowAns}-${question}" name="checklist-${question}" value="${ans}">
                        <label for="${lowAns}-${question}">${ans}</label><br> 
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
                        <div id="answer-${question}" class="longtext-field bot-field">
                            <textarea type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled></textarea>
                        </div>
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
                        if (val === 'text') {
                            newField = `
                                <div id="answer-${question}" class="text-field bot-field">
                                    <input type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled />
                                </div>
                            `
                        } else if (val === 'multiple') {
                            newField = `
                                <div id="answer-${question}" class="multiple-field">
                                    <div id="multiple-container-${question}"></div>
                                    <input type="text" name="new-option-${question}" id="new-option-${question}">
                                    <button id="add-multiple-${question}">Add New Option</button>
                                </div>
                            `
                        } else if (val === 'checklist') {
                            newField = `
                                <div id="answer-${question}" class="checklist-field">
                                    <div id="checklist-container-${question}"></div>
                                    <input type="text" name="new-option-${question}" id="new-option-${question}">
                                    <button id="add-checklist-${question}">Add New Option</button>
                                </div>
                            `
                        } else if (val === 'longtext') {
                            newField = `
                                <div id="answer-${question}" class="longtext-field bot-field">
                                    <textarea type="text" class="answer-input-text" placeholder="The answer will be here . . ." disabled></textarea>
                                </div>
                            `
                        } else if (val === 'date') {
                            newField = `
                                <div id="answer-${question}" class="date-field bot-field">
                                    <input type="date">
                                </div>
                            `
                        } else if (val === 'time') {
                            newField = `
                                <div id="answer-${question}" class="time-field bot-field">
                                    <input type="time">
                                </div>
                            `
                        } else if (val === 'datetime') {
                            newField = `
                                <div id="answer-${question}" class="datetime-field bot-field">
                                    <input type="datetime-local">
                                </div>
                            `
                        } else if (val === 'dropdown') {
                            newField = `
                                <div id="answer-${question}" class="dropdown-field bot-field">
                                    <select>
                                        <option value="a" selected>a</option>
                                        <option value="b">b</option>
                                        <option value="c">c</option>
                                    </select>
                                </div>
                            `
                        }
                        answerField.replaceWith(newField);
                        addEventAdd(question, val);
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
                    let type = '';
                    if (val === 'multiple') {
                        type = 'radio';
                    } else if (val === 'checklist') {
                        type = 'checkbox';
                    }
                    newField = `
                            <input type="${type}" id="${newId}" name="${val}-${question}" value="${newOptVal}">
                            <label for="${newId}">${newOptVal}</label><br>
                        `
                    let $container = getElement(containerId);
                    if ($container) {
                        $container.append(newField);
                        getElement(newOptionId)[0].value = null;
                    }
                }
            });
        }
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