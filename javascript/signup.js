
/** Sign-up controller 
 * when a sign up form is filled, a request is sent to the server
 * the data then will be sent to the signup.php if valid
 * */ 

const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

// when the form is submitted
continueBtn.onclick = ()=>{
    // creating an xml object
    let xhr = new XMLHttpRequest();
    // selecting the http method, connecting to the signup.php and stating that this method is asyncronous
    xhr.open("POST", "php/updateSignup.php", true);
    
    // set the response type
    xhr.responseType = "text";
    // loading the request
    xhr.onload = ()=>{
      if (xhr.readyState === XMLHttpRequest.DONE) 
      { 
        if (xhr.status === 200) // if success
        { 
          let data = xhr.response.trim(); // get the response
          if (data  === "success")  // check if the response from the server is success
          {
            window.location.href = "users.php"; // return to user.php
          } 
          else // display errors
          { 
            errorText.style.display = "block";
            errorText.textContent = data;
          }
        }
      }
    }
    // getting the data from the form
    let formData = new FormData(form);
    // sending the form data to signup.php
    xhr.send(formData);
}