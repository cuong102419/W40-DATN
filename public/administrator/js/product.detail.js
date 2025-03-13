
// quantity product
document.addEventListener("DOMContentLoaded", function () {
    let selectedColor = null;
    let selectedSize = null;

    document.querySelectorAll(".color-option").forEach(color => {
        color.addEventListener("click", function () {
            selectedColor = this.dataset.color;
            console.log("Selected Color:", selectedColor); 
            updateStockStatus();
        });
    });

    document.querySelectorAll(".size-option").forEach(size => {
        size.addEventListener("click", function () {
            selectedSize = this.dataset.size;
            console.log("Selected Size:", selectedSize); 
            updateStockStatus();
        });
    });
    function updateStockStatus() {
        if (!selectedColor || !selectedSize) {
            document.getElementById("stock-status").innerText = "Chọn màu và size";
            return;
        }
    
        console.log("Checking stock for:", selectedColor, selectedSize); 
    
        let variant = [...document.querySelectorAll(".quantity-option")].find(q =>
            q.dataset.color === selectedColor && q.dataset.size === selectedSize
        );
    
        if (variant) {
            let quantity = parseInt(variant.dataset.quantity);
            console.log("Found quantity:", quantity); 
    
            if (quantity === 0) {
                document.getElementById("stock-status").innerText = "Hết hàng";
            } else if (quantity < 5) {
                document.getElementById("stock-status").innerText = `Sắp hết hàng (${quantity})`;
            } else {
                document.getElementById("stock-status").innerText = `Còn hàng(${quantity})`;
            }
        } else {
            console.log("Variant not found!");
            document.getElementById("stock-status").innerText = "Hết hàng";
        }
    }
    
});
// --------------------------------------------------------
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

    let productDiscount = parseFloat(document.querySelector("#product-discount").value || 0);
    console.log("Giảm giá mới:", productDiscount);

    function updatePrice() {
        if (selectedColor && selectedSize) {
            const variant = productVariants.find(v => v.color === selectedColor && v.size === selectedSize);
            if (variant) {
                let finalPrice = variant.price * (1 - productDiscount / 100);
                priceDisplay.textContent = new Intl.NumberFormat().format(finalPrice) + " VND";
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

            document.querySelector("#selected-color").value = selectedColor;

            updateAvailableOptions();
            updatePrice();
        });
    });

    document.querySelectorAll(".size-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedSize = this.getAttribute("data-size");

            document.querySelectorAll(".size-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            document.querySelector("#selected-size").value = selectedSize;

            updateAvailableOptions();
            updatePrice();
        });
    });
});

// Add to cart
$(document).ready(function () {
    $('#add-to-cart').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        window.location.href = cartIndexUrl;
                    }, 2000);
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });
});
