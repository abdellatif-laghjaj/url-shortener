const form = document.querySelector('.wrapper form'),
    fullUrl = document.querySelector('input'),
    shortenBtn = document.querySelector('button');


form.onsubmit = (e) => {
    e.preventDefault();
}

shortenBtn.addEventListener('click', function(e) {
    //ajax request
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://api.shorte.st/v1/shorten');
    xhr.onload = () => {}
    xhr.send();
});