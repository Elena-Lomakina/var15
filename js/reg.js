"use strict";
function msgClose(id) {
	var msg = document.getElementById(id);
	var my_parent = msg.parentElement;
	my_parent.removeChild(msg);
}