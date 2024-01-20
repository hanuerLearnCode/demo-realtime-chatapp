
let searchBar = document.querySelector(".search input");
let searchIcon = document.querySelector('.search button');
let usersList = document.querySelector('.users-list');
let searchTerm = '';

// console.log(usersList);

searchIcon.onclick = () => {
    // console.log('click search icon');
    searchBar.classList.toggle('show');
    searchIcon.classList.toggle('active');
    searchBar.focus();

    if (searchBar.classList.contains('active')) {
        searchBar.value = '';
        searchBar.classList.remove('active');
    }
}

searchBar.onkeyup = () => {
    searchTerm = searchBar.value;
    // console.log(searchTerm);
    if (searchTerm != "") {
        searchBar.classList.add("active"); // if user enter something
      } else {
        searchBar.classList.remove("active"); // if user does not enter anything
      }

    let request = new XMLHttpRequest();
    request.open("POST", "../php/search.php", true);
    request.onload = () => {
        if (request.readyState === XMLHttpRequest.DONE && request.status === 200) {
            let data = request.response;
            usersList.innerHTML = data;
            // console.log(usersList);
        }
    }
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // endcoded the search term when sending the request to search.php
    request.send("searchTerm=" + searchTerm); // send the search term to search.php
}

/** return the data if user is not*/
setInterval ( () => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../php/users.php", true);
    // console.log(xhr);
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
  