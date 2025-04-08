const modalElement = document.getElementById('id_add_modal');

document.addEventListener('DOMContentLoaded', function () {
    modalElement.addEventListener('hidden.bs.modal', function () {
        const id_user = document.getElementById("id_user_form");
        id_user.value = "";

        const form = document.getElementById('id_form_user');
        new FormData(form).forEach((_, key) => {
            const input = document.getElementById(`id_${key}_form_user`);
            if (input) {
                input.value = "";
            }
        });
    });
});


function changeTabs(dest) {
    if (dest == "ue") {
        document.getElementById("id_title_modal").innerHTML = "Ajouter une UE";
        document.getElementById("id_modal_body_ue").style.display = "block";
        document.getElementById("id_modal_body_user").style.display = "none";

        document.getElementById("id_ues").style.display = "block";
        document.getElementById("id_ue_tabs").classList.add("active");
        document.getElementById("id_users").style.display = "none";
        document.getElementById("id_user_tabs").classList.remove("active");
    } else {
        document.getElementById("id_title_modal").innerHTML = "Ajouter un utilisateur";
        document.getElementById("id_modal_body_user").style.display = "block";
        document.getElementById("id_modal_body_ue").style.display = "none";

        document.getElementById("id_users").style.display = "block";
        document.getElementById("id_user_tabs").classList.add("active");
        document.getElementById("id_ues").style.display = "none";
        document.getElementById("id_ue_tabs").classList.remove("active");
    }
}

function closeModal() {
    const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
    modalInstance.hide();
}

function wantAdd() {
    action_modal.value = "add";
}