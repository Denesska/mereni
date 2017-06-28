var denis = ["mihai", "marius"];
var mihai = denis.filter(function (element) { return element === "mihai"; });
function greeter(person) {
    return "Hello, " + person;
}
var user = "Denis G";
document.body.innerHTML = greeter(user);
