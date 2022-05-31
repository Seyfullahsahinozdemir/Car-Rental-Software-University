function openPopup (name,model,price,seat,image) {
    console.log(name);
    document.getElementById('myForm').style.display = "block";
    document.getElementById('popup-car-name').value = name;
    document.getElementById('span-name').value = name;
    document.getElementById('popup-car-model').value = model;
    document.getElementById('span-model').value = model;
    document.getElementById('popup-car-price').value = price;
    document.getElementById('span-price').value = price;
    document.getElementById('popup-car-seat').value = seat;
    document.getElementById('span-seat').value = seat;
    document.getElementById('popup-car-image').value = image;
    document.getElementById('span-img').src = "uploads/"+image;
}

function closeForm() {
    document.getElementById("myForm").style.display = "none";
}

function editReservation(name,start,finish) {
    document.getElementById("updateForm").style.display = "block";
    document.getElementById('car_name').value = name;
    document.getElementById('car_start').value = start;
    document.getElementById('car_finish').value = finish;
    document.getElementById('last_start').value = start;
    document.getElementById('last_finish').value = finish;
}

function deleteForm(name,start,finish) {
    document.getElementById("deleteForm").style.display = "block";
    document.getElementById('delete_carname').value = name;
    document.getElementById('delete_start').value = start;
    document.getElementById('delete_finish').value = finish;
}

function closeUpdate() {
    document.getElementById("updateForm").style.display = "none";

}

function closeDeleteForm() {
    document.getElementById("deleteForm").style.display = "none";

}

function closeRate() {
    document.getElementById("rateForm").style.display = "none";
}


function openTempRate(carID) {
    let str = carID + "_car";
    document.getElementById(str).style.display = "block";
}

function closeTempRate() {
    /*let str = carID + "_car";
    document.getElementById(str).style.display = "none";*/
    let temp = document.getElementsByClassName('div1');
    for (let i = 0; i < temp.length; i++) {
        temp[i].style.display = "none";
    }
}