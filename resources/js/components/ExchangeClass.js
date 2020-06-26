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
			avaliableCurrencies: Object.keys(balance).map(item => {
				return currencies[parseInt(item, 10) - 1];
			}),
			exchangeRates: {"EURUSD": 1.1, "USDEUR": 0.9},
			currentValueLeft: 0,
			currentValueRight: 0,
			currentCurrencyLeft: 1,
			currentCurrencyRight: 1
		}
		this.handleCurrencies = this.handleCurrencies.bind(this);
		this.handleValues = this.handleValues.bind(this);
	}

	componentDidMount() {
		this.setState({
			currentCurrencyLeft: this.state.avaliableCurrencies[0].id,
			currentCurrencyRight: this.state.avaliableCurrencies[0].id == 1 ? this.state.currencies[1].id : 1
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

		const exchangeName = this.state.currencies[changedCurrencies[0] - 1].ISO_4217 + this.state.currencies[changedCurrencies[1] - 1].ISO_4217;
		let exchangeValue;
		if (!(exchangeName in this.state.exchangeRates)) {
			//makeAPICall()
		}
		else {
			exchangeValue = this.state.exchangeRates[exchangeName];
		}

		let values = {
			left: this.state.currentValueLeft,
			right: this.state.currentValueRight
		}

		if (target.id == "currenciesLeft") {
			values.left = values.left > this.state.balance[changedCurrencies[0]] ?
				this.state.balance[changedCurrencies[0]] :
				values.left;
		}
		values.right = values.left * exchangeValue;

		this.setState({
			currentValueLeft: values.left,
			currentValueRight: values.right,
			currentCurrencyLeft: changedCurrencies[0],
			currentCurrencyRight: changedCurrencies[1],
			exchangeRates: {
				...this.state.exchangeRates,
				[exchangeName]: exchangeValue
			}
		});
	}

	handleValues(event) {
		const target = event.currentTarget;
		if (target.id == "valueLeft") {
			let valueLeft = 0;
			if (target.value > balance[this.state.currentCurrencyLeft]) {
				valueLeft = balance[this.state.currentCurrencyLeft];
			}
			else if (target.value < 0) {
				valueLeft = 0;
			}
			else {
				valueLeft = Math.round(target.value * 100) / 100;
			}

			this.setState({
				currentValueLeft: valueLeft
			});
		}
		else {

		}
	}

	render() {
		let dataLeft = {
			id: "valueLeft",
			placeholder: "Amount to exchange",
			currentValue: this.state.currentValueLeft,
			currencyID: "currenciesLeft",
			currencyValue: this.state.currentCurrencyLeft,
			currencies: this.state.avaliableCurrencies,
		}

		let dataRight = {
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
