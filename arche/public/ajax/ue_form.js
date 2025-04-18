async function addUe(ue) {
    try {
        const request = await fetch(`/admin/ajax/create/ue`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(ue),
        });

        let response = await request.text();
        response = JSON.parse(response);

        if (response == 200) {
            // TODO faire les ue et l'id dans span, edit et delete
            document.getElementById("id_ues").innerHTML +=
                `
                <div id="id_ue_3" class="align-items-center justify-content-between mb-3 row">
                    <div class="col-12 col-md-6 d-flex flex-wrap">
                        <p id="id_ue_code_3" class="fw-bold m-0 me-2 code-catalogue">${ue.code}</p>
                        <p id="id_ue_name_3" class="m-0">${ue.name}</p>
                    </div>
                    <p id="id_ue_teacher_3" class="col-12 col-md-4 m-0">Enseignant responsable d'UE</p>

                    <div class="col-12 col-md-2 d-flex justify-content-center">
                        <button
                            data-bs-toggle="modal"
                            data-bs-target="#id_add_modal"
                            onclick="wantEditUe(3)"
                            class="btn btn-success btn-sm me-2">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button onclick="deleteUe('id_ue_3')" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                `
        }
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}


async function editUe(ue) {
    try {
        const request = await fetch(`/admin/ajax/edit/ue`, {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(ue),
        });

        let response = await request.text();
        response = JSON.parse(response);

        if (response == 200) {
            // TODO faire les ue et l'id dans span, edit et delete
            const id = ue['ue'];

            document.getElementById(`id_ue_code_${id}`).innerHTML = ue['code'];
            document.getElementById(`id_ue_name_${id}`).innerHTML = ue['name'];
            document.getElementById(`id_ue_teacher_${id}`).innerHTML = ue['teacher'];
        }
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}