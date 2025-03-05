document.addEventListener("DOMContentLoaded", function () {
    let selectedColor = null;
    let selectedSize = null;
    const priceDisplay = document.querySelector('.price');

    // Lấy dữ liệu từ HTML vào mảng biến thể sản phẩm
    const productVariants = [];
    document.querySelectorAll(".color-option").forEach(colorEl => {
        const color = colorEl.getAttribute("data-color");
        const sizes = colorEl.getAttribute("data-size").split(",");
        
        sizes.forEach(size => {
            const variant = {
                color: color,
                size: size.trim(),
                price: parseInt(colorEl.getAttribute("data-price")) // Chuyển về số
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
        // Cập nhật size dựa trên màu đã chọn
        document.querySelectorAll(".size-option").forEach(sizeEl => {
            const size = sizeEl.getAttribute("data-size");
            const isAvailable = productVariants.some(v => v.color === selectedColor && v.size === size);

            sizeEl.classList.toggle("disabled", selectedColor && !isAvailable);
        });

        // Cập nhật màu dựa trên size đã chọn
        document.querySelectorAll(".color-option").forEach(colorEl => {
            const color = colorEl.getAttribute("data-color");
            const isAvailable = productVariants.some(v => v.size === selectedSize && v.color === color);

            colorEl.classList.toggle("disabled", selectedSize && !isAvailable);
        });
    }

    // Xử lý chọn màu
    document.querySelectorAll(".color-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedColor = this.getAttribute("data-color");

            // Xóa active các màu khác, chỉ chọn màu hiện tại
            document.querySelectorAll(".color-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            updateAvailableOptions();
            updatePrice();
        });
    });

    // Xử lý chọn size
    document.querySelectorAll(".size-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedSize = this.getAttribute("data-size");

            // Xóa active các size khác, chỉ chọn size hiện tại
            document.querySelectorAll(".size-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            updateAvailableOptions();
            updatePrice();
        });
    });
});
