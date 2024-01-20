
// get html elements
let form = document.querySelector(".login form ");
let continueBtn = document.querySelector('.button input');
let errorText = document.querySelector('.error-text');
// console.log(errorText);

form.onsubmit = (e) => {
    e.preventDefault();
}

continueBtn.onclick = () => {
    // console.log('btn clicked');

    let request = new XMLHttpRequest();
    // console.log(request);

    request.open("POST", "../php/updateLogin.php", true);
    request.onload = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            let data = request.responseText;
            if (data === "success") {
                window.location.href = "../views/users.php";
            } else {
                errorText.style.display = "block";
                errorText.textContent = data;
            }
        }
    };
    let formData = new FormData(form);
    request.send(formData);
}