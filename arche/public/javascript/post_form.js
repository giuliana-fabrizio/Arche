const modalElement = document.getElementById('id_add_section_modal');
const form_section = document.getElementById('id_form_section');

document.addEventListener('DOMContentLoaded', function () {
    modalElement.addEventListener('hidden.bs.modal', function () {
        const id_section = document.getElementById("id_section_form");
        id_section.value = "";

        clearSectionForm();
    });
});


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


function clearSectionForm() {
    form_section.reset();
}


function closeModalSection() {
    const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
    modalInstance.hide();
}


function modalSection() {
    if (form_section.checkValidity()) {
        const formData = {};
        new FormData(form_section).forEach((value, key) => {
            formData[key] = value;
        });

        addSection(formData);
        closeModalSection();
    } else {
        form_section.reportValidity();
    }
}