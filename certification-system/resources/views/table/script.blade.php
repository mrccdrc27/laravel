<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const baseUrl = "{{ url('/') }}";

        // Define API URLs for all tables
        const apiUrls = {
            certifications: `${baseUrl}/api/cert`,
            issuers: `${baseUrl}/api/issuer`,
            users: `${baseUrl}/api/user_info`,
            organizations: `${baseUrl}/api/org`,
        };

        // Function to populate table rows dynamically
        function populateTable(tableId, data, keys) {
            const tableBody = document.querySelector(`#${tableId} tbody`);
            tableBody.innerHTML = ''; // Clear any existing rows

            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = keys.map(key => `<td>${item[key] || 'N/A'}</td>`).join('');
                tableBody.appendChild(row);
            });
        }

        // Fetch and populate the data for Certifications table
        axios.get(apiUrls.certifications)
            .then(response => {
                if (response.data && response.data.length > 0) {
                    populateTable('certificationTable', response.data, [
                        'certificationID', 'certificationNumber', 'courseID', 'title', 
                        'description', 'issuedAt', 'expiryDate', 'issuerID', 'userID'
                    ]);
                }
            })
            .catch(error => {
                console.error('Error fetching certification data:', error);
            });

        // Fetch and populate the data for Issuers table
        axios.get(apiUrls.issuers)
            .then(response => {
                if (response.data && response.data.length > 0) {
                    populateTable('issuerTable', response.data, [
                        'issuerID', 'firstName', 'middleName', 'lastName', 
                        'issuerSignature', 'organizationID', 'created_at', 'updated_at'
                    ]);
                }
            })
            .catch(error => {
                console.error('Error fetching issuer data:', error);
            });

        // Fetch and populate the data for Users table
        axios.get(apiUrls.users)
            .then(response => {
                if (response.data && response.data.length > 0) {
                    populateTable('userTable', response.data, [
                        'userID', 'studentID', 'firstName', 'middleName', 'lastName', 
                        'email', 'birthDate', 'sex', 'nationality', 'birthPlace'
                    ]);
                }
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
            });

        // Fetch and populate the data for Organizations table
        axios.get(apiUrls.organizations)
            .then(response => {
                const tableBody = document.querySelector('#organizationTable tbody');
                tableBody.innerHTML = ''; // Clear any existing rows

                response.data.data.forEach(organization => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${organization.organizationID}</td>
                        <td>${organization.name}</td>
                        <td>
                            <img src="data:image/png;base64,${organization.logo}" alt="Logo" style="max-height: 50px;">
                        </td>
                        <td>${organization.created_at}</td>
                        <td>${organization.updated_at}</td>
                    `;

                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching organization data:', error);
            });
    });
</script>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
