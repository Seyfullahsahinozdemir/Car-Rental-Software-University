



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
    let car_table = document.getElementById("carTable");
    let car_err = document.getElementById("errorTag");

    if ((small_btn.checked == true || mid_btn.checked == true || large_btn.checked == true) && (price1.checked == true || price2.checked == true || price3.checked == true) && sdate.value != "" && fdate.value != "" ) {
        if (mid_btn.checked == true && small_btn.checked == true && price2.checked == true && sdate.value != "" && fdate.value != "") {
            car_err.style.visibility = "hidden";
            document.getElementById("scrollable").style.visibility = "visible";
            car_table.innerHTML = "<div class='car-style' id='cars'><h3 style='margin-top: 5px;'>Sedan</h3><img src='img/sedan.png' alt='sedan'><p>Lorem ipsum dolor sit amet consectetur.</p><p>Price: 50$/day</p><a id='rent-btn' class='car-style' href='MyReservation.html'>Rent</a></div>"+
            "<div class='car-style' id='cars'><h3 style='margin-top: 5px;'>Sport</h3><img src='img/sport-car.png' alt='sport'><p>Lorem ipsum dolor sit amet consectetur.</p><p>Price: 90$/day</p><a id='rent-btn' class='car-style' href='MyReservation.html'>Rent</a></div>"+
            "<div class='car-style' id='cars'><h3 style='margin-top: 5px;'>Jeep</h3><img src='img/jeep.png' alt='jeep'><p>Lorem ipsum dolor sit amet consectetur.</p><p>Price: 60$/day</p><a id='rent-btn' class='car-style' href='MyReservation.html'>Rent</a></div>"
            + "<div class='car-style' id='cars'><h3 style='margin-top: 5px;'>Jeep</h3><img src='img/jeep.png' alt='jeep'><p>Lorem ipsum dolor sit amet consectetur.</p><p>Price: 60$/day</p><a id='rent-btn' class='car-style' href='MyReservation.html'>Rent</a></div>";
    
        } else {
            car_err.style.visibility = "visible";
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




