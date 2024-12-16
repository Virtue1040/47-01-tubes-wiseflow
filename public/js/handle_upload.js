function handle_upload(element) {
    let input = $(element);
    let fileName = input[0].files.length > 0 ? input[0].files[0].name : "No file selected";
    let getParent = input.parent();
    getParent.find("a[name='fileName']").text(fileName);
    let preview = getParent.find("img[name='preview']");
    if (input[0].files && input[0].files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            preview.css("display", "block");
            getParent.find("[name='icon']").css("display", "none")
            preview.attr("src", e.target.result);
        }
        reader.readAsDataURL(input[0].files[0]);
    }
}