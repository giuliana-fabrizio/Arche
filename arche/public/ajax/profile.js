function getFields() {
    return {
        firstname: document.getElementById('id_firstname'),
        surname: document.getElementById('id_name'),
        address: document.getElementById('id_address'),
        phone: document.getElementById('id_phone'),
        password: document.getElementById('id_password'),
        avatar: document.getElementById('id_avatar_image'),
        avatar_default: document.getElementById('id_avatar_default'),
        avatar_selected: document.getElementById('id_avatar'),
        mail: document.getElementById('id_mail')
    }
}


function updateFields(response, firstname, surname, address, phone, password, avatar, avatar_default, avatar_selected, mail) {

    firstname.value = response['firstname'];
    surname.value = response['name'];
    address.value = response['address'];
    phone.value = response['phone'];
    password.value = response['password'];
    mail.innerHTML = response['mail'];

    if (response['avatar']) {
        avatar_default.style.display = "none";
        avatar.style.display = "block";
        avatar.src = `/assets/images/avatar/${response['avatar']}.png`;
        avatar_selected.value = response['avatar'];
        changeAvatar(response['avatar'], `id_avatar_${response['avatar']}`);
    } else {
        avatar.style.display = "none";
        avatar_default.style.display = "block";
    }
}


async function update() {
    const { firstname, surname, address, phone, password, avatar, avatar_default, avatar_selected, mail } = getFields();

    const user = {
        firstname: firstname.value,
        name: surname.value,
        address: address.value,
        phone: phone.value,
        password: password.value,
        avatar: avatar_selected.value
    };

    try {
        const request = await fetch('/ajax/post/profile', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(user),
        });

        let response = await request.text();
        response = JSON.parse(response);

        cancelEdit();

        updateFields(response, firstname, surname, address, phone, password, avatar, avatar_default, avatar_selected, mail);
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}


async function initialView() {
    const { firstname, surname, address, phone, password, avatar, avatar_default, avatar_selected, mail } = getFields();

    try {
        const request = await fetch('/ajax/profile', {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            }
        });

        let response = await request.text();
        response = JSON.parse(response);

        cancelEdit();

        updateFields(response, firstname, surname, address, phone, password, avatar, avatar_default, avatar_selected, mail);
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}