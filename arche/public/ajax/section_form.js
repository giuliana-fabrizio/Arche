async function addSection(origin, section) {
    try {
        const request = await fetch(`/teacher/ajax/create/section`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json", // Corps de message il y a du JSON
                "X-Requested-with": "XMLHttpRequest" // Requête est de type Ajax
            },
            body: JSON.stringify(section), // Transmission du contenu de mon fumulaire au backend
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
                updateDisplay(response.sections_to_update, response.html, false);
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

            document.getElementById(`id_btn_edit_section_${data.id_section}`).addEventListener("click", function () {
                wantEditSection(data.id_ue, data.id_section, response.section_label, response.section_ranking);
            });

            const html = document.getElementById(`id_section_${data.id_section}`);
            if (response.sections_to_update.length != 0) {
                updateDisplay(response.sections_to_update, html, response.section_ranking, true);
            }
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


async function getSections(id_ue, id_select, id_section) {
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
            const select = document.getElementById(id_select);
            removeAllChildNodes(select);

            const sections = response.sections;
            const needFk = id_select.includes("post") ? true : false;

            sections.forEach((section, index) => {
                const option = document.createElement("option");
                option.value = needFk ? section.id : index + 1;
                option.textContent = section.label + " : position " + (index + 1);
                if (id_section == section.id) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


function updateDisplay(sections_to_update, current_html, section_ranking, isExisting) {
    const cours = document.getElementById("id_cours");

    if (sections_to_update.length == 0) {
        isExisting ? cours.insertAdjacentElement('afterend', current_html) : cours.insertAdjacentHTML('afterend', current_html);
        return;
    }


    const first_section = sections_to_update[0];
    const last_section = sections_to_update[sections_to_update.length - 1];
    const first_section_html = document.getElementById(`id_section_${first_section.id}`);
    const last_section_html = document.getElementById(`id_section_${last_section.id}`);


    if (section_ranking < first_section.ranking) {
        isExisting ? first_section_html.insertAdjacentElement('beforebegin', current_html) : cours.insertAdjacentHTML('beforebegin', current_html);
    } else {
        isExisting ? last_section_html.insertAdjacentElement('afterend', current_html) : last_section_html.insertAdjacentHTML('afterend', current_html);
    }

    sections_to_update.forEach(section => {
        const ranking = document.getElementById(`id_section_${section.id}_ranking`);
        ranking.innerText = section.ranking;

        const elem_html = document.getElementById(`id_section_${section.id}`);
        if (ranking < section_ranking) {
            first_section_html.insertAdjacentElement('afterend', elem_html)
        } else {
            last_section_html.insertAdjacentElement('beforebegin', elem_html)
        }
    });
}


function removeAllChildNodes(parent) {
    const options = parent.querySelectorAll("option:not([disabled])");
    options.forEach(option => option.remove());
}