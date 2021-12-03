const incrementButton = document.getElementsByClassName("inc");
const decrementButton = document.getElementsByClassName("dec");

// Increase
for (var i = 0; i < incrementButton.length; i++) {
    var button = incrementButton[i];
    button.addEventListener("click", function (e) {
        var buttonOnClicked = e.target;
        var input = buttonOnClicked.parentElement.children[2];
        var newValue = parseInt(input.value) + 1;
        input.value = newValue;
    });
}

// Decrease
for (var i = 0; i < decrementButton.length; i++) {
    var button = decrementButton[i];
    button.addEventListener("click", function (e) {
        var buttonOnClicked = e.target;
        var input = buttonOnClicked.parentElement.children[2];
        var newValue = parseInt(input.value) - 1;
        //To get rid of negative value
        if (newValue >= 0) {
            input.value = newValue;
        } else {
            input.value = 0;
        }
    });
}
