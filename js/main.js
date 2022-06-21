const form = document.querySelector('.wrapper form'),
    fullUrl = form.querySelector('input'),
    shortenBtn = form.querySelector('button'),
    blurEffect = document.querySelector('.blur-effect'),
    popupBox = document.querySelector('.popup-box'),
    form2 = popupBox.querySelector('form'),
    shortenUrl = popupBox.querySelector('input'),
    saveBtn = popupBox.querySelector('button'),
    copyBtn = popupBox.querySelector('.copy-icon'),
    infoBox = popupBox.querySelector('.info-box');



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
                
                form2.onsubmit = (e) => {
                    e.preventDefault();
                }
                //save button
                saveBtn.onclick = () => {
                    notie.confirm({
                        text: 'Are you sure you want to save this url?',
                        submitCallback: function() {
                            let xhr2 = new XMLHttpRequest();
                            xhr2.open('POST', 'php/save_url.php', true);
                            xhr2.onload = () => {
                                //if ajax request status is ok or success
                                if (xhr2.status === 200 && xhr2.readyState === 4) {
                                    let data = xhr2.response;
                                    if(data === 'success') {
                                        notie.alert({
                                            type: 1,
                                            text: 'Url saved successfully!'
                                        });
                                        setTimeout(() => {
                                            location.reload();
                                        }, 1000);
                                    }else {
                                        notie.alert({
                                            type: 3,
                                            text: data
                                        });
                                        infoBox.innerHTML = data;
                                        infoBox.classList.add('error');
                                    }
                                }
                            }
                            let short_url = shortenUrl.value;
                            let hidden_url = data;
                            xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            xhr2.send("shorten_url=" + short_url + "&hidden_url=" + hidden_url);
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