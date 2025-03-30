function changeRole() {
    const value = document.getElementById("id_role").value;
    document.getElementById("id_container_ues").style.display = value == 1 ? "none" : "block";
}