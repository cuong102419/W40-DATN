document.addEventListener("DOMContentLoaded", function () {
    let selectedColor = null;
    let selectedSize = null;
    const priceDisplay = document.querySelector('.price');

    const productVariants = [];
    document.querySelectorAll(".color-option").forEach(colorEl => {
        const color = colorEl.getAttribute("data-color");
        const sizes = colorEl.getAttribute("data-size").split(",");

        sizes.forEach(size => {
            const variant = {
                color: color,
                size: size.trim(),
                price: parseInt(colorEl.getAttribute("data-price"))
            };
            productVariants.push(variant);
        });
    });

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

            sizeEl.classList.toggle("disabled", selectedColor && !isAvailable);
        });

        document.querySelectorAll(".color-option").forEach(colorEl => {
            const color = colorEl.getAttribute("data-color");
            const isAvailable = productVariants.some(v => v.size === selectedSize && v.color === color);

            colorEl.classList.toggle("disabled", selectedSize && !isAvailable);
        });
    }

    document.querySelectorAll(".color-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedColor = this.getAttribute("data-color");

            document.querySelectorAll(".color-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            document.querySelector("#selected-color").value = selectedColor; // Gán giá trị vào input hidden

            updateAvailableOptions();
            updatePrice();
        });
    });

    document.querySelectorAll(".size-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedSize = this.getAttribute("data-size");

            document.querySelectorAll(".size-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            document.querySelector("#selected-size").value = selectedSize; // Gán giá trị vào input hidden

            updateAvailableOptions();
            updatePrice();
        });
    });
});
