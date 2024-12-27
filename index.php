<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON to CSV Export</title>
    <style>
        /* Base Styling for Dark Theme */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e2f;
            color: #d4d4dc;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #ffffff;
        }

        /* Form Container */
        .form-container {
            background-color: #2a2a40;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 620px;
        }

        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #bbbbcc;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border: 1px solid #444466;
            border-radius: 4px;
            background-color: #1f1f30;
            color: #d4d4dc;
            resize: none;
            font-family: 'Courier New', Courier, monospace;
        }
        textarea:focus {
            outline: none;
            border-color: #6a96ff;
        }
        button {
            display: inline-block;
            background-color: #6a96ff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #597fd1;
        }
        button:active {
            background-color: #4c70b8;
        }

        /* Output Section */
        #output {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #444466;
            border-radius: 4px;
            background-color: #1f1f30;
            color: #d4d4dc;
            white-space: pre-wrap;
            font-family: 'Courier New', Courier, monospace;
            overflow: auto;
            max-height: 200px;
        }
    </style>
</head>
<body>
    <h1>JSON to CSV Export</h1>
    <div class="form-container">
        <div class="form-group">
            <label for="jsonInput">Enter JSON Array:</label>
            <textarea id="jsonInput" placeholder='[{"id":1, "name":"John"}, {"id":2, "name":"Jane"}]'></textarea>
        </div>
        <button type="button" onclick="processJSON()">Download CSV</button>
    </div>

    <script>
        function processJSON() {
            // Get JSON input from the textarea
            const jsonInput = document.getElementById('jsonInput').value;

            try {
                // Parse the JSON input
                const jsonArray = JSON.parse(jsonInput);

                // Validate that the input is an array
                if (!Array.isArray(jsonArray)) {
                    throw new Error("Input is not a valid JSON array.");
                }

                // Generate CSV
                const csvContent = convertToCSV(jsonArray);

                //file name
                timestamp = new Date().getTime();
                const fileName = timestamp + '.csv';
                // Download the CSV
                downloadCSV(csvContent, fileName);
            } catch (error) {
                alert(`Error: ${error.message}`);
            }
        }

        function convertToCSV(jsonArray) {
            // Get the headers
            const headers = Object.keys(jsonArray[0]);

            // Create the header row and data rows
            const csvRows = [
                headers.join(','), // Header row
                ...jsonArray.map(row => headers.map(header => JSON.stringify(row[header] || "")).join(',')) // Data rows
            ];

            // Join rows with newline characters
            return csvRows.join('\n');
        }

        function downloadCSV(content, filename) {
            // Create a blob from the content
            const blob = new Blob([content], { type: 'text/csv' });

            // Create a link element
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;

            // Append the link, trigger the download, and remove the link
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>
