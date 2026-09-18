function getWeather() {

    const destination =
        document.getElementById(
            "weatherDestination"
        ).value;

    const result =
        document.getElementById(
            "weatherResult"
        );


    if (destination.trim() === "") {

        result.innerHTML =
            "<p>Please enter a destination.</p>";

        return;

    }


    fetch(
         "/web-technology/smart-travel-planner/weather_mvc.php?action=get_weather&destination="
        +
        encodeURIComponent(destination)
    )

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            result.innerHTML = `

                <div class="weather-card">

                    <h2>${data.destination}</h2>

                    <p>
                        <strong>Condition:</strong>
                        ${data.condition}
                    </p>

                    <p>
                        <strong>Temperature:</strong>
                        ${data.temperature} °C
                    </p>

                    <p>
                        <strong>Humidity:</strong>
                        ${data.humidity}%
                    </p>

                </div>

            `;

        } else {

            result.innerHTML =
                "<p>Weather information not found.</p>";

        }

    })

    .catch(error => {

        result.innerHTML =
            "<p>Unable to load weather information.</p>";

    });

}