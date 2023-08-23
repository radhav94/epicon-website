function isValidContact(isInput) {
	// alert("true");
  // Regular expressions for email and mobile number validation
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const mobilePattern = /^\d{8,}$/;

  if (emailPattern.test(isInput)) {
	return true;
  } else if (mobilePattern.test(isInput)) {
	return true;
  } else {
  	$('.get-otp-message').html("Please Enter Valid Details");
  	return false;
  }
}