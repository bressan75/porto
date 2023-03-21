function mostrar(e) {
    var tipo = e.parentNode.querySelector("[name='senha']");
    if (tipo.type == "password") {
        tipo.type = "text";
    } else {
        tipo.type = "password";
    }

    tipo.type = tipo.type;                     //aplica o tipo que ficou no primeiro campo

    if (e.classList.contains("fa-eye")) {   //se tem olho aberto
        e.classList.remove("fa-eye");       //remove classe olho aberto
        e.classList.add("fa-eye-slash");    //coloca classe olho fechado
    } else {
        e.classList.remove("fa-eye-slash"); //remove classe olho fechado
        e.classList.add("fa-eye");          //coloca classe olho aberto
    }
}