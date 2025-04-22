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
                updateDisplay(response.html, response.section_ranking, 0, false);
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
                wantEditSection(data.id_ue, data.id_section, response.section_label, response.section_ranking);
            });

            const html = document.getElementById(`id_section_${data.id_section}`);
            updateDisplay(html, response.section_ranking, response.old_section_ranking, true);
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
                if(id_section == section.id) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


function updateDisplay(html, section_ranking, old_section_ranking, isExisting) {
    const cours = document.getElementById("id_cours")
    const elems = cours.getElementsByClassName('accordion-item');
    let isOrdered = false;
    let index = 0;

    while (index < elems.length && !isOrdered) {
        elem = elems[index];
        const ranking = document.getElementById(`${elem.id}_ranking`);
        const ranking_value = ranking.innerHTML;
        if (ranking_value == section_ranking) {
            if (section_ranking > old_section_ranking) {
                isExisting ? elem.insertAdjacentElement('afterend', html) : elem.insertAdjacentHTML('beforebegin', html);
            } else {
                isExisting ? elem.insertAdjacentElement('beforebegin', html) : elem.insertAdjacentHTML('afterend', html);
            }
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