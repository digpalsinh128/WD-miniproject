/**
 * Simple JavaScript Form Validation
 * Checks user inputs before submitting the HTML form
 */

function validateForm() {
    var name = document.getElementById("student_name").value.trim();
    var roll = document.getElementById("roll_no").value.trim();
    var email = document.getElementById("email").value.trim();
    var dept = document.getElementById("department").value;
    var eventName = document.getElementById("event_name").value;

    // Check if Name is empty
    if (name === "" || name.length < 3) {
        alert("Please enter a valid full name (at least 3 letters).");
        document.getElementById("student_name").focus();
        return false;
    }

    // Check if Roll Number is empty
    if (roll === "") {
        alert("Please enter your Roll / Enrollment Number.");
        document.getElementById("roll_no").focus();
        return false;
    }

    // Check if Email format is valid
    if (email === "" || !email.includes("@")) {
        alert("Please enter a valid email address.");
        document.getElementById("email").focus();
        return false;
    }

    // Check Department selection
    if (dept === "") {
        alert("Please select your Department.");
        document.getElementById("department").focus();
        return false;
    }

    // Check Event selection
    if (eventName === "") {
        alert("Please select an Event to register.");
        document.getElementById("event_name").focus();
        return false;
    }

    return true; // Form submission proceeds
}
