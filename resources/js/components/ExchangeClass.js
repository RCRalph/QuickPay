import React from 'react';
import ReactDOM from 'react-dom';

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faLongArrowAltRight } from "@fortawesome/fontawesome-free-solid";

import axios from 'axios';

import Block from "./ExchangeBlock";

class Currency extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			ready: false,
			balance: {},
			currencies: [],
			avaliableCurrencies: [],
			exchangeRates: {},
			currentValueLeft: 0,
			currentValueRight: 0,
			currentCurrencyLeft: 1,
			currentCurrencyRight: 1,
			currentExchangeRate: 1
		}
		this.handleCurrencies = this.handleCurrencies.bind(this);
		this.handleValues = this.handleValues.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);
	}

	componentDidMount() {
		axios.get("/exchange/index")
			.then(response => {
				const apiData = response.data;
				const avaliableCurrencies = Object.keys(apiData.balance).map(item => {
					return apiData.currencies[parseInt(item, 10) - 1];
				})

				const currencies = {
					left: avaliableCurrencies[0].id,
					right: avaliableCurrencies[0].id == 1 ? apiData.currencies[1].id : 1
				}

				const sourceCurrency = apiData.currencies[currencies.left - 1].ISO_4217;
				const targetCurrency = apiData.currencies[currencies.right - 1].ISO_4217;
				const currentRate = apiData.exchangeRates[targetCurrency] / apiData.exchangeRates[sourceCurrency];

				this.setState({
					balance: apiData.balance,
					currencies: apiData.currencies,
					avaliableCurrencies: avaliableCurrencies,
					exchangeRates: apiData.exchangeRates,
					currentCurrencyLeft: currencies.left,
					currentCurrencyRight: currencies.right,
					currentExchangeRate: currentRate,
					currentValueLeft: "",
					currentValueRight: "",
					ready: true
				});
			});
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

		values.left = Math.round((target.id == "valueRight" ? target.value / this.state.currentExchangeRate : target.value) * 100) / 100;

		values.left = values.left > this.state.balance[this.state.currentCurrencyLeft] ?
			this.state.balance[this.state.currentCurrencyLeft] :
			(values.left < 0 ? 0 : values.left);

		this.setState({
			currentValueLeft: parseFloat(values.left),
			currentValueRight: Math.round(parseFloat(values.left) * this.state.currentExchangeRate * 100) / 100
		});
	}

	handleSubmit(event) {
		event.preventDefault();
		let element = document.getElementById("submitButton");
		element.innerHTML = '<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div>';
		element.disabled = true;
		axios.post("/exchange/store", {
			value: this.state.currentValueLeft,
			sourceCurrency: this.state.currentCurrencyLeft,
			targetCurrency: this.state.currentCurrencyRight
		})
		.then(response => {
			if (response.data.status == "success") {
				window.location.href = "/transactions";
			}
			else {
				let element = document.getElementById("submitButton");
				element.innerHTML = (Exchange);

				element.classList.add("btn-danger");
				setTimeout(() => {
					element.classList.remove("btn-danger");
					element.disabled = false;
				}, 500);
			}
		})
	}

	render() {
		if (this.state.ready) {
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
				<form onSubmit={this.handleSubmit}>
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
							<button className="btn btn-primary btn-block" id="submitButton">Exchange</button>
						</div>
					</div>
				</form>
			)
		}
		else {
			return (
				<div className="d-flex justify-content-center">
					<div className="spinner-grow text-primary my-5" role="status">
						<span className="sr-only">Loading...</span>
					</div>
				</div>
			)
		}
	}
}

export default Currency;

if (document.getElementById('currency')) {
    ReactDOM.render(<Currency />, document.getElementById('currency'));
}
