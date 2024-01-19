
/**
 * Chat Event Handler
 */

// get the elements
const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");
// prevent default
form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();

// when user is inputting
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active"); // active the send msg btn
    }else{
        sendBtn.classList.remove("active");
    }
}

// when a msg is sent
sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true); // data is sent to insert-chat.php
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = ""; // clear the texting area
              scrollToBottom(); // scroll to the latest message
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData); // send data
}
// when hovering above the texting area
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}
chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

// refresh the chat window after 500s
setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/updateGetChat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id); // send the receiver id to get-chat.php
}, 500);

// helper func
function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  