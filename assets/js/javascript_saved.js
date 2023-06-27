// Script para controlar la navegación entre pasos del formulario

var currentStep = 1;
var form = document.getElementById("registration-form");
var progressBar = document.getElementById("progress-bar");

var nextBtns = document.getElementsByClassName("next-step");
for (var i = 0; i < nextBtns.length; i++) {
  nextBtns[i].addEventListener("click", function () {
    if (currentStep < 5) {
      document.getElementById("step-" + currentStep).style.display = "none";
      currentStep++;
      document.getElementById("step-" + currentStep).style.display = "block";
      updateProgressBar();
    }
  });
}

var prevBtns = document.getElementsByClassName("previous-step");
for (var i = 0; i < prevBtns.length; i++) {
  prevBtns[i].addEventListener("click", function () {
    if (currentStep > 1) {
      document.getElementById("step-" + currentStep).style.display = "none";
      currentStep--;
      document.getElementById("step-" + currentStep).style.display = "block";
      updateProgressBar();
    }
  });
}

function updateProgressBar() {
  var progress = (currentStep - 1) * 25;
  progressBar.style.width = progress + "%";
}

// Version nueva del codigo
// Script para controlar la navegación entre pasos del formulario
var currentStep = 1;
var form = document.getElementById("registration-form");
var progressBar = document.getElementById("progress-bar");

var nextBtns = document.getElementsByClassName("next-step");
for (var i = 0; i < nextBtns.length; i++) {
  nextBtns[i].addEventListener("click", function () {
    if (validateCurrentStepFields()) {
      if (currentStep < 5) {
        document.getElementById("step-" + currentStep).style.display = "none";
        currentStep++;
        document.getElementById("step-" + currentStep).style.display = "block";
        updateProgressBar();
      }
    } else {
      showAlert("Por favor, completa todos los campos antes de continuar.");
    }
  });
}

var prevBtns = document.getElementsByClassName("previous-step");
for (var i = 0; i < prevBtns.length; i++) {
  prevBtns[i].addEventListener("click", function () {
    if (currentStep > 1) {
      document.getElementById("step-" + currentStep).style.display = "none";
      currentStep--;
      document.getElementById("step-" + currentStep).style.display = "block";
      updateProgressBar();
    }
  });
}

function updateProgressBar() {
  var progress = (currentStep - 1) * 25;
  progressBar.style.width = progress + "%";
}

function validateCurrentStepFields() {
  var stepFields = document.querySelectorAll(
    "#step-" + currentStep + " input, #step-" + currentStep + " select"
  );
  for (var i = 0; i < stepFields.length; i++) {
    if (stepFields[i].value === "") {
      return false;
    }
  }
  return true;
}

var showAlertDisplayed = false;

function showAlert(message) {
  if (!showAlertDisplayed) {
    var alertDiv = document.createElement("div");
    alertDiv.className = "alert alert-danger text-center";
    alertDiv.innerHTML = "<strong>" + message + "</strong>";
    form.insertBefore(alertDiv, form.firstChild);
    showAlertDisplayed = true;

    setTimeout(function () {
      alertDiv.style.display = "none";
      showAlertDisplayed = false;
    }, 3000);
  }
}
