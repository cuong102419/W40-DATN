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

        document.getElementById("checkout").submit();
    });
});
