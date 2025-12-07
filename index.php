<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Import CSV ke MySQL</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        #preview-area { max-height: 400px; overflow-y: auto; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <h2>Import CSV ke MySQL dengan Pratinjau</h2>

    <form id="uploadForm" enctype="multipart/form-data">
        <label for="csvFile">Pilih File CSV:</label>
        <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
        <button type="button" onclick="previewFile()">Pratinjau</button>
    </form>

    <div id="status"></div>
    
    <div id="preview-area" class="hidden">
        <h3>Pratinjau Data:</h3>
        <table id="dataTable">
            <!-- Data pratinjau akan dimasukkan di sini oleh JavaScript -->
        </table>
        <button id="submitButton" onclick="submitData()" class="hidden">Submit ke Database</button>
    </div>

    <script>
        let parsedData = [];

        function previewFile() {
            const fileInput = document.getElementById('csvFile');
            const file = fileInput.files[0];
            const statusDiv = document.getElementById('status');
            const previewArea = document.getElementById('preview-area');
            const submitButton = document.getElementById('submitButton');

            if (!file) {
                statusDiv.innerHTML = '<span style="color: red;">Pilih file terlebih dahulu.</span>';
                return;
            }

            if (file.type !== 'text/csv' && !file.name.endsWith('.csv')) {
                statusDiv.innerHTML = '<span style="color: red;">Hanya file CSV yang diizinkan.</span>';
                return;
            }

            statusDiv.innerHTML = '<span style="color: blue;">Memproses pratinjau...</span>';
            const reader = new FileReader();

            reader.onload = function(event) {
                const csvData = event.target.result;
                parsedData = parseCsv(csvData);
                displayPreview(parsedData);
                previewArea.classList.remove('hidden');
                submitButton.classList.remove('hidden');
                statusDiv.innerHTML = '';
            };

            reader.readAsText(file);
        }

        // Fungsi parse CSV sederhana tanpa library
        function parseCsv(csvText) {
            const lines = csvText.trim().split('\n');
            const headers = lines[0].split(',');
            const data = [];

            for (let i = 1; i < lines.length; i++) {
                const values = lines[i].split(',');
                if (values.length === headers.length) {
                    const obj = {};
                    for (let j = 0; j < headers.length; j++) {
                        obj[headers[j].trim()] = values[j].trim();
                    }
                    data.push(obj);
                }
            }
            return data;
        }

        function displayPreview(data) {
            const table = document.getElementById('dataTable');
            table.innerHTML = ''; // Clear existing table

            if (data.length === 0) {
                table.innerHTML = '<caption>Tidak ada data untuk ditampilkan.</caption>';
                return;
            }

            const headers = Object.keys(data[0]);
            let headerHtml = '<thead><tr>';
            headers.forEach(header => {
                headerHtml += `<th>${header}</th>`;
            });
            headerHtml += '</tr></thead><tbody>';
            
            let bodyHtml = headerHtml;
            data.forEach(row => {
                bodyHtml += '<tr>';
                headers.forEach(header => {
                    bodyHtml += `<td>${row[header]}</td>`;
                });
                bodyHtml += '</tr>';
            });
            bodyHtml += '</tbody>';
            table.innerHTML = bodyHtml;
        }

        function submitData() {
            const statusDiv = document.getElementById('status');
            statusDiv.innerHTML = '<span style="color: blue;">Mengirim data ke database...</span>';
            
            // Kirim data yang sudah di-parse melalui AJAX/Fetch ke backend PHP
            fetch('import.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(parsedData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    statusDiv.innerHTML = `<span style="color: green;">Berhasil mengimpor ${data.count} baris data!</span>`;
                    document.getElementById('submitButton').classList.add('hidden');
                } else {
                    statusDiv.innerHTML = `<span style="color: red;">Error: ${data.message}</span>`;
                }
            })
            .catch((error) => {
                statusDiv.innerHTML = `<span style="color: red;">Terjadi kesalahan jaringan: ${error}</span>`;
            });
        }
    </script>
</body>
</html>
