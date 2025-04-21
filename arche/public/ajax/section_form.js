async function addSection(origin, section) {
    try {
        const request = await fetch(`/teacher/ajax/create/section`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(section),
        });

        const response = await request.json();

        if (response.code == 200) {
            if (origin == "post_form") {
                const select_section = document.getElementById("id_section_post");
                const option = document.createElement("option");

                option.value = response.section_id;
                option.innerHTML = response.section_label;
                option.selected = true;

                select_section.appendChild(option);
            } else {
                updateDisplay(response.html, response.section_ranking, false);
            }

            document.getElementById("id_ajax_no_result").style.display = "none";
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


async function editSection(data) {
    try {
        const request = await fetch(`/teacher/ajax/edit/section/${data.id_section}`, {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(data),
        });

        const response = await request.json();

        if (response.code == 200) {
            document.getElementById(`id_label_section_${data.id_section}`).innerHTML = response.section_label;

            document.getElementById("id_btn_edit_section").addEventListener("click", function () {
                wantEditSection(data.id_section, response.section_label, response.section_ranking);
            });

            const html = document.getElementById(`id_section_${data.id_section}`);
            updateDisplay(html, response.section_ranking, true);
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


async function getSections(id_ue) {
    try {
        const request = await fetch(`/teacher/ajax/sections/${id_ue}`, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            }
        });

        const response = await request.json();

        if (response.code == 200) {
            const select = document.getElementById("id_ranking_form_section");
            removeAllChildNodes(select);
            const sections = response.sections;

            sections.forEach((section, index) => {
                const option = document.createElement("option");
                option.value = index + 1;
                option.textContent = section.label + " " + (index + 1);
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


function updateDisplay(html, section_ranking, isExisting) {
    const cours = document.getElementById("id_cours").getElementsByClassName('accordion-item');
    let isOrdered = false;
    let index = 0;

    while (index < cours.length && !isOrdered) {
        elem = cours[index];
        const ranking = document.getElementById(`${elem.id}_ranking`).innerHTML;
        if (ranking == section_ranking) {
            isExisting ? elem.insertAdjacentElement('beforebegin', html) : elem.insertAdjacentHTML('beforebegin', html);
            isOrdered = true;
        }
        index += 1;
    }

    if (!isOrdered) {
        isExisting ? cours.insertAdjacentElement('beforeend', html) : cours.insertAdjacentHTML('beforeend', html);
    }
}


function removeAllChildNodes(parent) {
    const options = parent.querySelectorAll("option:not([disabled])");
    options.forEach(option => option.remove());
}