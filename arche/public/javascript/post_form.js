function changeTabs(dest) {
    if (dest == "text") {
        document.getElementById("id_form_text").style.display = "block";
        document.getElementById("id_text_tabs").classList.add("active");
        document.getElementById("id_form_file").style.display = "none";
        document.getElementById("id_file_tabs").classList.remove("active");
    } else {
        document.getElementById("id_form_file").style.display = "block";
        document.getElementById("id_file_tabs").classList.add("active");
        document.getElementById("id_form_text").style.display = "none";
        document.getElementById("id_text_tabs").classList.remove("active");
    }
}