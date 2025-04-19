const modalElement = document.getElementById('id_add_section_modal');
const form_section = document.getElementById('id_form_section');

document.addEventListener('DOMContentLoaded', function () {
    modalElement.addEventListener('hidden.bs.modal', function () {
        const id_section = document.getElementById("id_section_form");
        id_section.value = "";

        clearSectionForm();
    });
});


function clearSectionForm() {
    form_section.reset();
}


function closeModalSection() {
    const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
    modalInstance.hide();
}


function modalSection(origin) {
    if (form_section.checkValidity()) {
        const formData = {};
        new FormData(form_section).forEach((value, key) => {
            formData[key] = value;
        });

        addSection(origin, formData);
        closeModalSection();
    } else {
        form_section.reportValidity();
    }
}


function wantEditSection(id) {
    document.getElementById("id_title_modal_section").innerHTML = "Modifier une section";
}