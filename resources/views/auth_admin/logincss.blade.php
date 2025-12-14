<style>
    /* --- VARIABEL WARNA (Disesuaikan dengan Dashboard SiPAWA) --- */
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

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: var(--bg-body);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        /* dari CSS pertama */
        align-items: center;
        justify-content: center;
        position: relative;
    }

    /* Background Dekoratif */
    body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 50%;
        background: linear-gradient(to bottom, #e0f2fe 0%, transparent 100%);
        z-index: -1;
    }

    /* --- LOGIN CONTAINER --- */
    .auth-page {
        width: 100%;
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .login-container {
        width: 100%;
        max-width: 1000px;
        min-height: 600px;
        background: var(--surface);
        border-radius: 20px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05),
            0 8px 10px -6px rgba(0, 0, 0, 0.01);
    }

    /* --- LOGO SiPAWA (Atas Tengah) --- */
    .bina-desa-logo {
        font-family: 'Nunito', sans-serif;
        font-weight: 1000;
        font-size: 42px;
        color: #3BC2EF;
        text-align: center;
        margin-bottom: 50px;
        letter-spacing: -1px;
    }

    /* --- SISI KIRI (FORM) --- */
    .left-section {
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: white;
    }

    .brand-logo-container {
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-logo {
        height: 50px;
        width: auto;
    }

    .brand-text {
        font-size: 24px;
        font-weight: 700;
        color: #38CFFE;
    }

    .brand-text span {
        color: #38CFFE;
    }

    .header {
        margin-bottom: 40px;
    }

    .header h1 {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    .header p {
        color: var(--text-muted);
        font-size: 15px;
        line-height: 1.5;
    }

    /* INPUT */
    .input-group {
        position: relative;
        margin-bottom: 25px;
    }

    .input-field {
        width: 100%;
        padding: 14px 16px;
        background: #fff;
        border: 1.5px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-main);
        font-size: 15px;
        outline: none;
        transition: all 0.2s ease;
    }

    .input-field:focus {
        border-color: var(--input-focus);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .input-field.is-invalid {
        border-color: var(--error);
        background-color: #fef2f2;
    }

    /* Floating Label */
    .input-group label {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 14px;
        pointer-events: none;
        transition: all 0.2s ease;
        background-color: transparent;
        padding: 0 4px;
    }

    .input-field:focus~label,
    .input-field:not(:placeholder-shown)~label {
        top: 0;
        font-size: 12px;
        color: var(--primary-solid);
        background-color: white;
        z-index: 2;
    }

    .text-danger {
        color: var(--error);
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* OPTIONS */
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
        cursor: pointer;
        color: var(--text-muted);
    }

    .remember-me input {
        accent-color: var(--primary-solid);
        width: 16px;
        height: 16px;
    }

    .forgot-pass {
        color: var(--primary-solid);
        font-weight: 600;
        text-decoration: none;
    }

    .forgot-pass:hover {
        text-decoration: underline;
    }

    /* BUTTON */
    .btn-submit {
        width: 100%;
        padding: 16px;
        background: var(--primary-gradient);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
    }

    /* --- SISI KANAN (GAMBAR) --- */
    .right-section {
        position: relative;
        background-color: #f8fafc;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        overflow: hidden;
    }

    .bg-image {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        filter: brightness(0.9);
        transition: transform 5s ease;
    }

    .login-container:hover .bg-image {
        transform: scale(1.05);
    }

    .overlay-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(30, 41, 59, 0.8) 0%,
                rgba(30, 41, 59, 0) 60%);
        z-index: 1;
    }

    .caption {
        position: relative;
        z-index: 2;
        color: white;
    }

    .caption h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .caption p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
    }

    /* RESPONSIVE */
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
    }
</style>
