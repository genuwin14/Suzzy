/**
 * Function to add a header to the PDF
 */
function addHeader(pdf, logoImage) {
    const logoWidth = 17;
    pdf.addImage(logoImage, 'PNG', 10, 5, logoWidth, 17);
    
    pdf.setFontSize(10);
    pdf.text("Republic of the Philippines", 30, 14);
    pdf.setFont("Helvetica", "bold");
    pdf.text("CAMARINES SUR POLYTECHNIC COLLEGES", 30, 18);
    pdf.setFont("Helvetica", "normal");
    pdf.text("Nabua, Camarines Sur", 30, 22);

    pdf.setFontSize(7);
    pdf.setFont("Helvetica", "bold");
    pdf.setTextColor(79, 129, 189);
    pdf.text("ISO 9001:2015", 10 + (logoWidth / 2), 24, { align: "center" });

    const pageWidth = pdf.internal.pageSize.width;

    pdf.setFontSize(8);
    pdf.setFont("Helvetica", "bold");
    pdf.setTextColor(0, 0, 0);
    pdf.text("CSPC-LB-CCS-07", pageWidth - 10, 27, { align: "right" });

    pdf.setDrawColor(79, 129, 189);
    pdf.setLineWidth(0.8);
    pdf.line(5, 26, 321, 26);
    
    pdf.setFontSize(18);
    pdf.setFont("Helvetica", "bold");
    pdf.setTextColor(0, 0, 0);
    pdf.text("LABORATORY KEY LOGBOOK", 125, 36);
}