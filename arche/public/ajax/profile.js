function getFields() {
    return {
        full_name: document.getElementById('id_name'),
        address: document.getElementById('id_address'),
        phone: document.getElementById('id_phone'),
        password: document.getElementById('id_password'),
        avatar: document.getElementById('id_avatar')
    }
}


function updateFields(response, full_name, address, phone, password, avatar) {
    full_name.value = response['name'];
    address.value = response['address'];
    phone.value = response['phone'];
    password.value = response['password']
    avatar.value = response['avatar'];
}


async function update() {
    const { full_name, address, phone, password, avatar } = getFields();

    const user = {
        name: full_name.value,
        address: address.value,
        phone: phone.value,
        password: password.value,
        avatar: avatar.value
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

        updateFields(response, full_name, address, phone, password, avatar)

        resetDisplay()
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}


async function cancel() {
    const { full_name, address, phone, password, avatar } = getFields();

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

        updateFields(response, full_name, address, phone, password, avatar)

        resetDisplay()
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}