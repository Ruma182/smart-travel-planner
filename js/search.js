
const searchInput = document.getElementById("searchInput");
const destinationResults = document.getElementById("destinationResults");


// ========================================
// SEARCH DESTINATIONS
// ========================================

function searchDestinations() {

    const searchText = searchInput.value.trim();

    destinationResults.innerHTML = `
        <div class="destination-loading">
            <p>Searching destinations...</p>
        </div>
    `;


    const xhr = new XMLHttpRequest();


    // ========================================
    // MVC SEARCH URL
    // ========================================

    xhr.open(
        "GET",
        "/web-technology/smart-travel-planner/destination_mvc.php?action=search&search=" +
        encodeURIComponent(searchText),
        true
    );


    xhr.onload = function () {

        if (xhr.status === 200) {

            try {

                const destinations = JSON.parse(xhr.responseText);

                destinationResults.innerHTML = "";


                // ========================================
                // NO DESTINATION
                // ========================================

                if (destinations.length === 0) {

                    destinationResults.innerHTML = `
                        <div class="destination-empty">

                            <h3>No Destination Found</h3>

                            <p>
                                We could not find any destination
                                matching your search.
                            </p>

                        </div>
                    `;

                    return;
                }


                // ========================================
                // DESTINATION CARDS
                // ========================================

                let resultsHTML = "";


                destinations.forEach(function (destination) {

                    resultsHTML += `

                        <div class="destination-card">

                            <h2>
                                ${destination.name}
                            </h2>

                            <p>
                                <strong>Location:</strong>
                                ${destination.location}
                            </p>

                            <p>
                                ${destination.description}
                            </p>

                            <p>
                                <strong>Estimated Cost:</strong>
                                ৳${destination.estimated_cost}
                            </p>


                            <div class="destination-actions">

                                <a
                                    href="/web-technology/smart-travel-planner/favorite_mvc.php?action=add&destination=${encodeURIComponent(destination.name)}"
                                    class="favorite-btn"
                                >
                                    Add to Favorite
                                </a>

                            </div>


                        </div>

                    `;

                });


                destinationResults.innerHTML = resultsHTML;

            }


            catch (error) {

                console.error("JSON Error:", error);

                destinationResults.innerHTML = `
                    <div class="destination-empty">

                        <h3>Something Went Wrong</h3>

                        <p>
                            Unable to load destinations.
                            Please try again.
                        </p>

                    </div>
                `;

            }

        }


        else {

            console.error(
                "Server Error:",
                xhr.status,
                xhr.responseText
            );

            destinationResults.innerHTML = `
                <div class="destination-empty">

                    <h3>Unable to Load Destinations</h3>

                    <p>
                        Server error. Please try again later.
                    </p>

                </div>
            `;

        }

    };


    // ========================================
    // CONNECTION ERROR
    // ========================================

    xhr.onerror = function () {

        destinationResults.innerHTML = `
            <div class="destination-empty">

                <h3>Connection Error</h3>

                <p>
                    Unable to connect to the server.
                </p>

            </div>
        `;

    };


    xhr.send();

}


// ========================================
// LIVE SEARCH
// ========================================

searchInput.addEventListener(
    "input",
    searchDestinations
);


// ========================================
// LOAD ALL DESTINATIONS
// ========================================

window.addEventListener(
    "load",
    searchDestinations
);

