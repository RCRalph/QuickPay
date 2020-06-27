import React from 'react';
import ReactDOM from 'react-dom';

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faLongArrowAltRight } from "@fortawesome/fontawesome-free-solid";

import Block from "./ExchangeBlock";

class Currency extends React.Component {
	constructor() {
		super();
		this.state = {
			balance: balance,
			currencies: currencies,
			exchangeKey: exchangeKey,
			avaliableCurrencies: Object.keys(balance).map(item => {
				return currencies[parseInt(item, 10) - 1];
			}),
			exchangeRates: {},
			currentValueLeft: 0,
			currentValueRight: 0,
			currentCurrencyLeft: 1,
			currentCurrencyRight: 1,
			currentExchangeRate: 1
		}
		this.handleCurrencies = this.handleCurrencies.bind(this);
		this.handleValues = this.handleValues.bind(this);
	}

	componentDidMount() {
		let currencies = {
			left: this.state.avaliableCurrencies[0].id,
			right: this.state.avaliableCurrencies[0].id == 1 ? this.state.currencies[1].id : 1
		}

		const fetchLink = "http://data.fixer.io/api/latest?access_key=" + this.state.exchangeKey +
			"&symbols=" + this.state.currencies.map(item => {
				return item.ISO_4217 != "EUR" ? item.ISO_4217 : "";
			}).filter(item => {
				return item != "";
			}).join(",") + "&format=1";

		fetch(fetchLink)
			.then(data => data.json())
			.then(data => {
				const rates = { ...data.rates, EUR: 1 };
				const currentRate = rates[this.state.currencies[currencies.right - 1].ISO_4217] / rates[this.state.currencies[currencies.left - 1].ISO_4217];

				this.setState({
					currentCurrencyLeft: currencies.left,
					currentCurrencyRight: currencies.right,
					exchangeRates: rates,
					currentExchangeRate: currentRate
				});
			})
			.catch(error => console.log(error));
	}

	handleCurrencies(event) {
		const target = event.currentTarget;
		let changedCurrencies = [this.state.currentCurrencyLeft, this.state.currentCurrencyRight];

		if (target.id == "currenciesLeft") {
			changedCurrencies[0] = parseInt(target.value);
			changedCurrencies[1] = parseInt(changedCurrencies[0] == changedCurrencies[1] ?
				(changedCurrencies[0] == 1 ? "2" : "1") :
				changedCurrencies[1]);
		}
		else {
			changedCurrencies[1] = parseInt(target.value != this.state.currentCurrencyLeft ?
				target.value :
				(this.state.currentCurrencyLeft == 1 ? "2" : "1"));
		}

		const exchangeRate = this.state.exchangeRates[this.state.currencies[changedCurrencies[1] - 1].ISO_4217] / this.state.exchangeRates[this.state.currencies[changedCurrencies[0] - 1].ISO_4217]
		console.log(exchangeRate);

		let values = {
			left: this.state.currentValueLeft,
			right: this.state.currentValueRight
		}

		if (target.id == "currenciesLeft") {
			values.left = Math.round((values.left > this.state.balance[changedCurrencies[0]] ?
				this.state.balance[changedCurrencies[0]] :
				values.left) * 100) / 100;
		}
		values.right = Math.round(values.left * exchangeRate * 100) / 100;

		this.setState({
			currentValueLeft: values.left,
			currentValueRight: values.right,
			currentCurrencyLeft: changedCurrencies[0],
			currentCurrencyRight: changedCurrencies[1],
			currentExchangeRate: exchangeRate
		});
	}

	handleValues(event) {
		let target = event.currentTarget;
		target.value = parseFloat(target.value);
		let values = {
			left: this.state.currentValueLeft,
			right: this.state.currentValueRight
		}

		values.left = Math.round((target.id == "valueRight" ? target.value / exchangeRate : target.value) * 100) / 100;

		values.left = values.left > this.state.balance[this.state.currentCurrencyLeft] ?
			this.state.balance[this.state.currentCurrencyLeft] :
			(values.left < 0 ? 0 : values.left);

		this.setState({
			currentValueLeft: parseFloat(values.left),
			currentValueRight: Math.round(parseFloat(values.left) * this.state.currentExchangeRate * 100) / 100
		});
	}

	render() {
		const dataLeft = {
			id: "valueLeft",
			placeholder: "Amount to exchange",
			currentValue: this.state.currentValueLeft,
			currencyID: "currenciesLeft",
			currencyValue: this.state.currentCurrencyLeft,
			currencies: this.state.avaliableCurrencies,
		}

		const dataRight = {
			id: "valueRight",
			placeholder: "Amount to get",
			currentValue: this.state.currentValueRight,
			currencyID: "currenciesRight",
			currencyLeft: this.state.currentCurrencyLeft,
			currencyValue: this.state.currentCurrencyRight,
			currencies: this.state.currencies
		}

		return (
			<form>
				<div className="row">
					<div className="col-6 text-right font-weight-bold">
						Exchange rate:
					</div>

					<div className="col-6">
						{this.state.currentExchangeRate}
					</div>
				</div>

				<div className="row">
					<div className="w-100 d-flex justify-content-between align-items-center mx-3">
						<Block {...dataLeft} handleValues={this.handleValues} handleCurrencies={this.handleCurrencies} />

						<div className="display-1 my-0 py-0 mx-4 text-primary">
							<FontAwesomeIcon icon={faLongArrowAltRight} />
						</div>

						<Block {...dataRight} handleValues={this.handleValues} handleCurrencies={this.handleCurrencies} />
					</div>
				</div>

				<div className="row">
					<div className="col-4 offset-4">
						<button className="btn btn-primary btn-block">Exchange</button>
					</div>
				</div>
			</form>
		)
	}
}

export default Currency;

if (document.getElementById('currency')) {
    ReactDOM.render(<Currency />, document.getElementById('currency'));
}
