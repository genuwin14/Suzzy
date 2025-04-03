/**
 * Function to add a table and ensure the header and footer appear on every page
 */
function addTableWithHeaderAndFooter(pdf, logoImage) {
    const table = document.getElementById("logsTable");
    const tableData = [];
    const headers = [];

    // Extract table headers
    table.querySelectorAll("thead tr th").forEach(th => {
        headers.push(th.innerText);
    });

    // Extract table body data
    table.querySelectorAll("tbody tr").forEach(tr => {
        const row = [];
        tr.querySelectorAll("td").forEach(td => {
            row.push(td.innerText);
        });
        tableData.push(row);
    });

    const rowsPerPage = 20; // Limit to 20 rows per page
    let isFirstPage = true;
    let currentPage = 1;
    let totalPages = Math.ceil(tableData.length / rowsPerPage);

    for (let i = 0; i < tableData.length; i += rowsPerPage) {
        let pageData = tableData.slice(i, i + rowsPerPage); // Get 20 rows per page
        
        if (!isFirstPage) pdf.addPage(); // Add new page after the first

        addHeader(pdf, logoImage);
        
        pdf.autoTable({
            head: [headers],
            body: pageData,
            theme: 'grid',
            startY: isFirstPage ? 40 : 40, // First page starts at 40, others at 20
            margin: { left: 12 },
            styles: { 
                fontSize: 10, 
                valign: 'middle', 
                halign: 'center',
                lineColor: [0, 0, 0], // Black border color
                textColor: [0, 0, 0],
                lineWidth: 0.05 // Thickness of table borders
            },
            columnStyles: { 
                0: { cellWidth: 30 },  
                1: { cellWidth: 80 }, 
                2: { cellWidth: 33 }, 
                3: { cellWidth: 60 }, 
                4: { cellWidth: 40 }, 
                5: { cellWidth: 40 } 
            },
            headStyles: { 
                fontSize: 11, 
                fontStyle: 'bold', 
                fillColor: false, // Transparent background
                textColor: [0, 0, 0], // Black text for contrast
                lineColor: [0, 0, 0], // Black header border
                lineWidth: 0.05
            }
        });

        addFooter(pdf, currentPage, totalPages);
        isFirstPage = false;
        currentPage++;
    }
}
