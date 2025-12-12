const body = document.body;
const recuperarBox = document.querySelector( ".recuperar-box" );
const h1 = document.getElementsByTagName( "h1" )[ 0 ];
const inputs = document.querySelectorAll( "input" );
const recuperarButton = document.getElementById( "recuperar-button" );

function switchTheme() {
    recuperarBox.classList.toggle( "dark-mode" );
    body.classList.toggle( "dark-mode" );
    h1.classList.toggle( "dark-mode" );
    inputs.forEach(input => {
        input.classList.toggle( "dark-mode" )
    });
    recuperarButton.classList.toggle( "dark-mode" );
    h2.classList.toggle( "dark-mode" );
}

