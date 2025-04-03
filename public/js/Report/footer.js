/**
 * Function to add a footer to the PDF
 */
function addFooter(pdf) {
    const footerYPosition = pdf.internal.pageSize.height - 13;
    pdf.setDrawColor(79, 129, 189);
    pdf.setLineWidth(0.8);
    pdf.line(5, footerYPosition, 351, footerYPosition);

    const pageWidth = pdf.internal.pageSize.width;
    const currentDate = new Date();
    const options = { year: 'numeric', month: 'long' };
    const formattedDate = currentDate.toLocaleDateString(undefined, options);

    pdf.setFontSize(10);
    pdf.setFont("Helvetica", "normal");

    const totalPages = pdf.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
        pdf.setPage(i);

        // Clear any previous footer content for this page
        pdf.setFillColor(255, 255, 255); // White background to overwrite
        pdf.rect(0, footerYPosition, pageWidth, 20, 'F'); // Clear footer area

        // Adjust the position of the page number to avoid overlapping
        const pageNumberText = `Page ${i} of ${totalPages}`;
        const pageNumberWidth = pdf.getTextWidth(pageNumberText);

        pdf.text(`Effective Date: ${formattedDate}`, 5, footerYPosition + 4, { align: "left" });
        pdf.text(pageNumberText, pageWidth - pageNumberWidth - 5, footerYPosition + 4, { align: "left" });
    }
}