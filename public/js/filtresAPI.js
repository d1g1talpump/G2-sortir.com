function initCampusNames(){
    //json response
    fetch("{{app_url_api}}/campus", {method:"GET"})
        .then(response => response.json())
        .then(response =>{
            console.log(response);
            let option = ""
            response.map(campusName =>{
                option += `<option value="${campusName.id}">${campusName.name}</option>`
            })
            console.log(option);
            document.querySelector("#campusNames").innerHTML= option;
        })
        .catch(e=>(alert("ERROR : no options")))
}

function initCampusNamesTwig() {
    // twig response
    fetch("{{app_url_api}}/campus?option=twig", {method: "GET"})
        .then(response => response.text())
        .then(response => {
            document.querySelector("#campusNames").innerHTML = response;
        })
        .catch(e => (alert("ERROR : no options"))
        )}