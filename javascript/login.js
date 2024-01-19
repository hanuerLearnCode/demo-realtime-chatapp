
/**
 * Login controller
 */

const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    // set the response type
    xhr.responseType = "text";
    // load
    xhr.onload = ()=>{
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response.trim() // remove the whitespace of the xhr.response
          console.log(data); 
          if (data === "success") {
            console.log(data);
            // window.location.href = "users.php";
          } else {
            errorText.style.display = "block";
            errorText.textContent = data;
          }
        }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}