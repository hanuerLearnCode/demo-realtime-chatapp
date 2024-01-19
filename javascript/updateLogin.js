/**
 * update login controller
 */

const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e) => {
    e.preventDefault;
}

continueBtn.onclick = () => {
    console.log("btn onclick");
    const xhr = new XMLHttpRequest();
    console.log(xhr);
    xhr.open('POST', 'php/updateLogin.php', true);
    xhr.responseType = 'text';
    console.log('something');
    xhr.onload = () => {
        console.log("xhr has been loaded");
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
            }
        }
    }
}