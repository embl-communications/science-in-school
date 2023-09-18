function generateTable() {
    /* Generates the binary table based on the generated word. */
    var word = getGivenWord();
    if (!isFirstWord()) destroyPreviousTable();

    displayGeneratedWord(word);
    buildBinaryTable(word, "professor");
}

function getGivenWord() {
    return document.getElementById("input-word").value.toUpperCase();
}

function isFirstWord() {
    return document.getElementById("generated-word").innerHTML == "";
}

function getRandomWord() {
    var words_list = ["ANIMAL", "COISA", "BICHO", "OLÁ"];
    var index = Math.floor(Math.random() * words_list.length);
    return words_list[index];
}

function displayGeneratedWord(word) {
    document.getElementById("generated-word").innerHTML = word;
}
