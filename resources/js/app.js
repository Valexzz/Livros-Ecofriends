import './bootstrap';

$.extend($.validator.messages, {
    required: "Preencha esse campo!",
    remote: "Please fix this field.",
    email: "Por favor insira um endereço de email válido!",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Por favor insira apenas dígitos!",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: $.validator.format("Máximo de {0} caracteres atingido!"),
    minlength: $.validator.format("Mínimo de {0} caracteres!"),
    rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
    range: $.validator.format("Please enter a value between {0} and {1}."),
    max: $.validator.format("Please enter a value less than or equal to {0}."),
    min: $.validator.format("Please enter a value greater than or equal to {0}.")
});