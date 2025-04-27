<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
// تضمين مكتبات jsPDF و html2canvas
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
  const { jsPDF } = window.jspdf;
    function exportToPDF() {
        html2canvas(document.getElementById('export-area'), { scale: 2, scrollY: -window.scrollY })
              .then(canvas => {
                      const imgData = canvas.toDataURL('image/png');
                              const pdf = new jsPDF('p', 'pt', 'a4');
                                      const pdfW = pdf.internal.pageSize.getWidth();
                                              const pdfH = pdf.internal.pageSize.getHeight();
                                                      const imgH = (canvas.height * pdfW) / canvas.width;
                                                              let heightLeft = imgH;
                                                                      let position = 0;
                                                                              pdf.addImage(imgData, 'PNG', 0, position, pdfW, imgH);
                                                                                      heightLeft -= pdfH;
                                                                                              while (heightLeft > 0) {
                                                                                                        position = heightLeft - imgH;
                                                                                                                  pdf.addPage();
                                                                                                                            pdf.addImage(imgData, 'PNG', 0, position, pdfW, imgH);
                                                                                                                                      heightLeft -= pdfH;
                                                                                                                                              }
                                                                                                                                                      pdf.save('نتائج_الانتخابات.pdf');
                                                                                                                                                            });
                                                                                                                                                              }
                                                                                                                                                              </script>