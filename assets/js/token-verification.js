const form = document.querySelector("[verification-form]");
const verificationInput = document.querySelector("[verification-input]");
const verificationError = document.querySelector("[verification-error]");

const inputRegex = /[\d]{6}/;

const validator = (regex, value, error) => {
	const input = value.trim();
	let isValid = false;
	if (input === "") {
		error.textContent = "This field is required";
		isValid = false;
	} else if (!regex.test(input)) {
		error.textContent = "Please enter a valid value";
		isValid = false;
	} else {
		error.textContent = "";
		isValid = true;
	}
	return isValid;
};

verificationInput.addEventListener("keyup", (e) => {
	const input = e.target.value;
	validator(inputRegex, input, verificationError);
});

form.addEventListener("submit", (e) => {
	e.preventDefault();
	const isValid = validator(inputRegex, verificationInput.value, verificationError);
	if (isValid) form.submit();
});
