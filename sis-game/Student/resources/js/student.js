var file;
function loadWords(event) {
	var input = event.target;

	var reader = new FileReader();
	reader.onload = function(){
	  file = reader.result;
	};
	reader.readAsText(input.files[0]);
	// After reading, disable input and allow play
	document.getElementById("upload").style = "display:none";
	document.getElementById("generate").style = "display:inline";

}

function generateTable() {
	resetGame();

	/* Generates the binary table based on the generated word. */
	var words_list = file.split("\n");
	var word = words_list[
		Math.floor(Math.random() * words_list.length)
	].toUpperCase();
	document.getElementById("word").innerHTML = word;
	destroyPreviousTable();
	buildBinaryTable(word, "estudante");
	showBinaryTable();
	togglePlaying();
}

function showBinaryTable() {
	document.getElementById("generated-image-section").style.display = "block";
}

function togglePlaying() {
	document.getElementById("generate").disabled = !document.getElementById(
		"generate"
	).disabled;
}

function validateGuess() {
	var inputs = document.getElementsByClassName("char");
	var correct_word = document.getElementById("word").innerHTML;
	var guess = "";
	for (input of inputs) {
		guess += input.value;
	}
	if (guess.toUpperCase() === correct_word) {
		document.getElementById("confirm").style.display = "none";
		document.getElementById("result-right").style.display = "inline";
		document.getElementById("generate").disabled = false;
		increaseCorrect();
	} else {
		document.getElementById("confirm").style.display = "none";
		document.getElementById("result-wrong").style.display = "inline";
		setTimeout(function () {
			document.getElementById("result-wrong").style.display = "none";
			document.getElementById("confirm").style.display = "inline";
		}, 3000);
		increaseWrong();
	}
}

function increaseCorrect() {
	if (typeof increaseCorrect.correct == "undefined")
		increaseCorrect.correct = 0;
	increaseCorrect.correct += 1;
	document.getElementById("correct").innerHTML =
		increaseCorrect.correct + " correct";
}

function increaseWrong() {
	if (typeof increaseWrong.wrong == "undefined") increaseWrong.wrong = 0;
	increaseWrong.wrong += 1;
	document.getElementById("wrong").innerHTML =
		increaseWrong.wrong + " wrong";
}

function resetGame() {
	document.getElementById("instructions").style.display = "inline";

	/* Controls for bottom of table */
	/* Should show the button and hide any text */
	document.getElementById("confirm").style.display = "inline";
	document.getElementById("result-right").style.display = "none";
	document.getElementById("result-wrong").style.display = "none"; // should not be needed, but to stay on the safe side...
}
