const form = document.getElementById('formCambiar');
const pass = document.getElementById('password');
const pass_confirmed = document.getElementById('password_confirmed');


form.addEventListener('submit',(e)=>{
    e.preventDefault();
    console.log(pass,pass_confirmed);
    if (pass.value == pass_confirmed.value) {
        form.submit();
    }
})

