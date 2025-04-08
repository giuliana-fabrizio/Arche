const action_modal = document.getElementById("id_action_modal");
const btn_submit = document.getElementById("id_btn_form_ue");
const form = document.getElementById('id_user_form');

function modalUe() {
    if (form.checkValidity()) {
        const formData = {};
        new FormData(form).forEach((value, key) => {
            formData[key] = value;
        });

        if (action_modal.value == "add") {
            addUser(formData);
        } else {
            editUser(formData);
        }
        closeModal();
    } else {
        form.reportValidity();
    }
}


function wantEditUser(id) { // TODO mettre le user entier : )
}