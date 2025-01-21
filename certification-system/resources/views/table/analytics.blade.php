<div class="container mt-5">
    <h2>Record Summary</h2>
    <div id="analytics" class="list-group mb-4">
        <!-- Analytics data will be dynamically added here -->
    </div>
</div>

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

        // Function to update the analytics section
        function updateAnalytics(analyticsData) {
            const analyticsElement = document.querySelector('#analytics');
            analyticsElement.innerHTML = `
                <div class="list-group-item">
                    <h5 class="mb-1">Record Counts</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Total Certifications: ${analyticsData.certifications}</li>
                        <li class="list-group-item">Total Issuers: ${analyticsData.issuers}</li>
                        <li class="list-group-item">Total Users: ${analyticsData.users}</li>
                        <li class="list-group-item">Total Organizations: ${analyticsData.organizations}</li>
                    </ul>
                </div>
            `;
        }

        // Fetch and update the analytics data
        Promise.all([
            axios.get(apiUrls.certifications),
            axios.get(apiUrls.issuers),
            axios.get(apiUrls.users),
            axios.get(apiUrls.organizations)
        ])
        .then(([certResponse, issuerResponse, userResponse, orgResponse]) => {
            const analyticsData = {
                certifications: certResponse.data.length,
                issuers: issuerResponse.data.length,
                users: userResponse.data.length,
                organizations: orgResponse.data.data.length
            };
            updateAnalytics(analyticsData);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    });
</script>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
