export interface IFixerError {
    readonly type: string;
    readonly info: string;
}
export interface IFixerRates {
    readonly [currency: string]: number;
}
export interface IFixerResponse {
    readonly base: string;
    readonly date: string;
    readonly rates: IFixerRates;
    readonly timestamp: number;
    readonly error?: IFixerError;
}
export interface IFixerSymbols {
    readonly [symbol: string]: string;
}
export interface IFixerSymbolResponse {
    readonly symbols: IFixerSymbols;
    readonly error?: IFixerError;
}
export interface IFixerConvertRequestOptions {
    readonly from: string;
    readonly to: string;
    readonly amount: number;
    readonly date?: string;
}
export interface IFixerConvertResponse {
    readonly success: boolean;
    readonly query: {
        readonly from: string;
        readonly to: string;
        readonly amount: number;
    };
    readonly date: string;
    readonly result: number;
}
export interface IFixerTimeseriesResponse {
    readonly success: boolean;
    readonly start_date: string;
    readonly end_date: string;
    readonly base: string;
    readonly rates: Record<string, Record<string, number>>;
}
export interface IRawParams {
    [key: string]: any;
}
export interface IRequestOptions {
    base?: string;
    symbols?: string[];
    access_key: string;
}
export interface IBasicOptions {
    baseUrl: string;
    accessKey?: string;
}
export declare abstract class Fixer {
    protected basicOptions: IBasicOptions;
    constructor(opts?: Partial<IBasicOptions>);
    set({ baseUrl, accessKey }?: Partial<IBasicOptions>): Fixer;
    forDate(date: Date | string, opts?: Partial<IRequestOptions>): Promise<IFixerResponse>;
    latest(opts?: Partial<IRequestOptions>): Promise<IFixerResponse>;
    symbols(opts?: Partial<IRequestOptions>): Promise<IFixerSymbolResponse>;
    convert(from: string, to: string, amount: number, date?: Date | string): Promise<IFixerConvertResponse>;
    timeseries(startDate: Date | string, endDate: Date | string, opts?: Partial<IRequestOptions>): Promise<IFixerTimeseriesResponse>;
    protected abstract request<Result>(url: string, opts: IRawParams): Promise<Result>;
}
