
/** User Controller */

const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
usersList = document.querySelector(".users-list");

/** Toggle search icon */
searchIcon.onclick = ()=>{
  // show the searchBar
  searchBar.classList.toggle("show");
  // active search icon 
  searchIcon.classList.toggle("active");
  searchBar.focus();
  // ?? 
  if(searchBar.classList.contains("active")){
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

/** When the searchBar is active */
searchBar.onkeyup = ()=>{
  // get the user input
  let searchTerm = searchBar.value;
  if (searchTerm != "") {
    searchBar.classList.add("active"); // if user enter something
  } else {
    searchBar.classList.remove("active"); // if user does not enter anything
  }
  // send request to serve-side
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data; // return the targeted user
        }
    }
  }
  // ??
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
}

/** after 5s user stops inputting, return the data */
setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500);

