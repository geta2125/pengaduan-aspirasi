<style>
    /* ================= VARIABEL WARNA ================= */
    :root {
        --primary-gradient: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%);
        --primary-solid: #3b82f6;

        --bg-body: #f1f5f9;
        --surface: #ffffff;

        --text-main: #1e293b;
        --text-muted: #64748b;

        --border-color: #e2e8f0;
        --input-focus: #3b82f6;
        --error: #ef4444;
    }

    /* ================= RESET ================= */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    /* ================= BODY ================= */
    body {
        background-color: var(--bg-body);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    /* Background atas */
    body::before {
        content: '';
        position: absolute;
        inset: 0 0 auto 0;
        height: 50%;
        background: linear-gradient(to bottom, #e0f2fe 0%, transparent 100%);
        z-index: -1;
    }

    /* ================= WRAPPER ================= */
    .auth-page {
        width: 100%;
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    /* ================= CARD LOGIN ================= */
    .login-container {
        width: 100%;
        max-width: 1000px;
        min-height: 600px;
        background: var(--surface);
        border-radius: 20px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, .05),
            0 8px 10px -6px rgba(0, 0, 0, .02);
    }

    /* ================= SISI KIRI ================= */
    .left-section {
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #fff;
    }

    /* ===== LOGO (TENGAH & GEDE) ===== */
    .brand-logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 35px;
    }

    .brand-logo {
        height: 100px;
        /* GEDE */
        width: auto;
        transition: transform .3s ease;
    }

    .brand-logo:hover {
        transform: scale(1.05);
    }

    /* ================= HEADER ================= */
    .header {
        text-align: center;
        margin-bottom: 40px;
    }

    .header h1 {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 10px;
    }

    .header p {
        font-size: 15px;
        color: var(--text-muted);
    }

    /* ================= INPUT ================= */
    .input-group {
        position: relative;
        margin-bottom: 25px;
    }

    .input-field {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid var(--border-color);
        border-radius: 10px;
        font-size: 15px;
        outline: none;
        transition: .2s;
    }

    .input-field:focus {
        border-color: var(--input-focus);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .1);
    }

    .input-field.is-invalid {
        border-color: var(--error);
        background: #fef2f2;
    }

    /* Floating label */
    .input-group label {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: var(--text-muted);
        pointer-events: none;
        transition: .2s;
        background: #fff;
        padding: 0 4px;
    }

    .input-field:focus~label,
    .input-field:not(:placeholder-shown)~label {
        top: 0;
        font-size: 12px;
        color: var(--primary-solid);
    }

    /* Error text */
    .text-danger {
        color: var(--error);
        font-size: 12px;
        margin-top: 5px;
    }

    /* ================= OPTIONS ================= */
    .options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        font-size: 14px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
    }

    .remember-me input {
        accent-color: var(--primary-solid);
    }

    .forgot-pass {
        color: var(--primary-solid);
        font-weight: 600;
        text-decoration: none;
    }

    /* ================= BUTTON ================= */
    .btn-submit {
        width: 100%;
        s padding: 16px;
        background: var(--primary-gradient);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, .35);
    }

    /* ================= SISI KANAN ================= */
    .right-section {
        position: relative;
        display: flex;
        align-items: flex-end;
        padding: 40px;
        overflow: hidden;
    }

    .bg-image {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        transition: transform 5s ease;
    }

    .login-container:hover .bg-image {
        transform: scale(1.05);
    }

    .overlay-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(30, 41, 59, .85),
                rgba(30, 41, 59, 0));
    }

    .caption {
        position: relative;
        color: #fff;
    }

    .caption h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .caption p {
        font-size: 16px;
        opacity: .9;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 900px) {
        .login-container {
            grid-template-columns: 1fr;
            max-width: 450px;
        }

        .right-section {
            display: none;
        }

        .left-section {
            padding: 40px 30px;
        }

        .brand-logo {
            height: 80px;
            /* logo mengecil di HP */
        }
    }
</style>
