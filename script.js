/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function showDropdown() {
    var myDropdownContent = document.getElementById("myDropdown");
    if(myDropdownContent.style.display == "block"){
        myDropdownContent.style.display= "none"
    }else{
        myDropdownContent.style.display= "block"
    }
}
  
// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var myDropdownContent = document.getElementById("myDropdown");
        var myDropdownContent2 = document.getElementById("myDropdown2");
        myDropdownContent.style.display= "none"
        myDropdownContent2.style.display= "none"
    }
}

function showDropdown2() {
    var myDropdownContent = document.getElementById("myDropdown2");
    if(myDropdownContent.style.display == "block"){
        myDropdownContent.style.display= "none"
    }else{
        myDropdownContent.style.display= "block"
    }
}

