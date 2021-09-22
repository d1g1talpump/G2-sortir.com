const someId = document.getElementById('some-id');
const example = document.getElementById('example');

someId.addEventListener('change', doSomething);

function doSomething() {
    if (someId.value === "yes") {
        example.innerHTML = "YES!"
    } else {
        example.innerHTML = ""
    }
}