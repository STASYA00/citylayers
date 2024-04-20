function createContainer(){
    var div = document.createElement("div");
    div.innerHTML = "test!!!!!!!!!!!!!!!";
    div.style.color = 'red';
    // better to use CSS though - just set class
    div.setAttribute('class', 'panel'); // and make sure myclass has some styles in css
    document.body.appendChild(div);
    
}

