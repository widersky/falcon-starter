import Cookies from "js-cookie";

const CookiesInfo = () => {
    const cookieInfoElement = document.getElementById("CookiesInfo");
    const cookieName = "c-info";
    const moreText = cookieInfoElement.dataset.moreText;

    if (Cookies.get(cookieName)) return false;

    cookieInfoElement.style.display = 'flex';
    cookieInfoElement.innerHTML = `${cookieInfoElement.dataset.text} <button>OK</button> <a href="${cookieInfoElement.dataset.moreLink}">${moreText}</a>`;

    cookieInfoElement.querySelector("button").addEventListener("click", () => {
        cookieInfoElement.style.display = 'none';
        Cookies.set(cookieName, true);
    });
}

export default CookiesInfo;
