console.log("hello");
document.addEventListener('DOMContentLoaded', function(){
let vote = document.querySelector('#button');
let User_info = document.querySelector('.user-info')
let imageUser = document.querySelector('.image-user')

vote.addEventListener('click', () =>{
  vote.style.transform = "scale(0)";
})

imageUser.addEventListener('mouseover', () => {
  User_info.style.display = "none";
})

imageUser.addEventListener('click', () =>{
  User_info.style.display = "block";
})

document.addEventListener('mouseover', () =>{
  User_info.style.display = "none";
})





});