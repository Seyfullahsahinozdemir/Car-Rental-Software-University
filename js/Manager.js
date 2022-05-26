function openForm() {
    document.getElementById("myForm").style.display = "block";
    
}

function closeForm() {
    document.getElementById("myForm").style.display = "none";
}

function editCarForm(id,name,model,price,state,seat,day) {
  document.getElementById("updateForm").style.display = "block";
  document.getElementById('editID').value = id;
  document.getElementById('editname').value = name;
  document.getElementById('editmodel').value = model;
  document.getElementById('editprice').value = price;
  document.getElementById('editnumSeat').value = seat;
  document.getElementById('editnumDay').value = day;
  document.getElementById('editstate').value = state;


}

function closeEditForm() {
  document.getElementById("updateForm").style.display = "none";
}

function deleteForm(id) {
  document.getElementById("deleteForm").style.display = "block";
  document.getElementById('deleteid').value = id;
}

function closeDeleteForm() {
  document.getElementById("deleteForm").style.display = "none";
}

function editReservation(name,start,finish) {
  document.getElementById("updateForm").style.display = "block";
  document.getElementById('car_name').value = name;
  document.getElementById('car_start').value = start;
  document.getElementById('car_finish').value = finish;
  document.getElementById('last_start').value = start;
  document.getElementById('last_finish').value = finish;
}

function delForm(name,start,finish) {
  document.getElementById("deleteForm").style.display = "block";
  document.getElementById('delete_carname').value = name;
  document.getElementById('delete_start').value = start;
  document.getElementById('delete_finish').value = finish;
}