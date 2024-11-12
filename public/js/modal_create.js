let colorDefault = "rgb(94,147,218)"
let colorUnActive = "rgb(156 163 175)"

function init_create_modal(name, stepArray, stepContainer, validator, property) {
    function checkIfAllFormFilled() {
        let valid = true
        console.log($("#modal_form").serializeArray());
        $.each($("#modal_form").serializeArray(), function (i, v) {
            if (v.value.length <= 0) {
                valid = false;
                return;
            }
        });

        return valid;
    }
    $.ajax({
        url: '/component/modal',
        method: 'GET',
        success: function (response) {
            let div = $(response);
            let modal = $(div).find("div[name='modal']");
            modal.css("opacity", "0");
            modal.css("margin-top", "-30px")
            $('body').prepend(div);
            let element = $(div).find("div[name='listStep']");
            let container = $(div).find("form[name='container']");
            let buttonContinue = $(div).find("button[name='continue']");
            let buttonBack = $(div).find("button[name='back']");
            container.find("input[name='form_name']").val(name);
            let step = 0;
    
            modal.animate({
                marginTop: "0",
                opacity: "1"
            })
    
            div.click(function (event) {
                if (event.target === div[0]) {
                    div.remove();
                }
            });
    
            function checkingValidateByName() {
                if (validator[step] === undefined) { return; }
                let counter = 0;
                let length = validator[step].length;
                for (let x = 1; x <= validator[step].length; x++) {
                    $.each($("#modal_form").serializeArray(), function (i, v) {
                        let inputName = validator[step][x - 1];
                        if (v.name !== inputName) { return true; }
                        if (v.value.length > 0) { counter += 1 }
                    });
                }
                if (counter === length) { buttonContinue.prop("disabled", false); return true; } else { buttonContinue.prop("disabled", true); return false; }
            }
    
            for (let i = 1; i <= stepArray.length; i++) {
    
                let stepName = stepArray[i - 1]['title'];
                let iconName = stepArray[i - 1]['icon'];
                let curContainer = $(stepContainer[i - 1]);
                let template1 = $(div).find("div[name='template1']").clone();
                let template2 = $(div).find("div[name='template2']").clone();
                curContainer.attr('name', 'step' + i);
                template1.attr('name', 'step' + i);
                template1.find("a").html(stepName);
                template1.css('display', 'flex');
                template1.find("[name='icon']").text(i)
                
                // To fetch icon asynchronously, use $.ajax here if needed
                // $.ajax({
                //     url: '/cdn/icon/' + iconName,
                //     method: 'GET',
                //     success: function(response) {
                //         template1.append(`
                //             <div class="w-full h-full p-[5px] flex justify-center items-center" name="icon">
                //                 ${response}
                //             </div>
                //         `);  
                //     }
                // });
    
                if (validator[i - 1] !== undefined) {
                    for (let x = 1; x <= validator[i - 1].length; x++) {
                        let inputName = validator[i - 1][x - 1];
                        let element = $(`[name='${inputName}']`);
                        element.on('input change', function () {
                            checkingValidateByName();
                        });
                    }
                }
    
                element.append(template1);
                container.prepend(curContainer);
                if (i != stepArray.length) {
                    template2.attr('name', 'line' + i);
                    template2.css('display', 'block');
                    element.append(template2);
                }
                if (i != 1) { curContainer.css("display", "none"); }
            }
    
            function Step(steper) {
                let getColor = (steper > 0) ? colorDefault : colorUnActive;
                let curStep = element.find(`div[name='step${step}']`)
                let nextStep = element.find(`div[name='step${step + steper}']`)
                let lineStep = element.find(`div[name='line${step}']`)
                let curContainer = container.find(`div[name="step${step}"]`);
                let nextContainer = container.find(`div[name="step${step + steper}"]`);
    
                if (steper < 0) {
                    let temp = curStep; curStep = nextStep; nextStep = temp;
                    lineStep = element.find(`div[name='line${step - 1}']`)
                }
                curContainer.css("display", "none");
                nextContainer.css("display", "block");
                if (steper < 0) {
                    curStep.css("background-color", "transparent");
                    curStep.css("border-color", colorDefault);
                    curStep.find("div[name='checklist']").css({
                        display: 'none'
                    })
                    curStep.find("[name='icon']").css({
                        display: 'block'
                    })
                    buttonContinue.prop("disabled", false)
    
                } else {
                    curStep.css("background-color", getColor);
                    curStep.css("border-color", getColor);
                    curStep.find("div[name='checklist']").css({
                        display: 'block'
                    })
                    curStep.find("[name='icon']").css({
                        display: 'none'
                    })
                }
    
                nextStep.css("border-color", getColor);
                lineStep.css("background-color", getColor);
                nextStep.find("a").css('color', getColor);
                step += steper;
                checkingValidateByName();
                if (step - 1 === 0) { buttonBack.prop("disabled", true) } else { buttonBack.prop("disabled", false) }
                if (property.lastButton !== undefined) {
                    if (step == stepArray.length) {
                        buttonContinue.html(property.lastButton)
                    } else {
                        buttonContinue.html("CONTINUE")
                    }
                }
                if (step == stepArray.length) {
                    if (!checkIfAllFormFilled()) {
                        buttonContinue.prop("disabled", true)
                    } else {
                        buttonContinue.prop("disabled", false)
                    }
                }
            }
    
            Step(1);
    
            buttonContinue.click(function (event) {
                if (step == stepArray.length) {
                    if (checkIfAllFormFilled()) {
                        return true;
                    }
                }
                Step(1);
                event.preventDefault();
            });
    
            buttonBack.click(function (event) {
                Step(-1);
                event.preventDefault();
            });
            if (property.onCreate !== undefined) { property.onCreate(); }
        },
        error: function () {
            alert('Error fetching data');
        }
    });    
}