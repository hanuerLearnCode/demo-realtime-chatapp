
// showing/hiding password

const pswrdField = document.querySelector(".form input[type='password']"),
toggleIcon = document.querySelector(".form .field i");

toggleIcon.onclick = () =>{
  if(pswrdField.type === "password"){
    pswrdField.type = "text";
    toggleIcon.classList.add("active"); // add "active" to the class tag of <i>
  }else{
    pswrdField.type = "password";
    toggleIcon.classList.remove("active");
  }
}
