window.onload = function () {

  // For add album to image modal form
  var modal = document.getElementById("modal");

  var btn = document.getElementById("btn");

  var span = document.getElementsByClassName("close")[0];

  btn.onclick = function () {
    modal.style.display = "block";
  }

  span.onclick = function () {
    modal.style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  // For remove album from image modal form
  var modal1 = document.getElementById("modal1");

  var btn1 = document.getElementById("btn1");

  var span1 = document.getElementsByClassName("close1")[0];

  btn1.onclick = function () {
    modal1.style.display = "block";
  }

  span1.onclick = function () {
    modal1.style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      modal1.style.display = "none";
    }
  }

  // For image deletion
  var modal2 = document.getElementById("modal2");

  var btn2 = document.getElementById("btn2");

  var yes = document.getElementById("yes");

  var cancel = document.getElementById("cancel");

  btn2.onclick = function () {
    modal2.style.display = "block";
    return false;
  }

  yes.onclick = function () {
    modal2.style.display = "none";
  }

  cancel.onclick = function () {
    modal2.style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      modal2.style.display = "none";
    }
  }

}
