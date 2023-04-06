var cards = document.getElementsByClassName('dotted-card-inner');
cards[0].addEventListener( 'click', function() {
    cards[0].classList.toggle('is-flipped');
    var matching_digit = document.getElementById('numbers-0');
    matching_digit.innerText = (parseInt(matching_digit.innerText) + 1) % 2;
});
cards[1].addEventListener( 'click', function() {
    cards[1].classList.toggle('is-flipped');
    var matching_digit = document.getElementById('numbers-1');
    matching_digit.innerText = (parseInt(matching_digit.innerText) + 1) % 2;
});
cards[2].addEventListener( 'click', function() {
    cards[2].classList.toggle('is-flipped');
    var matching_digit = document.getElementById('numbers-2');
    matching_digit.innerText = (parseInt(matching_digit.innerText) + 1) % 2;
});
cards[3].addEventListener( 'click', function() {
    cards[3].classList.toggle('is-flipped');
    var matching_digit = document.getElementById('numbers-3');
    matching_digit.innerText = (parseInt(matching_digit.innerText) + 1) % 2;
});
cards[4].addEventListener( 'click', function() {
    cards[4].classList.toggle('is-flipped');
    var matching_digit = document.getElementById('numbers-4');
    matching_digit.innerText = (parseInt(matching_digit.innerText) + 1) % 2;
});
cards[5].addEventListener( 'click', function() {
    cards[5].classList.toggle('is-flipped');
    var matching_digit = document.getElementById('numbers-5');
    matching_digit.innerText = (parseInt(matching_digit.innerText) + 1) % 2;
});
window.onload = (event) => {
    const checkbox = document.querySelector('#letter-toggle');

    checkbox.addEventListener('change', function() { // do this on load
        if (this.checked) {
            for (var d of document.getElementsByClassName('letter-wrap')) {
                d.style.visibility = "visible";
            }
        } else {
            for (var d of document.getElementsByClassName('letter-wrap'))
                d.style.visibility = "hidden";
        }
        });
};

function calculateShowResult() {
    // Sum binary
    var position_0 = parseInt(document.getElementById('numbers-0').innerText)
    var position_1 = parseInt(document.getElementById('numbers-1').innerText)
    var position_2 = parseInt(document.getElementById('numbers-2').innerText)
    var position_3 = parseInt(document.getElementById('numbers-3').innerText)
    var position_4 = parseInt(document.getElementById('numbers-4').innerText)
    var position_5 = parseInt(document.getElementById('numbers-5').innerText)
    var total = position_0*32 + position_1*16 + position_2*8 + position_3*4 + position_4*2 + position_5;

    var letters = " ABCDEFGHIJKLMNOPQRSTUVWXYZÇÃÕÊÁÂÓÉÀÔÍÚÄÅÆÈËÌÍÎÏÑÒÖØÙÛÜÝßŸČĆŠŽŘ";
    var result_letter = letters.charAt(total);

    document.getElementById("result-number").innerText = total;
    if (total >= letters.length) {
        result_letter = "No matching letter"
    }
    document.getElementById("result-letter").innerText = result_letter;
    document.getElementsByClassName("result-values")[0].style.display = "flex";
    document.getElementsByClassName("result-show-button")[1].disabled = false;
}

function hideResult() {
    document.getElementsByClassName("result-values")[0].style.display = "none";
    document.getElementsByClassName("result-show-button")[1].disabled = true;
}