const form = document.querySelector('.wrapper form'),
    fullUrl = form.querySelector('input'),
    shortenBtn = form.querySelector('button'),
    blurEffect = document.querySelector('.blur-effect'),
    popupBox = document.querySelector('.popup-box'),
    shortenUrl = popupBox.querySelector('input'),
    saveBtn = popupBox.querySelector('button'),
    copyBtn = popupBox.querySelector('.copy-icon');



form.onsubmit = (e) => {
    e.preventDefault();
}

shortenBtn.addEventListener('click', function(e) {
    //ajax request
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/url_controll.php', true);
    xhr.onload = () => {
        //if ajax request status is ok or success
        if (xhr.status === 200 && xhr.readyState === 4) {
            let data = xhr.response;
            if(data.length <= 5) {
                //if the url successfully shortened
                blurEffect.style.display = 'block';
                popupBox.classList.add('show');

                //set the url in the popup box
                let domain = "localhost/url-shortener/";
                shortenUrl.value = domain + data;
                
                //save button
                saveBtn.onclick = () => {
                    notie.confirm({
                        text: 'Are you sure you want to save this url?',
                        submitCallback: function() {
                            location.reload();
                        }
                    });
                }

                //copy button
                copyBtn.onclick = () => {
                    shortenUrl.select();
                    document.execCommand('copy');
                    notie.alert({
                        type: 'success',
                        text: 'Copied to clipboard',
                        time: 2
                    });
                }
            }else{
                notie.alert({
                    type: 'error',
                    text: data,
                    time: 2
                });
            }
        }
    }
    //send form data to php file
    let formData = new FormData(form);
    xhr.send(formData);
});