document.addEventListener("DOMContentLoaded", function () {
    let submitButton = document.querySelector(".btn-theme");
    let privacyCheckbox = document.getElementById("privacy");
    let paymentRadios = document.querySelectorAll("input[name='payment_method']");
    let hiddenPaymentInput = document.getElementById("payment_method");

    // Cập nhật input ẩn khi chọn phương thức thanh toán
    paymentRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            hiddenPaymentInput.value = this.value;
        });
    });

    // Đảm bảo input ẩn được set giá trị mặc định khi trang tải xong
    let checkedRadio = document.querySelector("input[name='payment_method']:checked");
    if (checkedRadio) {
        hiddenPaymentInput.value = checkedRadio.value;
    }

    // Xử lý khi nhấn nút thanh toán
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

        // Đảm bảo input hidden có giá trị trước khi submit
        hiddenPaymentInput.value = selectedPayment.value;

        document.getElementById("checkout").submit();
    });
});
