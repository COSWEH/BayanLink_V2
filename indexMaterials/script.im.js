document.addEventListener("DOMContentLoaded", function () {
	const yearSpan = document.getElementById("current-year");
	yearSpan.textContent = new Date().getFullYear();

	const moonIcon = document.getElementById("moon-icon");
	const sunIcon = document.getElementById("sun-icon");
	const html = document.documentElement;

	const currentTheme = localStorage.getItem("theme") || "dark";
	html.setAttribute("data-bs-theme", currentTheme);
	moonIcon.style.display = currentTheme === "dark" ? "inline" : "none";
	sunIcon.style.display = currentTheme === "dark" ? "none" : "inline";

	document
		.getElementById("theme-toggle")
		.addEventListener("click", function () {
			const currentTheme = html.getAttribute("data-bs-theme");
			const newTheme = currentTheme === "dark" ? "light" : "dark";

			html.setAttribute("data-bs-theme", newTheme);
			moonIcon.style.display = newTheme === "dark" ? "inline" : "none";
			sunIcon.style.display = newTheme === "dark" ? "none" : "inline";

			localStorage.setItem("theme", newTheme);
		});
});
