function showResponse(i) {
    let response = document.getElementById('response' + i);
    if(response.style.display == "block") {
        response.style.display = 'none';
    } else {   
        response.style.display = 'block';
    }
}

