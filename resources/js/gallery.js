document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".filter-btn");
    const galleryItems = document.querySelectorAll(".gallery-item");

    filterButtons.forEach(button => {
        button.addEventListener("click", function () {
            const filter = this.getAttribute("data-filter");

            galleryItems.forEach(item => {
                if (filter === "all" || item.classList.contains(filter)) {
                    item.classList.remove("hidden");
                } else {
                    item.classList.add("hidden");
                }
            });

            // Aktif buton stilini değiştir
            filterButtons.forEach(btn => btn.classList.remove("btn-primary"));
            this.classList.add("btn-primary");
        });
    });
});
