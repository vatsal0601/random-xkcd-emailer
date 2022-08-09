const form = document.querySelector("[user-form]");
const nameInput = document.querySelector("[name-input]");
const nameError = document.querySelector("[name-error]");
const emailInput = document.querySelector("[email-input]");
const emailError = document.querySelector("[email-error]");

const nameRegex = /^[a-zA-Z ]+$/;
const emailRegex = /^([a-z \d \. -]+)@([a-z \d -]+)\.([a-z]{2,})(\.[a-z]{2,})?$/;

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

nameInput.addEventListener("keyup", (e) => {
	const input = e.target.value;
	validator(nameRegex, input, nameError);
});

emailInput.addEventListener("keyup", (e) => {
	const input = e.target.value;
	validator(emailRegex, input, emailError);
});

form.addEventListener("submit", (e) => {
	e.preventDefault();
	const isNameValid = validator(nameRegex, nameInput.value, nameError);
	const isEmailValid = validator(emailRegex, emailInput.value, emailError);

	if (isNameValid && isEmailValid) form.submit();
});
