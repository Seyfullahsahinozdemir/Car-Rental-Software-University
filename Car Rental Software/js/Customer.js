function searchCheck() {
    let small_btn = document.getElementById("small");
    let mid_btn = document.getElementById("mid");
    let large_btn = document.getElementById("large");

    // check types
    let type_check = document.getElementById("type-check");
    if (small_btn.checked == false && mid_btn.checked == false && large_btn.checked == false) {
        type_check.style.visibility = "visible";
    }
    else {
        type_check.style.visibility = "hidden";
    }

    let price1 = document.getElementById("price1");
    let price2 = document.getElementById("price2");
    let price3 = document.getElementById("price3");

    // check price
    let price_check = document.getElementById("price-check");
    if (price1.checked == false && price2.checked == false && price3.checked == false) {
        price_check.style.visibility = "visible";
    }
    else {
        price_check.style.visibility = "hidden";
    }

    let sdate = document.getElementById("sdate");
    let fdate = document.getElementById("fdate");
    
    let date_check = document.getElementById("date-check");
    if (sdate.value == "" || fdate.value == "") {
        date_check.style.visibility = "visible";
    }
    else {
        date_check.style.visibility = "hidden";
    }

    // static part if user choose small-size and 300$ together the system doesn't show available car.
    let car_ul = document.getElementById("carList");
    let car_table = document.getElementById("carTable");
    if ((small_btn.checked == true || mid_btn.checked == true || large_btn.checked == true) && (price1.checked == true || price2.checked == true || price3.checked == true) && sdate.value != "" && fdate.value != "" ) {
        if (mid_btn.checked == true && small_btn.checked == true && price2.checked == true && sdate.value != "" && fdate.value != "") {
            document.getElementById("scrollable").style.visibility = "visible";
            car_ul.innerHTML = "";
            car_table.innerHTML = "<tr><th>Image</th><th>Model</th><th>Price</th><th>Check</th></tr><tr><td><img src='img/sedan.png' alt='sedan'></td><td>Sedan</td><td>220$</td><td><input type='checkbox' name='sedan' id='sedan'></td></tr>"+
            "<tr><td><img src='img/sport-car.png' alt='sport-car'></td><td>Sport</td><td>280$</td><td><input type='checkbox' name='sport' id='sport'></td></tr>"+
            "<tr><td><img src='img/jeep.png' alt='jeep'></td><td>Jeep</td><td>250$</td><td><input type='checkbox' name='jeep' id='jeep'></td></tr>";
            let add_btn = document.getElementById("add-btn");
            add_btn.style.visibility = "visible";
    
        } else {
            car_ul.innerHTML = "<span style='color: red;'>* There is no available car !!!</span>";
            document.getElementById("scrollable").style.visibility = "hidden";
            car_table.innerHTML = "";
        }
    }

}

function checkCarList() {
    let sedan = document.getElementById("sedan");
    let sport = document.getElementById("sport");
    let jeep = document.getElementById("jeep");
    if ((sedan.checked == false && sport.checked == false && jeep.checked == false) || (sedan.checked == true && sport.checked == true) || (jeep.checked == true && sport.checked == true) || (sedan.checked == true && jeep.checked == true)) {
        alert("Not possible choice !!!")
    }
    else {
        window.location.href = "MyReservation.html";
    }
}
