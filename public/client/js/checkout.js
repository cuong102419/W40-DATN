document.addEventListener("DOMContentLoaded", function () {
    let submitButton = document.getElementById("checkout-btn");
    let privacyCheckbox = document.getElementById("privacy");
    let paymentRadios = document.querySelectorAll("input[name='payment_method']");
    let hiddenPaymentInput = document.getElementById("payment_method");
    let totalInput = document.querySelector("input[name='total']");
    let totalDisplay = document.querySelector(".order-total h5.text-danger");

    function getTotalFromDisplay() {
        return parseInt(totalDisplay.innerText.replace(/\D/g, ''), 10);
    }

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

        if (!privacyCheckbox.checked) {
            toastr.error('Bạn cần đồng ý điều khoản và điều kiện mua hàng.');
            return;
        }

        let selectedPayment = document.querySelector("input[name='payment_method']:checked");
        if (!selectedPayment) {
            toastr.error('Vui lòng chọn hình thức thanh toán.');
            return;
        }

        hiddenPaymentInput.value = selectedPayment.value;

        totalInput.value = getTotalFromDisplay();

        // Lấy tên tỉnh và huyện
        let provinceName = provinceSelect.options[provinceSelect.selectedIndex].text;
        let districtName = districtSelect.options[districtSelect.selectedIndex].text;

        // Gửi tên tỉnh và huyện vào các trường tương ứng trong form
        document.querySelector('input[name="province"]').value = provinceName;
        document.querySelector('input[name="district"]').value = districtName;

        document.getElementById("checkout").submit();
    });

    const provinceSelect = document.getElementById("province");
    const districtSelect = document.getElementById("district");

    if (!provinceSelect || !districtSelect) {
        console.error("Không tìm thấy phần tử #province hoặc #district");
        return;
    }

    // Gọi API lấy danh sách tỉnh/thành
    fetch("https://provinces.open-api.vn/api/p/")
        .then(res => res.json())
        .then(data => {
            data.forEach(province => {
                let option = new Option(province.name, province.code); // Lấy code để fetch huyện
                provinceSelect.add(option);
            });
        })
        .catch(err => console.error("Lỗi khi lấy danh sách tỉnh/thành:", err));

    // Khi chọn tỉnh, gọi API để lấy quận/huyện
    provinceSelect.addEventListener("change", function () {
        let provinceCode = this.value;
        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>'; // Reset dropdown

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
});
