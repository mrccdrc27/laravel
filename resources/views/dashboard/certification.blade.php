<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 dark:text-blue-400 leading-tight">
            {{ __('certification') }}
        </h2>        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="container">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Certificates</h2>
                    <div id="certificate-list"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userId = {{ Auth::id() }};
            const certificateListElement = document.getElementById('certificate-list');
            
            fetch(`https://genesiscs.azurewebsites.net/api/user/${userId}/certificates`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const certificates = data.data;
                        const userFullName = data.userFullName || 'Unknown User';

                        // Function to format date into human-readable format
                        function formatDate(dateString) {
                            const options = { year: 'numeric', month: 'long', day: 'numeric' };
                            const date = new Date(dateString);
                            return date.toLocaleDateString('en-US', options);
                        }

                        const tableHtml = `
                            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Certificates for ${userFullName}</h3>
                            ${certificates.length > 0 ? `
                                <table class="min-w-full bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                            <th class="px-6 py-3 text-left">#</th>
                                            <th class="px-6 py-3 text-left">Certification Number</th>
                                            <th class="px-6 py-3 text-left">Title</th>
                                            <th class="px-6 py-3 text-left">Issued Date</th>
                                            <th class="px-6 py-3 text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700 dark:text-gray-300">
                                        ${certificates.map((certificate, index) => `
                                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                                <td class="px-6 py-4">${certificate.certificationID}</td>
                                                <td class="px-6 py-4">${certificate.certificationNumber}</td>
                                                <td class="px-6 py-4">${certificate.title}</td>
                                                <td class="px-6 py-4">${formatDate(certificate.issuedAt)}</td>
                                                <td class="px-6 py-4">
                                                    <a href="${certificate.certificateLink}" class="text-blue-500 hover:text-blue-700" target="_blank">
                                                        <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                                                            View Certificate
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            ` : `
                                <div class="text-center text-gray-600 dark:text-gray-400 mt-6">
                                    <p>No certificates found.</p>
                                </div>
                            `}
                        `;
                        certificateListElement.innerHTML = tableHtml;
                    } else {
                        certificateListElement.innerHTML = `
                            <div class="text-center text-gray-600 dark:text-gray-400 mt-6">
                                <p>No certificates found.</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error fetching certificates:', error);
                    certificateListElement.innerHTML = `
                        <div class="text-center text-red-600 mt-6">
                            <p>Error loading certificates.</p>
                        </div>
                    `;
                });
        });
    </script>
</x-app-layout>
