const action_modal = document.getElementById("id_action_modal");
const form_ue = document.getElementById('id_form_ue');

function modalUe() {
    if (form_ue.checkValidity()) {
        const formData = {};
        new FormData(form_ue).forEach((value, key) => {
            formData[key] = value;
        });

        if (action_modal.value == "add") {
            addUe(formData);
        } else {
            editUe(formData);
        }
        closeModal();
    } else {
        form_ue.reportValidity();
    }
}


function wantEditUe(id) { // TODO mettre l'ue entière : )
    const codeOld = document.getElementById(`id_ue_code_${id}`);
    const nameOld = document.getElementById(`id_ue_name_${id}`);
    const oldImage = document.getElementById(``)

    // TODO donner pour value le ue[key]
    // const formData = {};
    // new FormData(form_ue).forEach((value, key) => {
    //     formData[key] = value;
    // });

    const id_ue = document.getElementById("id_ue_form");
    const code = document.getElementById("id_code_form_ue");
    const name = document.getElementById("id_name_form_ue");
    const image = document.getElementById("id_image_form_ue");

    id_ue.value = id;
    name.value = nameOld.innerText;
    code.value = codeOld.innerText;
    // image.value = oldImage.value;

    document.getElementById("id_title_modal").innerHTML = "Modifier une UE";
    action_modal.value = "edit";
}