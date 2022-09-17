import moment from "moment";

const helpers = {
    cutText(text, length) {
        if (text.split(" ").length > 1) {
            const string = text.substring(0, length);
            const splitText = string.split(" ");
            splitText.pop();
            return splitText.join(" ") + "...";
        } else {
            return text;
        }
    },
    formatDate(date, format) {
        return moment(date).format(format);
    },
    capitalizeFirstLetter(string) {
        if (string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        } else {
            return "";
        }
    },
    onlyNumber(string) {
        if (string) {
            return string.replace(/\D/g, "");
        } else {
            return "";
        }
    },
    formatCurrency(number) {
        if (number) {
            const formattedNumber = number.toString().replace(/\D/g, "");
            const rest = formattedNumber.length % 3;
            let currency = formattedNumber.substr(0, rest);
            const thousand = formattedNumber.substr(rest).match(/\d{3}/g);
            let separator;

            if (thousand) {
                separator = rest ? "." : "";
                currency += separator + thousand.join(".");
            }

            return currency;
        } else {
            return "";
        }
    },
    isset(obj) {
        if (obj !== null && obj !== undefined) {
            if (typeof obj === "object" || Array.isArray(obj)) {
                return Object.keys(obj).length;
            } else {
                return obj.toString().length;
            }
        }

        return false;
    },
    toRaw(obj) {
        return JSON.parse(JSON.stringify(obj));
    },
    randomNumbers(from, to, length) {
        const numbers = [0];
        for (let i = 1; i < length; i++) {
            numbers.push(Math.ceil(Math.random() * (from - to) + to));
        }

        return numbers;
    },
};

export default helpers;
