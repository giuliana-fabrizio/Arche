async function addSection(origin, section) {
    try {
        const request = await fetch(`/ajax/create/section`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(section),
        });

        let response = await request.text();
        response = JSON.parse(response);

        if (response.code == 200) {
            if (origin == "post_form") {
                const select_section = document.getElementById("id_section_post");
                const option = document.createElement("option");

                option.value = section['name']; // TODO mettre l'id
                option.innerHTML = section['name'];
                option.selected = true;

                select_section.appendChild(option);
            } else {
                const cours = document.getElementById("id_cours");

                cours.innerHTML += `
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <h2 class="w-100">
                                <button
                                    class="accordion-button collapsed fs-5 fw-bold"
                                    data-bs-target="#collapseFour"
                                    data-bs-toggle="collapse"
                                    type="button">
                                    ${section['name']}
                                </button>
                            </h2>
                            <div class="dropdown dropdown-plus">
                                <a class="dropdown-toggle-plus" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end p-0">
                                    <li><a class="dropdown-item text-success" href="#">Éditer</a></li>
                                    <li><a class="dropdown-item text-danger" href="#">Supprimer</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="collapseFour" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the
                                collapse
                                plugin
                                adds the appropriate classes that we use to style each element. These classes control the
                                overall
                                appearance, as
                                well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS
                                or
                                overriding our
                                default variables. It's also worth noting that just about any HTML can go within the
                                <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                        </div>
                    </div>`
            }
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}