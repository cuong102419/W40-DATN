document.addEventListener("DOMContentLoaded", function () {
    function fetchProducts(color, size) {
        fetch(`/get-similar-products?color=${color}&size=${size}`)
            .then(response => response.json())
            .then(data => {
                let productContainer = document.getElementById("similar-products");
                productContainer.innerHTML = ""; // Xóa sản phẩm cũ

                data.forEach(product => {
                    let productHTML = `
                        <div class="product-item">
                            <img src="${product.image}" alt="${product.name}">
                            <h5>${product.name}</h5>
                            <p>${product.price} VND</p>
                        </div>
                    `;
                    productContainer.innerHTML += productHTML;
                });
            })
            .catch(error => console.error("Lỗi khi tải sản phẩm:", error));
    }

    document.querySelectorAll(".color-option").forEach(option => {
        option.addEventListener("click", function () {
            let selectedColor = this.getAttribute("data-color");
            let selectedSize = document.querySelector(".size-option.active")?.getAttribute("data-size") || "";

            document.querySelectorAll(".color-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            fetchProducts(selectedColor, selectedSize);
        });
    });

    document.querySelectorAll(".size-option").forEach(option => {
        option.addEventListener("click", function () {
            let selectedSize = this.getAttribute("data-size");
            let selectedColor = document.querySelector(".color-option.active")?.getAttribute("data-color") || "";

            document.querySelectorAll(".size-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            fetchProducts(selectedColor, selectedSize);
        });
    });
});
