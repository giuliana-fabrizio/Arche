function changeTabs(dest) {
    document.getElementById("id_ue").style.display = dest == "ue" ? "block" : "none";
    document.getElementById("id_user").style.display = dest == "ue" ? "none" : "block";
}