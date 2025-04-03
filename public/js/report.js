document.getElementById('printButton').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({ orientation: 'landscape', format: 'legal' });

    let base64Logo = ""; 
    const logoImage = new Image();
    logoImage.src = base64Logo ? `data:image/png;base64,${base64Logo}` : '/images/cspc.png';

    logoImage.onload = function () {
        addTableWithHeaderAndFooter(pdf, logoImage);
        const pdfBlob = pdf.output('blob');
        const pdfUrl = URL.createObjectURL(pdfBlob);
        window.open(pdfUrl, '_blank');
    };
});
