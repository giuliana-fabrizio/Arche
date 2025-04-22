document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".dropdown-menu").addEventListener("click", function (event) {
        event.stopPropagation();
    });
});


function displayItems(disabled) {
    document.getElementById("id_firstname").disabled = disabled;
    document.getElementById("id_firstname").classList.toggle("mb-2", !disabled);
    document.getElementById("id_name").disabled = disabled;
    document.getElementById("id_name").classList.toggle("mb-2", !disabled);
    document.getElementById("id_btn_edit").style.display = disabled ? "block" : "none";

    document.getElementById("id_mail").style.display = disabled ? "block" : "none";
    document.getElementById("id_address").disabled = disabled;

    document.getElementById("id_phone").disabled = disabled;

    document.getElementById("id_password_container").style.display = disabled ? "none" : "block";
    document.getElementById("id_engage_collapse_avatar").style.display = disabled ? "none" : "block";
    document.getElementById("id_collapse_avatar").classList.toggle("d-none", disabled);

    document.getElementById("id_btn_logout").classList.toggle("d-none", !disabled);
    document.getElementById("id_btn_cancel").classList.toggle("d-none", disabled);
    document.getElementById("id_btn_valid").classList.toggle("d-none", disabled);
}


function wantEditProfile() { displayItems(false); }


function cancelEdit() {
    displayItems(true);
    resetAvatar();

    const collapse = document.getElementById("id_engage_collapse_avatar")
    if (!collapse.classList.contains("collapsed")) {
        collapse.classList.add("collapsed")
        document.getElementById("id_collapse_avatar").classList.remove("show");
    }
}


function resetAvatar() {
    document.getElementById("id_avatar").value = null;
    const oldAvatar = document.getElementsByClassName("img-avatar-selected");
    if (oldAvatar.length == 1) oldAvatar[0].classList.remove("img-avatar-selected");
}


function changeAvatar(avatar, id_selected) {
    resetAvatar();
    document.getElementById("id_avatar").value = avatar;
    document.getElementById(id_selected).classList.add("img-avatar-selected");
}


function collapseAvatar() {
    const collapse = document.getElementById("id_engage_collapse_avatar");
    if (collapse.classList.contains("collapsed")) resetAvatar(); // TODO corriger si le mec sélectionne juste pas d'icon
}


function editProfile() {
    const form = document.getElementById("id_form_profile");

    if (form.checkValidity()) {
        const formData = {};
        new FormData(form).forEach((value, key) => {
            formData[key] = value;
        });

        update(formData);
    } else {
        form.reportValidity();
    }
}