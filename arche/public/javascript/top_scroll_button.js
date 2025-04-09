document.addEventListener("DOMContentLoaded", () => {
    const btn_scroll = document.getElementById("id_btn_scroll_top");

    function checkScroll() {
        if (window.scrollY > 50) {
            btn_scroll.style.display = "block";
        } else {
            btn_scroll.style.display = "none";
        }
    }

    window.addEventListener("scroll", checkScroll);
    checkScroll();
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}