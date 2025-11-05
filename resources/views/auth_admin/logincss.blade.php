<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #3735bd;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #17004d;
            --success: #b91010;
            --error: #ef4444;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: linear-gradient(135deg, #667eea 0%, #3c3c8a 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        .auth-page::before,
        .auth-page::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite ease-in-out;
        }

        .auth-page::before {
            width: 500px;
            height: 500px;
            top: -250px;
            right: -100px;
            animation-delay: 0s;
        }

        .auth-page::after {
            width: 400px;
            height: 400px;
            bottom: -200px;
            left: -100px;
            animation-delay: 5s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(30px, 30px) scale(1.1);
            }
        }

        /* Glass Card */
        .auth-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1100px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: slideUp 0.8s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 650px;
        }

        /* Left Side - Form */
        .auth-form {
            padding: 60px 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand {
            text-align: center;
            margin-bottom: 48px;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }

        .brand-logo img {
            max-width: 70px;
            max-height: 70px;
        }

        .brand-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 16px;
            color: var(--text-muted);
            font-weight: 400;
        }

        .form-header {
            margin-bottom: 32px;
        }

        .form-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* Form Controls */
        .form-field {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            color: var(--text-dark);
            background: var(--bg-light);
            border: 2px solid transparent;
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--error);
            background: #fef2f2;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
            font-size: 18px;
        }

        .form-control.with-icon {
            padding-left: 46px;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.3s;
            font-size: 18px;
            padding: 4px;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--error);
            margin-top: 8px;
            font-weight: 500;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-label {
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 500;
            cursor: pointer;
            user-select: none;
        }

        .btn-primary {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Right Side - Visual */
        .auth-visual {
            background: linear-gradient(135deg, #667eea 0%, #2a1a86 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .auth-visual::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: pulse 4s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
        }

        .visual-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .visual-image {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
            animation: floatImage 6s ease-in-out infinite;
        }

        @keyframes floatImage {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .visual-text {
            margin-top: 40px;
            color: white;
        }

        .visual-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 12px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .visual-desc {
            font-size: 16px;
            opacity: 0.95;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .auth-grid {
                grid-template-columns: 1fr;
            }

            .auth-visual {
                display: none;
            }

            .auth-form {
                padding: 50px 40px;
            }
        }

        @media (max-width: 576px) {
            .auth-form {
                padding: 40px 30px;
            }

            .brand-title {
                font-size: 26px;
            }

            .form-title {
                font-size: 18px;
            }
        }

        /* Loading State */
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }
    </style>
