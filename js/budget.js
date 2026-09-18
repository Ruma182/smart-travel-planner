const transport = document.getElementById("transport");
const hotel = document.getElementById("hotel");
const food = document.getElementById("food");
const other = document.getElementById("other");

const totalBudget = document.getElementById("totalBudget");
const totalBudgetInput = document.getElementById("total_budget");


function calculateBudget() {

    const transportCost = Number(transport.value) || 0;
    const hotelCost = Number(hotel.value) || 0;
    const foodCost = Number(food.value) || 0;
    const otherCost = Number(other.value) || 0;

    const total =
        transportCost +
        hotelCost +
        foodCost +
        otherCost;

    totalBudget.textContent = "৳" + total;

    totalBudgetInput.value = total;
}


transport.addEventListener("input", calculateBudget);
hotel.addEventListener("input", calculateBudget);
food.addEventListener("input", calculateBudget);
other.addEventListener("input", calculateBudget);