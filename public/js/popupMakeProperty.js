let colorDefault = "rgb(94,147,218)"

function init_create_property(div, stepArray) {
    let element = $(div).find("div[name='listStep']");
    let button = $(div).find("button");
    let step = 0;
    for (let i = 1; i <= stepArray.length; i++) {
        let stepName = stepArray[i - 1];
        element.append(`
                        <div class="w-[40px] h-[40px] border-4 bg-[#5E93DA] bg-opacity-25 border-gray-400 rounded-full relative" name="step${i}">
                            <a class="absolute top-10 left-1/2 text-sm font-bold text-black -translate-x-1/2">${stepName}</a>
                        </div>
                    `)
        if (i != stepArray.length) {
            element.append(`
                            <div class="w-[100px] h-[4px] bg-gray-300" name="line${i}">
                            </div>
                        `);
        }
    }
    function nextStep() {
        let curStep = element.find(`div[name='step${step}']`)
        let nextStep = element.find(`div[name='step${step + 1}']`)
        let lineStep = element.find(`div[name='line${step}']`)
        curStep.css("background-color", colorDefault);
        curStep.css("border-color", colorDefault);
        nextStep.css("border-color", colorDefault);
        lineStep.css("background-color", colorDefault);
        curStep.find("a").css("color", "rgb(0,0,0)");
        nextStep.find("a").css("color", colorDefault);
        step += 1;
    }
    nextStep();
    button.click(function () {
        if (nextStep == stepArray.length) { return false; }
        nextStep();
    });
}