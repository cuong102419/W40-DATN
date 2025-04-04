document.addEventListener("DOMContentLoaded", function () {
    let submitButton = document.getElementById("checkout-btn");
    let privacyCheckbox = document.getElementById("privacy");
    let paymentRadios = document.querySelectorAll("input[name='payment_method']");
    let hiddenPaymentInput = document.getElementById("payment_method");
    let totalInput = document.querySelector("input[name='total']");
    let totalDisplay = document.querySelector(".order-total h5.text-danger");

    const provinceSelect = document.getElementById("province");
    const districtSelect = document.getElementById("district");

    if (!provinceSelect || !districtSelect) {
        console.error("Không tìm thấy phần tử #province hoặc #district");
        return;
    }

    function getTotalFromDisplay() {
        return parseInt(totalDisplay.innerText.replace(/\D/g, ''), 10);
    }

    function showError(selectElement, message) {
        let oldError = selectElement.parentElement.querySelector(".text-danger");
        if (oldError) oldError.remove();

        let errorSpan = document.createElement("span");
        errorSpan.classList.add("text-danger", "small", "mt-2", "d-block");
        errorSpan.innerText = message;

        selectElement.parentElement.appendChild(errorSpan);
    }

    function removeError(selectElement) {
        let oldError = selectElement.parentElement.querySelector(".text-danger");
        if (oldError) oldError.remove();
    }

    provinceSelect.addEventListener("change", function () {
        let provinceCode = this.value;
        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
        removeError(provinceSelect);

        if (!provinceCode) return;

        fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
            .then(res => res.json())
            .then(data => {
                data.districts.forEach(district => {
                    let option = new Option(district.name, district.name);
                    districtSelect.add(option);
                });
            })
            .catch(err => console.error("Lỗi khi lấy danh sách quận/huyện:", err));
    });

    districtSelect.addEventListener("change", function () {
        removeError(districtSelect);
    });

    paymentRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            hiddenPaymentInput.value = this.value;
        });
    });

    let checkedRadio = document.querySelector("input[name='payment_method']:checked");
    if (checkedRadio) {
        hiddenPaymentInput.value = checkedRadio.value;
    }

    submitButton.addEventListener("click", function (event) {
        event.preventDefault();

        removeError(provinceSelect);
        removeError(districtSelect);

        if (!privacyCheckbox.checked) {
            toastr.error('Bạn cần đồng ý điều khoản và điều kiện mua hàng.');
            return;
        }

        let selectedPayment = document.querySelector("input[name='payment_method']:checked");
        if (!selectedPayment) {
            toastr.error('Vui lòng chọn hình thức thanh toán.');
            return;
        }

        if (provinceSelect.selectedIndex <= 0) {
            showError(provinceSelect, "Vui lòng chọn Tỉnh/Thành phố.");
            return;
        }

        if (districtSelect.selectedIndex <= 0) {
            showError(districtSelect, "Vui lòng chọn Quận/Huyện.");
            return;
        }

        hiddenPaymentInput.value = selectedPayment.value;
        totalInput.value = getTotalFromDisplay();

        let provinceName = provinceSelect.options[provinceSelect.selectedIndex].text;
        let districtName = districtSelect.options[districtSelect.selectedIndex].text;

        document.querySelector('input[name="province"]').value = provinceName;
        document.querySelector('input[name="district"]').value = districtName;

        document.getElementById("checkout").submit();
    });

    fetch("https://provinces.open-api.vn/api/p/")
        .then(res => res.json())
        .then(data => {
            data.forEach(province => {
                let option = new Option(province.name, province.code);
                provinceSelect.add(option);
            });
        })
        .catch(err => console.error("Lỗi khi lấy danh sách tỉnh/thành:", err));
});
