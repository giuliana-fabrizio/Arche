const action_modal_user = document.getElementById("id_action_modal");
const form_user = document.getElementById('id_form_user');

const container_ues = document.getElementById("id_container_ues");
const searchInput = document.getElementById("id_ues_form_user");
const selectedItems = container_ues.querySelector('.selected-items');
const options_list = document.getElementById("id_ues_list");
const selected_ues = [];


searchInput.addEventListener('input', filterOptions);

function filterOptions() {
    const filter = searchInput.value.toLowerCase().trim();
    const options = options_list.querySelectorAll('.option');
    const no_option = options_list.querySelectorAll('.disable')[0];
    let isResult = false;

    options.forEach(option => {
        const text = option.textContent.toLowerCase();
        if (text.includes(filter)) {
            isResult = true;
            option.style.display = "block";
        } else {
            option.style.display = "none";
        }
    });

    no_option.style.display = isResult ? "none" : "block";
}


function removeTag(span, value) {
    const index = selected_ues.indexOf(value);
    if (index > -1) {
        selected_ues.splice(index, 1);
    }
    span.parentElement.remove();
}


function selectUe(event) {
    const value = event.textContent; // TODO changer !
    if (selected_ues.includes(value)) return;

    selected_ues.push(value);

    const tag = document.createElement('div');
    tag.className = 'badge m-1 text-bg-blue';
    tag.innerHTML = `${value}<span onclick="removeTag(this, '${value}')">&times;</span>`;

    searchInput.insertAdjacentElement('beforebegin', tag);
    searchInput.value = '';
    filterOptions();
}


function changeRole() {
    const value = document.getElementById("id_role_form_user").value;
    document.getElementById("id_container_ues").style.display = value == 1 ? "none" : "block";
}


function clearAllTags() {
    const tags = document.querySelectorAll('#id_selected_ue .badge');
    tags.forEach(tag => tag.remove());

    selected_ues.length = 0;
    searchInput.value = '';
}


function clearUserForm() {
    new FormData(form_user).forEach((_, key) => {
        const input = document.getElementById(`id_${key}_form_user`);
        if (input) {
            input.value = "";
        }
    });

    clearAllTags();
}


function modalUser() {
    if (form_user.checkValidity()) {
        const formData = {};
        new FormData(form_user).forEach((value, key) => {
            formData[key] = value;
        });

        if (action_modal_user.value == "add") {
            addUser(formData);
        } else {
            editUser(formData);
        }
        closeModal();
    } else {
        form_user.reportValidity();
    }
}


function wantEditUser(id) { // TODO mettre le user entier : )
    const nameOld = document.getElementById(`id_user_name_${id}`);
    const mailOld = document.getElementById(`id_user_mail_${id}`);

    // TODO donner pour value le user[key]
    // const formData = {};
    // new FormData(form_user).forEach((value, key) => {
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
    action_modal_user.value = "edit";
}