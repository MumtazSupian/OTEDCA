/**
 * Table Export Utilities
 * Provides Copy, Excel, PDF, and Print functionality for HTML tables.
 * 
 * Usage: Add onclick="tableExport.copy(this)" etc. to buttons.
 * Each function finds the closest table by searching for a <table> element
 * relative to the button, or by an explicit table ID.
 */
var tableExport = (function () {

    /**
     * Helper: Get table data (headers + rows) excluding the "Actions" column.
     */
    function getTableData(tableEl) {
        var headers = [];
        var rows = [];
        var excludeCols = [];

        // Determine which columns are "Actions" so we can skip them
        var ths = tableEl.querySelectorAll('thead th');
        ths.forEach(function (th, i) {
            var text = th.textContent.trim().toLowerCase();
            if (text === 'actions' || text === 'aksi') {
                excludeCols.push(i);
            } else {
                headers.push(th.textContent.trim().replace(/\s+/g, ' '));
            }
        });

        var bodyRows = tableEl.querySelectorAll('tbody tr');
        bodyRows.forEach(function (tr) {
            if (tr.style.display === 'none') return; // skip filtered rows
            var cells = tr.querySelectorAll('td');
            if (cells.length === 0) return;
            var row = [];
            cells.forEach(function (td, i) {
                if (excludeCols.indexOf(i) === -1) {
                    row.push(td.textContent.trim().replace(/\s+/g, ' '));
                }
            });
            if (row.length > 0) rows.push(row);
        });

        return { headers: headers, rows: rows };
    }

    /**
     * Get the page title for the export document.
     */
    function getPageTitle() {
        // Try to find the main heading on the page
        var h2 = document.querySelector('h2');
        if (h2) return h2.textContent.trim().replace(/\s+/g, ' ');
        var h3 = document.querySelector('h3');
        if (h3) return h3.textContent.trim().replace(/\s+/g, ' ');
        return document.title || 'Data Export';
    }

    /**
     * Find the table element from a button click context or explicit ID.
     */
    function findTable(tableIdOrButton) {
        if (typeof tableIdOrButton === 'string') {
            return document.getElementById(tableIdOrButton);
        }
        // Walk up the DOM to find the closest container that has a table
        var el = tableIdOrButton;
        while (el && el !== document.body) {
            el = el.parentElement;
            var tbl = el ? el.querySelector('table') : null;
            if (tbl) return tbl;
        }
        // Fallback: first table on the page
        return document.querySelector('table');
    }

    /**
     * Show a brief toast notification
     */
    function showToast(message, type) {
        var bgColor = type === 'success' ? '#16a34a' : '#333';
        var icon = type === 'success' ? '✓' : 'ℹ';
        var toast = document.createElement('div');
        toast.innerHTML = '<span style="margin-right:8px;font-size:16px;">' + icon + '</span>' + message;
        toast.style.cssText = 'position:fixed;top:20px;right:20px;background:' + bgColor + ';color:#fff;padding:12px 24px;border-radius:8px;z-index:99999;font-size:13px;font-family:Inter,Arial,sans-serif;box-shadow:0 4px 12px rgba(0,0,0,0.25);transition:all 0.4s ease;display:flex;align-items:center;opacity:0;transform:translateY(-10px);';
        document.body.appendChild(toast);
        // Animate in
        setTimeout(function() {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);
        // Animate out
        setTimeout(function () {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(function () { toast.remove(); }, 400);
        }, 2500);
    }

    /**
     * Build professional HTML document for PDF/Print
     */
    function buildProfessionalHTML(data, title, forPrint) {
        var now = new Date();
        var dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        var timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

        var html = '<!DOCTYPE html>';
        html += '<html lang="id"><head><meta charset="utf-8">';
        html += '<title>' + title + '</title>';
        html += '<style>';

        // --- Reset & Base ---
        html += '*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }';
        html += 'body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; background: #fff; padding: 0; margin: 0; }';

        // --- Page Container ---
        html += '.page-container { max-width: 900px; margin: 0 auto; padding: 40px 30px; }';

        // --- Header ---
        html += '.report-header { border-bottom: 3px solid #dc2626; padding-bottom: 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-start; }';
        html += '.header-left h1 { font-size: 22px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }';
        html += '.header-left .subtitle { font-size: 13px; color: #64748b; }';
        html += '.header-right { text-align: right; font-size: 12px; color: #64748b; line-height: 1.8; }';
        html += '.header-right .company { font-size: 15px; font-weight: 700; color: #dc2626; margin-bottom: 2px; }';

        // --- Info Bar ---
        html += '.info-bar { display: flex; justify-content: space-between; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 18px; margin-bottom: 20px; font-size: 12px; color: #475569; }';
        html += '.info-bar .badge { background: #dc2626; color: #fff; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }';

        // --- Table ---
        html += 'table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }';
        html += 'thead tr { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); }';
        html += 'thead th { color: #fff; font-weight: 600; padding: 10px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border: none; }';
        html += 'thead th:first-child { border-radius: 6px 0 0 0; }';
        html += 'thead th:last-child { border-radius: 0 6px 0 0; }';
        html += 'tbody tr { border-bottom: 1px solid #e2e8f0; }';
        html += 'tbody tr:nth-child(even) { background-color: #f8fafc; }';
        html += 'tbody tr:nth-child(odd) { background-color: #ffffff; }';
        html += 'tbody td { padding: 9px 12px; color: #334155; font-size: 12px; }';
        html += 'tbody td:first-child { font-weight: 600; color: #64748b; text-align: center; width: 40px; }';
        html += 'tbody tr:last-child td:first-child { border-radius: 0 0 0 6px; }';
        html += 'tbody tr:last-child td:last-child { border-radius: 0 0 6px 0; }';

        // --- Footer ---
        html += '.report-footer { border-top: 2px solid #e2e8f0; padding-top: 16px; margin-top: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #94a3b8; }';
        html += '.footer-left { display: flex; align-items: center; gap: 8px; }';
        html += '.footer-dot { width: 6px; height: 6px; border-radius: 50%; background: #dc2626; }';

        // --- Print Styles ---
        html += '@media print {';
        html += '  body { padding: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }';
        html += '  .page-container { padding: 20px; max-width: 100%; }';
        html += '  thead tr { background: #1e293b !important; -webkit-print-color-adjust: exact; }';
        html += '  thead th { color: #fff !important; }';
        html += '  tbody tr:nth-child(even) { background-color: #f1f5f9 !important; }';
        html += '  .no-print { display: none !important; }';
        html += '}';

        // --- Page size ---
        html += '@page { size: A4 landscape; margin: 15mm; }';

        html += '</style></head><body>';
        html += '<div class="page-container">';

        // --- Header Section ---
        html += '<div class="report-header">';
        html += '  <div class="header-left">';
        html += '    <h1>' + title + '</h1>';
        html += '    <div class="subtitle">Laporan Data &mdash; Dicetak secara otomatis dari sistem</div>';
        html += '  </div>';
        html += '  <div class="header-right">';
        html += '    <div class="company">OTE DCA</div>';
        html += '    <div>' + dateStr + '</div>';
        html += '    <div>Pukul ' + timeStr + ' WIB</div>';
        html += '  </div>';
        html += '</div>';

        // --- Info Bar ---
        html += '<div class="info-bar">';
        html += '  <div>Total Data: <strong>' + data.rows.length + '</strong> baris &bull; Kolom: <strong>' + data.headers.length + '</strong></div>';
        html += '  <div class="badge">' + (forPrint ? 'PRINT' : 'PDF EXPORT') + '</div>';
        html += '</div>';

        // --- Table ---
        html += '<table>';
        html += '<thead><tr>';
        data.headers.forEach(function (h) {
            html += '<th>' + h + '</th>';
        });
        html += '</tr></thead>';
        html += '<tbody>';
        if (data.rows.length === 0) {
            html += '<tr><td colspan="' + data.headers.length + '" style="text-align:center;padding:20px;color:#94a3b8;font-style:italic;">Tidak ada data</td></tr>';
        } else {
            data.rows.forEach(function (row) {
                html += '<tr>';
                row.forEach(function (cell) {
                    html += '<td>' + cell + '</td>';
                });
                html += '</tr>';
            });
        }
        html += '</tbody></table>';

        // --- Footer ---
        html += '<div class="report-footer">';
        html += '  <div class="footer-left"><span class="footer-dot"></span> Dokumen ini digenerate otomatis oleh sistem OTE DCA</div>';
        html += '  <div>Halaman 1 dari 1</div>';
        html += '</div>';

        html += '</div>'; // page-container
        html += '</body></html>';

        return html;
    }

    /**
     * COPY — copies table data to clipboard as tab-separated text.
     */
    function copyTable(tableIdOrButton) {
        var tableEl = findTable(tableIdOrButton);
        if (!tableEl) return;
        var data = getTableData(tableEl);
        var text = data.headers.join('\t') + '\n';
        data.rows.forEach(function (row) {
            text += row.join('\t') + '\n';
        });

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function () {
                showToast(data.rows.length + ' baris data berhasil di-copy!', 'success');
            });
        } else {
            // Fallback
            var textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.cssText = 'position:fixed;left:-9999px;';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            textarea.remove();
            showToast(data.rows.length + ' baris data berhasil di-copy!', 'success');
        }
    }

    /**
     * EXCEL — exports table data as a styled .xls file (HTML-based, opens in Excel).
     */
    function exportExcel(tableIdOrButton) {
        var tableEl = findTable(tableIdOrButton);
        if (!tableEl) return;
        var data = getTableData(tableEl);
        var title = getPageTitle();
        var now = new Date();
        var dateStr = now.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });

        // Build HTML that Excel can render with styling
        var html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        html += '<head><meta charset="utf-8">';
        html += '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
        html += '<x:Name>Data</x:Name>';
        html += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>';
        html += '</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
        html += '<style>';
        html += 'table { border-collapse: collapse; width: 100%; }';
        html += '.title-row td { font-size: 16pt; font-weight: bold; color: #1e293b; padding: 8px 6px 2px; border: none; }';
        html += '.subtitle-row td { font-size: 9pt; color: #64748b; padding: 2px 6px 12px; border: none; }';
        html += '.header-row td { background-color: #1e293b; color: #ffffff; font-weight: bold; font-size: 10pt; padding: 8px 10px; border: 1px solid #334155; text-align: left; }';
        html += '.data-row td { padding: 6px 10px; border: 1px solid #e2e8f0; font-size: 10pt; color: #334155; }';
        html += '.data-row-even td { background-color: #f8fafc; }';
        html += '.data-row-odd td { background-color: #ffffff; }';
        html += '.num-col { text-align: center; color: #64748b; font-weight: 600; width: 40px; }';
        html += '.footer-row td { font-size: 8pt; color: #94a3b8; padding: 10px 6px 4px; border: none; font-style: italic; }';
        html += '</style></head><body>';

        html += '<table>';

        // Title row
        html += '<tr class="title-row"><td colspan="' + data.headers.length + '">' + title + '</td></tr>';
        html += '<tr class="subtitle-row"><td colspan="' + data.headers.length + '">Diekspor pada: ' + dateStr + ' &bull; Total: ' + data.rows.length + ' data</td></tr>';

        // Empty separator row
        html += '<tr><td colspan="' + data.headers.length + '" style="height:6px;border:none;"></td></tr>';

        // Header row
        html += '<tr class="header-row">';
        data.headers.forEach(function (h) {
            html += '<td>' + h + '</td>';
        });
        html += '</tr>';

        // Data rows
        if (data.rows.length === 0) {
            html += '<tr class="data-row"><td colspan="' + data.headers.length + '" style="text-align:center;color:#94a3b8;">Tidak ada data</td></tr>';
        } else {
            data.rows.forEach(function (row, idx) {
                var rowClass = idx % 2 === 0 ? 'data-row data-row-odd' : 'data-row data-row-even';
                html += '<tr class="' + rowClass + '">';
                row.forEach(function (cell, ci) {
                    var cls = ci === 0 ? ' class="num-col"' : '';
                    html += '<td' + cls + '>' + cell + '</td>';
                });
                html += '</tr>';
            });
        }

        // Footer row
        html += '<tr><td colspan="' + data.headers.length + '" style="height:6px;border:none;"></td></tr>';
        html += '<tr class="footer-row"><td colspan="' + data.headers.length + '">Dokumen ini digenerate otomatis oleh sistem OTE DCA</td></tr>';

        html += '</table></body></html>';

        // Create downloadable file
        var blob = new Blob(['\uFEFF' + html], { type: 'application/vnd.ms-excel;charset=utf-8;' });
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = title.replace(/[^a-zA-Z0-9]/g, '_') + '_' + now.toISOString().slice(0, 10) + '.xls';
        link.click();
        URL.revokeObjectURL(link.href);
        showToast('File Excel berhasil di-download!', 'success');
    }

    /**
     * PDF — generates a professional PDF using a print-friendly window.
     */
    function exportPDF(tableIdOrButton) {
        var tableEl = findTable(tableIdOrButton);
        if (!tableEl) return;
        var data = getTableData(tableEl);
        var title = getPageTitle();
        var html = buildProfessionalHTML(data, title, false);

        var win = window.open('', '_blank');
        if (!win) {
            showToast('Pop-up diblokir browser. Izinkan pop-up untuk export PDF.', 'error');
            return;
        }
        win.document.write(html);
        win.document.close();
        setTimeout(function () {
            win.print();
        }, 600);
        showToast('Dokumen PDF siap dicetak/disimpan', 'success');
    }

    /**
     * PRINT — prints the table directly with professional layout.
     */
    function printTable(tableIdOrButton) {
        var tableEl = findTable(tableIdOrButton);
        if (!tableEl) return;
        var data = getTableData(tableEl);
        var title = getPageTitle();
        var html = buildProfessionalHTML(data, title, true);

        var win = window.open('', '_blank');
        if (!win) {
            showToast('Pop-up diblokir browser. Izinkan pop-up untuk print.', 'error');
            return;
        }
        win.document.write(html);
        win.document.close();
        setTimeout(function () {
            win.print();
            setTimeout(function () { win.close(); }, 1500);
        }, 600);
    }

    // Public API
    return {
        copy: copyTable,
        excel: exportExcel,
        pdf: exportPDF,
        print: printTable
    };
})();
