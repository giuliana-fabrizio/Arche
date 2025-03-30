function changeTabs(dest) {
    if (dest == "ue") {
        document.getElementById("id_ue").style.display = "block";
        document.getElementById("id_ue_tabs").classList.add("active");
        document.getElementById("id_user").style.display = "none";
        document.getElementById("id_user_tabs").classList.remove("active");
    } else {
        document.getElementById("id_user").style.display = "block";
        document.getElementById("id_user_tabs").classList.add("active");
        document.getElementById("id_ue").style.display = "none";
        document.getElementById("id_ue_tabs").classList.remove("active");
    }
}