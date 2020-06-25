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
			exchangeRates: {"EURUSD": 0.9},
			currentValueLeft: "0",
			currentValueRight: "0",
			currentCurrencyLeft: "1",
			currentCurrencyRight: "1"
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
		if (event.currentTarget.id == "currenciesLeft") {
			this.setState({
				currentCurrencyLeft: event.currentTarget.value
			});
		}
		else {
			this.setState({
				currentCurrencyRight: event.currentTarget.value
			});
		}
	}

	handleValues(event) {

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
						<Block {...dataLeft} handleCurrencies={this.handleCurrencies} />

						<div className="display-1 my-0 py-0 mx-4 text-primary">
							<FontAwesomeIcon icon={faLongArrowAltRight} />
						</div>

						<Block {...dataRight} handleCurrencies={this.handleCurrencies} />
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
