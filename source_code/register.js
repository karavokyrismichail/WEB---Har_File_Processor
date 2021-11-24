const password1 = document.querySelector("#password_1");
const password2 = document.querySelector("#password_2");
const btn = document.querySelector("#register_button");

function showReg(){
	var pass = document.getElementById("password_1")
	var passC = document.getElementById("password_2")

	if (pass.type === "password"){
		pass.type = "text";
		passC.type = "text";
	} else {
		pass.type = "password";
		passC.type = "password";
	}
}

var checkPasswords = function() {
	var pass1 = document.getElementById("password_1")
	var pass2 = document.getElementById("password_2")

	if (pass1.value === pass2.value){
		pass2.style.color = "green";
	} else {
		pass2.style.color = "red";
	}
}
