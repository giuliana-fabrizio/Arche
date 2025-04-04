async function addUser(user) {

    try {
        const request = await fetch(`/ajax/create/user`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(user),
        });

        let response = await request.text();
        response = JSON.parse(response);

        if (response == 200) {
            // TODO faire les ue et l'id dans span, edit et delete
            document.getElementById("id_users").innerHTML +=
                `
                <div id="id_user_3" class="align-items-center justify-content-between mb-3 row">
                    <p class="d-flex col-12 col-md-2 m-0">${user.firstname} ${user.name}</p>
                    <p class="d-flex col-12 col-md-3 m-0">${user.mail}</p>
                    <p class="col-12 col-md-2 m-0">${user.role}</p>
                    <div class="align-items-center col-12 col-md-3 d-flex flex-wrap justify-content-start">
                        <p class="badge m-0 m-1 text-bg-blue">WE.4A</p>
                        <p class="badge m-0 m-1 text-bg-blue">WE.4A</p>
                        <p class="badge m-0 m-1 text-bg-blue">WE.4A</p>
                        <p class="badge m-0 m-1 text-bg-blue">WE.4A</p>
                    </div>

                    <div class="col-12 col-md-2 d-flex justify-content-center">
                        <button class="btn btn-success btn-sm me-2">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button onclick="deleteUser('id_user_3')" class="btn btn-danger btn-sm">
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


async function editUser(user) {

    try {
        const request = await fetch(`/ajax/edit/user`, {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(user),
        });

        let response = await request.text();
        response = JSON.parse(response);

        if (response == 200) {
            // TODO faire les ue et l'id dans span, edit et delete
            const id = user['id_user'];

            document.getElementById(`id_user_name_${id}`).innerHTML = user['firstname'] +
                " " + user['name'];
            document.getElementById(`id_user_mail_${id}`).innerHTML = user['mail'];
            document.getElementById(`id_user_role_${id}`).innerHTML = user['role'];
        }
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}