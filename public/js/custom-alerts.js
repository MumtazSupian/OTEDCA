/**
 * Custom Alerts & Confirmation Dialogs
 * Beautiful replacement for browser's native confirm() and alert().
 * Auto-intercepts all DELETE form submissions.
 */
(function () {
    'use strict';

    // =============================================
    // 1. INJECT MODAL HTML + STYLES
    // =============================================
    var styles = document.createElement('style');
    styles.textContent = `
        /* ===== OVERLAY ===== */
        .custom-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 100000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .custom-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ===== CONFIRM MODAL ===== */
        .confirm-modal {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            width: 400px;
            max-width: 90vw;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.8) translateY(20px);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
        }
        .custom-overlay.active .confirm-modal {
            transform: scale(1) translateY(0);
        }

        .confirm-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: iconPulse 2s ease-in-out infinite;
        }
        @keyframes iconPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.2); }
            50% { box-shadow: 0 0 0 12px rgba(220, 38, 38, 0); }
        }
        .confirm-icon svg {
            width: 36px;
            height: 36px;
            color: #dc2626;
        }

        .confirm-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            font-family: 'Inter', sans-serif;
        }
        .confirm-message {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 28px;
            font-family: 'Inter', sans-serif;
        }

        .confirm-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .confirm-btn {
            padding: 10px 28px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            font-family: 'Inter', sans-serif;
            outline: none;
        }
        .confirm-btn-cancel {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .confirm-btn-cancel:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .confirm-btn-delete {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        }
        .confirm-btn-delete:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.45);
            transform: translateY(-1px);
        }
        .confirm-btn-delete:active {
            transform: translateY(0);
        }

        /* ===== SUCCESS TOAST ===== */
        .success-toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 100001;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .success-toast {
            background: #fff;
            border-radius: 12px;
            padding: 16px 24px 16px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.08);
            transform: translateX(120%);
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            min-width: 320px;
            max-width: 450px;
            border-left: 4px solid #16a34a;
            position: relative;
            overflow: hidden;
        }
        .success-toast.show {
            transform: translateX(0);
        }
        .success-toast.hide {
            transform: translateX(120%);
            transition: transform 0.3s ease-in;
        }
        .success-toast-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .success-toast-icon svg {
            width: 22px;
            height: 22px;
            color: #16a34a;
        }
        .success-toast-content {
            flex: 1;
        }
        .success-toast-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
            font-family: 'Inter', sans-serif;
        }
        .success-toast-msg {
            font-size: 13px;
            color: #64748b;
            font-family: 'Inter', sans-serif;
        }
        .success-toast-close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s;
            line-height: 1;
        }
        .success-toast-close:hover {
            color: #475569;
            background: #f1f5f9;
        }
        .success-toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #16a34a, #22c55e);
            border-radius: 0 0 0 12px;
            animation: progressShrink 4s linear forwards;
        }
        @keyframes progressShrink {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* ===== ERROR TOAST ===== */
        .error-toast {
            border-left-color: #dc2626;
        }
        .error-toast .success-toast-icon {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
        }
        .error-toast .success-toast-icon svg {
            color: #dc2626;
        }
        .error-toast .success-toast-progress {
            background: linear-gradient(90deg, #dc2626, #ef4444);
        }

        /* ===== UPGRADE SESSION SUCCESS ALERTS ===== */
        .session-success-premium {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7) !important;
            border: 1px solid #86efac !important;
            border-left: 4px solid #16a34a !important;
            border-radius: 12px !important;
            padding: 16px 20px !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            color: #166534 !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 14px !important;
            animation: slideInDown 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
            box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1) !important;
        }
        .session-success-premium::before {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #16a34a;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            flex-shrink: 0;
        }
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-16px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(styles);

    // Create toast container
    var toastContainer = document.createElement('div');
    toastContainer.className = 'success-toast-container';
    toastContainer.id = 'toastContainer';
    document.body.appendChild(toastContainer);

    // Create overlay + modal
    var overlay = document.createElement('div');
    overlay.className = 'custom-overlay';
    overlay.id = 'confirmOverlay';
    overlay.innerHTML = `
        <div class="confirm-modal">
            <div class="confirm-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </div>
            <div class="confirm-title">Hapus Data?</div>
            <div class="confirm-message">Apakah Anda yakin ingin menghapus data ini?<br>Tindakan ini tidak dapat dibatalkan.</div>
            <div class="confirm-buttons">
                <button class="confirm-btn confirm-btn-cancel" id="confirmCancel">Batal</button>
                <button class="confirm-btn confirm-btn-delete" id="confirmDelete">
                    <span style="display:inline-flex;align-items:center;gap:6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        Ya, Hapus
                    </span>
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(overlay);

    // =============================================
    // 2. MODAL LOGIC
    // =============================================
    var pendingForm = null;

    function showConfirmModal(form) {
        pendingForm = form;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        // Focus the cancel button
        setTimeout(function() {
            document.getElementById('confirmCancel').focus();
        }, 100);
    }

    function hideConfirmModal() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        pendingForm = null;
    }

    // Cancel button
    document.getElementById('confirmCancel').addEventListener('click', function () {
        hideConfirmModal();
    });

    // Delete button
    document.getElementById('confirmDelete').addEventListener('click', function () {
        if (pendingForm) {
            // Remove all onsubmit handlers so they don't trigger confirm() again
            pendingForm.onsubmit = null;
            pendingForm.removeAttribute('onsubmit');
            // Remove onclick from submit button
            var btn = pendingForm.querySelector('button[type="submit"]');
            if (btn) {
                btn.onclick = null;
                btn.removeAttribute('onclick');
            }
            pendingForm.submit();
        }
        hideConfirmModal();
    });

    // Close on overlay click (outside modal)
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) {
            hideConfirmModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('active')) {
            hideConfirmModal();
        }
    });

    // =============================================
    // 3. AUTO-INTERCEPT DELETE FORMS
    // =============================================
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!(form instanceof HTMLFormElement)) return;

        // Check if this form has a DELETE method field
        var methodInput = form.querySelector('input[name="_method"][value="DELETE"]');
        if (!methodInput) return;

        // Prevent default submission
        e.preventDefault();
        e.stopImmediatePropagation();

        // Show custom modal
        showConfirmModal(form);
    }, true); // use capture phase to intercept before onsubmit

    // Also intercept click on delete buttons (for onclick="return confirm()")
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('button[type="submit"]');
        if (!btn) return;
        var form = btn.closest('form');
        if (!form) return;
        var methodInput = form.querySelector('input[name="_method"][value="DELETE"]');
        if (!methodInput) return;

        // Only intercept if there's a confirm in onclick
        var onclickAttr = btn.getAttribute('onclick');
        if (onclickAttr && onclickAttr.indexOf('confirm') !== -1) {
            e.preventDefault();
            e.stopImmediatePropagation();
            showConfirmModal(form);
        }
    }, true);

    // =============================================
    // 4. SHOW SUCCESS TOAST FUNCTION
    // =============================================
    window.showSuccessToast = function (message, title) {
        title = title || 'Berhasil!';
        var toast = document.createElement('div');
        toast.className = 'success-toast';
        toast.innerHTML = `
            <div class="success-toast-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="success-toast-content">
                <div class="success-toast-title">${title}</div>
                <div class="success-toast-msg">${message}</div>
            </div>
            <button class="success-toast-close" onclick="this.closest('.success-toast').classList.add('hide'); setTimeout(() => this.closest('.success-toast').remove(), 300);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="success-toast-progress"></div>
        `;
        toastContainer.appendChild(toast);

        // Animate in
        setTimeout(function() { toast.classList.add('show'); }, 50);

        // Auto remove after 4 seconds
        setTimeout(function () {
            toast.classList.add('hide');
            setTimeout(function () { toast.remove(); }, 300);
        }, 4000);
    };

    // =============================================
    // 5. AUTO-UPGRADE SESSION SUCCESS MESSAGES
    // =============================================
    document.addEventListener('DOMContentLoaded', function () {
        // Find all success session alerts (only div elements outside tables)
        var alerts = document.querySelectorAll('div[style*="dff0d8"], div[style*="d4edda"], div[style*="dcfce7"], .alert-success');
        alerts.forEach(function (alert) {
            if (alert.closest('table') || ['TH', 'TD', 'TR', 'TBODY', 'THEAD', 'TABLE'].includes(alert.tagName)) {
                return;
            }
            var message = alert.textContent.trim();
            if (!message) return;

            // Add the premium class
            alert.className = 'session-success-premium';
            // Reset inline styles that conflict
            alert.style.backgroundColor = '';
            alert.style.color = '';
            alert.style.border = '';

            // Also show as a toast
            setTimeout(function() {
                showSuccessToast(message, 'Berhasil!');
            }, 300);

            // Auto-hide the inline alert after 5 seconds
            setTimeout(function () {
                alert.style.transition = 'all 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                alert.style.maxHeight = '0';
                alert.style.padding = '0';
                alert.style.margin = '0';
                alert.style.overflow = 'hidden';
                setTimeout(function() { alert.remove(); }, 500);
            }, 5000);
        });
    });

})();
