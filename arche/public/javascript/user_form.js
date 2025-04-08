const action_modal = document.getElementById("id_action_modal");
const btn_submit = document.getElementById("id_btn_create_user");
const form = document.getElementById('id_form_user');

function modalUser() {
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


function wantAddUser() {
    action_modal.value = "add";
}


function wantEditUser(id) { // TODO mettre le user entier : )
    const nameOld = document.getElementById(`id_user_name_${id}`);
    const mailOld = document.getElementById(`id_user_mail_${id}`);

    // TODO donner pour value le user[key]
    // const formData = {};
    // new FormData(form).forEach((value, key) => {
    //     formData[key] = value;
    // });

    const id_user = document.getElementById("id_user_form");
    const firstname = document.getElementById("id_firstname_form_user");
    const name = document.getElementById("id_name_form_user");
    const mail = document.getElementById("id_mail_form_user");
    const phone = document.getElementById("id_phone_form_user");
    const adress = document.getElementById("id_address_form_user");
    const role = document.getElementById("id_role_form_user");

    id_user.value = id;
    firstname.value = nameOld.innerText;
    mail.value = mailOld.innerText;

    document.getElementById("id_title_modal").innerHTML = "Modifier un utilisateur";
    action_modal.value = "edit";
}


function changeRole() {
    const value = document.getElementById("id_role_form_user").value;
    document.getElementById("id_container_ues").style.display = value == 1 ? "none" : "block";
}