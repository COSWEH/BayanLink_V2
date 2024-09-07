<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #pdf-canvas {
            border: 1px solid #ccc;
            height: 600px;
            width: 100%;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="container mt-4">
        <canvas id="pdf-canvas"></canvas>
    </div>

    <!-- PDF.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js"></script>
    <script>
        // URL of the PDF file
        const url = 'includes/doc_template/brgy_clearance.pdf';

        // Asynchronous download of PDF
        pdfjsLib.getDocument(url).promise.then(pdf => {
            // Fetch the first page
            pdf.getPage(1).then(page => {
                const scale = 1.5; // Scale to adjust the size
                const viewport = page.getViewport({
                    scale
                });

                // Prepare canvas using PDF page dimensions
                const canvas = document.getElementById('pdf-canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext).promise.then(() => {
                    console.log('Page rendered');
                });
            });
        }).catch(error => {
            console.error('Error loading PDF:', error);
        });
    </script>
</body>

</html>