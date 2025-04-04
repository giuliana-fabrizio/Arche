function changeTabs(dest) {
    if (dest == "ue") {
        document.getElementById("id_title_modal").innerHTML = "Ajouter une UE";

        document.getElementById("id_ues").style.display = "block";
        document.getElementById("id_ue_tabs").classList.add("active");
        document.getElementById("id_users").style.display = "none";
        document.getElementById("id_user_tabs").classList.remove("active");
    } else {
        document.getElementById("id_title_modal").innerHTML = "Ajouter un utilisateur";

        document.getElementById("id_users").style.display = "block";
        document.getElementById("id_user_tabs").classList.add("active");
        document.getElementById("id_ues").style.display = "none";
        document.getElementById("id_ue_tabs").classList.remove("active");
    }
}