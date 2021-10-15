const $checkoutForm = document.querySelector("#checkout-form");
const $checkoutFormDummy = document.querySelector("#dummy-form");
const $checkoutFormSubmit = document.querySelector("#checkout-form #submit");
const $formSubmitSpinner = document.querySelector("#form_submit_spinner");

if ($checkoutFormDummy) {
	$checkoutFormDummy.addEventListener("submit", (e) => {
		e.preventDefault();
	});
}

if ($checkoutForm) {
	$checkoutForm.addEventListener("submit", (e) => {
		e.preventDefault();
		// console.log(e);
		// console.log($checkoutForm.elements);

		$checkoutFormSubmit.disabled = true;
		$formSubmitSpinner.style.display = "inline-block";

		sendData();
	});
}

function sendData() {
	// Bind the FormData object and the form element
	const FD = new FormData($checkoutForm);
	const $infobox = document.querySelector("#infobox");

	fetch(AJAX_URL, {
		method: "POST",
		credentials: "same-origin",
		headers: {
			//'Content-Type': 'application/json',
			//'Content-Type': 'application/x-www-form-urlencoded'
		},
		body: FD,
	})
		.then((resp) => resp.json())
		.then((data) => {
			$infobox.style.display = "none";
			$infobox.removeAttribute("class");
			$checkoutFormSubmit.disabled = false;
			$formSubmitSpinner.style.display = "none";

			if (data.success) {
				if (data.method === "GET") {
					window.location.href = data.content;
				} else if (data.method === "POST") {
					let $afterFormWrap = document.createElement("div");
					$checkoutForm.after($afterFormWrap);
					$afterFormWrap.innerHTML = data.content;
					let $afterForm = $afterFormWrap.querySelector("form");
					$afterForm.submit();
				}
			} else {
				$infobox.innerHTML = data.message;
				$infobox.classList.add("alert", "alert-danger");
				$infobox.style.display = "block";
			}
		})
		.catch(function(error) {
			console.log(JSON.stringify(error));
		});

	/*
    const XHR = new XMLHttpRequest();

    // Define what happens on successful data submission
    XHR.addEventListener( "load", function(event) {
      alert( event.target.responseText );
      console.log(event.target.responseText);
    } );

    // Define what happens in case of error
    XHR.addEventListener( "error", function( event ) {
      alert( 'Oops! Something went wrong.' );
    } );

    // Set up our request
    XHR.open( "POST", AJAX_URL );

    // The data sent is what the user provided in the form
    XHR.send( FD );*/
}
