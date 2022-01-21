
function addProperty() {
	var list = document.getElementById("listProperty"); // это наш родитель и у него скоро будут детки
	var items = document.createElement("div"); // обёртка для пары свойсво/значение
	var name = document.createElement("input"); // имя свойства
	var val = document.createElement("input"); // значение
	
	// атрибуты для поля имени свойства
	name.setAttribute("type", "text");
	name.setAttribute("maxlength", "50");
	name.setAttribute("placeholder", "Название свойства");
	name.setAttribute("name", "property-name[]");//массив для имён свойств
	name.setAttribute("required", "");
	
	// атрибуты для поля значения
	val.setAttribute("type", "text");
	val.setAttribute("maxlength", "50");
	val.setAttribute("placeholder", "Значение свойства");
	val.setAttribute("name", "property-value[]");//массив для значений свойств
	val.setAttribute("required", "");
	
	// для обёртки установим класс из CSS свойств(add.css)
	items.classList.add("items");
	
	// добавлем поля в обёртку
	items.appendChild(name);
	items.appendChild(val);
	
	list.appendChild(items); // теперь отобразим всё на экране
	
}


function deleteProperty() {
	var parent = document.getElementById("listProperty"); // это наш родитель
	
	if(parent.children.length != 0) {
		//удаление последнего элемента
		parent.removeChild(parent.lastElementChild);
	}
}