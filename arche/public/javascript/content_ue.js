function changeContentTabs(dest) {
    if (dest == "cours") {
        document.getElementById("id_cours").style.display = "block";
        document.getElementById("id_participants").style.display = "none";

        document.getElementById("id_btn_add_section").style.display = "block";
        document.getElementById("id_btn_add_post").style.display = "block";

        document.getElementById("id_tab_cours").classList.add("active");
        document.getElementById("id_tab_participants").classList.remove("active");
    } else {
        document.getElementById("id_participants").style.display = "block";
        document.getElementById("id_cours").style.display = "none";

        document.getElementById("id_btn_add_section").style.display = "none";
        document.getElementById("id_btn_add_post").style.display = "none";

        document.getElementById("id_tab_participants").classList.add("active");
        document.getElementById("id_tab_cours").classList.remove("active");
    }
}