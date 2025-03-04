document.addEventListener("DOMContentLoaded", function () {
    let selectedColor = null;
    let selectedSize = null;
    const priceDisplay = document.querySelector('.price');

    const productVariants = Array.from(document.querySelectorAll(".color-option")).map(el => ({
        color: el.getAttribute("data-color"),
        size: el.getAttribute("data-size"),
        price: el.getAttribute("data-price")
    }));

    function updatePrice() {
        if (selectedColor && selectedSize) {
            const variant = productVariants.find(v => v.color === selectedColor && v.size === selectedSize);
            if (variant) {
                priceDisplay.textContent = new Intl.NumberFormat().format(variant.price) + " VND";
            }
        }
    }

    function updateAvailableOptions() {

        document.querySelectorAll(".size-option").forEach(sizeEl => {
            const size = sizeEl.getAttribute("data-size");
            const isAvailable = productVariants.some(v => v.color === selectedColor && v.size === size);

            if (selectedColor && !isAvailable) {
                sizeEl.classList.add("disabled");
            } else {
                sizeEl.classList.remove("disabled");
            }
        });


        document.querySelectorAll(".color-option").forEach(colorEl => {
            const color = colorEl.getAttribute("data-color");
            const isAvailable = productVariants.some(v => v.size === selectedSize && v.color === color);

            if (selectedSize && !isAvailable) {
                colorEl.classList.add("disabled");
            } else {
                colorEl.classList.remove("disabled");
            }
        });
    }

    document.querySelectorAll(".color-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedColor = this.getAttribute("data-color");

            document.querySelectorAll(".color-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            updateAvailableOptions();
            updatePrice();
        });
    });

    document.querySelectorAll(".size-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedSize = this.getAttribute("data-size");

            document.querySelectorAll(".size-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            updateAvailableOptions();
            updatePrice();
        });
    });
});
