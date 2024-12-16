let colorDefault = "rgb(94,147,218)"
let colorUnActive = "rgb(156 163 175)"

function init_create_modal(name, stepArray, stepContainer, validator, property) {
    function checkIfAllFormFilled() {
        let valid = true
        let counter = 0;
        let length = 0;
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
            container.attr('action', `${getHost()}/api/${name}`);
            let buttonContinue = $(div).find("button[name='continue']");
            let buttonBack = $(div).find("button[name='back']");
            container.find("input[name='form_name']").val(name);
            let step = 0;

            if (property['hideStep']) {
                element.css('display', 'none');
            }
            if (property['hideBack']) {
                buttonBack.css('display', 'none');
            }

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
                    let isOr = false;
                    $.each($("#modal_form").serializeArray(), function (i, v) {
                        let inputName = validator[step][x - 1];
                        if (inputName.split('||').length > 1) {
                            isOr = true;
                            let temp = inputName.split('||');
                            if (v.name !== temp[1]) { return true; }
                            let getRestCounter = length - 1;
                            validator[step].forEach(function (vars) {
                                let inputName2 = vars.split('||')[1];
                                if (inputName2 === undefined) {
                                    inputName2 = vars;
                                }
                                inputName2 = $(`[name='${inputName2}']`)[0];
                                if (inputName2.name !== vars) { return true; }
                                if (inputName2.value.length > 0) { getRestCounter -= 1 }
                            });
                            if (v.value.length > 0) { counter += getRestCounter }
                        } else {
                            if (v.name !== inputName) { return true; }
                            if (v.value.length > 0) { counter += 1 }
                        }
                    });
                    if (isOr) {
                        length -= 1;
                    }
                }

                if (property['disableContinue']) {
                    return;
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

                if (validator[i] !== undefined) {
                    for (let x = 1; x <= validator[i].length; x++) {
                        let v = validator[i][x - 1];
                        let inputName = v.split('||')[1];
                        if (inputName === undefined) {
                            inputName = v;
                        }
                        let element = curContainer.find(`[name='${inputName}']`);
                        element.on('input change propertychange', function () {
                            checkingValidateByName();
                        });
                    }
                }

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
                    if (!property['disableContinue'] || property['disableContinue'] === undefined) {
                        buttonContinue.prop("disabled", false)
                    }

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
                if (property['onNext'] !== undefined) {
                    property['onNext'](step-1, step, div);
                }
                checkingValidateByName();
                if (!property['backAsCancel'] || property['backAsCancel'] === undefined) {
                    if (step - 1 === 0) { buttonBack.prop("disabled", true) } else { buttonBack.prop("disabled", false) }
                }
                if (property.lastButton !== undefined) {
                    if (step == stepArray.length) {
                        buttonContinue.html(property.lastButton)
                    } else {
                        buttonContinue.html("CONTINUE")
                    }
                }
                if (step == stepArray.length) {
                    if (!property['disableContinue'] || property['disableContinue'] === undefined) {
                        if (validator.length > 0) {
                            checkingValidateByName();
                        } else {
                            buttonContinue.prop("disabled", false);
                        }
                        // if (!checkIfAllFormFilled()) {
                        //     buttonContinue.prop("disabled", true)
                        // } else {
                        //     buttonContinue.prop("disabled", false)
                        // }
                    }
                }
            }

            if (property['max-width'] !== undefined) {
                modal.css("max-width", property['max-width'])
            }
            if (property['min-width'] !== undefined) {
                modal.css("min-width", property['min-width'])
            }
            if (property['max-height'] !== undefined) {
                modal.css("max-height", property['max-height'])
            }
            if (property['min-height'] !== undefined) {
                modal.css("min-height", property['min-height'])
            }

            Step(1);

            if (property['disableContinue']) {
                buttonContinue.prop("disabled", true);
            }
            if (property['disableBack']) {
                buttonBack.prop("disabled", true);
            }

            if (property['backAsClose']) {
                buttonBack.html("CLOSE")
                buttonBack.prop("disabled", false)
                buttonBack.click(function (event) {
                    div.remove();
                    event.preventDefault();
                });
            } else {
                buttonBack.click(function (event) {
                    Step(-1);
                    event.preventDefault();
                });
            }

            if (property['backButton'] !== undefined) {
                buttonBack.html(property['backButton'])
            }
            if (property['readonly'] !== undefined) {
                let readonly = property['readonly'];
                $.each(readonly, function (i, v) {
                    container.find(`[name='${v}']`).prop("readonly", true)
                });
            }

            buttonContinue.click(function (event) {
                if (step == stepArray.length) {
                    return true;
                }
                Step(1);
                event.preventDefault();
            });

            if (property.onCreate !== undefined) { property.onCreate(container, div); }
        },
        error: function () {
            alert('Error fetching data');
        }
    });
}