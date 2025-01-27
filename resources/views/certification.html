<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Certifications</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Search Certifications</h1>

    <!-- Search Form -->
    <form id="searchForm">
        <label for="name">Enter Name:</label>
        <input type="text" id="name" name="name" value="{{ request('name') }}" required>
        <button type="submit">Search</button>
        <button type="button" id="resetButton">Reset</button>
    </form>

    <!-- Display Results -->
    <h2>Results:</h2>
    <table id="resultsTable">
        <thead>
            <tr>
                <th>Certification ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Issued At</th>
                <th>Expiry Date</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic content will be inserted here by JavaScript -->
        </tbody>
    </table>

    <p id="noResults" style="display:none;">No results found.</p>

    <script>
        document.getElementById("searchForm").addEventListener("submit", function(event) {
            event.preventDefault();
            
            let name = document.getElementById("name").value;
            let url = `/api/search/cert?name=${encodeURIComponent(name)}`;

            // Clear previous results
            document.querySelector("#resultsTable tbody").innerHTML = "";
            document.getElementById("noResults").style.display = "none";

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        // Loop through the JSON data and populate the table
                        data.forEach(certification => {
                            let row = document.createElement("tr");
                            
                            row.innerHTML = `
                                <td>${certification.certificationID}</td>
                                <td>${certification.title}</td>
                                <td>${certification.description}</td>
                                <td>${certification.issuedAt}</td>
                                <td>${certification.expiryDate}</td>
                                <td>${certification.userinfo.firstName} ${certification.userinfo.middleName} ${certification.userinfo.lastName}</td>
                            `;

                            document.querySelector("#resultsTable tbody").appendChild(row);
                        });
                    } else {
                        document.getElementById("noResults").style.display = "block";
                    }
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                });
        });

        // Reset the form and table when the reset button is clicked
        document.getElementById("resetButton").addEventListener("click", function() {
            // Clear search input
            document.getElementById("name").value = "";
            
            // Clear the results table
            document.querySelector("#resultsTable tbody").innerHTML = "";
            
            // Hide the "No results" message
            document.getElementById("noResults").style.display = "none";
        });
    </script>
</body>
</html>
