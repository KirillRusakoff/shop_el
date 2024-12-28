document.addEventListener("DOMContentLoaded", () => {
    // Пример функционала: Переключение изображений в карточке товара
    const images = document.querySelectorAll(".product-detail .images img");
    if (images.length > 0) {
        images.forEach((img) => {
            img.addEventListener("click", () => {
                images.forEach((img) => img.classList.remove("active"));
                img.classList.add("active");
            });
        });
    }
});
