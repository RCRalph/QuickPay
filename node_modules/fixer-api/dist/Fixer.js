"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.Fixer = void 0;
const constants_1 = require("./constants");
const formatDate_1 = require("./formatDate");
class Fixer {
    constructor(opts = {}) {
        this.basicOptions = {
            baseUrl: opts.baseUrl || constants_1.DEFAULT_URL,
            accessKey: opts.accessKey
        };
    }
    set({ baseUrl, accessKey } = {}) {
        this.basicOptions.baseUrl = baseUrl || this.basicOptions.baseUrl;
        this.basicOptions.accessKey = accessKey || this.basicOptions.accessKey;
        return this;
    }
    forDate(date, opts = {}) {
        return __awaiter(this, void 0, void 0, function* () {
            return this.request(`/${formatDate_1.ensureDateString(date)}`, opts);
        });
    }
    latest(opts = {}) {
        return __awaiter(this, void 0, void 0, function* () {
            return this.request('/latest', opts);
        });
    }
    symbols(opts = {}) {
        return __awaiter(this, void 0, void 0, function* () {
            return this.request('/symbols', opts);
        });
    }
    convert(from, to, amount, date) {
        return __awaiter(this, void 0, void 0, function* () {
            return this.request('/convert', {
                from,
                to,
                amount,
                date
            });
        });
    }
    timeseries(startDate, endDate, opts = {}) {
        return __awaiter(this, void 0, void 0, function* () {
            const start = formatDate_1.ensureDateString(startDate);
            const end = formatDate_1.ensureDateString(endDate);
            return this.request('/timeseries', Object.assign({ start_date: start, end_date: end }, opts));
        });
    }
}
exports.Fixer = Fixer;
//# sourceMappingURL=Fixer.js.map