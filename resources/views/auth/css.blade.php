<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: rgb(252, 252, 252);
        position: relative;
    }

    .wrapper {
        position: relative;
        width: 800px;
        height: 500px;
        display: flex;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 5px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .form-container {
        width: 50%;
        height: 100%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: white;
        transition: opacity 0.5s ease-in-out;
        z-index: 2;
    }

    .form-container1 {
        width: 50%;
        height: 100%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: rgb(255, 255, 255);
        transition: opacity 0.5s ease-in-out;
        z-index: 2;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        background: orange;
        transition: transform 0.5s ease-in-out;
        z-index: 3;
    }

    .show-signup .overlay {
        transform: translateX(-100%);
        background: rgb(76, 76, 217);
        /* Đổi sang màu xanh khi chuyển sang Sign Up */
    }

    .show-signup #signup-container {
        opacity: 1;
        pointer-events: auto;
    }

    .form-container h2 {
        color: #322dc7;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .form-container1 h2 {
        color: #f33535;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .form-container input {
        width: 90%;
        padding: 12px;
        margin: 10px 0;
        border: 2px solid #3473cc;
        border-radius: 8px;
        font-size: 16px;
    }

    .form-container1 input {
        width: 90%;
        padding: 12px;
        margin: 10px 0;
        border: 2px solid #de5318;
        border-radius: 8px;
        font-size: 16px;
    }

    .form-container1 button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(45deg, #e4dc43, #ff3300);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        transition: 0.3s;
    }

    .form-container button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(45deg, #284cc2, #4fbcb3);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        transition: 0.3s;
    }

    .form-container1 button:hover {
        background: linear-gradient(45deg, #fa3503, #cc0000);
    }

    .form-container button:hover {
        background: linear-gradient(45deg, #5e53db, #650efb);
    }

    .remember-container {
        display: flex;
        align-items: center;
        /* Căn giữa theo chiều dọc */
        justify-content: space-between;
        width: 90%;
    }

    .remember-container label {
        display: flex;
        align-items: center;
        gap: 5px;
        /* Tạo khoảng cách giữa checkbox và văn bản */
    }

    .remember-container a {
        text-decoration: none;
        color: rgb(105, 105, 248);
    }

    a {
        text-decoration: none;
        color: white;
    }

    .btn {
        border: #c2a628;
        background: #d26420;
        width: 100px;
        height: 40px;
    }

    .btn:hover {
        background: #be2113;
    }
</style>
