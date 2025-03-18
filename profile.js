function displayItems(disabled) {
    document.getElementById("id_name").disabled = disabled;
    document.getElementById("id_name").classList.toggle("mb-2", !disabled);
    document.getElementById("id_btn_edit").style.display = disabled ? "block" : "none";

    document.getElementById("id_mail").style.display = disabled ? "block" : "none";
    document.getElementById("id_adress").disabled = disabled;

    document.getElementById("id_phone").disabled = disabled;

    document.getElementById("id_password").style.display = disabled ? "none" : "block";
    document.getElementById("id_engage_collapse_avatar").style.display = disabled ? "none" : "block";
    document.getElementById("id_collapse_avatar").classList.toggle("d-none", disabled)
    document.getElementById("id_btn_action").classList.toggle("d-none", disabled);
}

function editProfile() { displayItems(false); }

function cancelEdit() { displayItems(true); }

function changeAvatar(avatar, id_selected) {
    var oldAvatar = document.getElementsByClassName("img-avatar-selected");
    if (oldAvatar.length == 1) oldAvatar[0].classList.remove("img-avatar-selected");
    document.getElementById("id_avatar").value = avatar;
    document.getElementById(id_selected).classList.add("img-avatar-selected");
}