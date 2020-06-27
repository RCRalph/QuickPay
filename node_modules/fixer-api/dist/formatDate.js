"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ensureDateString = void 0;
const padNumber = (num) => (num < 10 ? `0${num}` : num.toString());
function ensureDateString(input) {
    const RE_DATE = /^\d{4}-\d{2}-\d{2}$/;
    if (typeof input === 'string' && RE_DATE.test(input)) {
        return input;
    }
    if (input instanceof Date) {
        return formatDate(input);
    }
    throw new TypeError(`Invalid date argument: ${input}`);
}
exports.ensureDateString = ensureDateString;
function formatDate(date) {
    return `${date.getUTCFullYear()}-${padNumber(date.getMonth() + 1)}-${padNumber(date.getDate())}`;
}
exports.default = formatDate;
//# sourceMappingURL=formatDate.js.map