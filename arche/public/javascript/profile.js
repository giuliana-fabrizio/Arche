document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".dropdown-menu").addEventListener("click", function (event) {
        event.stopPropagation();
    });
});


function displayItems(disabled) {
    document.getElementById("id_name").disabled = disabled;
    document.getElementById("id_name").classList.toggle("mb-2", !disabled);
    document.getElementById("id_btn_edit").style.display = disabled ? "block" : "none";

    document.getElementById("id_mail").style.display = disabled ? "block" : "none";
    document.getElementById("id_address").disabled = disabled;

    document.getElementById("id_phone").disabled = disabled;

    document.getElementById("id_password").style.display = disabled ? "none" : "block";
    document.getElementById("id_engage_collapse_avatar").style.display = disabled ? "none" : "block";
    document.getElementById("id_collapse_avatar").classList.toggle("d-none", disabled)
    document.getElementById("id_btn_action").classList.toggle("d-none", disabled);
}

function editProfile() { displayItems(false); }

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
    console.log(document.getElementById(id_selected).classList, id_selected)
}

function collapseAvatar() {
    const collapse = document.getElementById("id_engage_collapse_avatar");
    if (collapse.classList.contains("collapsed")) resetAvatar(); // TODO corriger si le mec sélectionne juste pas d'icon
}