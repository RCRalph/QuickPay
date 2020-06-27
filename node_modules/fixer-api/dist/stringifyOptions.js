"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
function stringifyOptions(opts) {
    return Object.entries(opts)
        .map(([key, value]) => `${key}=${encodeURIComponent(`${value instanceof Array ? value.join(',') : value}`)}`)
        .join('&');
}
exports.default = stringifyOptions;
//# sourceMappingURL=stringifyOptions.js.map