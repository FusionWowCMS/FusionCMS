const Donate = {
    disableButton: function (id) {
        $('#button_' + id).prop("disabled", true);
        document.getElementById("overlay_" + id).style.display = "flex";
    },

	 showPaypal() {
		 const methods = document.getElementById('donate-methods');
		 const paypal = document.getElementById('paypal');

		 methods.classList.remove('donate-visible');
		 setTimeout(() => {
			 methods.classList.add('d-none');

			 paypal.classList.remove('d-none');
			 setTimeout(() => {
				 paypal.classList.add('donate-visible');
			 }, 10);
		 }, 500);
	}
};