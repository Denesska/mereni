let denis = ["mihai", "marius"];
let mihai = denis.filter(element => element === "mihai");

function greeter(person: string) {
    return "Hello, " + person;
}

var user = "Denis G";

document.body.innerHTML = greeter(user);