function convertCurrency() {

    const amount =
        document.getElementById("amount").value;

    const from =
        document.getElementById("fromCurrency").value;

    const to =
        document.getElementById("toCurrency").value;

    const result =
        document.getElementById("currencyResult");


    if (amount === "" || Number(amount) <= 0) {

        result.innerHTML =
            "<p>Please enter a valid amount.</p>";

        return;

    }


    fetch(
          
         "/web-technology/smart-travel-planner/currency_mvc.php?action=convert&amount="
      
        +
        encodeURIComponent(amount)
        +
        "&from="
        +
        encodeURIComponent(from)
        +
        "&to="
        +
        encodeURIComponent(to)

    )

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            result.innerHTML = `

                <div class="currency-card">

                    <h2>
                        ${data.amount}
                        ${data.from}

                        =

                        ${data.result}
                        ${data.to}
                    </h2>

                </div>

            `;

        } else {

            result.innerHTML =
                "<p>Conversion failed.</p>";

        }

    })

    .catch(error => {

        result.innerHTML =
            "<p>Unable to convert currency.</p>";

    });

}