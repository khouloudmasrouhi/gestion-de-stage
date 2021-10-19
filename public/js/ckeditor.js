//on initialise CKEditor
BalloonEditor
    .create(document.querySelector("#editor0"))
    .then(editor => {
            editor.sourceElement.parentElement.addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("#offre_stage_description").value = editor.getData();
            this.submit();
        })


    });

BalloonEditor
    .create(document.querySelector("#editor1"))
    .then(editor => {
            editor.sourceElement.parentElement.addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("#offre_stage_mission").value = editor.getData();
            this.submit();
        })

    });

BalloonEditor
    .create(document.querySelector("#editor2"))
    .then(editor => {
            editor.sourceElement.parentElement.addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("#offre_stage_preRequis").value = editor.getData();
            this.submit();
        })


    });